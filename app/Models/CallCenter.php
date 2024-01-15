<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallCenter extends Model
{
    use HasFactory;

    // protected $fillable = ['solved'];

    protected $table = 'cdr';
    protected $connection= 'mysql2';

    public function cc_detail() {
        return $this->hasOne(CallCenterr::class, 'uniqueid', 'uniqueid');
    }
}
