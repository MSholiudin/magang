@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0 text-white">📦 Daftar Produk</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        @forelse ($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    @if ($product->file_path)
                        <img src="{{ asset($product->file_path) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Rp{{ number_format($product->price, 0, ',', '.') }}</h6>
                        <p class="card-text flex-grow-1">{{ $product->description }}</p>

                        {{-- Jika ingin tetap tampilkan tombol juga, aktifkan ini --}}
                        {{-- 
                        @if ($product->file_path)
                            <a href="{{ asset($product->file_path) }}" target="_blank" class="btn btn-outline-primary mt-auto">📎 Lihat File</a>
                        @else
                            <span class="text-muted mt-auto">Tidak ada file</span>
                        @endif 
                        --}}
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted">
                Belum ada produk yang tersedia.
            </div>
        @endforelse
    </div>
</div>
@endsection
