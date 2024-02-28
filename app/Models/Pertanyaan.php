<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pertanyaan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'pertanyaan';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];

    public function child () {

        return $this->hasMany(Pertanyaan::class, 'parent_id', 'id');
    }
}
