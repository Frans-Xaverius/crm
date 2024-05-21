<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\WAConversation;
use App\Models\Customer;
use Carbon\Carbon;

class WhatsappController extends Controller {

    public $monthData =  ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
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
}
