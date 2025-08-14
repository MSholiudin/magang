@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Buat Transaksi</h1>
    
    <form method="POST" action="{{ route('sales.store') }}" id="sales-form">
        @csrf
        
        <div class="row mb-3">
            <div class="col-md-6">
                <label>Tanggal Transaksi</label>
                <input type="date" name="sale_date" class="form-control" 
                    value="{{ old('sale_date', now()->format('Y-m-d')) }}" required>
            </div>
            <div class="col-md-6">
                <label>Nama Pelanggan (Opsional)</label>
                <input type="text" name="customer_name" class="form-control" 
                    value="{{ old('customer_name') }}">
            </div>
        </div>
        
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                Daftar Produk
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>
                                {{ $product->name }}
                                <input type="hidden" name="products[{{ $product->id }}][id]" 
                                    value="{{ $product->id }}">
                            </td>
                            <td>
                                Rp <span class="price">{{ number_format($product->price) }}</span>
                                <input type="hidden" class="price-value" value="{{ $product->price }}">
                            </td>
                            <td width="150">
                                <input type="number" 
                                    name="products[{{ $product->id }}][quantity]" 
                                    class="form-control quantity" 
                                    min="1" 
                                    max="{{ $product->stock }}" 
                                    value="{{ old('products.'.$product->id.'.quantity', 1) }}" 
                                    required>
                            </td>
                            <td class="subtotal">
                                Rp {{ number_format($product->price) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-end">Total</th>
                            <th id="total">Rp {{ number_format($products->sum('price')) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
        <a href="{{ route('sales.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('sales-form');
    const quantityInputs = document.querySelectorAll('.quantity');
    
    // Fungsi hitung total
    function calculateTotal() {
        let total = 0;
        
        quantityInputs.forEach(input => {
            const row = input.closest('tr');
            const price = parseFloat(row.querySelector('.price-value').value);
            const quantity = parseInt(input.value) || 0;
            const subtotal = price * quantity;
            
            row.querySelector('.subtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
            total += subtotal;
        });
        
        document.getElementById('total').textContent = 'Rp ' + total.toLocaleString('id-ID');
    }
    
    // Event listener untuk input quantity
    quantityInputs.forEach(input => {
        input.addEventListener('change', function() {
            const maxStock = parseInt(this.max);
            const minStock = parseInt(this.min);
            let value = parseInt(this.value) || 0;
            
            if (value > maxStock) {
                value = maxStock;
                alert('Jumlah melebihi stok tersedia! Stok tersedia: ' + maxStock);
            }
            
            if (value < minStock) {
                value = minStock;
            }
            
            this.value = value;
            calculateTotal();
        });
        
        input.addEventListener('input', calculateTotal);
    });
    
    // Handle form submission
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Validasi stok
        let valid = true;
        quantityInputs.forEach(input => {
            const maxStock = parseInt(input.max);
            const quantity = parseInt(input.value) || 0;
            
            if (quantity > maxStock) {
                valid = false;
                const row = input.closest('tr');
                const productName = row.querySelector('td:first-child').textContent.trim();
                alert(`Jumlah ${productName} melebihi stok tersedia!`);
            }
        });
        
        if (!valid) return;
        
        // Kirim data
        try {
            const response = await fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: new FormData(this)
            });

            const result = await response.json();
            
            if (!response.ok) throw new Error(result.message || 'Terjadi kesalahan server');
            
            if (result.redirect) {
                window.location.href = result.redirect;
            } else {
                window.location.reload();
            }
            
        } catch (error) {
            console.error('Error:', error);
            alert('Gagal menyimpan transaksi: ' + error.message);
        }
    });
});
</script>
@endsection