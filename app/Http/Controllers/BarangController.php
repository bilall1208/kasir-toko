<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::where('user_id', session('user_id'))->latest()->get();
        return view('barang.index', compact('barang'));
    }

    public function create()
    {
        return view('barang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang'  => 'required|string|max:255',
            'harga_modal'  => 'required|numeric|min:0',
            'harga_jual'   => 'required|numeric|min:0',
            'foto'         => 'nullable|image|max:2048',
        ]);

        $namaFoto = null;
        if ($request->hasFile('foto')) {
            $namaFoto = time() . '_' . $request->file('foto')->getClientOriginalName();
            $request->file('foto')->move(public_path('uploads/barang'), $namaFoto);
        }

        Barang::create([
            'user_id'     => session('user_id'),
            'nama_barang' => $request->nama_barang,
            'foto'        => $namaFoto,
            'harga_modal' => $request->harga_modal,
            'harga_jual'  => $request->harga_jual,
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit(Barang $barang)
    {
        // pastikan barang ini milik user yang login
        if ($barang->user_id != session('user_id')) {
            abort(403);
        }
        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, Barang $barang)
    {
        if ($barang->user_id != session('user_id')) {
            abort(403);
        }

        $request->validate([
            'nama_barang'  => 'required|string|max:255',
            'harga_modal'  => 'required|numeric|min:0',
            'harga_jual'   => 'required|numeric|min:0',
            'foto'         => 'nullable|image|max:2048',
        ]);

        $namaFoto = $barang->foto;
        if ($request->hasFile('foto')) {
            $namaFoto = time() . '_' . $request->file('foto')->getClientOriginalName();
            $request->file('foto')->move(public_path('uploads/barang'), $namaFoto);
        }

        $barang->update([
            'nama_barang' => $request->nama_barang,
            'foto'        => $namaFoto,
            'harga_modal' => $request->harga_modal,
            'harga_jual'  => $request->harga_jual,
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diupdate.');
    }

    public function destroy(Barang $barang)
    {
        if ($barang->user_id != session('user_id')) {
            abort(403);
        }

        $barang->delete();
        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }
}
