@extends('layouts.app')
@section('title', 'Register')

@section('content')
<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-row">

            <!-- Panel kiri -->
            <div class="auth-brand">
                <h4>Kasir Toko</h4>
                <p>Daftar sekarang dan mulai kelola tokomu dengan mudah.</p>

                <div class="auth-feature"><span class="dot"><i class="bi bi-box-seam"></i></span> Kelola data barang</div>
                <div class="auth-feature"><span class="dot"><i class="bi bi-receipt"></i></span> Transaksi cepat & akurat</div>
                <div class="auth-feature"><span class="dot"><i class="bi bi-bar-chart"></i></span> Riwayat penjualan lengkap</div>
            </div>

            <!-- Panel kanan -->
            <div class="auth-form">
                <h4>Buat Akun Baru</h4>
                <p class="subtitle">Isi data di bawah untuk mendaftarkan tokomu.</p>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Pengguna</label>
                            <input type="text" name="nama_pengguna" class="form-control" placeholder="Nama kamu" value="{{ old('nama_pengguna') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Toko</label>
                            <input type="text" name="nama_toko" class="form-control" placeholder="Nama toko kamu" value="{{ old('nama_toko') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="contoh@email.com" value="{{ old('email') }}">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Daftar</button>
                </form>

                <p class="text-center mt-3 mb-0" style="font-size:0.92rem;">
                    Sudah punya akun? <a href="{{ route('login') }}" class="fw-semibold text-decoration-none">Login di sini</a>
                </p>
            </div>

        </div>
    </div>
</div>
@endsection