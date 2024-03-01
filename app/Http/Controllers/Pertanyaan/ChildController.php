<?php

namespace App\Http\Controllers\Pertanyaan;

use App\Http\Controllers\Pertanyaan\PertanyaanController;
use Illuminate\Http\Request;
use App\Models\Pertanyaan;
use DB;

class ChildController extends PertanyaanController {
    
    public function update (Request $request) {

        if ($request->post('jawaban')) {

            Pertanyaan::where([
                'id' => $request->post('id')
            ])->update([
                'jawaban' => $request->post('jawaban')
            ]);

        } else {

            Pertanyaan::where([
                'id' => $request->post('id')
            ])->update([
                'content' => $request->post('pertanyaan')
            ]);

        }

        return redirect()->back();

    }

    public function append (Request $request) {

        $type = $request->post('select-type');

        Pertanyaan::create([
            'parent_id' => $request->post('id'),
            'level' => $request->post('level') + 1,
            $type => $request->post($type)
        ]);

        return redirect()->back();
    }

}
