<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kasir Toko')</title>
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap/css/bootstrap-icons.css') }}" rel="stylesheet">
</head>
<body>

    @if(session('user_id'))
    <nav class="navbar navbar-expand-lg navbar-light app-navbar">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <img class="logo" src="{{ asset('assets/img/Kasir-Toko-Logo.png') }}" alt="Logo Kasir" width="120" height="40">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('barang.*') ? 'active' : '' }}" href="{{ route('barang.index') }}">Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('penjualan.*') ? 'active' : '' }}" href="{{ route('penjualan.index') }}">Penjualan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('riwayat.*') ? 'active' : '' }}" href="{{ route('riwayat.index') }}">Riwayat</a>
                    </li>
                    <li class="nav-item ms-2">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-sm btn-outline-light" type="submit">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    @endif

    <div class="container py-4">
        @yield('content')
    </div>    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        @yield('scripts')
</body>
</html>