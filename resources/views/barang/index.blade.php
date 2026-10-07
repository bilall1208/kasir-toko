@extends('layouts.app')
@section('title', 'Data Barang')

@section('content') 
@if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
    @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <h3><i class="bi bi-box2-fill"></i> Data Barang</h3>
        <p>Kelola barang dagangan toko kamu di sini</p>
    </div>
    <a href="{{ route('barang.create') }}" class="btn btn-primary fw-semibold">+ Tambah Barang</a>
</div>

<div class="row g-4">
    @forelse($barang as $b)
        <div class="col-md-4 col-sm-6">
            <div class="card barang-card h-100">
                @if($b->foto)
                    <img src="{{ asset('uploads/barang/'.$b->foto) }}" class="card-img-top" alt="{{ $b->nama_barang }}">
                @else
                    <div class="card-img-top d-flex align-items-center justify-content-center bg-secondary bg-opacity-10" style="height:160px;">
                        <span class="text-muted">Tidak ada foto</span>
                    </div>
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $b->nama_barang }}</h5>
                    <p class="mb-1 text-muted">Harga Modal: Rp {{ number_format($b->harga_modal, 0, ',', '.') }}</p>
                    <p class="mb-3 fw-bold text-primary">Harga Jual: Rp {{ number_format($b->harga_jual, 0, ',', '.') }}</p>

                    <div class="d-flex gap-2">
                        <a href="{{ route('barang.edit', $b->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                        <form action="{{ route('barang.destroy', $b->id) }}" method="POST" onsubmit="return confirm('Yakin hapus barang ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="empty-state">
            <h5>Belum ada barang <i class="bi bi-box-seam-fill"></i></h5>
            <p>Yuk tambahkan barang pertamamu!</p>
        </div>  
    @endforelse
</div>
@endsection