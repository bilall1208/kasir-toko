<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function index()
    {
        $barang = Barang::where('user_id', session('user_id'))->get();
        return view('penjualan.index', compact('barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id'    => 'required|array|min:1',
            'barang_id.*'  => 'required|exists:barang,id',
            'qty'          => 'required|array|min:1',
            'qty.*'        => 'required|integer|min:1',
            'uang_dibayar' => 'required|numeric|min:0',
        ]);

        // hitung total harga berdasarkan data asli dari database (bukan dari input form)
        // biar gak bisa dimanipulasi harganya dari luar
        $totalHarga = 0;
        $items = [];

        foreach ($request->barang_id as $i => $barangId) {
            $barang = Barang::where('id', $barangId)
                ->where('user_id', session('user_id'))
                ->first();

            if (!$barang) {
                continue; // lewati kalau barang bukan milik user ini
            }

            $qty = $request->qty[$i];
            $subtotal = $barang->harga_jual * $qty;
            $totalHarga += $subtotal;

            $items[] = [
                'barang_id'   => $barang->id,
                'nama_barang' => $barang->nama_barang,
                'harga_jual'  => $barang->harga_jual,
                'qty'         => $qty,
                'subtotal'    => $subtotal,
            ];
        }

        if ($request->uang_dibayar < $totalHarga) {
            return back()->withErrors(['uang_dibayar' => 'Uang yang dibayar kurang dari total belanja.'])->withInput();
        }

        $kembalian = $request->uang_dibayar - $totalHarga;

        DB::transaction(function () use ($totalHarga, $request, $kembalian, $items) {
            $penjualan = Penjualan::create([
                'user_id'      => session('user_id'),
                'total_harga'  => $totalHarga,
                'uang_dibayar' => $request->uang_dibayar,
                'kembalian'    => $kembalian,
            ]);

            foreach ($items as $item) {
                DetailPenjualan::create([
                    'penjualan_id' => $penjualan->id,
                    'barang_id'    => $item['barang_id'],
                    'nama_barang'  => $item['nama_barang'],
                    'harga_jual'   => $item['harga_jual'],
                    'qty'          => $item['qty'],
                    'subtotal'     => $item['subtotal'],
                ]);
            }
        });

        return redirect()->route('penjualan.index')->with('success', 'Transaksi berhasil disimpan.');
    }

    public function riwayat()
    {
        $penjualan = Penjualan::with('detail')
            ->where('user_id', session('user_id'))
            ->latest()
            ->get();

        return view('penjualan.riwayat', compact('penjualan'));
    }
}
