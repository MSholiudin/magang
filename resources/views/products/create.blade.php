@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-primary text-white text-center">
                    <h4>{{ isset($product) ? 'Edit' : 'Tambah' }} Produk</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}" 
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(isset($product)) @method('PUT') @endif

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Produk</label>
                            <input type="text" name="name" class="form-control" placeholder="Masukkan nama produk" 
                                value="{{ old('name', $product->name ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Harga</label>
                            <input type="number" name="price" class="form-control" step="any" placeholder="Masukkan harga produk" 
                                value="{{ old('price', $product->price ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Tulis deskripsi produk">{{ old('description', $product->description ?? '') }}</textarea>
                        </div>

                        <!-- Drag & Drop Area -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Upload Gambar/File</label>
                            <div id="drop-area" class="border border-2 border-dashed rounded p-3 text-center bg-light">
                                <p class="text-muted mb-2">Tarik & letakkan gambar di sini atau klik untuk pilih</p>
                                <input type="file" name="file_path" id="file-input" class="d-none" accept="image/*">
                                <button type="button" class="btn btn-outline-primary" id="browse-btn">Pilih Gambar</button>
                            </div>
                            <!-- Preview Gambar -->
                            <div class="mt-3 text-center">
                                @if(isset($product) && $product->file_path)
                                    <img src="{{ asset('storage/'.$product->file_path) }}" id="preview" class="img-fluid rounded" style="max-height: 200px;">
                                @else
                                    <img id="preview" class="img-fluid rounded d-none" style="max-height: 200px;">
                                @endif
                            </div>
                        </div>

                        <div class="d-grid">
                            <button class="btn btn-success btn-lg">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script Drag & Drop + Preview -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const dropArea = document.getElementById('drop-area');
    const fileInput = document.getElementById('file-input');
    const browseBtn = document.getElementById('browse-btn');
    const preview = document.getElementById('preview');

    // Klik tombol -> buka input file
    browseBtn.addEventListener('click', () => fileInput.click());

    // Preview saat pilih file
    fileInput.addEventListener('change', function() {
        showPreview(this.files[0]);
    });

    // Drag & Drop events
    ['dragenter', 'dragover'].forEach(event => {
        dropArea.addEventListener(event, e => {
            e.preventDefault();
            e.stopPropagation();
            dropArea.classList.add('border-primary');
        });
    });

    ['dragleave', 'drop'].forEach(event => {
        dropArea.addEventListener(event, e => {
            e.preventDefault();
            e.stopPropagation();
            dropArea.classList.remove('border-primary');
        });
    });

    // Saat file di-drop
    dropArea.addEventListener('drop', e => {
        const file = e.dataTransfer.files[0];
        fileInput.files = e.dataTransfer.files;
        showPreview(file);
    });

    // Fungsi tampilkan preview
    function showPreview(file) {
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        }
    }
});
</script>
@endsection
