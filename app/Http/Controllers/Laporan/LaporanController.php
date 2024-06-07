<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;
use App\Models\Pabx;

use Illuminate\Support\Facades\Response;

class LaporanController extends Controller {

    protected $phoneNumber = '0215085754';
    protected $monthData =  ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

    public function render ($month, $year) {

        $pabx = Pabx::whereMonth('calldate', $month)
                   ->whereYear('calldate', $year)
                   ->get();

        $reader = IOFactory::createReaderForFile('template/Template_Log Panggilan.xlsx');
        $spreadsheet = $reader->load('template/Template_Log Panggilan.xlsx');
        $ord = 2;

        foreach ($pabx as $k => $c) {

            $spreadsheet->getActiveSheet()->fromArray([
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

        $writer = new Xlsx($spreadsheet);
        $writer->save(Storage::path('test.xlsx')); 

        header("Content-Description: File Transfer"); 
        header("Content-Type: application/octet-stream"); 
        header("Content-Disposition: attachment; filename=Log Panggilan {$month}-{$year}.xlsx"); 

        readfile(Storage::path('test.xlsx'));
    }
    
}
