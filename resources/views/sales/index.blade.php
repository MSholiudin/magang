@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Transaksi Penjualan</h1>
    
    <div class="mb-4">
        <a href="{{ route('sales.select-products') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Transaksi Baru
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No. Transaksi</th>
                            <th>Tanggal</th>
                            <th>Pelanggan</th>
                            <th>Total</th>
                            <th>Jumlah Item</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $sale)
                        <tr>
                            <td>{{ $sale->transaction_number }}</td>
                            <td>{{ $sale->sale_date->format('d/m/Y H:i') }}</td>
                            <td>{{ $sale->customer_name ?? '-' }}</td>
                            <td>Rp {{ number_format($sale->total_amount) }}</td>
                            <td>{{ $sale->saleDetails ? $sale->saleDetails->sum('quantity') : 0 }}</td>
                            <td>
                                <a href="{{ route('sales.receipt', $sale->id) }}" 
                                    class="btn btn-sm btn-info" title="Lihat Struk">
                                    <i class="fas fa-receipt"></i>
                                Struk</a>
                                <form action="{{ route('sales.destroy', ['sale' => $sale->id]) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus transaksi?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada transaksi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{ $sales->links() }} <!-- Pagination -->
        </div>
    </div>
</div>
@endsection