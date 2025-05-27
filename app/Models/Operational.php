<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Operational extends Model
{
    protected $table = 'operationals';

    protected $fillable = [
        'day',
        'open_time',
        'close_time',
        'tenant_id',
        'is_open',
    ];

    public function tenant(): BelongsToMany
    {
        return $this->belongsToMany(Tenant::class);
    }
}