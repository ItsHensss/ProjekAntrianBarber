<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategoris';

    protected $fillable = [
        'image',
        'judul',
        'deskripsi',
    ];

    // Relasi ke Produk
    public function produks()
    {
        return $this->hasMany(Produk::class, 'kategori_id');
    }
}