<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FotoPotongan extends Model
{
    protected $table = 'foto_potongans';

    protected $fillable = [
        'image',
        'judul',
        'tenant_id',
        'deskripsi',
    ];

    public function tenant(): BelongsToMany
    {
        return $this->belongsToMany(Tenant::class);
    }
}