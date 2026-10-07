<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';

    protected $fillable = [
        'user_id',
        'nama_barang',
        'foto',
        'harga_modal',
        'harga_jual',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
