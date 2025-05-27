<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoInterior extends Model
{
    protected $table = 'foto_interiors';

    protected $fillable = [
        'image',
        'judul',
        'deskripsi',
        'team_id',
    ];

    public function team()
    {
        return $this->belongsTo(Tenant::class);
    }
}
