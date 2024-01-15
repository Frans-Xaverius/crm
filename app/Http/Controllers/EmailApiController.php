<?php

namespace App\Http\Controllers;

use App\Models\QontakDatas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use stdClass;

class EmailApiController extends Controller
{
    public function get_percentage($total, $number)
    {
        if ($total > 0) {
            return round(($number * 100) / $total, 0);
        } else {
            return 0;
        }
    }

    public function getQontakData($request)
    {
        $rawData = QontakDatas::where('channel', 'email')
            ->where('_updated_at', date('Y-m-d', strtotime($request->from_date)))
            ->get();

        $yesterdayRawData = QontakDatas::where('channel', 'email')
            ->where('_updated_at', date('Y-m-d', strtotime($request->from_date . "-1 days")))
            ->get();

        $read = 0;
        $readData = [];
        $unread = 0;
        $unreadData = [];
        $solved = 0;
        $solvedData = [];
        $unsolved = 0;
        $unsolvedData = [];

        foreach ($rawData as $data) {
            if ($data->resolved_at != null) {
                $solved++;
                $solvedData[] = $data;
            } else {
                $unsolved++;
                $unsolvedData[] = $data;
            }

            if ($data->unread_count == 0) {
                $read++;
                $readData[] = $data;
            } else {
                $unread++;
                $unreadData[] = $data;
            }
        }

        $message = $read + $unread;

        $pread = 0;
        $punread = 0;
        $psolved = 0;
        $punsolved = 0;

        foreach ($yesterdayRawData as $pdata) {
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
        }

        $pmessage = $pread + $punread;

        $pmessage = $this->get_percentage($message, $message - $pmessage);
        $pread = $this->get_percentage($read, $read - $pread);
        $punread = $this->get_percentage($unread, $unread - $punread);
        $psolved = $this->get_percentage($solved, $solved - $psolved);
        $punsolved = $this->get_percentage($unsolved, $unsolved - $punsolved);

        $object = new stdClass();

        $object->message = $message;
        $object->solved = $solved;
        $object->solvedData = $solvedData;
        $object->unsolved = $unsolved;
        $object->unsolvedData = $unsolvedData;
        $object->read = $read;
        $object->readData = $readData;
        $object->unread = $unread;
        $object->unreadData = $unreadData;
        $object->pmessage = $pmessage;
        $object->pread = $pread;
        $object->punread = $punread;
        $object->psolved = $psolved;
        $object->punsolved = $punsolved;

        return $object;
    }

    public function getGraphData()
    {
        $daily = [];
        $weekly = [];
        $monthly = [];
        $yearly = [];

        // dayly
        $dailyWa = QontakDatas::where('channel', 'email')
            ->whereYear('_updated_at', date('Y'))
            ->whereMonth('_updated_at', date('m'))
            ->orderBy('_updated_at', 'asc')
            ->get();

        $raw2DailyWa = [];
        foreach ($dailyWa as $value) {
            $raw2DailyWa[date('d M', strtotime($value->_updated_at))][] = $value;
        }

        foreach ($raw2DailyWa as $k => $v) {
            $dailyRead = 0;
            $dailyUnread = 0;
            foreach ($v as $vv) {
                if (empty($monthly[$k]['read'])) {
                    $daily[$k]['date'] = $k;
                    $daily[$k]['read'] = 0;
                    $daily[$k]['unread'] = 0;
                }
                if ($vv->unread_count == 0) {
                    $dailyRead++;
                } else {
                    $dailyUnread++;
                }
            }
            $daily[$k]['read'] = $dailyRead;
            $daily[$k]['unread'] = $dailyUnread;
        }

        // weekly
        $today = Carbon::today();
        $startOfMonth = $today->copy()->startOfMonth();
        $week = $startOfMonth->copy();
        $weekly = [];
        $weeklyData = QontakDatas::where('channel','email')->whereYear('_updated_at', date('Y'))->whereMonth('_updated_at', date('m'))->orderBy('_updated_at', 'asc')->get();
        $read = 0;
        $unread = 0;
        foreach ($weeklyData as $key => $value) {
            # code...
            $updatedAt = Carbon::createFromTimestamp(strtotime($value->_updated_at));
            $isInThisWeek = $updatedAt->lte($week->copy()->endOfWeek());
            // if in this week then add data to the array and add a week to endofweek
            if (!$isInThisWeek) {
                $startDate = $week->copy();
                $weekly["Week " . $startDate->weekOfMonth]  = [
                    'read' => (int) $read,
                    'unread' => (int) $unread
                ];
                $week->addWeek();
                $read = 0;
                $unread = 0;
            }
            // and if its the last data and its in this week then add the current week total accumaltion to the array
            if ((count($weeklyData) - 1) == $key) {
                $startDate = $week->copy();
                $weekly["Week " . $startDate->weekOfMonth] = [
                    'read' => (int) $read,
                    'unread' => (int) $unread,
                ];
            }
            $read += (int) $value->read;
            $unread += (int) $value->unread;
        }

        // monthly
        $rawMonthlyWa = QontakDatas::where('channel', 'email')
            ->whereYear('_updated_at', date('Y'))
            ->orWhereYear('_updated_at', date('Y') - 1)
            ->orderBy('_updated_at', 'asc')
            ->get();

        $raw2MonthlyWa = [];
        foreach ($rawMonthlyWa as $value) {
            $raw2MonthlyWa[date('M Y', strtotime($value->_updated_at))][] = $value;
        }

        if (empty($monthly[date('M Y', strtotime('-1 month'))])) {
            $monthly[date('M Y', strtotime('-1 month'))]['date'] = (date('M Y', strtotime('-1 month'))) . '';
            $monthly[date('M Y', strtotime('-1 month'))]['read'] = 0;
            $monthly[date('M Y', strtotime('-1 month'))]['unread'] = 0;
        }

        foreach ($raw2MonthlyWa as $k => $v) {
            $monthlyRead = 0;
            $monthlyUnread = 0;
            foreach ($v as $vv) {
                if (empty($monthly[$k]['read'])) {
                    $monthly[$k]['date'] = $k;
                    $monthly[$k]['read'] = 0;
                    $monthly[$k]['unread'] = 0;
                }
                if ($vv->unread_count == 0) {
                    $monthlyRead++;
                } else {
                    $monthlyUnread++;
                }
            }
            $monthly[$k]['read'] += $monthlyRead;
            $monthly[$k]['unread'] += $monthlyUnread;
        }

        // foreach ($monthly as $k => $v) {
        //     $monthly[$k]['read'] = (int) ($monthly[$k]['read'] / count($raw2MonthlyWa[$k]));
        //     $monthly[$k]['unread'] = (int) ($monthly[$k]['unread'] / count($raw2MonthlyWa[$k]));
        // }


        // yearly
        $rawYearlyWa = QontakDatas::where('channel', 'email')
            ->orderBy('_updated_at', 'asc')
            ->get();

        $raw2YearlyWa = [];
        foreach ($rawYearlyWa as $value) {
            $raw2YearlyWa[date('Y', strtotime($value->_updated_at))][] = $value;
        }

        if (empty($yearly[date('Y') - 1])) {
            $yearly[date('Y') - 1]['date'] = (date('Y') - 1) . '';
            $yearly[date('Y') - 1]['read'] = 0;
            $yearly[date('Y') - 1]['unread'] = 0;
        }

        foreach ($raw2YearlyWa as $k => $v) {
            $yearlyRead = 0;
            $yearlyUnread = 0;
            foreach ($v as $vv) {
                if (empty($yearly[$k]['read'])) {
                    $yearly[$k]['date'] = $k . '';
                    $yearly[$k]['read'] = 0;
                    $yearly[$k]['unread'] = 0;
                }
                if ($vv->unread_count == 0) {
                    $yearlyRead++;
                } else {
                    $yearlyUnread++;
                }
            }
            $yearly[$k]['read'] = $yearlyRead;
            $yearly[$k]['unread'] = $yearlyUnread;
        }

        // foreach ($yearly as $k => $v) {
        //     $yearly[$k]['read'] = (int) ($yearly[$k]['read'] / count($raw2YearlyWa[$k]));
        //     $yearly[$k]['unread'] = (int) ($yearly[$k]['unread'] / count($raw2YearlyWa[$k]));
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
        $qontak = $this->getQontakData($request);
        $graph = $this->getGraphData();

        return response()->json([
            'graph' => $graph,
            'card' => [
                "message" => $qontak->message,
                "read" => $qontak->read,
                "unread" => $qontak->unread,
                "solved" => $qontak->solved,
                "unsolved" => $qontak->unsolved,

            ],
            'persentage' => [
                "message" => $qontak->pmessage,
                "read" => $qontak->pread,
                "unread" => $qontak->punread,
                "solved" => $qontak->psolved,
                "unsolved" => $qontak->punsolved,
            ],
            'data' => [
                "read" => $qontak->readData,
                "unread" => $qontak->unreadData,
                "solved" => $qontak->solvedData,
                "unsolved" => $qontak->unsolvedData,
            ]
        ]);
    }
    // private $qontak_access_token;
    // private $data;
    // private $meta;

    // public function __construct()
    // {
    //     $url = 'https://service-chat.qontak.com/oauth/token';
    //     $curl = curl_init();

    //     curl_setopt_array($curl, [
    //         CURLOPT_URL => $url,
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING => "",
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 30,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => "POST",
    //         CURLOPT_POSTFIELDS => "{\n  \"username\": \"".auth()->user()->qontak_email."\",\n  \"password\": \"".auth()->user()->qontak_password."\",\n  \"grant_type\": \"password\",\n  \"client_id\":\"".env('QONTAK_CLIENT_ID')."\",\n  \"client_secret\":\"".env('QONTAK_CLIENT_SECRET')."\"\n}",
    //         CURLOPT_HTTPHEADER => [
    //             "Content-Type: application/json"
    //         ],
    //     ]);

    //     $response = curl_exec($curl);
    //     $err = curl_error($curl);

    //     curl_close($curl);

    //     if ($err) {
    //         echo "cURL Error #:" . $err;
    //     }
    //     // else {
    //     //     echo $response;
    //     // }
    //     $decodedResponse = json_decode($response);
    //     $this->qontak_access_token = $decodedResponse->access_token;
    //     $this->getData();
    // }

    // public function getData()
    // {
    //     $curl = curl_init();

    //     curl_setopt_array($curl, [
    //         CURLOPT_URL => "https://service-chat.qontak.com/api/open/v1/rooms",
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING => "",
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 30,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => "GET",
    //         CURLOPT_HTTPHEADER => [
    //             "Authorization: Bearer" . $this->qontak_access_token,
    //             "Content-Type: application/json"
    //         ],
    //     ]);

    //     $response = curl_exec($curl);
    //     $err = curl_error($curl);

    //     curl_close($curl);

    //     if ($err) {
    //         echo "cURL Error #:" . $err;
    //     }
    //     $decoded = json_decode($response);

    //     $decoded->data = array_map(function ($data) {
    //         if ($data->channel == 'email') {
    //             return $data;
    //         }
    //     }, $decoded->data);
    //     $decoded->data = array_filter($decoded->data, fn ($data) => $data != null, 1);
    //     $decoded->data = array_values($decoded->data);
    //     $this->data = $decoded->data;
    //     $this->meta = $decoded->meta;
    // }

    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function filterByDate($request)
    // {
    //     // return $request->all();
    //     $fromDate = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($request->from_date)));
    //     $toDate = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($request->to_date)));

    //     $datas = [];

    //     foreach ($this->data as $data) {
    //         $dataUpdatedAt = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($data->updated_at)));
    //         if ($dataUpdatedAt->between($fromDate, $toDate) == true) {
    //             array_push($datas, $data);
    //         }
    //     }

    //     return $datas;
    // }

    // public function index(Request $request)
    // {
    //     if (!empty($request->from_date) && !empty($request->to_date)) {
    //         $this->data = $this->filterByDate($request);
    //     }

    //     $read = 0;
    //     $readData = [];
    //     $unread = 0;
    //     $unreadData = [];
    //     $solved = 0;
    //     $solvedData = [];
    //     $unsolved = 0;
    //     $unsolvedData = [];

    //     foreach ($this->data as $data) {
    //         # code...
    //         if ($data->resolved_at != null) {
    //             $solved++;
    //             $solvedData[] = $data;
    //         } else {
    //             $unsolved++;
    //             $unsolvedData[] = $data;
    //         }

    //         if ($data->unread_count == 0) {
    //             $read++;
    //             $readData[] = $data;
    //         } else {
    //             $unread++;
    //             $unreadData[] = $data;
    //         }
    //     }
    //     // dd($read, $unread, $solved, $unsolved);

    //     return response()->json([
    //         'card' => [
    //             "read" => $read,
    //             "unread" => $unread,
    //             "solved" => $solved,
    //             "unsolved" => $unsolved,

    //         ],
    //         'data' => [
    //             "read" => $readData,
    //             "unread" => $unreadData,
    //             "solved" => $solvedData,
    //             "unsolved" => $unsolvedData,
    //         ]
    //     ]);
    // }

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
