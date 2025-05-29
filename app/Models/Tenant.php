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

    // relasi foto interior
    public function fotoInteriors()
    {
        return $this->hasMany(FotoInterior::class);
    }
    // relasi produk
    public function produks()
    {
        return $this->hasMany(Produk::class);
    }
    // relasi queue
    public function queues()
    {
        return $this->hasMany(Queue::class);
    }
    // relasi operational
    public function operationals()
    {
        return $this->hasMany(Operational::class);
    }

    // foto potongan
    public function fotoPotongans()
    {
        return $this->hasMany(FotoPotongan::class);
    }

    // relasi ke table lokasi
    public function lokasi()
    {
        return $this->hasMany(Lokasi::class);
    }
}
