<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        $data = User::orderBy('id', 'desc')->get();
        $role = $this->role;
        // return response()->json([
        //     'status' => 'success',
        //     'data' => $data
        // ]);
        return view('user.index', compact('data', 'role'));
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $validated = $request->all();

            $data = new User();
            $data->name = $validated['name'];
            $data->email = $validated['email'];
            $data->password = Hash::make($validated['password']);
            // $data->qontak_user_id = $validated['qontak_user_id'];
            // $data->qontak_email = $validated['qontak_email'];
            // $data->qontak_password = $validated['qontak_password'];
            $data->phone = $validated['phone'];
            $data->sso = $validated['sso'];
            $data->department_id = $validated['department_id'];
            $data->role = $validated['role'];
            $data->save();

            // return response()->json([
            //     'status' => 'success',
            //     'data' => $data
            // ]);
            
            
            return redirect()->route('setting.accountmanagement');
        } else {
            $divisi = Department::where('id', '!=', '1')->pluck('name', 'id');
            $role = $this->role;
            return view('user.add', compact('divisi', 'role'));
        }
    }

    public function edit(Request $request, $id)
    {
        $data = User::find($id);
        if ($request->isMethod('post')) {
            $validated = $request->all();

            $data->name = $validated['name'];
            $data->email = $validated['email'];
            if (!empty($validated['password'])) {
                $data->password = Hash::make($validated['password']);
            }
            // $data->qontak_user_id = $validated['qontak_user_id'];
            // $data->qontak_email = $validated['qontak_email'];
            // $data->qontak_password = $validated['qontak_password'];
            $data->phone = $validated['phone'];
            $data->sso = $validated['sso'];
            $data->department_id = $validated['department_id'];
            $data->role = $validated['role'];
            $data->save();

            // return response()->json([
            //     'status' => 'success',
            //     'data' => $data
            // ]);
            
            
            return redirect()->route('setting.accountmanagement');
        } else {
            $divisi = Department::where('id', '!=', '1')->pluck('name', 'id');
            $role = $this->role;
            return view('user.add', compact('divisi', 'role', 'data', 'id'));
        }
    }

    public function delete(Request $request, $id)
    {
        $data = User::find($id)->delete();
        // return response()->json([
        //     'status' => 'success',
        //     'data' => $data
        // ]);
        return redirect()->route('setting.accountmanagement');
    }
}
