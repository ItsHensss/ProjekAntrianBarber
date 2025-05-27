<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Tenant::class);
    }
}
