<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Laporan\LaporanController;
use Illuminate\Http\Request;
use App\Models\Cdr;
use Carbon\Carbon;
use App\Models\Pabx;
use App\Helper\ChartCall;
use Exception;

class LogPanggilanController extends LaporanController {

    public function index (Request $request) {

        try {

            $month = $this->monthData;
            $currMonth = $request->get('month') ?? Carbon::now()->month;
            $currYear = $request->get('year') ?? Carbon::now()->year;

            $cdr = Cdr::where('src', 'not like', "%{$this->phoneNumber}%")
                   ->where(Cdr::raw('CHAR_LENGTH(src)'), '>', 4)
                   ->whereMonth('calldate', $currMonth)
                   ->whereYear('calldate', $currYear)
                   ->get();

            $pabx = Pabx::whereMonth('calldate', $currMonth)
                   ->whereYear('calldate', $currYear)
                   ->get();

            $chartCall = new ChartCall($cdr);
            $chartData = json_encode((object) [
                'answer' => $chartCall->jumlahPanggilan('ANSWERED', 'disposition'),
                'no_answer' => $chartCall->jumlahPanggilan('NO ANSWER', 'disposition'),
            ]);

            $duration = json_encode((object) [
                'answer' => $chartCall->durasiPanggilan('ANSWERED'),
                'noAnswer' => $chartCall->durasiPanggilan('NO ANSWER')
            ]);

            $pabxCall = new ChartCall($pabx); 
            $pabxPanggilan = json_encode((object)[
                'answer' => $pabxCall->jumlahPanggilan('ANSWERED', 'respon'),
                'no_answer' => $pabxCall->jumlahPanggilan('NO ANSWER', 'respon'),
            ]);

            return view ('laporan.log-panggilan.index', 
                compact('cdr', 'month', 'chartData', 'duration', 'currMonth', 'currYear', 'pabxCall')
            );

        } catch(Exception $e) {

            return redirect()->route('home')->with(['message' => [$e->getMessage(), 'danger']]);
        }
    }

    public function unduh (Request $request) {

        $this->loadSpreadsheet('template/Template_Log Panggilan.xlsx');
        $month = $request->post('month');
        $year = $request->post('year');

        $pabx = Pabx::whereMonth('calldate', $month)
                ->whereYear('calldate', $year)
                ->get();

        $ord = 2;
        foreach ($pabx as $k => $c) {
            $this->spreadsheet->getActiveSheet()->fromArray([
                $k + 1,
                date("d-m-Y", strtotime($c->calldate)),
                date("h:i:s", strtotime($c->calldate)),
                $c->number,
                $c->respon,
                $c->durasi,
                strip_tags($c->catatan)
            ], NULL, "A{$ord}");
            $ord++;
        }

        $this->render("Log Panggilan_ {$month}-{$year}");
    }

}
