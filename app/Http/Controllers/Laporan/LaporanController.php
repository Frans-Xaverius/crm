<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class LaporanController extends Controller {

    protected $phoneNumber = '0215085754';
    protected $monthData =  ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

    public function render () {

        $reader = IOFactory::createReaderForFile('template/Template_Log Panggilan.xlsx');
        $spreadsheet = $reader->load('template/Template_Log Panggilan.xlsx');

        $spreadsheet->getActiveSheet()->fromArray([
            1,2,3,4,5,6
        ], NULL, "B2");

        $writer = new Xlsx($spreadsheet);
        $writer->save(Storage::path('test.xlsx'));

       return response()->download(Storage::path('test.xlsx'), 'test.xlsx');
    }
    
}
