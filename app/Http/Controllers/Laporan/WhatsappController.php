<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\WAConversation;
use App\Models\Customer;

class WhatsappController extends Controller {

    public function index () {

        $conversation = WAConversation::all();
        $tagsData = $conversation->pluck('tags')->flatten()->pluck('detail')->pluck('name')->toArray();

        $dataChart = (object)[
            'tags' => array_count_values($tagsData)
        ];

        return view('laporan.whatsapp.index', compact('conversation', 'dataChart'));
    }

    public function chat (Request $request) {

        $conversation = WAConversation::find($request->get('id'));
        $adminId = Customer::where([
            'is_admin' => 1
        ])->first()->id;

        return view('laporan.whatsapp.chat.index', compact('conversation', 'adminId'));
    }
}
