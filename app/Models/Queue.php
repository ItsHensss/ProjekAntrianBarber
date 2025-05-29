<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Queue extends Model
{
    protected $fillable = [
        'user_id',
        'produk_id',
        'nomor_antrian',
        'status',
        'is_validated',
        'requested_chapster_id',
        'tenant_id',
        'booking_date',
    ];

    /**
     * Get the user that owns the queue.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

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
}
