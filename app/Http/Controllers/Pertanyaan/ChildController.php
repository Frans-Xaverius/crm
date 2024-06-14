<?php

namespace App\Http\Controllers\Pertanyaan;

use App\Http\Controllers\Pertanyaan\PertanyaanController;
use Illuminate\Http\Request;
use App\Models\Pertanyaan;
use DB;
use Ramsey\Uuid\Uuid;

class ChildController extends PertanyaanController {
    
    public function update (Request $request) {

        if ($request->post('jawaban')) {

            $source = [
                'jawaban' => $request->post('jawaban')
            ];

            $file = $request->file('file_support');

            if ($file != NULL) {

                $nameFile = Uuid::uuid4().".".$file->getClientOriginalExtension();
                $file->move(env('PATH_STORAGE'), $nameFile);
                $source['file_support'] = $nameFile;
                $source['mime_type'] = $file->getClientMimeType();

            }

            Pertanyaan::where([
                'id' => $request->post('id')
            ])->update($source);

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
        $source = [
            'parent_id' => $request->post('id'),
            'level' => $request->post('level') + 1,
            $type => $request->post($type)
        ];

        $file = $request->file('file_support');
        
        if ($file != NULL) {

            $nameFile = Uuid::uuid4().".".$file->getClientOriginalExtension();
            $file->move(env('PATH_STORAGE'), $nameFile);
            $source['file_support'] = $nameFile;
            $source['mime_type'] = $file->getClientMimeType();
            
        }

        Pertanyaan::create($source);

        return redirect()->back();

    }

    public function delete (Request $request) {

        $pertanyaan = Pertanyaan::where('id', $request->post('id'))->get();
        $level = $pertanyaan[0]->level;

        $dt = $this->getAllChild($pertanyaan);

        Pertanyaan::whereIn('id', $this->arrId)->delete();
        $this->arrId = [];

        if ($level == 1) {

            return redirect()->route('pertanyaan');

        } else {

            return redirect()->back();

        }
        
    }

}
