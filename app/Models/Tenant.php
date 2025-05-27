<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $table = 'tenants';

    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Get the users associated with the tenant.
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}