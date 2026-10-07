@extends('layouts.app')
@section('title', 'Riwayat Penjualan')

@section('content')
<div class="page-header">
    <h3><i class="bi bi-bar-chart-line-fill"></i> Riwayat Penjualan</h3>
    <p>Semua transaksi yang pernah terjadi di toko kamu</p>
</div>

@if($penjualan->count() == 0)
    <div class="card">
        <div class="card-body">
            <div class="empty-state">
                <h5>Belum ada transaksi <i class="bi bi-receipt-cutoff"></i></h5>
                <p>Riwayat penjualan akan muncul di sini setelah kamu melakukan transaksi.</p>
            </div>
        </div>
    </div>
@else
    @foreach($penjualan as $p)
        <div class="card mb-3">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between flex-wrap align-items-start mb-3">
                    <div>
                        <h6 class="fw-bold mb-1">Transaksi #{{ $p->id }}</h6>
                        <span class="text-muted">{{ $p->created_at->translatedFormat('d F Y, H:i') }} WIB</span>
                    </div>
                    <div class="text-end">
                        <div class="text-muted small">Total Belanja</div>
                        <div class="fw-bold text-primary fs-5">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</div>
                    </div>
                </div>

                <table class="table table-sm mb-3">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Harga Satuan</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($p->detail as $d)
                            <tr>
                                <td>{{ $d->nama_barang }}</td>
                                <td class="text-center">{{ $d->qty }}</td>
                                <td class="text-end">Rp {{ number_format($d->harga_jual, 0, ',', '.') }}</td>
                                <td class="text-end">Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="row justify-content-end">
                    <div class="col-md-4">
                        <div class="d-flex justify-content-between small text-muted">
                            <span>Uang Dibayar</span>
                            <span>Rp {{ number_format($p->uang_dibayar, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between small text-success fw-semibold">
                            <span>Kembalian</span>
                            <span>Rp {{ number_format($p->kembalian, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif
@endsection