<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    // relasi
    public function queues()
    {
        return $this->hasMany(Queue::class);
    }
}
