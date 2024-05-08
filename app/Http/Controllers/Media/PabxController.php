<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cdr;
use Carbon\Carbon;
use App\Models\Pabx;

class PabxController extends Controller {
    
    private $phoneNumber = '0215085754';

    public function index () {

        $now = Carbon::now();
        $cdr = Cdr::where('src', 'not like', "%{$this->phoneNumber}%")
               ->where(Cdr::raw('CHAR_LENGTH(src)'), '>', 4)
               ->whereMonth('calldate', $now->month)
               ->whereYear('calldate', $now->year)
               ->whereDay('calldate', $now->day)
               ->get();

        return view('media.pabx.index', compact('cdr'));
    }

    public function submit (Request $request) {

        $check = Pabx::where([
            'calldate' => $request->post('calldate'),
        ])->first();

        $arrData = [
            'number' => $request->post('number'),
            'durasi' => $request->post('durasi'),
            'catatan' => $request->post('catatan'),
            'respon' => $request->post('respon')
        ];

        if (empty($check)) {

            $arrData['calldate'] = $request->post('calldate');
            Pabx::create($arrData);

        } else {

            Pabx::where([
                'id' => $check->id
            ])->update($arrData);
        }

        return redirect()->back()->with('message', ['Action Berhasil', 'success']);;
    }
}
