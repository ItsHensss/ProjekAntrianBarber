<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    protected $fillable = [
        'user_id',
        'barber_table_id',
        'nomor_antrian',
        'status',
        'is_validated',
        'requested_chapster_id',
    ];

    /**
     * Get the user that owns the queue.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the barber associated with the queue.
     */
    public function barberTable()
    {
        return $this->belongsTo(BarberTable::class, 'barber_table_id');
    }

    /**
     * Get the requested chapster associated with the queue.
     */
    public function requestedChapster()
    {
        return $this->belongsTo(Employee::class, 'requested_chapster_id');
    }
}
