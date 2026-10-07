<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    protected $table = 'detail_penjualan';

    protected $fillable = [
        'penjualan_id',
        'barang_id',
        'nama_barang',
        'harga_jual',
        'qty',
        'subtotal',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
