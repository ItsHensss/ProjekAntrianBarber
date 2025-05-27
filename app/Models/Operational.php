<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operational extends Model
{
    protected $table = 'operationals';

    protected $fillable = [
        'day',
        'open_time',
        'close_time',
        'is_open',
    ];
}
