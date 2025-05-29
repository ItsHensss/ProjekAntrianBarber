<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = [
        'nama',
        'nomor',
        'user_id',
    ];

    // relasi ke queue
    public function queues()
    {
        return $this->hasMany(Queue::class);
    }

    // relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
