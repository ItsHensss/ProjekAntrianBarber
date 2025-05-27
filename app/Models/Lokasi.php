<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    protected $table = 'lokasis';

    protected $fillable = [
        'nama_cabang',
        'alamat',
        'kota',
        'telepon',
        'email',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}