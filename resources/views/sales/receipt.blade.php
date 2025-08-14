@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Struk Transaksi #{{ $sales->transaction_number }}</h2>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <p><strong>Tanggal:</strong> {{ $sales->sale_date->format('d/m/Y H:i') }}</p>
                    <p><strong>Pelanggan:</strong> {{ $sales->customer_name ?? '-' }}</p>
                </div>
            </div>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @if($sales->saleDetails)
                        @foreach($sales->saleDetails as $detail)
                        <tr>
                            <td>{{ $detail->product->name }}</td>
                            <td>Rp {{ number_format($detail->unit_price) }}</td>
                            <td>{{ $detail->quantity }}</td>
                            <td>Rp {{ number_format($detail->subtotal) }}</td>
                        </tr>
                        @endforeach
                    @else
                        <p>Tidak ada detail transaksi</p>
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3">Total</th>
                        <th>Rp {{ number_format($sales->total_amount) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection