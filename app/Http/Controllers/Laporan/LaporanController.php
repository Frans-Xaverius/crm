<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Response;

class LaporanController extends Controller {

    protected $phoneNumber = '0215085754';
    protected $monthData =  ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
    protected $spreadsheet;

    public function loadSpreadsheet ($file) {
        
        $reader = IOFactory::createReaderForFile($file);
        $this->spreadsheet = $reader->load($file);
    }

    public function render ($newName) {

        $writer = new Xlsx($this->spreadsheet);
        $writer->save(Storage::path('test.xlsx')); 

        header("Content-Description: File Transfer"); 
        header("Content-Type: application/octet-stream"); 
        header("Content-Disposition: attachment; filename={$newName}.xlsx"); 

        readfile(Storage::path('test.xlsx'));
    }
    
}
