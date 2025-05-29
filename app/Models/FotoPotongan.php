<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FotoPotongan extends Model
{
    protected $table = 'foto_potongans';

    protected $fillable = [
        'image',
        'judul',
        'tenant_id',
        'deskripsi',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}