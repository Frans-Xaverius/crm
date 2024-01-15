<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallCenterr extends Model
{
    use HasFactory;

    protected $table = 'call_centers';
    protected $connection= 'pgsql';
}
