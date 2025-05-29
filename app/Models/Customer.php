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

    // relasi ke table users
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}