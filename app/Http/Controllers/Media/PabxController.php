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
        $pabx = Pabx::select('*')
                ->whereMonth('calldate', $now->month)
                ->whereYear('calldate', $now->year)
                ->whereDay('calldate', $now->day)
                ->get();

        $callDate = $pabx->pluck('calldate')->toArray();
        $cdr = Cdr::where('src', 'not like', "%{$this->phoneNumber}%")
               ->where(Cdr::raw('CHAR_LENGTH(src)'), '>', 4)
               ->whereMonth('calldate', $now->month)
               ->whereYear('calldate', $now->year)
               ->whereDay('calldate', $now->day)
               ->whereNotIn('calldate', $callDate)
               ->get();

        return view('media.pabx.index', compact('cdr'));
    }

    public function submit (Request $request) {

        Pabx::create([
            'calldate' => $request->post('calldate'),
            'number' => $request->post('number'),
            'durasi' => $request->post('durasi'),
            'catatan' => $request->post('catatan'),
            'respon' => $request->post('respon')
        ]);

        return redirect()->back();
    }
}
