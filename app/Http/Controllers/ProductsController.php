<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function dashboard(){
        $products = Product::where('stock', '>', 0)->get();
        return view('dashboard', compact('products'));
    }

    public function index() {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create() {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'file_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048'
        ]);

        $data = $request->only(['name', 'price', 'description']);

        if ($request->hasFile('file_path')) {
            $filename = time() . '_' . $request->file('file_path')->getClientOriginalName();
            $request->file('file_path')->storeAs('uploads', $filename, 'public');
            $data['file_path'] = 'storage/uploads/' . $filename;
        }

        Product::create($data);
        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit(Product $product) {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'file_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048'
        ]);

        $data = $request->only(['name', 'price', 'description']);

        if ($request->hasFile('file_path')) {
            // Hapus file lama
            if ($product->file_path && file_exists(public_path($product->file_path))) {
                unlink(public_path($product->file_path));
            }

            // Upload file baru
            $filename = time() . '_' . $request->file('file_path')->getClientOriginalName();
            $request->file('file_path')->storeAs('uploads', $filename, 'public');
            $data['file_path'] = 'storage/uploads/' . $filename;
        }

        $product->update($data);
        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product) {
        // Hapus file jika ada
        if ($product->file_path && file_exists(public_path($product->file_path))) {
            unlink(public_path($product->file_path));
        }

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
