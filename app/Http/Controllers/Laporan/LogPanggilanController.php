<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cdr;
use Carbon\Carbon;

class LogPanggilanController extends Controller {

    private $phoneNumber = '0215085754';
    public $monthData =  ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
    public $object = [];
    
    public function createChart ($dt, $flag) {

        $arrHari = [];
        foreach ($dt->toArray() as $d) {
            if ($d['disposition'] == $flag) {
                $hari = Carbon::createFromFormat('Y-m-d H:i:s', $d['calldate'])->format('l');
                array_push($arrHari, $hari);
            }
        }

        return array_count_values($arrHari);

    }

    public function index (Request $request) {

        $month = $this->monthData;
        $currMonth = $request->get('month') ?? Carbon::now()->month;
        $currYear = $request->get('year') ?? Carbon::now()->year;

        $cdr = Cdr::where('src', 'not like', "%{$this->phoneNumber}%")
               ->where(Cdr::raw('CHAR_LENGTH(src)'), '>', 4)
               ->whereMonth('calldate', $currMonth)
               ->whereYear('calldate', $currYear)
               ->get();

        $this->object['answer'] = $this->createChart($cdr, 'ANSWERED');
        $this->object['no_answer'] = $this->createChart($cdr, 'NO ANSWER');
        $chartData = json_encode((object) $this->object);

        return view ('laporan.log-panggilan.index', compact('cdr', 'month', 'chartData'));
    }

}
