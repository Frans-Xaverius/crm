<?php

namespace App\Http\Controllers;

use App\Models\QontakDatas;
use App\Models\SocialbladeDatas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use stdClass;

class InstagramApiController extends Controller
{
    private $qontak_access_token;
    private $data;
    private $meta;

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
        $rawData = QontakDatas::where('channel', 'ig')
            ->where('_updated_at', date('Y-m-d', strtotime($request->from_date)))
            ->get();

        $yesterdayRawData = QontakDatas::where('channel', 'ig')
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

    public function getStatisticsData($request)
    {
        $data = SocialbladeDatas::where('chanel', 'instagram')
            ->where('date', date('Y-m-d', strtotime($request->from_date)))
            ->first();

        $data->likes = (int) $data->likes;
        $data->comments = (int) $data->comments;
        $data->followers = (int) $data->followers;

        $yesterdaydata = SocialbladeDatas::where('chanel', 'instagram')
            ->where('date', date('Y-m-d', strtotime($request->from_date . "-1 days")))
            ->first();

        $yesterdaydata->likes = (int) $yesterdaydata->likes;
        $yesterdaydata->comments = (int) $yesterdaydata->comments;
        $yesterdaydata->followers = (int) $yesterdaydata->followers;

        $plikes = $this->get_percentage($data->likes, $data->likes - $yesterdaydata->likes);
        $pcomments = $this->get_percentage($data->comments, $data->comments - $yesterdaydata->comments);
        $pfollowers = $this->get_percentage($data->followers, $data->followers - $yesterdaydata->followers);

        $object = new stdClass();

        $object->likes = $data->likes;
        $object->comments = $data->comments;
        $object->followers = $data->followers;
        $object->plikes = $plikes;
        $object->pcomments = $pcomments;
        $object->pfollowers = $pfollowers;

        return $object;
    }

    public function getGraphData()
    {
        $daily = [];
        $weekly = [];
        $monthly = [];
        $yearly = [];

        // dayly
        $dailyIg = SocialbladeDatas::where('chanel', 'instagram')
            ->whereYear('date', date('Y'))
            ->whereMonth('date', date('m'))
            ->orderBy('date', 'asc')
            ->get();

        foreach ($dailyIg as $value) {
            $daily[] = [
                'date' => date('d M', strtotime($value->date)),
                'likes' => (int) $value->likes,
                'comments' => (int) $value->comments,
                'followers' => (int) $value->followers
            ];;
        }

        $today = Carbon::today();
        $startOfMonth = $today->copy()->startOfMonth();
        $week = $startOfMonth->copy();
        $weekly = [];
        $weeklyData = SocialbladeDatas::where('chanel','instagram')->whereYear('updated_at', date('Y'))->whereMonth('updated_at', date('m'))->orderBy('updated_at', 'asc')->get();
        $likes = 0;
        $comments = 0;
        $followers = 0;
        foreach ($weeklyData as $key => $value) {
            # code...
            $updatedAt = Carbon::createFromTimestamp(strtotime($value->_updated_at));
            $isInThisWeek = $updatedAt->lte($week->copy()->endOfWeek());
            // if in this week then add data to the array and add a week to endofweek
            if (!$isInThisWeek) {
                $startDate = $week->copy();
                $weekly["Week " . $startDate->weekOfMonth]  = [
                    'likes' => (int) $likes,
                    'comments' => (int) $comments,
                    'followers' => (int) $followers,
                ];
                $week->addWeek();
                $likes = 0;
                $comments = 0;
            }
            // and if its the last data and its in this week then add the current week total accumaltion to the array
            if ((count($weeklyData) - 1) == $key) {
                $startDate = $week->copy();
                $weekly["Week " . $startDate->weekOfMonth] = [
                    'likes' => (int) $likes,
                    'comments' => (int) $comments,
                    'followers' => (int) $followers,
                ];
            }
            $likes += (int) $value->likes;
            $comments += (int) $value->comments;
            $followers += (int) $value->followers;
        }

        // monthly
        $rawMonthlyIg = SocialbladeDatas::where('chanel', 'instagram')
            ->where(function ($q) {
                $q->whereYear('date', date('Y'));
                $q->orWhereYear('date', date('Y') - 1);
            })
            ->orderBy('date', 'asc')
            ->get();

        $raw2MonthlyFb = [];
        foreach ($rawMonthlyIg as $value) {
            $raw2MonthlyFb[date('M Y', strtotime($value->date))][] = $value;
        }

        foreach ($raw2MonthlyFb as $k => $v) {
            foreach ($v as $vv) {
                if (empty($monthly[$k]['likes'])) {
                    $monthly[$k]['date'] = $k;
                    $monthly[$k]['likes'] = 0;
                    $monthly[$k]['comments'] = 0;
                    $monthly[$k]['followers'] = 0;
                }
                $monthly[$k]['likes'] += $vv->likes;
                $monthly[$k]['comments'] += $vv->comments;
                $monthly[$k]['followers'] += $vv->followers;
            }
        }

        foreach ($monthly as $k => $v) {
            $monthly[$k]['likes'] = (int) ($monthly[$k]['likes'] / count($raw2MonthlyFb[$k]));
            $monthly[$k]['comments'] = (int) ($monthly[$k]['comments'] / count($raw2MonthlyFb[$k]));
            $monthly[$k]['followers'] = (int) ($monthly[$k]['followers'] / count($raw2MonthlyFb[$k]));
        }

        // if (empty($monthly[date('M Y', strtotime('+1 month'))])) {
        //     $monthly[date('M Y', strtotime('+1 month'))]['date'] = (date('M Y', strtotime('+1 month'))) . '';
        //     $monthly[date('M Y', strtotime('+1 month'))]['likes'] = 0;
        //     $monthly[date('M Y', strtotime('+1 month'))]['comments'] = 0;
        // }

        // yearly
        $rawYearlyFb = SocialbladeDatas::where('chanel', 'instagram')
            ->orderBy('date', 'asc')
            ->get();

        $raw2YearlyFb = [];
        foreach ($rawYearlyFb as $value) {
            $raw2YearlyFb[date('Y', strtotime($value->date))][] = $value;
        }

        if (empty($yearly[date('Y') - 1])) {
            $yearly[date('Y') - 1]['date'] = (date('Y') - 1) . '';
            $yearly[date('Y') - 1]['likes'] = 0;
            $yearly[date('Y') - 1]['comments'] = 0;
            $yearly[date('Y') - 1]['followers'] = 0;
        }

        foreach ($raw2YearlyFb as $k => $v) {
            foreach ($v as $vv) {
                if (empty($yearly[$k]['likes'])) {
                    $yearly[$k]['date'] = $k . '';
                    $yearly[$k]['likes'] = 0;
                    $yearly[$k]['comments'] = 0;
                    $yearly[$k]['followers'] = 0;
                }
                $yearly[$k]['likes'] += $vv->likes;
                $yearly[$k]['comments'] += $vv->comments;
                $yearly[$k]['followers'] += $vv->followers;
            }
        }

        foreach ($yearly as $k => $v) {
            if ($k != date('Y') - 1) {
                $yearly[$k]['likes'] = (int) ($yearly[$k]['likes'] / count($raw2YearlyFb[$k]));
                $yearly[$k]['comments'] = (int) ($yearly[$k]['comments'] / count($raw2YearlyFb[$k]));
                $yearly[$k]['followers'] = (int) ($yearly[$k]['followers'] / count($raw2YearlyFb[$k]));
            }
        }

        // result
        $object = new stdClass();
        $object->daily = $daily;
        $object->weekly = array_values($weekly);
        $object->monthly = array_values($monthly);
        $object->yearly = array_values($yearly);

        return $object;
    }

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
    //         if ($data->channel == 'ig') {
    //             return $data;
    //         }
    //     }, $decoded->data);
    //     $decoded->data = array_filter($decoded->data, fn ($data) => $data != null, 1);
    //     $decoded->data = array_values($decoded->data);
    //     $this->data = $decoded->data;
    //     $this->meta = $decoded->meta;
    // }

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

    public function index(Request $request)
    {
        $qontak = $this->getQontakData($request);
        $statistics = $this->getStatisticsData($request);
        $graph = $this->getGraphData();

        return response()->json([
            'graph' => $graph,
            'card' => [
                "followers" => $statistics->followers,
                "likes" => $statistics->likes,
                "comments" => $statistics->comments,
                "message" => $qontak->message,
                "read" => $qontak->read,
                "unread" => $qontak->unread,
                "solved" => $qontak->solved,
                "unsolved" => $qontak->unsolved,

            ],
            'persentage' => [
                "followers" => $statistics->pfollowers,
                "likes" => $statistics->plikes,
                "comments" => $statistics->pcomments,
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
