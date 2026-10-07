<?php

use App\Http\Controllers\BarangController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PenjualanController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

Route::post('/register', [AuthController::class, 'register'])->name('register.store');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.store');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('ceklogin')->group(function () {
    Route::resource('barang', BarangController::class)->except(['show']);
});

Route::middleware('ceklogin')->group(function () {
    Route::resource('barang', BarangController::class)->except(['show']);
    Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
    Route::post('/penjualan', [PenjualanController::class, 'store'])->name('penjualan.store');
});

Route::middleware('ceklogin')->group(function () {
    Route::resource('barang', BarangController::class)->except(['show']);
    Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
    Route::post('/penjualan', [PenjualanController::class, 'store'])->name('penjualan.store');
    Route::get('/riwayat', [PenjualanController::class, 'riwayat'])->name('riwayat.index');
});