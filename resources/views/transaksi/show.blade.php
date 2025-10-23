@extends('layouts.app')
@section('title', 'Detail Transaksi #' . $transaksi->id)

@section('content')
<div class="content-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1">Detail Transaksi #{{ $transaksi->id }}</h5>
            <p class="text-muted mb-0">
                Tanggal: {{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d F Y, H:i:s') }}
            </p>
        </div>
        <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Back to List</a>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <label class="small text-muted">Kasir</label>
            <p>{{ $transaksi->nama_kasir }}</p>
        </div>
        <div class="col-md-6">
            <label class="small text-muted">Pembeli</label>
            <p>{{ $transaksi->nama_pembeli ?? '-' }}</p>
        </div>
    </div>
    
    <h5 class="fw-bold">Item yang Dibeli</h5>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th class="text-end">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi->details as $detail)
            <tr>
                <td>{{ $detail->product->title ?? 'N/A' }}</td>
                <td>{{ $detail->jumlah_pembelian }}</td>
                <td>Rp {{ number_format($detail->product->price ?? 0, 0, ',', '.') }}</td>
                <td class="text-end">Rp {{ number_format($detail->subtotal_harga, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="fw-bold">
                <td colspan="3" class="text-end border-0">Grand Total:</td>
                <td class="text-end border-0 fs-5">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</div>
@endsection
