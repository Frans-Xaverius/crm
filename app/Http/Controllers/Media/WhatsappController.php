<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\WAChat;
use App\Models\Customer;
use App\Events\MessageEvent;
use App\Models\WAConversation;
use Ramsey\Uuid\Uuid;
use App\Models\User;
use Exception;

class WhatsappController extends Controller
{
    public function index () {

        $customer = Customer::where([
            'is_admin' => 0
        ])->get();

        $users = User::all();

        return view ('media.whatsapp.index', compact('customer', 'users'));
    }


    public function riwayat (Request $request) {

        $data = WAChat::where([
            'from' => $request->get('id')
        ])->orWhere([
            'to' => $request->get('id')
        ])->orderBy('created_at', 'ASC')->get();

        $num = $request->get('num');
        $customer = Customer::where('no_telp', 'like', "%{$num}%")->first();
        $user = User::select('name', 'role')->where([
            'id' => $customer->user_id
        ])->first();

        $res = (object) [
            'chat' => $data,
            'eks' => $user
        ];

        echo json_encode($res);
    }

    public function trigger (Request $request) {

        $content = (object) [
            'message' => $request->get('message'),
            'admin' => $request->get('admin')
        ];

        $event = new MessageEvent($content);
        broadcast($event);

    }

    public function complete (Request $request) {

        $num = $request->post('number');
        $customer = Customer::where('no_telp', 'like', "%{$num}%")->first();

        $conversation = WAConversation::where([
            'customer_id' => $customer->id
        ])->orderBy('created_at', 'DESC')->first();

        $url = $_ENV['URL_WA'];
        $msg = "Berapa rating yang diberikan pada layanan ini?";
        $requestUrl = "{$url}api";


        if (!empty($conversation)) {
            
            WAConversation::where([
                'id' => $conversation->id,
            ])->update([
                'status' => 2
            ]);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $requestUrl);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
            ));

            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
                'num' => $num,
                'msg' => $msg,
            ]));

            curl_exec($ch);
            curl_close($ch);
            
        }

        return redirect()->back();
    }

    public function storeAttachment (Request $request) {

        $num = $request->post('number');
        $caption = $request->post('caption');
        $file = $request->file('file');
        $nameFile = Uuid::uuid4().".".$file->getClientOriginalExtension();
        $file->move($_ENV['PATH_CONVERSATION'], $nameFile);

        $url = $_ENV['URL_WA'];
        $msg = urlencode($nameFile);
        $type = $file->getClientMimeType();
        $requestUrl = "{$url}api";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $requestUrl);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));
        
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            'num' => $num,
            'msg' => $msg,
            'file' => 1,
            'type' => $type,
            'caption' => $caption
        ]));

        curl_exec($ch);
        curl_close($ch);

        return json_encode($request->post());

    }

    public function eskalasi (Request $request) {

        try {
            
            $customer = Customer::where('no_telp', 'like', "%{$request->post('number')}%")->first();

            if (empty($customer)) {
                throw new Exception("User tidak ada", 1);
            }
        
            Customer::where([
                'id' => $customer->id
            ])->update([
                'user_id' => $request->post('user_id')
            ]);

            return redirect()->back()->with('message', ['Update Berhasil', 'success']);

        } catch (Exception $e) {
            
            return redirect()->back()->with('message', [$e->getMessage(), 'danger']);
        }
    }
}
