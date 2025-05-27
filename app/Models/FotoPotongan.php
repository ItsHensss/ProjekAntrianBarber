<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoPotongan extends Model
{
    protected $table = 'foto_potongans';

    protected $fillable = [
        'image',
        'judul',
        'deskripsi',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}