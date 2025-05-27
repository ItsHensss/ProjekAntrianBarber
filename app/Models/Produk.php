<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produks';

    protected $fillable = [
        'image',
        'harga',
        'team_id',
        'judul',
        'deskripsi',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}