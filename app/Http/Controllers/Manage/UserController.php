<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Department;

class UserController extends Controller
{
    public function index () {

        $user = User::all();
        $role = UserRole::all();
        $department = Department::all();

        return view('manage.user.index', compact('user', 'role', 'department'));

    }
}
