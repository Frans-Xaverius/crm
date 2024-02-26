<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cdr;
use Carbon\Carbon;

class LogPanggilanController extends Controller {

    private $phoneNumber = '0215085754';
    public $monthData =  ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
    
    public function index (Request $request) {

        $month = $this->monthData;
        $currMonth = $request->get('month') ?? Carbon::now()->month;
        $currYear = $request->get('year') ?? Carbon::now()->year;

        $cdr = Cdr::where('src', 'not like', "%{$this->phoneNumber}%")
               ->where(Cdr::raw('CHAR_LENGTH(src)'), '>', 4)
               ->whereMonth('calldate', $currMonth)
               ->whereYear('calldate', $currYear)
               ->get();

        return view ('laporan.log-panggilan.index', compact('cdr', 'month'));
    }

}
