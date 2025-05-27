<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarberTable extends Model
{
    protected $fillable = [
        'nama',
        'is_occupied',
        'customer_id',
        'employee_id',
    ];

    // Relasi ke user sebagai pelanggan
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    // Relasi ke user sebagai pegawai/chapster
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    // Relasi ke antrian
    public function queue()
    {
        return $this->hasMany(Queue::class);
    }
}
