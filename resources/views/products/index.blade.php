@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0 text-white">📦 Kelola Produk</h1>
        <a href="{{ route('products.create') }}" class="btn btn-success">+ Tambah Produk</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover table-striped mb-0">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Nama</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Stock</th>
                        <th scope="col">Deskripsi</th>
                        <th scope="col">Lihat Produk</th>
                        <th scope="col" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                            <td>{{ $item->stock }}</td>
                            <td>{{ $item->description }}</td>
                            <td>
                                @if ($item->file_path)
                                    <a href="{{ asset($item->file_path) }}" target="_blank">📎 Lihat File</a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center justify-content-between">
                                <a href="{{ route('products.edit', $item->id) }}" class="btn btn-sm btn-warning me-1">Edit</a>
                                <form action="{{ route('products.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada produk.</td> {{-- ⬅ Sesuaikan colspan-nya --}}
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
