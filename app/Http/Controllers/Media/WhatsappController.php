<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\WAChat;
use App\Models\Customer;
use App\Events\MessageEvent;
use App\Events\QrEvent;
use App\Models\WAConversation;
use Ramsey\Uuid\Uuid;
use App\Models\User;
use Exception;
use Auth;
use App\Models\Tag;
use App\Models\WATag;

class WhatsappController extends Controller
{
    public function index () {

        $role = Auth::user()->detailRole->name;

        if ($role == "Super Admin") {

            $conversation = WAConversation::where([
                'status' => 1
            ])->get();

        } else {

            $conversation = WAConversation::where([
                'status' => 1,
                'user_id' => Auth::user()->id
            ])->get();
        }

        $users = User::all();
        $tag = Tag::all();
        $adminId = Customer::where([
            'is_admin' => 1
        ])->first()->id;

        return view ('media.whatsapp.index', compact('conversation', 'users', 'tag', 'adminId'));
    }


    public function riwayat (Request $request) {

        $conversation = WAConversation::where([
            'id' => $request->get('id'),
        ])->first();

        $res = (object) [
            'chat' => $conversation->chat ?? [],
            'eks' => $conversation->user,
            'tag' => !empty($conversation->tags) ? $conversation->tags->pluck('tags_id')->toArray() : [],
            'customer' => $conversation->customer
        ];

        echo json_encode($res);

    }

    public function trigger (Request $request) {

        $event = null;

        if ($request->get('message')) {

            $content = (object) [
                'message' => $request->get('message'),
                'admin' => $request->get('admin')
            ];

            $event = new MessageEvent($content);
        }

        if ($request->get('token')) {

            $event = new QrEvent($request->get('token'));
        }

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
            
            WAConversation::where([
                'id' => $request->post('conv_id')
            ])->update([
                'user_id' => $request->post('user_id')
            ]);

            return redirect()->back()->with('message', ['Update Berhasil', 'success']);

        } catch (Exception $e) {
            
            return redirect()->back()->with('message', [$e->getMessage(), 'danger']);
        }
    }

    public function setTag (Request $request) {

        WATag::where([
            'wa_conversation_id' => $request->post('conv_id'),
        ])->delete();

        foreach ($request->post('tags') as $t) {
            
            WATag::create([
                'tags_id' => $t,
                'wa_conversation_id' => $request->post('conv_id'),
            ]);
        }

        return redirect()->back()->with('message', ['Update Berhasil', 'success']);
    }
}
