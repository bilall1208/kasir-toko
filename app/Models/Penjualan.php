<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'penjualan';

    protected $fillable = [
        'user_id',
        'total_harga',
        'uang_dibayar',
        'kembalian',
    ];

    public function detail()
    {
        return $this->hasMany(DetailPenjualan::class);
    }
}
