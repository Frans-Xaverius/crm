<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

use function GuzzleHttp\Promise\all;

class DepartmentApiController extends Controller
{
    //

    public function index()
    {
        $data = Department::where('id', '!=', '1')->orderBy('id', 'desc')->get();
        // return response()->json([
        //     'status' => 'success',
        //     'data' => $data
        // ]);
        return view('agent.index', compact('data'));
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $validated = $request->all();

            $data = new Department();
            $data->name = $validated['name'];
            $data->department = $validated['department'];
            $data->app = json_encode($validated['app']);

            $divisi = Department::where('id', '!=', '1')->pluck('name', 'q_id')->toArray();
            $acc = array_keys($this->q_acc);
            $d = array_keys($divisi);
            $diff = array_diff($acc, $d);

            if (count($diff)) {
                $diff = array_values($diff);
                $q_id = $diff[0];
                $data->q_id = $q_id;
                $data->email = $this->q_acc[$q_id]['email'];
                $data->password = $this->q_acc[$q_id]['password'];
                $data->save();
            }

            // return response()->json([
            //     'status' => 'success',
            //     'data' => $data
            // ]);


            return redirect()->route('setting.agentmanagement');
        } else {
            $app = $this->app;
            return view('agent.add', compact('app'));
        }
    }

    public function edit(Request $request, $id)
    {
        $data = Department::find($id);
        if ($request->isMethod('post')) {
            $validated = $request->all();

            $data->name = $validated['name'];
            $data->department = $validated['department'];
            $data->app = json_encode($validated['app']);
            $data->save();

            return redirect()->route('setting.agentmanagement');
        } else {
            $app = $this->app;
            return view('agent.add', compact('id', 'data', 'app'));
        }
    }

    public function delete(Request $request, $id)
    {
        $data = Department::find($id)->delete();
        // return response()->json([
        //     'status' => 'success',
        //     'data' => $data
        // ]);

        return redirect()->route('setting.agentmanagement');
    }
}
