<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    use HasFactory;
    protected $table = 'pertanyaan';
    protected $guarded = ['id'];

    public function child () {

        return $this->hasMany(Pertanyaan::class, 'parent_id', 'id');
    }
}
