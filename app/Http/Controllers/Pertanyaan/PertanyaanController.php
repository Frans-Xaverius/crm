<?php

namespace App\Http\Controllers\Pertanyaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pertanyaan;
use DB;

class PertanyaanController extends Controller
{

    protected $arrId = [];

    public function index () {

        $pertanyaan = Pertanyaan::where('level', '=', 1)->get();

        return view ('pertanyaan.index', compact('pertanyaan'));
    }

    public function submit (Request $request) {

        $input = [
            'level' => 1,
            'content' => $request->post('content'),
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

    public function manage (Request $request) {

        $pertanyaan = Pertanyaan::where('id', $request->get('id'))->get();

        $data = $this->getAllChild($pertanyaan)[0];
        return view ('pertanyaan.manage.index', compact('data'));
    }
}
