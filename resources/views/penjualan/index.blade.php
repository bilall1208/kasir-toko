@extends('layouts.app')
@section('title', 'Penjualan')

@section('content')
<div class="page-header">
    <h3><i class="bi bi-receipt-cutoff"></i> Transaksi Penjualan</h3>
    <p>Pilih barang yang dibeli pelanggan</p>
</div>

@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card">
    <div class="card-body p-4">
        
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if($barang->count() == 0)
        <div class="empty-state">
            <h5>Belum ada barang <i class="bi bi-box-seam-fill"></i></h5>
            <p>Tambahkan barang dulu di menu Barang sebelum melakukan penjualan.</p>
        </div>
        @else
        <form method="POST" action="{{ route('penjualan.store') }}" id="formPenjualan">
            @csrf

            <table class="table align-middle" id="tabelItem">
                <thead>
                    <tr>
                        <th>Barang</th>
                        <th style="width:120px">Qty</th>
                        <th style="width:150px">Subtotal</th>
                        <th style="width:60px"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="baris-item">
                        <td>
                            <select name="barang_id[]" class="form-select pilih-barang" required>
                                <option value="">-- Pilih Barang --</option>
                                @foreach($barang as $b)
                                <option value="{{ $b->id }}" data-harga="{{ $b->harga_jual }}">
                                    {{ $b->nama_barang }} (Rp {{ number_format($b->harga_jual, 0, ',', '.') }})
                                </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" name="qty[]" class="form-control input-qty" value="1" min="1" required>
                        </td>
                        <td>
                            <span class="fw-semibold subtotal-text">Rp 0</span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-danger btn-hapus-baris">✕</button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <button type="button" class="btn btn-outline-primary mb-4" id="btnTambahBaris">+ Tambah Barang</button>

            <hr>

            <div class="row justify-content-end">
                <div class="col-md-5">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="fw-semibold">Total Belanja</span>
                        <span class="fw-bold text-primary fs-5" id="totalHarga">Rp 0</span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Uang Dibayar Pelanggan</label>
                        <input type="number" name="uang_dibayar" id="uangDibayar" class="form-control" min="0" required>
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <span class="fw-semibold">Kembalian</span>
                        <span class="fw-bold text-success fs-5" id="kembalianText">Rp 0</span>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Simpan Transaksi</button>
                </div>
            </div>
        </form>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    const tabelBody = document.querySelector('#tabelItem tbody');
    const btnTambah = document.getElementById('btnTambahBaris');
    const totalHargaEl = document.getElementById('totalHarga');
    const uangDibayarEl = document.getElementById('uangDibayar');
    const kembalianEl = document.getElementById('kembalianText');

    // tambah baris barang baru
    btnTambah.addEventListener('click', function() {
        const barisPertama = tabelBody.querySelector('.baris-item');
        const barisBaru = barisPertama.cloneNode(true);

        // reset value baris baru
        barisBaru.querySelector('.pilih-barang').value = '';
        barisBaru.querySelector('.input-qty').value = 1;
        barisBaru.querySelector('.subtotal-text').textContent = 'Rp 0';

        tabelBody.appendChild(barisBaru);
        hitungTotal();
    });

    // hapus baris (pakai event delegation biar baris baru juga kena)
    tabelBody.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-hapus-baris')) {
            const semuaBaris = tabelBody.querySelectorAll('.baris-item');
            if (semuaBaris.length > 1) {
                e.target.closest('.baris-item').remove();
                hitungTotal();
            }
        }
    });

    // setiap kali pilih barang atau ubah qty, hitung ulang
    tabelBody.addEventListener('change', function(e) {
        if (e.target.classList.contains('pilih-barang') || e.target.classList.contains('input-qty')) {
            hitungSubtotalBaris(e.target.closest('.baris-item'));
            hitungTotal();
        }
    });
    tabelBody.addEventListener('keyup', function(e) {
        if (e.target.classList.contains('input-qty')) {
            hitungSubtotalBaris(e.target.closest('.baris-item'));
            hitungTotal();
        }
    });

    function hitungSubtotalBaris(baris) {
        const select = baris.querySelector('.pilih-barang');
        const qty = parseInt(baris.querySelector('.input-qty').value) || 0;
        const harga = parseInt(select.selectedOptions[0]?.dataset.harga) || 0;
        const subtotal = harga * qty;

        baris.querySelector('.subtotal-text').textContent = formatRupiah(subtotal);
    }

    function hitungTotal() {
        let total = 0;
        document.querySelectorAll('.baris-item').forEach(function(baris) {
            const select = baris.querySelector('.pilih-barang');
            const qty = parseInt(baris.querySelector('.input-qty').value) || 0;
            const harga = parseInt(select.selectedOptions[0]?.dataset.harga) || 0;
            total += harga * qty;
        });

        totalHargaEl.textContent = formatRupiah(total);
        hitungKembalian(total);

        // simpan total di data attribute biar bisa dipakai saat input uang berubah
        totalHargaEl.dataset.value = total;
    }

    uangDibayarEl.addEventListener('keyup', function() {
        const total = parseInt(totalHargaEl.dataset.value) || 0;
        hitungKembalian(total);
    });

    function hitungKembalian(total) {
        const uang = parseInt(uangDibayarEl.value) || 0;
        const kembalian = uang - total;
        kembalianEl.textContent = formatRupiah(kembalian < 0 ? 0 : kembalian);
    }

    function formatRupiah(angka) {
        return 'Rp ' + angka.toLocaleString('id-ID');
    }
</script>
@endsection