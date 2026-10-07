@extends('layouts.app')
@section('title', 'Login')

@section('content')
<div class="auth-wrapper">
    <div class="auth-card shadow">
        <div class="auth-row">

            <!-- Panel kiri -->
            <div class="auth-brand">    
                <h4>Kasir Toko</h4>
                <p>Kelola barang dan transaksi tokomu dalam satu tempat.</p>

                <div class="auth-feature"><span class="dot"><i class="bi bi-box-seam"></i></span> Kelola data barang</div>
                <div class="auth-feature"><span class="dot"><i class="bi bi-receipt"></i></span> Transaksi cepat & akurat</div>
                <div class="auth-feature"><span class="dot"><i class="bi bi-bar-chart"></i></span> Riwayat penjualan lengkap</div>
            </div>

            <!-- Panel kanan -->
            <div class="auth-form">
                <h4>Selamat Datang Kembali</h4>
                <p class="subtitle">Masuk ke akun tokomu untuk melanjutkan.</p>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="contoh@email.com" value="{{ old('email') }}">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan password">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>

                <p class="text-center mt-3 mb-0" style="font-size:0.92rem;">
                    Belum punya akun? <a href="{{ route('register') }}" class="fw-semibold text-decoration-none">Daftar di sini</a>
                </p>
            </div>

        </div>
    </div>
</div>
@endsection