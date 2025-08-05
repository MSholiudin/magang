@extends('layouts.app')

@section('content')
<h2>{{ isset($product) ? 'Edit' : 'Tambah' }} Produk</h2>

<form action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($product)) @method('PUT') @endif

    <div class="mb-3">
        <label>Nama Produk</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $product->name ?? '') }}">
    </div>

    <div class="mb-3">
        <label>Harga</label>
        <input type="number" name="price" class="form-control" value="{{ old('price', $product->price ?? '') }}">
    </div>

    <div class="mb-3">
        <label>Deskripsi</label>
        <textarea name="description" class="form-control">{{ old('description', $product->description ?? '') }}</textarea>
    </div>

    <div class="mb-3">
        <label for="file_path" class="form-label">Upload Gambar/File</label>
        <input type="file" name="file_path" class="form-control">
    </div>

    <button class="btn btn-success">Simpan</button>
</form>
@endsection
