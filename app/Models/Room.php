<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $casts = [
        'data' => 'array'
    ];
    protected $fillable = [
        'room_id',
        'date_time',
        'data',
    ];
}
