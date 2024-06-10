<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Laporan\LaporanController;
use Illuminate\Http\Request;

use App\Models\WAConversation;
use App\Models\Customer;
use Carbon\Carbon;

class WhatsappController extends LaporanController {

    public function index (Request $request) {

        $month = $this->monthData;
        $currMonth = $request->get('month') ?? Carbon::now()->month;
        $currYear = $request->get('year') ?? Carbon::now()->year;

        $conversation = WAConversation::whereMonth('created_at', $currMonth)
                        ->whereYear('created_at', $currYear)
                        ->get();
                        
        $tags = $conversation->pluck('tags')->flatten()->pluck('detail')->pluck('name')->toArray();
        $eskalasi = $conversation->pluck('user')->flatten()->pluck('name')->toArray();

        $dataChart = (object)[
            'tags' => array_count_values($tags),
            'eskalasi' => array_count_values($eskalasi)
        ];

        return view('laporan.whatsapp.index', compact('conversation', 'dataChart', 'month', 'currYear', 'currMonth'));
    }

    public function chat (Request $request) {

        $conversation = WAConversation::find($request->get('id'));
        $adminId = Customer::where([
            'is_admin' => 1
        ])->first()->id;

        return view('laporan.whatsapp.chat.index', compact('conversation', 'adminId'));
    }

    public function unduh (Request $request) {

        $this->loadSpreadsheet('template/Template_Log Whatsapp.xlsx');
        $month = $request->post('month');
        $year = $request->post('year');

        $conv = WAConversation::whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->get();

        $ord = 2;
        foreach ($conv as $k => $c) {

            $arrTags = $c->tags->flatten()->pluck('detail')->pluck('name')->toArray();

            $this->spreadsheet->getActiveSheet()->fromArray([
                $k + 1,
                date("d-m-Y", strtotime($c->created_at)),
                $c->user->name ?? 'Tidak ditentukan',
                $c->customer->no_telp ?? '-',
                $c->customer->nama ?? '-',
                implode(", ", $arrTags),
                $c->chat->count(),
                $c->rate,
            ], NULL, "A{$ord}");

            $ord++;
        }

         $this->render("Log Whatsapp_ {$month}-{$year}");
    }
}
