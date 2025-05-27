<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produks';

    protected $fillable = [
        'kategori_id',
        'image',
        'harga',
        'judul',
        'deskripsi',
    ];

    // Relasi ke Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function pakets()
    {
        return $this->hasMany(Paket::class, 'produk_id');
    }

    // Relasi ke DetailPaket
    public function detailPakets()
    {
        return $this->hasMany(DetailPaket::class, 'produk_id');
    }
}
