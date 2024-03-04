<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\WAChat;
use App\Models\Customer;
use App\Events\MessageEvent;

class WhatsappController extends Controller
{
    public function index () {

        $customer = Customer::where([
            'is_admin' => 0
        ])->get();

        return view ('media.whatsapp.index', compact('customer'));
    }


    public function riwayat (Request $request) {

        $data = WAChat::where([
            'from' => $request->get('id')
        ])->orWhere([
            'to' => $request->get('id')
        ])->orderBy('created_at', 'ASC')->get();

        echo json_encode($data);
    }

    public function trigger (Request $request) {

        $content = (object) [
            'message' => $request->get('message'),
            'admin' => $request->get('admin')
        ];

        $event = new MessageEvent($content);
        broadcast($event);

    }
}
