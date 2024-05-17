<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\WAConversation;

class WhatsappController extends Controller {

    public function index () {

        $conversation = WAConversation::all();

        return view('laporan.whatsapp.index', compact('conversation'));
    }
}
