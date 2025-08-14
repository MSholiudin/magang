@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Pilih Produk</h1>
    <form method="GET" action="{{ route('sales.create') }}">
        <div class="row">
            @foreach($products as $product)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5>{{ $product->name }}</h5>
                        <p>Harga: Rp {{ number_format($product->price) }}</p>
                        <p>Stok: {{ $product->stock }}</p>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" 
                                name="selected_products[]" 
                                value="{{ $product->id }}" 
                                id="product-{{ $product->id }}">
                            <label class="form-check-label" for="product-{{ $product->id }}">
                                Pilih
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <button type="submit" class="btn btn-primary">Lanjut ke Transaksi</button>
    </form>
</div>
@endsection