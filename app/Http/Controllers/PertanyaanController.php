<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pertanyaan;

class PertanyaanController extends Controller
{
    public function index () {

        $pertanyaan = Pertanyaan::where('content', '!=', NULL)->get();

        return view ('pertanyaan.index', compact('pertanyaan'));
    }

    public function add () {

        $parent = Pertanyaan::where('content', '!=', NULL)->orderBy('level', 'ASC')->get();

        return view ('pertanyaan.add.index', compact('parent'));
    }

    public function getChild (Request $request) {
        
        $data = Pertanyaan::where([
            'parent_id' => $request->get('id'),
        ])->get();

        echo json_encode($data);   
  
    }

    public function submit (Request $request) {

        $dt = Pertanyaan::find($request->post('parent'));

        $input = [
            'level' => $dt->level + 1,
            'parent_id' => $dt->id,
            'content' => $request->post('pertanyaan'),
            'jawaban' => $request->post('jawaban'),
        ];

        Pertanyaan::create($input);
        return redirect()->route('pertanyaan');
    }
}
