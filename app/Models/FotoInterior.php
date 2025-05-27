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
        'tenant_id',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}