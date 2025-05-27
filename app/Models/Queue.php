<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    protected $fillable = [
        'user_id',
        'nomor_antrian',
        'status',
        'is_validated',
        'requested_chapster_id',
    ];

    /**
     * Get the user that owns the queue.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
