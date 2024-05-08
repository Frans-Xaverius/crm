<?php

namespace App\Helper;
use Carbon\Carbon;

class ChartCall {
	
	public $masterData;

	public function __construct($dt) {
		
		$this->masterData = $dt;
	}

	public function jumlahPanggilan ($flag, $row) {

		$arrHari = [];
        foreach ($this->masterData->toArray() as $d) {

            if ($d[$row] == $flag) {
                $carbonDate = Carbon::createFromFormat('Y-m-d H:i:s', $d['calldate'])->locale('id');
                $hari = $carbonDate->getTranslatedDayName('dddd');
                array_push($arrHari, $hari);
            }
        }

        return array_count_values($arrHari);
	}

	public function durasiPanggilan ($flag) {

		$dt = $this->masterData->where('disposition', $flag);
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

}