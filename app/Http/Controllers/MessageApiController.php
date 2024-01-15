<?php

namespace App\Http\Controllers;

use App\Models\SentMessage;
use App\Models\Department;
use App\Models\Eks;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class MessageApiController extends Controller
{
    private $qontak_access_token;
    private $qontakData;

    public function getQontakAccessToken()
    {
        $url = 'https://service-chat.qontak.com/oauth/token';
        $curl = curl_init();

        // curl_setopt_array($curl, [
        //     CURLOPT_URL => $url,
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => "",
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 30,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => "POST",
        //     CURLOPT_POSTFIELDS => "{\n  \"username\": \"" . auth()->user()->qontak_email . "\",\n  \"password\": \"" . auth()->user()->qontak_password . "\",\n  \"grant_type\": \"password\",\n  \"client_id\":\"" . env('QONTAK_CLIENT_ID') . "\",\n  \"client_secret\":\"" . env('QONTAK_CLIENT_SECRET') . "\"\n}",
        //     CURLOPT_HTTPHEADER => [
        //         "Content-Type: application/json"
        //     ],
        // ]);

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n  \"username\": \"" . env('QONTAK_USERNAME') . "\",\n  \"password\": \"" . env('QONTAK_PASSWORD') . "\",\n  \"grant_type\": \"password\",\n  \"client_id\":\"" . env('QONTAK_CLIENT_ID') . "\",\n  \"client_secret\":\"" . env('QONTAK_CLIENT_SECRET') . "\"\n}",
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        //dd($response);

        if ($err) {
            echo "cURL Error #:" . $err;
        }
        // else {
        //     echo $response;
        // }
        $decodedResponse = json_decode($response);
        $this->qontak_access_token = $decodedResponse->access_token;
    }

    public function getQontakData($page = 1)
    {
        $this->getQontakAccessToken();

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://service-chat.qontak.com/api/open/v1/rooms?offset=" . $page,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer" . $this->qontak_access_token,
                "Content-Type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        }

        $decoded = json_decode($response);

        // array_map($decoded->data, function ($data) {
        //     var_dump($data->channel);
        //     return $data;
        // });

        $decoded->data = array_filter($decoded->data, function ($data) {
            $app = ['wa', 'wa_cloud', 'fb', 'livechat_dot_com', 'ig', 'web_chat', 'email', 'telegram'];
            // $app = json_decode(auth()->user()->Department->app);
            if (in_array($data->channel, $app)) {
                return $data;
            }
        }, 1);
        $decoded->data = array_values($decoded->data);

        $data = [];
        if (count($decoded->data)) {
            // for ($i = 0; $i < count($decoded->data); $i++) {
            //     if ($decoded->data[$i]->channel_integration_id == env('QONTAK_WA_INTEGRATION_ID')) {
            //         $data[] = $decoded->data[$i];
            //         // Perform your desired action when channel_integration_id matches the env value
            //         // For example:
            //     }
            foreach ($decoded->data as $key => $value) {
                // if (($value->channel == 'wa' || $value->channel == 'wa_cloud') && $value->channel_integration_id != env('QONTAK_WA_INTEGRATION_ID')) {
                //     continue;
                // }

                if ($value->channel_integration_id == env('QONTAK_WA_INTEGRATION_ID')) {
                    $data[] = $value;
                    $room = Room::where('room_id', $value->id)->first();
                    if (empty($room)) $room = new Room();
                    $room->room_id = $value->id;
                    $room->datetime = date('Y-m-d H:i:s', strtotime($value->last_activity_at));
                    $room->data = $value;
                    $room->save();
                }
            }
        }
        // $this->qontakData = $data;
        return $data;

        // $rooms = Room::orderBy('datetime', 'desc')->get();
        // $erooms = [];
        // foreach ($rooms as $key => $value) {
        //     $erooms[$value->room_id] = $value->data;
        // }

        // return $erooms;
    }

    // public function index() {
    //     $data = QontakDatas::where('resolved_at', null)->orderByDesc('updated_at')->get();

    //     return response()->json([
    //         'status' => 'success',
    //         'data' => $data
    //     ]);
    // }

    // public function getRoomHistory(Request $request)
    // {
    //     $chatHistory = SentMessage::where('room_id', $request->room_id)->get()->sortBy('_created_at');
    //     return response()->json([
    //         'status' => 'success',
    //         'data' => $chatHistory
    // ]);
    public function index()
    {
        $qdata1 = $this->getQontakData();
        $qdata2 = $this->getQontakData(2);
        $qdata3 = $this->getQontakData(3);
        // $qdata = array_merge($qdata1, $qdata2, $qdata3);

        $rooms = Room::orderBy('datetime', 'desc')->get();
        $qdata = [];
        foreach ($rooms as $key => $value) {
            $qdata[] = $value->data;
        }

        if (!in_array(auth()->user()->role, ['admin', 'supervisor'])) {
            $eks = Eks::pluck('d_id', 'r_id')->toArray();
            $eks_key = array_keys($eks);
            $data = [];
            foreach ($qdata as $key => $value) {
                if(in_array($value['id'], $eks_key) && !empty($eks[$value['id']]) && in_array(auth()->user()->department_id, $eks[$value['id']])) {
                    $data[] = $value;
                }
            }
        } else {
            $data = $qdata;
        }

        return response()->json([
            'status' => 'success',
            'data' => $data,
            // 'a' => auth()->user()->role,
        ]);
    }

    public function getRoomHistory(Request $request)
    {
        // //
        // $this->getQontakAccessToken();

        // // read
        $this->markAllAsRead($request);

        // $curl = curl_init();
        // curl_setopt_array($curl, [
        //     CURLOPT_URL => "https://service-chat.qontak.com/api/open/v1/rooms/" . $request->room_id . "/histories",
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => "",
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 30,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => "GET",
        //     CURLOPT_HTTPHEADER => [
        //         "Authorization: Bearer" . $this->qontak_access_token,
        //         "Content-Type: application/json"
        //     ],
        // ]);

        // $response = curl_exec($curl);
        // $err = curl_error($curl);

        // curl_close($curl);

        // $decoded = json_decode($response);

        $chatHistory = SentMessage::where('room_id', $request->room_id)->get();

        return response()->json([
            'status' => 'success',
            // 'data' => $decoded->data,
            'data' => $chatHistory
        ]);
    }

    public function markRoomAsResolved(Request $request)
    {
        $this->getQontakAccessToken();

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://service-chat.qontak.com/api/open/v1/rooms/" . $request->room_id . "/resolve",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_POSTFIELDS => "-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"agent_id\"\r\n\r\n\r\n-----011000010111000001101001--\r\n\r\n",
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer" . $this->qontak_access_token,
                "Content-Type: multipart/form-data; boundary=---011000010111000001101001"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $decoded = json_decode($response);

        $date = date('Y-m-d H:i:s');
        SentMessage::where('room_id', $request->room_id)->update([
            'resolved_at' => $date
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $decoded
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendMessage(Request $request)
    {
        $this->getQontakAccessToken();

        $curl = curl_init();
        $file_names = [];
        $file_urls = [];
        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $key => $file) {
                # code...
                $name = $request->room_id + $file->getClientOriginalName() + $file->getClientOriginalExtension();
                $file_names[] = $name;
                $file_urls[] = $file->storeAs('message_files', $name, 'public');
            }
        }

        if ($request->channel != "email") {

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://service-chat.qontak.com/api/open/v1/messages/" . $request->channel,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"room_id\"\r\n\r\n" . $request->room_id . "\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"type\"\r\n\r\ntext\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"cc\"\r\n\r\n\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"text\"\r\n\r\n" . $request->text . "\r\n-----011000010111000001101001--\r\n\r\n",
                CURLOPT_HTTPHEADER => [
                    "Authorization: Bearer" . $this->qontak_access_token,
                    "Content-Type: multipart/form-data; boundary=---011000010111000001101001"
                ],
            ]);
        } else {
            //
            $request->type = 'text';

            $curl = curl_init();

            // curl_setopt_array($curl, [
            //     CURLOPT_URL => "https://service-chat.qontak.com/api/open/v1/messages/email",
            //     CURLOPT_RETURNTRANSFER => true,
            //     CURLOPT_ENCODING => "",
            //     CURLOPT_MAXREDIRS => 10,
            //     CURLOPT_TIMEOUT => 30,
            //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //     CURLOPT_CUSTOMREQUEST => "POST",
            //     CURLOPT_POSTFIELDS => "-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"room_id\"\r\n\r\n" . $request->room_id . "\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"type\"\r\n\r\n" . $request->type . "\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"text\"\r\n\r\n" . $request->text . "\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"created_at\"\r\n\r\n" . date('Y-m-d') . "\r\n-----011000010111000001101001--\r\n\r\n",
            //     CURLOPT_HTTPHEADER => [
            //         "Authorization: Bearer" . $this->qontak_access_token,
            //         "Content-Type: multipart/form-data; boundary=---011000010111000001101001"
            //     ],
            // ]);

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://service-chat.qontak.com/api/open/v1/messages/email",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"room_id\"\r\n\r\n" . $request->room_id . "\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"type\"\r\n\r\n" . $request->type . "\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"text\"\r\n\r\n" . $request->text . "\r\n-----011000010111000001101001--\r\n\r\n",
                CURLOPT_HTTPHEADER => [
                    "Authorization: Bearer " . $this->qontak_access_token,
                    "Content-Type: multipart/form-data; boundary=---011000010111000001101001"
                ],
            ]);
        }

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $decoded = json_decode($response);
        $data = $decoded->data;
        $room_id = $data->room_id;
        $type = $data->type;
        $text = $data->text;
        $sender_id = $data->sender_id;
        $sender_name = $data->sender->name;
        $channel = $request->channel;
        $attachment = implode(',', $file_urls);
        $filename = implode(',', $file_names);
        $file_url = $attachment;
        $_created_at = $data->room->last_message_at;

        $newMessage = new SentMessage();
        $newMessage->room_id = $room_id;
        $newMessage->type = $type;
        $newMessage->text = $text;
        $newMessage->sender_id = $sender_id;
        $newMessage->sender_name = $sender_name;
        $newMessage->channel = $channel;
        $newMessage->attachment = $attachment;
        $newMessage->filename = $filename;
        $newMessage->file_url = $file_url;
        $newMessage->_created_at = $_created_at;
        $newMessage->avatar = $data->room->avatar->url;
        $newMessage->name = $data->room->name;
        $newMessage->account_uniq_id = $data->room->account_uniq_id;
        $newMessage->channel_account = $data->room->channel_account;
        $newMessage->participant_type = 'agent';
        $newMessage->save();

        return response()->json([
            'status' => 'success',
            'data' => $newMessage
        ]);
    }

    public function assignAgentToRoom(Request $request)
    {
        // $this->getQontakAccessToken();

        // $d = $this->removeAgentFromRoom($request);

        // $decoded = null;
        // if (!empty($request->agent_id)) {
        //     foreach ($request->agent_id as $key => $value) {
        //         $curl = curl_init();

        //         curl_setopt_array($curl, [
        //             CURLOPT_URL => "https://service-chat.qontak.com/api/open/v1/rooms/" . $request->room_id . "/agents/" . $value,
        //             CURLOPT_RETURNTRANSFER => true,
        //             CURLOPT_ENCODING => "",
        //             CURLOPT_MAXREDIRS => 10,
        //             CURLOPT_TIMEOUT => 30,
        //             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //             CURLOPT_CUSTOMREQUEST => "POST",
        //             CURLOPT_POSTFIELDS => "",
        //             CURLOPT_HTTPHEADER => [
        //                 "Authorization: Bearer" . $this->qontak_access_token,
        //                 "Content-Type: application/json"
        //             ],
        //         ]);

        //         $response = curl_exec($curl);
        //         $err = curl_error($curl);

        //         curl_close($curl);
        //         $decoded = json_decode($response);
        //     }
        // }

        // return response()->json([
        //     'status' => 'success',
        //     'data' => $decoded
        // ]);

        $data = Eks::where('r_id', $request->room_id)->first();
        if (empty($data)) {
            $data = new Eks();
        }
        $data->r_id = $request->room_id;
        $data->d_id = !empty($request->agent_id) ? $request->agent_id : [];
        $data->save();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function removeAgentFromRoom(Request $request)
    {
        //
        // $this->getQontakAccessToken();

        // $removeAgent = null;
        // foreach ($this->eskalasi as $key => $value) {
        //     if ($key != $request->agent_id) {
        //         $removeAgent = $key;
        //     }
        // }

        $decoded = null;
        // $esKeys = array_keys($this->eskalasi);
        $divisi = Department::where('id', '!=', '1')->pluck('name', 'q_id')->toArray();
        $esKeys = array_keys($divisi);
        if (!empty($request->agent_id)) {
            $diff = array_diff($esKeys, $request->agent_id);
        } else {
            $diff = $esKeys;
        }

        foreach ($diff as $key => $value) {
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://service-chat.qontak.com/api/open/v1/rooms/" . $request->room_id . "/agents/" . $value,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "DELETE",
                CURLOPT_HTTPHEADER => [
                    "Authorization: Bearer" . $this->qontak_access_token,
                    "Content-Type: application/json"
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);
            $decoded = json_decode($response);
        }

        return response()->json([
            'status' => 'success',
            'data' => $decoded
        ]);
    }

    public function markAllAsRead(Request $request)
    {
        $this->getQontakAccessToken();

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://service-chat.qontak.com/api/open/v1/rooms/" . $request->room_id . "/mark_all_as_read",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer" . $this->qontak_access_token,
                "Content-Type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        $decoded = json_decode($response);
        return response()->json([
            'status' => 'success',
            'data' => $decoded
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function eskalasi()
    {
        $divisi = Department::where('id', '!=', '1')->pluck('name', 'id')->toArray();
        return response()->json([
            'status' => 'success',
            'data' => $divisi
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
