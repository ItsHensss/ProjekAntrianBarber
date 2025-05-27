<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Produk extends Model
{
    protected $table = 'produks';

    protected $fillable = [
        'image',
        'harga',
        'tenant_id',
        'judul',
        'deskripsi',
    ];

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Tenant::class);
    }
}