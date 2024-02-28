<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pertanyaan;
use DB;

class PertanyaanController extends Controller
{

    private $arrId = [];

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

    public function edit (Request $request) {

        $data = Pertanyaan::find($request->get('id'));
        $parent = Pertanyaan::where('content', '!=', NULL)->orderBy('level', 'ASC')->get();

        return view ('pertanyaan.edit.index', compact('data', 'parent'));

    }

    public function getAllChild ($pertanyaan) {

        foreach ($pertanyaan as $p) {

            array_push($this->arrId, $p->id);
            $isChildren = Pertanyaan::where('parent_id', $p->id)->get();

            if (!empty($isChildren)) {
                $p->children = $isChildren;
                $this->getAllChild($p->children);
            }
        }

        return $pertanyaan;

    }

    public function delete (Request $request) {

        $pertanyaan = Pertanyaan::where('id', $request->post('id'))->get();
        $dt = $this->getAllChild($pertanyaan);

        Pertanyaan::whereIn('id', $this->arrId)->delete();
        $this->arrId = [];
        return redirect()->route('pertanyaan');
    }

    public function update (Request $request) {


    }

    public function manage (Request $request) {

        $pertanyaan = Pertanyaan::where('id', $request->get('id'))->get();

        $data = $this->getAllChild($pertanyaan)[0];
        return view ('pertanyaan.manage.index', compact('data'));
    }
}
