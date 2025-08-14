@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Produk Tersedia</h1>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form id="multiSelectForm" action="{{ route('sales.create') }}" method="GET">
        <div class="row">
            @foreach($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card product-card h-100">
                    @if($product->file_path)
                    <img src="{{ asset($product->file_path) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($product->description, 100) }}</p>
                        <p class="card-text">
                            <strong>Harga:</strong> Rp {{ number_format($product->price, 0, ',', '.') }}<br>
                            <strong>Stok:</strong> {{ $product->stock }}
                        </p>
                        
                        <div class="form-check">
                            <input class="form-check-input product-check" 
                                type="checkbox" 
                                name="selected_products[]" 
                                value="{{ $product->id }}"
                                id="product-{{ $product->id }}">
                            <label class="form-check-label" for="product-{{ $product->id }}">
                                Pilih Produk
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="fixed-bottom bg-white p-3 shadow">
            <div class="container">
                <button type="submit" class="btn btn-primary btn-lg" id="proceedBtn" disabled>
                    <i class="fas fa-cart-plus me-2"></i> Buat Penjualan (<span id="selectedCount">0</span> produk dipilih)
                </button>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.product-check');
    const proceedBtn = document.getElementById('proceedBtn');
    const selectedCount = document.getElementById('selectedCount');
    
    function updateButton() {
        const checkedCount = document.querySelectorAll('.product-check:checked').length;
        proceedBtn.disabled = checkedCount === 0;
        selectedCount.textContent = checkedCount;
    }
    
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateButton);
    });
});
</script>

<style>
.product-card {
    transition: transform 0.2s;
}
.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}
.form-check-input {
    width: 1.2em;
    height: 1.2em;
    margin-top: 0.2em;
}
</style>
@endsection