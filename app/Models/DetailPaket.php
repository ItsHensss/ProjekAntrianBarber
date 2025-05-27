<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPaket extends Model
{
    protected $table = 'detail_pakets';

    protected $fillable = [
        'paket_id',
        'produk_id',
    ];

    public function paket()
    {
        return $this->belongsTo(Paket::class, 'paket_id');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
