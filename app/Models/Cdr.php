<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cdr extends Model {

    use HasFactory;
    protected $table = 'cdr';
    protected $connection = 'mysql2';

    public function pabx() {

        return $this->setConnection('mysql')->belongsTo(Pabx::class, 'calldate', 'calldate');
    }
}
