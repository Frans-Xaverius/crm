<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Department;
use GuzzleHttp\Client;

class UserController extends Controller {

    public function index () {

        $user = User::all();
        $role = UserRole::all();
        $department = Department::all();

        return view('manage.user.index', compact('user', 'role', 'department'));

    }

    public function update (Request $request) {

        User::where([
            'id' => $request->post('id')
        ])->update([
            'role' => $request->post('role'),
            'department_id' => $request->post('department_id')
        ]);

        return redirect()->back()->with(['message' => ['Update berhasil', 'success']]);
    }


    public function delete(Request $request) {

        User::where([
            'id' => $request->post('id')
        ])->delete();

        return redirect()->back()->with(['message' => ['User berhasil dihapus', 'warning']]);
    }

    public function load () {

        $user = User::all();

        foreach ($user as $u) {

            $client = new Client();
            $target = "https://sso-dev.universitaspertamina.ac.id/api/username-check?username={$u->username}";
            $response = $client->request('POST', $target, ['verify' => false]);

            $statusCode = $response->getStatusCode();
            $content = $response->getBody()->getContents();
            $res = json_decode($content);

            if(!empty($res->data)) {

                User::where([
                    'id' => $u->id
                ])->update([
                    'name' => $res->data->name
                ]);
            }
        }

        return redirect()->back()->with(['message' => ['Load user berhasil', 'info']]);

    }
}
