<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customer';

    public function from () {

        return $this->belongsTo(WAChat::class, 'id', 'from')->orderBy('created_at', 'DESC');
    }

    public function to () {

       return $this->belongsTo(WAChat::class, 'id', 'to')->orderBy('created_at', 'DESC');
    }
}
