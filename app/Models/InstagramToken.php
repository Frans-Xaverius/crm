<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstagramToken extends Model
{
    use HasFactory;
    protected $table = 'instagram_token';
    public $timestamps = false;

    protected $guarded = ['id'];
}
