<?php

namespace App\Http\Controllers;

use App\Models\CallCenter;
use App\Models\CallCenterr;
use App\Models\QontakDatas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class CallCenterApiController extends Controller
{
    public $isCallCenter = true;
    public function __construct()
    {
        try {
            $cc = CallCenter::count();
        } catch (\Exception $e) {
            $this->isCallCenter = false;
        }
    }

    public function get_percentage($total, $number)
    {
        if ($total > 0) {
            return round(($number * 100) / $total, 0);
        } else {
            return 0;
        }
    }

    // public function filterByDate($request)
    // {
    //     // return $request->all();
    //     $fromDate = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($request->from_date)));
    //     $toDate = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($request->to_date)));

    //     $datas = [];

    //     foreach ($data as $data) {
    //         $dataUpdatedAt = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($data->updated_at)));
    //         if ($dataUpdatedAt->between($fromDate, $toDate) == true) {
    //             array_push($datas, $data);
    //         }
    //     }

    //     return $datas;
    // }

    public function filterByDate($fromDate, $toDate, $rawData)
    {
        // return $request->all();
        $fromDate = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($fromDate)));
        $toDate = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($toDate)));

        $datas = [];

        foreach ($rawData as $data) {
            $dataUpdatedAt = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($data->calldate)));
            if ($dataUpdatedAt->between($fromDate, $toDate) == true) {
                array_push($datas, $data);
            }
        }

        return $datas;
    }

    public function getGraphData($rawData)
    {
        $daily = [];
        $weekly = [];
        $monthly = [];
        $yearly = [];

        // dayly
        $dailyWa = $rawData;

        $raw2DailyWa = [];
        foreach ($dailyWa as $value) {
            $raw2DailyWa[date('d M', strtotime($value->calldate))][] = $value;
        }

        foreach ($raw2DailyWa as $k => $v) {
            $dailyanswer = 0;
            $dailyUnanswer = 0;
            foreach ($v as $vv) {
                if (empty($daily[$k]['answer'])) {
                    $daily[$k]['date'] = $k;
                    $daily[$k]['answer'] = 0;
                    $daily[$k]['unanswer'] = 0;
                }
                if ($vv->disposition == "ANSWERED") {
                    $dailyanswer++;
                } else {
                    $dailyUnanswer++;
                }
            }
            $daily[$k]['answer'] = $dailyanswer;
            $daily[$k]['unanswer'] = $dailyUnanswer;
        }

        $today = Carbon::today();
        $startOfMonth = $today->copy()->startOfMonth();
        $week = $startOfMonth->copy();
        $weekly = [];
        $weeklyData = QontakDatas::whereYear('_updated_at', date('Y'))->whereMonth('_updated_at', date('m'))->orderBy('_updated_at', 'asc')->get();
        $facebook = 0;
        $instagram = 0;
        $whatsapp = 0;
        $web_chat = 0;
        foreach ($weeklyData as $key => $value) {
            # code...
            $updatedAt = Carbon::createFromTimestamp(strtotime($value->_updated_at));
            $isInThisWeek = $updatedAt->lte($week->copy()->endOfWeek());
            // if in this week then add data to the array and add a week to endofweek
            if (!$isInThisWeek) {
                if ($this->isCallCenter) {
                    $callWeekly = CallCenter::whereYear('calldate', date('Y'))->whereMonth('calldate', date('M'))->where('calldate', '<', $week->copy()->endOfWeek())->get()->count();
                } else {
                    $callWeekly = 0;
                }
                $startDate = $week->copy();
                $weekly["Week " . $startDate->weekOfMonth]  = [
                    'facebook' => (int) $facebook,
                    'instagram' => (int) $instagram,
                    'whatsapp' => (int) $whatsapp,
                    'web_chat' => (int) $web_chat,
                    'callcenter' => (int) $callWeekly,
                ];
                $week->addWeek();
                $facebook = 0;
                $instagram = 0;
                $whatsapp = 0;
                $web_chat = 0;
            }
            // and if its the last data and its in this week then add the current week total accumaltion to the array
            if ((count($weeklyData) - 1) == $key) {
                if ($this->isCallCenter) {
                    $callWeekly = CallCenter::whereYear('calldate', date('Y'))->whereMonth('calldate', date('M'))->where('calldate', '<', $week->copy()->endOfWeek())->get()->count();
                } else {
                    $callWeekly = 0;
                }
                $startDate = $week->copy();
                $weekly["Week " . $startDate->weekOfMonth] = [
                    'facebook' => (int) $facebook,
                    'instagram' => (int) $instagram,
                    'whatsapp' => (int) $whatsapp,
                    'web_chat' => (int) $web_chat,
                    'callcenter' => (int) $callWeekly,
                ];
            }
            switch ($value->channel) {
                case 'fb':
                    $facebook++;
                    break;
                case 'ig':
                    $instagram++;
                    break;
                case 'wa':
                    $whatsapp++;
                    break;
                case 'web_chat':
                    $web_chat++;
                    break;
            }
        }

        // monthly
        $rawMonthlyWa = $rawData;

        $raw2MonthlyWa = [];
        foreach ($rawMonthlyWa as $value) {
            $raw2MonthlyWa[date('M Y', strtotime($value->calldate))][] = $value;
        }

        // if (empty($monthly[date('M Y', strtotime('-1 month'))])) {
        //     $monthly[date('M Y', strtotime('-1 month'))]['date'] = (date('M Y', strtotime('-1 month'))) . '';
        //     $monthly[date('M Y', strtotime('-1 month'))]['answer'] = 0;
        //     $monthly[date('M Y', strtotime('-1 month'))]['unanswer'] = 0;
        // }

        foreach ($raw2MonthlyWa as $k => $v) {
            $monthlyanswer = 0;
            $monthlyUnanswer = 0;
            foreach ($v as $vv) {
                if (empty($monthly[$k]['answer'])) {
                    $monthly[$k]['date'] = $k;
                    $monthly[$k]['answer'] = 0;
                    $monthly[$k]['unanswer'] = 0;
                }
                if ($vv->disposition == "ANSWERED") {
                    $monthlyanswer++;
                } else {
                    $monthlyUnanswer++;
                }
            }
            $monthly[$k]['answer'] += $monthlyanswer;
            $monthly[$k]['unanswer'] += $monthlyUnanswer;
        }

        // foreach ($monthly as $k => $v) {
        //     $monthly[$k]['unanswer'] = (int) ($monthly[$k]['unanswer'] / count($raw2MonthlyWa[$k]));
        //     $monthly[$k]['answer'] = (int) ($monthly[$k]['answer'] / count($raw2MonthlyWa[$k]));
        // }

        // yearly
        $rawYearlyWa = $rawData;

        $raw2YearlyWa = [];
        foreach ($rawYearlyWa as $value) {
            $raw2YearlyWa[date('Y', strtotime($value->calldate))][] = $value;
        }

        foreach ($raw2YearlyWa as $k => $v) {
            $yearlyanswer = 0;
            $yearlyUnanswer = 0;
            foreach ($v as $vv) {
                if (empty($yearly[$k]['answer'])) {
                    $yearly[$k]['date'] = $k . '';
                    $yearly[$k]['answer'] = 0;
                    $yearly[$k]['unanswer'] = 0;
                }
                if ($vv->disposition == "ANSWERED") {
                    $yearlyanswer++;
                } else {
                    $yearlyUnanswer++;
                }
            }
            $yearly[$k]['answer'] = $yearlyanswer;
            $yearly[$k]['unanswer'] = $yearlyUnanswer;
        }

        // foreach ($yearly as $k => $v) {
        //     $yearly[$k]['answer'] = (int) ($yearly[$k]['answer'] / count($raw2YearlyWa[$k]));
        //     $yearly[$k]['unanswer'] = (int) ($yearly[$k]['unanswer'] / count($raw2YearlyWa[$k]));
        // }

        // if (empty($yearly[date('Y') + 1])) {
        //     $yearly[date('Y') + 1]['date'] = (date('Y') + 1) . '';
        //     $yearly[date('Y') + 1]['answer'] = 0;
        //     $yearly[date('Y') + 1]['unanswer'] = 0;
        // }

        // result
        $object = new stdClass();
        $object->daily = array_values($daily);
        $object->weekly = array_values($weekly);
        $object->monthly = array_values($monthly);
        $object->yearly = array_values($yearly);

        return $object;
    }

    public function index(Request $request)
    {
        // $historyData = CallCenter::all();
        // $todayData = $this->filterByDate($request->from_date, $request->from_date, $historyData);
        // $yesterdayData = $this->filterByDate(date('Y-m-d', strtotime($request->from_date . "-1 days")), date('Y-m-d', strtotime($request->from_date . "-1 days")), $historyData);

        if ($this->isCallCenter) {
            $historyData = CallCenter::where(function ($q) {
                $q->where('src', 'NOT LIKE', '%0215085754%');
                // $q->where('src', '!=', '2001');
                $q->where(DB::raw('CHAR_LENGTH(src)'), '>', 4);
            })->whereYear('calldate', date('Y'))->orWhereYear('calldate', date('Y') - 1)->get();
            $todayData = CallCenter::with(['cc_detail'])->where(function ($q) {
                $q->where('src', 'NOT LIKE', '%0215085754%');
                // $q->where('src', '!=', '2001');
                $q->where(DB::raw('CHAR_LENGTH(src)'), '>', 4);
            })->whereBetween('calldate', [$request->from_date . ' 00:00:00', $request->from_date . ' 23:23:59'])->get();
            $yesterdayData = CallCenter::where(function ($q) {
                $q->where('src', 'NOT LIKE', '%0215085754%');
                // $q->where('src', '!=', '2001');
                $q->where(DB::raw('CHAR_LENGTH(src)'), '>', 4);
            })->whereBetween('calldate', [date('Y-m-d', strtotime($request->from_date . "-1 days")) . ' 00:00:00', date('Y-m-d', strtotime($request->from_date . "-1 days")) . ' 23:23:59'])->get();
        } else {
            $historyData = [];
            $todayData = [];
            $yesterdayData = [];
        }


        $answered = 0;
        $unanswered = 0;
        $solved = 0;
        $terpanggil = 0;
        $sibuk = 0;
        $menunggu = 0;
        $answeredData = [];
        $unansweredData = [];
        $solvedData = [];

        foreach ($todayData as $data) {
            if ($data->solved) {
                $solved++;
                $solvedData[] = $data;
            }

            if ($data->disposition == "ANSWERED") {
                $answered++;
                $answeredData[] = $data;
            } else {
                $unanswered++;
                $unansweredData[] = $data;
            }

            $hold = ['Playback', 'Congestion'];
            if ($data->lastapp == "Dial") {
                $terpanggil++;
            } elseif (in_array($data->lastapp, $hold)) {
                $menunggu++;
            } else {
                $sibuk++;
            }
        }

        $panswered = 0;
        $punanswered = 0;
        $psolved = 0;
        $pterpanggil = 0;
        $psibuk = 0;
        $pmenunggu = 0;

        foreach ($yesterdayData as $pdata) {
            if ($pdata->solved != false) {
                $psolved++;
            }

            if ($pdata->disposition == "ANSWERED") {
                $panswered++;
            } else {
                $punanswered++;
            }

            $hold = ['Playback', 'Congestion'];
            if ($pdata->lastapp == "Dial") {
                $pterpanggil++;
            } elseif (in_array($pdata->lastapp, $hold)) {
                $pmenunggu++;
            } else {
                $psibuk++;
            }
        }

        $panswered = $this->get_percentage($answered, $answered - $panswered);
        $punanswered = $this->get_percentage($unanswered, $unanswered - $punanswered);
        $psolved = $this->get_percentage($solved, $solved - $psolved);
        $pterpanggil = $this->get_percentage($terpanggil, $terpanggil - $pterpanggil);
        $psibuk = $this->get_percentage($sibuk, $sibuk - $psibuk);
        $pmenunggu = $this->get_percentage($menunggu, $menunggu - $pmenunggu);

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

        // $historyData = $historyData->filter();

        $graph = $this->getGraphData($historyData);

        return response()->json([
            'graph' => $graph,
            'card' => [
                "answered" => $answered,
                "unanswered" => $unanswered,
                "solved" => $solved,
                "terpanggil" => $terpanggil,
                "sibuk" => $sibuk,
                "menunggu" => $menunggu,

            ],
            'persentage' => [
                'answered' => $panswered,
                'unanswered' => $punanswered,
                'solved' => $psolved,
                'terpanggil' => $pterpanggil,
                'sibuk' => $psibuk,
                'menunggu' => $pmenunggu,
            ],
            'data' => [
                "answered" => $answeredData,
                "unanswered" => $unansweredData,
                "solved" => $solvedData,
            ],
            'history' => $todayData
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
    public function update(Request $request)
    {
        //
        $callData = CallCenterr::where('uniqueid', $request->id)->first();
        if (empty($callData)) {
            $callData = new CallCenterr();
        }
        $callData->uniqueid = $request->id;
        $callData->src = $request->name;
        $callData->save();


        return response()->json([
            'status' => [
                'code' => 200,
                'message' => 'success'
            ],
            'data' => $callData
        ]);
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
