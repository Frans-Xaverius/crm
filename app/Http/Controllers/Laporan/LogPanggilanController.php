<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cdr;
use Carbon\Carbon;
use App\Models\Pabx;

class LogPanggilanController extends Controller {

    private $phoneNumber = '0215085754';
    public $monthData =  ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
    public $object = [];

    protected function createChart ($dt, $flag) {

        $arrHari = [];
        foreach ($dt->toArray() as $d) {

            if ($d['disposition'] == $flag) {
                $carbonDate = Carbon::createFromFormat('Y-m-d H:i:s', $d['calldate'])->locale('id');
                $hari = $carbonDate->getTranslatedDayName('dddd');
                array_push($arrHari, $hari);
            }
        }

        return array_count_values($arrHari);
    }

    protected function createDuration ($dt, $flag) {

        $dt = $dt->where('disposition', $flag);
        $dt = array_column($dt->toArray(), 'duration', 'calldate');
        $arrDuration = [];
        $curr = 0;

        foreach ($dt as $k => $d) {

            $date = (int) Carbon::createFromFormat('Y-m-d H:i:s', $k)->format('d');

            if ($date > $curr) {
                
                array_push($arrDuration, (object) [
                    'date' => $date,
                    'detik' => $d,
                ]);

                $curr = $date;

            } else {
                
                $len = count($arrDuration);
                $arrDuration[$len - 1]->detik += $d; 
            }
        }

        return $arrDuration;
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

        $duration = json_encode((object) [
            'answer' => $this->createDuration($cdr, 'ANSWERED'),
            'noAnswer' => $this->createDuration($cdr, 'NO ANSWER')
        ]);

        return view ('laporan.log-panggilan.index', compact('cdr', 'month', 'chartData', 'duration', 'currMonth', 'currYear'));
    }

}
