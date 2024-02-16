<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\WAChat;

class WhatsappController extends Controller
{
    public function index () {

        return view ('media.whatsapp.index');
    }
}
