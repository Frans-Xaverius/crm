<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pabx extends Model
{
    use HasFactory;
    protected $table = 'pabx';
    public $timestamps = false;

    protected $guarded = ['id'];
}
