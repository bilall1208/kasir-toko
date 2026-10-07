@extends('layouts.app')
@section('title', 'Edit Barang')

@section('content')
<div class="page-header">
    <h3><i class="bi bi-pencil-square"></i> Edit Barang</h3>
    <p>Perbarui detail barang</p>
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

        <form method="POST" action="{{ route('barang.update', $barang->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @if($barang->foto)
                <img src="{{ asset('uploads/barang/'.$barang->foto) }}" class="mb-3 rounded" style="height:120px;">
            @endif

            <div class="mb-3">
                <label class="form-label">Nama Barang</label>
                <input type="text" name="nama_barang" class="form-control" value="{{ old('nama_barang', $barang->nama_barang) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Ganti Foto (opsional)</label>
                <input type="file" name="foto" class="form-control">
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Harga Modal</label>
                    <input type="number" name="harga_modal" class="form-control" value="{{ old('harga_modal', $barang->harga_modal) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Harga Jual</label>
                    <input type="number" name="harga_jual" class="form-control" value="{{ old('harga_jual', $barang->harga_jual) }}">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('barang.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection