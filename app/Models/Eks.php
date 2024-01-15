<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eks extends Model
{
    use HasFactory;

    protected $casts = [
        'd_id' => 'array',
    ];
}
