<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'role',
        'department_id',
        'username',
    ];

    public function Department () {

        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function detailRole () {

        return $this->belongsTo(UserRole::class, 'role', 'id');
    }
}
