<?php

namespace App\Http\Controllers;

use App\Models\QontakDatas;
use Illuminate\Http\Request;
use App\Models\Room;

class CustomerMonitoringApiController extends Controller
{
    private $qontak_access_token;

    public function getAccessToken()
    {
        $url = 'https://service-chat.qontak.com/oauth/token';
        $curl = curl_init();

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

        if ($err) {
            echo "cURL Error #:" . $err;
        }

        $decodedResponse = json_decode($response);
        $this->qontak_access_token = $decodedResponse->access_token;
    }
    public function getData()
    {
        $this->getAccessToken();

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://service-chat.qontak.com/api/open/v1/contact_objects",
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
        } else {
            echo $response;
        }
    }

    public function channelAbr($channel)
    {
        switch ($channel) {
            case 'fb':
                # code...
                return "Facebook";
                break;

            case 'ig':
                # code...
                return "Instagram";
                break;
            case 'wa':
                # code...
                return "Whatsapp";
                break;
            case 'wa_cloud':
                # code...
                return "Whatsapp";
                break;
            case 'web_chat':
                # code...
                return "Web Chat";
                break;
            case 'email':
                # code...
                return "Email";
                break;
            case 'livechat_dot_com':
                # code...
                return "Live Chat";
                break;

            default:
                # code...
                return "";
                break;
        }
    }

    // public function filterByDate($request)
    // {
    //     // return $request->all();
    //     $fromDate = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($request->from_date)));
    //     $toDate = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($request->to_date)));

    //     $datas = [];

    //     foreach ($request->data as $data) {
    //         $dataUpdatedAt = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($data->updated_at)));
    //         if ($dataUpdatedAt->between($fromDate, $toDate) == true) {
    //             array_push($datas, $data);
    //         }
    //     }

    //     return $datas;
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        // if (!empty($request->from_date) && !empty($request->to_date)) {
        //     $this->data = $this->filterByDate($request);
        // }

        $roomRaw = Room::all();
        $room = [];
        $phone = [];
        foreach ($roomRaw as $key => $value) {
            $room[$value->room_id] = $value->data['channel_integration_id'];
            $phone[$value->room_id] = $value->data['account_uniq_id'];
        }

        $rawdata = QontakDatas::whereBetween('_updated_at', [$request->from_date, $request->to_date])->whereIn('channel', ['wa', 'wa_cloud', 'ig', 'email', 'web_chat', 'fb', 'livechat_dot_com'])->get();
        
        $datas = [];
        foreach ($rawdata as $data) {
            if (!empty($room[$data->_id]) && $room[$data->_id] == env('QONTAK_WA_INTEGRATION_ID')) {
                $datas[] = [
                    'Name' => $data->name ? $data->name : $data->username,
                    'Channel' => $data->channel ? $this->channelAbr($data->channel) : "",
                    'Phone Number' => $phone[$value->room_id],
                    'Email' => $data->channel == "email" || $data->channel == "web_chat" ? $data->username : null,
                    'Username' => $data->channel == "fb" || $data->channel == "ig" ? $data->username : null,
                    'Solved' => !empty($data->resolved_at) ? true : false,
                    'Created At' => $data->created_at->toDateTimeString(),
                    'Status' => $data->status,
                    'c' => !empty($room[$data->_id]) ? $room[$data->_id] : '',
                ];
            }
        }

        return response()->json([
            'data' => $datas
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
