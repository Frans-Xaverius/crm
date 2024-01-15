<?php

namespace App\Http\Controllers;

use App\Models\CallCenter;
use App\Models\QontakDatas;
use App\Models\SentMessage;
use App\Models\Tag;
use Illuminate\Http\Request;
use stdClass;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use App\Models\Room;

class ReportApiController extends Controller
{
    public function __construct()
    {
        // try {
        //     //code...
        //     CallCenter::count();
        //     Config::set('isCallCenterCallAble', true);
        // } catch (\Throwable $th) {
        //     //throw $th;
        //     Config::set('isCallCenterCallAble', false);
        // }
        Config::set('isCallCenterCallAble', false);
    }
    public function get_percentage($total, $number)
    {
        if ($total > 0) {
            return round(($number * 100) / $total, 2);
        } else {
            return 0;
        }
    }

    public function filterCcByDate($fromDate, $toDate, $rawData)
    {
        // return $request->all();
        $fromDate = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($fromDate)));
        $toDate = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($toDate)));

        $datas = [];

        foreach ($rawData as $data) {
            if (!empty($data)) {
                $dataUpdatedAt = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($data->calldate)));
                if ($dataUpdatedAt->between($fromDate, $toDate) == true) {
                    array_push($datas, $data);
                }
            }
        }

        return $datas;
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

    public function getCallData(Request $request)
    {
        // $call = CallCenter::where('_updated_at', date('Y-m-d', strtotime($request->from_date)))
        //     ->get();
        // $yesterdayCall = CallCenter::where('_updated_at', date('Y-m-d', strtotime($request->from_date . "-1 days")))
        //     ->get();

        // $historyData = CallCenter::all();
        // $call = $this->filterCcByDate($request->from_date, $request->from_date, $historyData);
        // $yesterdayCall = $this->filterCcByDate(date('Y-m-d', strtotime($request->from_date . "-1 days")), date('Y-m-d', strtotime($request->from_date . "-1 days")), $historyData);
        $callAble = Config::get('isCallCenterCallAble');
        if ($callAble) {
            $historyData = CallCenter::whereBetween('calldate', [$request->from_date . ' 00:00:00', $request->from_date . ' 23:23:59'])->get();
            $call = CallCenter::whereBetween('calldate', [$request->from_date . ' 00:00:00', $request->from_date . ' 23:23:59'])->get();
            $yesterdayCall = CallCenter::whereBetween('calldate', [date('Y-m-d', strtotime($request->from_date . "-1 days")) . ' 00:00:00', date('Y-m-d', strtotime($request->from_date . "-1 days")) . ' 23:23:59'])->get();
        } else {
            $historyData = 0;
            $call = 0;
            $yesterdayCall = 0;
        }

        $incoming = 0;
        $missed = 0;
        $hold = 0;
        $answer = 0;
        $pincoming = 0;
        $pmissed = 0;
        $phold = 0;
        $panswer = 0;

        $holdLastapp = ['Playback', 'Congestion'];
        $answerLastapp = ['Dial', 'Congestion', 'Busy', 'Playback'];

        if ($callAble){
            foreach ($call as $data) {
                # code...
                $incoming++;
                if (in_array($data->lastapp, $holdLastapp)) {
                    $hold++;
                }
                if (in_array($data->lastapp, $answerLastapp)) {
                    $answer++;
                }
                if ($data->disposition == "NO ANSWER") {
                    $missed++;
                }
            }
            foreach ($yesterdayCall as $data) {
                # code...
                $pincoming++;
                if (in_array($data->lastapp, $holdLastapp)) {
                    $phold++;
                }
                if (in_array($data->lastapp, $answerLastapp)) {
                    $panswer++;
                }
                if ($data->disposition == "NO ANSWER") {
                    $pmissed++;
                }
            }
        }

        $pincoming = $this->get_percentage($incoming, $incoming - $pincoming);
        $phold = $this->get_percentage($hold, $hold - $phold);
        $panswer = $this->get_percentage($answer, $answer - $panswer);
        $pmissed = $this->get_percentage($missed, $missed - $pmissed);

        // $historyData = $historyData->map(function ($data) {
        //     if ($data->lastapp != "Authenticate") {
        //         $data->clid = str_replace(["<", ">", " ", '"'], ["", "", "|", ''], $data->clid);
        //         if (substr($data->clid, 0, 1) == "|") {
        //             $data->clid = str_replace("|", "", $data->clid);
        //         }
        //         $obj = new stdClass();
        //         $obj->id = $data->id;
        //         $obj->calldate = $data->calldate;
        //         $obj->clid = $data->clid;
        //         $obj->src = $data->src;
        //         $obj->dst = $data->dst;
        //         $obj->dcontext = $data->dcontext;
        //         $obj->channel = $data->channel;
        //         $obj->dstchannel = $data->dstchannel;
        //         $obj->lastapp = $data->lastapp;
        //         $obj->lastdata = $data->lastdata;
        //         $obj->duration = $data->duration;
        //         $obj->billsec = $data->billsec;
        //         $obj->disposition = $data->disposition;
        //         $obj->amaflags = $data->amaflags;
        //         $obj->uniqueid = $data->uniqueid;
        //         $obj->userfield = $data->userfield;
        //         $obj->accountcode = $data->accountcode;
        //         $obj->solved = $data->solved ? $data->solved : false;
        //         $obj->created_at = $data->created_at;
        //         $obj->updated_at = $data->updated_at;
        //         return $obj;
        //     }
        // });
        // $historyData = $this->filterCcByDate($request->from_date, $request->from_date, $historyData);

        $obj = new stdClass();

        $obj->incoming = $incoming;
        $obj->hold = $hold;
        $obj->missed = $missed;
        $obj->answer = $answer;
        $obj->pincoming = $pincoming;
        $obj->phold = $phold;
        $obj->pmissed = $pmissed;
        $obj->panswer = $panswer;
        // $obj->history = $call;
        $obj->history = $historyData;

        return $obj;
    }

    public function getQontakData($request)
    {

        $roomRaw = Room::all();
        $room = [];
        foreach ($roomRaw as $key => $value) {
            $room[$value->room_id] = $value->data['channel_integration_id'];
        }
        
        $tgg = Tag::pluck('name', 'id');
        //Conversation tab
        // $historyData = QontakDatas::all();
        $rawhistoryData = QontakDatas::whereBetween('_updated_at', [$request->from_date, $request->to_date])->whereIn('channel', ['wa', 'wa_cloud', 'ig', 'email', 'web_chat', 'fb', 'livechat_dot_com'])->get();

        $historyData = [];
        foreach ($rawhistoryData as $data) {
            if (!empty($room[$data->_id]) && $room[$data->_id] == env('QONTAK_WA_INTEGRATION_ID')) {
                $tag = [];

                if (!empty($data->tags)) {
                    $t = json_decode($data->tags);
                    foreach ($t as  $vv) {
                        $tag[] = $tgg[$vv];
                    }
                }

                $tag = join(", ", $tag);

                $historyData[] = [
                    'Name' => $data->name ? $data->name : $data->username,
                    'Channel' => $data->channel ? $this->channelAbr($data->channel) : "",
                    'Phone Number' => $data->phone_number,
                    'Email' => $data->channel == "email" || $data->channel == "web_chat" ? $data->username : null,
                    'Username' => $data->channel == "fb" || $data->channel == "ig" ? $data->username : null,
                    'Solved' => !empty($data->resolved_at) ? true : false,
                    'Created At' => $data->created_at->toDateTimeString(),
                    'Status' => $data->status,
                    'Tag' => $tag,
                    'Rating' => $data->rating,
                ];
            }
        }

        $rawData = QontakDatas::where('_updated_at', date('Y-m-d', strtotime($request->from_date)))
            ->get();

        $yesterdayRawData = QontakDatas::where('_updated_at', date('Y-m-d', strtotime($request->from_date . "-1 days")))
            ->get();
        $totalSent = SentMessage::where('_created_at', date('Y-m-d', strtotime($request->from_date)))->count();

        $ptotalSent = SentMessage::where('_created_at', date('Y-m-d', strtotime($request->from_date . "-1 days")))->count();

        $tag = [];
        $ptag = [];
        $tg = Tag::orderBy('name', 'asc')->get();

        foreach ($tg as $t) {
            $tag[$t->id] = 0;
            $ptag[$t->id] = 0;
        }

        $read = 0;
        $unread = 0;
        $solved = 0;
        $unsolved = 0;
        $totalConversation = 0;
        $totalIncomingCall = 0;
        $totalUser = 0;

        foreach ($rawData as $data) {
            if (!empty($room[$data->_id]) && $room[$data->_id] == env('QONTAK_WA_INTEGRATION_ID')) {
                $totalConversation++;
                $totalUser++;
                if ($data->resolved_at != null) {
                    $solved++;
                } else {
                    $unsolved++;
                }

                if ($data->unread_count == 0) {
                    $read++;
                } else {
                    $unread++;
                }

                if (!empty($data->tags)) {
                    $t = json_decode($data->tags);
                    foreach ($t as  $vv) {
                        $tag[$vv]++;
                    }
                }
            }
        }

        $pread = 0;
        $punread = 0;
        $psolved = 0;
        $punsolved = 0;
        $ptotalConversation = 0;
        $ptotalIncomingCall = 0;
        $ptotalUser = 0;

        foreach ($yesterdayRawData as $pdata) {
            if (!empty($room[$pdata->_id]) && $room[$pdata->_id] == env('QONTAK_WA_INTEGRATION_ID')) {
                $ptotalConversation++;
                $ptotalUser++;
                if ($pdata->resolved_at != null) {
                    $psolved++;
                } else {
                    $punsolved++;
                }

                if ($pdata->unread_count == 0) {
                    $pread++;
                } else {
                    $punread++;
                }

                if (!empty($pdata->tags)) {
                    $t = json_decode($pdata->tags);
                    foreach ($t as  $vv) {
                        $ptag[$vv]++;
                    }
                }
            }
        }

        $pread = $this->get_percentage($read, $read - $pread);
        $punread = $this->get_percentage($unread, $unread - $punread);
        $psolved = $this->get_percentage($solved, $solved - $psolved);
        $punsolved = $this->get_percentage($unsolved, $unsolved - $punsolved);
        $ptotalConversation = $this->get_percentage($totalConversation, $totalConversation - $ptotalConversation);
        $ptotalIncomingCall = $this->get_percentage($totalIncomingCall, $totalIncomingCall - $ptotalIncomingCall);
        $ptotalSent = $this->get_percentage($totalSent, $totalSent - $ptotalSent);
        $ptotalUser = $this->get_percentage($totalUser, $totalUser - $ptotalUser);

        foreach ($ptag as $key => $value) {
            $ptag[$key] = $this->get_percentage($tag[$key], $tag[$key] - $ptag[$key]);
        }

        $object = new stdClass();

        $object->solved = $solved;
        $object->unsolved = $unsolved;
        $object->read = $read;
        $object->unread = $unread;
        $object->totalSent = $totalSent;
        $object->totalConversation = $totalConversation;
        $object->totalIncomingCall = $totalIncomingCall;
        $object->totalUser = $totalUser;
        $object->pread = $pread;
        $object->punread = $punread;
        $object->psolved = $psolved;
        $object->punsolved = $punsolved;
        $object->ptotalConversation = $ptotalConversation;
        $object->ptotalIncomingCall = $ptotalIncomingCall;
        $object->ptotalSent = $ptotalSent;
        $object->ptotalUser = $ptotalUser;
        $object->history = $historyData;
        $object->tag = $tag;
        $object->ptag = $ptag;

        return $object;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $qontak = $this->getQontakData($request);
        $call = $this->getCallData($request);

        return response()->json([
            'conversation' => [
                'card' => [
                    "read" => $qontak->read,
                    "unread" => $qontak->unread,
                    "solved" => $qontak->solved,
                    "unsolved" => $qontak->unsolved,
                    "totalConversation" => $qontak->totalConversation,
                    "totalIncomingCall" => $qontak->totalIncomingCall,
                    "totalSent" => $qontak->totalSent,
                    "totalUser" => $qontak->totalUser,

                ],
                'persentage' => [
                    "read" => $qontak->pread,
                    "unread" => $qontak->punread,
                    "solved" => $qontak->psolved,
                    "unsolved" => $qontak->punsolved,
                    "totalConversation" => $qontak->ptotalConversation,
                    "totalIncomingCall" => $qontak->ptotalIncomingCall,
                    "totalSent" => $qontak->ptotalSent,
                    "totalUser" => $qontak->ptotalUser,
                ],
                'data' => [
                    "history" => $qontak->history
                ]
            ],
            'call' => [
                'card' => [
                    "incoming" => $call->incoming,
                    "hold" => $call->hold,
                    "missed" => $call->missed,
                    "answer" => $call->answer,

                ],
                'persentage' => [
                    "incoming" => $call->pincoming,
                    "hold" => $call->phold,
                    "missed" => $call->pmissed,
                    "answer" => $call->panswer,
                ],
                'data' => [
                    "history" => $call->history
                ]
            ],
            'tagging' => [
                'card' => $qontak->tag,
                'persentage' => $qontak->ptag
            ]
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
