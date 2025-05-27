<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    protected $table = 'pakets';

    protected $fillable = [
        'nama_paket',
        'deskripsi',
        'harga',
        'produk_id',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    public function detailPakets()
    {
        return $this->hasMany(DetailPaket::class, 'paket_id');
    }
}