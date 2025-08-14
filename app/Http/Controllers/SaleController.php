<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SaleController extends Controller
{
    // Menampilkan form pemilihan produk
    public function selectProducts()
    {
        $products = Product::where('stock', '>', 0)->get();
        return view('sales.select-products', compact('products'));
    }

    // Menampilkan form transaksi
    public function create(Request $request)
    {
        $request->validate([
            'selected_products' => 'required|array|min:1',
            'selected_products.*' => 'exists:products,id'
        ]);

        $products = Product::whereIn('id', $request->selected_products)
                    ->where('stock', '>', 0)
                    ->get();

        return view('sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'sale_date' => 'required|date',
            'customer_name' => 'nullable|string|max:255',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1'
        ]);

        \DB::beginTransaction();

        try {
            // 1. Buat transaksi utama
            $sale = Sale::create([
                'transaction_number' => 'TRX-' . now()->format('YmdHis'),
                'sale_date' => $validated['sale_date'],
                'customer_name' => $validated['customer_name'] ?? null,
                'total_amount' => 0 // Sementara 0, akan diupdate setelah hitung total
            ]);

            $totalAmount = 0;

            // 2. Proses setiap produk
            foreach ($validated['products'] as $productData) {
                $product = Product::find($productData['id']);

                // Validasi stok
                if ($product->stock < $productData['quantity']) {
                    throw new \Exception("Stok {$product->name} tidak mencukupi");
                }

                $subtotal = $product->price * $productData['quantity'];

                // 3. Simpan detail transaksi
                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => $productData['quantity'],
                    'unit_price' => $product->price,
                    'subtotal' => $subtotal
                ]);

                // 4. Update stok produk
                $product->decrement('stock', $productData['quantity']);

                $totalAmount += $subtotal;
            }

            // 5. Update total transaksi
            $sale->update(['total_amount' => $totalAmount]);

            \DB::commit();

            return response()->json([
                'success' => true,
                'redirect' => route('sales.receipt', $sale->id),
                'message' => 'Transaksi berhasil disimpan!'
            ]);

        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Transaction Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan transaksi: ' . $e->getMessage()
            ], 500);
        }
    }

    // Menampilkan struk
    public function receipt($id)
    {
        $sales = Sale::with('saleDetails')->findOrFail($id); 
        return view('sales.receipt', compact('sales'));
    }

    // Daftar transaksi
    public function index()
    {
        $sales = Sale::with('saleDetails')->latest()->paginate(10);
        return view('sales.index', compact('sales'));
    }

    public function destroy(Sale $sale)
    {
        DB::beginTransaction();
        
        try {
            // Kembalikan stok produk
            foreach ($sale->saleDetails as $detail) {
                $detail->product->increment('stock', $detail->quantity);
            }
            
            // Hapus transaksi
            $sale->delete();
            
            DB::commit();
            
            return redirect()->route('sales.index')
                ->with('success', 'Transaksi berhasil dihapus');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('sales.index')
                ->with('error', 'Gagal menghapus transaksi: '.$e->getMessage());
        }
    }
}