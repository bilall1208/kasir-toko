@extends('layouts.app')
@section('title', 'Tambah Barang')

@section('content')
<div class="page-header">
    <h3><i class="bi bi-plus-square-fill"></i> Tambah Barang</h3>
    <p>Isi detail barang yang mau dijual</p>
</div>

<div class="card">
    <div class="card-body p-4">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('barang.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Barang</label>
                <input type="text" name="nama_barang" class="form-control" value="{{ old('nama_barang') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Foto Barang</label>
                <input type="file" name="foto" class="form-control">
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Harga Modal</label>
                    <input type="number" name="harga_modal" class="form-control" value="{{ old('harga_modal') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Harga Jual</label>
                    <input type="number" name="harga_jual" class="form-control" value="{{ old('harga_jual') }}">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('barang.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection