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
        'team_id',
        'is_open',
    ];

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Tenant::class);
    }
}