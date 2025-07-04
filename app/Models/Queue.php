<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Queue extends Model
{
    protected $fillable = [
        'customer_id',
        'produk_id',
        'user_id',
        'nomor_antrian',
        'status',
        'is_validated',
        'tenant_id',
        'booking_date',
    ];

    /**
     * Get the produk associated with the queue.
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    // relasi ke customer
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    // relasi ke user yang melayani
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
