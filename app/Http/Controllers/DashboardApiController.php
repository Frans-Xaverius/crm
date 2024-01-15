<?php

namespace App\Http\Controllers;

use App\Models\CallCenter;
use App\Models\QontakDatas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use stdClass;
use App\Models\Room;

class DashboardApiController extends Controller
{
    //
    public function __construct()
    {
        try {
            //code...
            CallCenter::count();
            Config::set('isCallCenterCallAble', true);
        } catch (\Throwable $th) {
            //throw $th;
            Config::set('isCallCenterCallAble', false);
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
    public function getQontakData($request)
    {
        $roomRaw = Room::all();
        $room = [];
        foreach ($roomRaw as $key => $value) {
            $room[$value->room_id] = $value->data['channel_integration_id'];
        }

        $rawData = QontakDatas::where('_updated_at', date('Y-m-d', strtotime($request->from_date)))
            ->get();

        $yesterdayRawData = QontakDatas::where('_updated_at', date('Y-m-d', strtotime($request->from_date . "-1 days")))
            ->get();

        $facebook = 0;
        $instagram = 0;
        $whatsapp = 0;
        $web_chat = 0;

        foreach ($rawData as $data) {
            switch ($data->channel) {
                case 'fb':
                    $facebook++;
                    break;
                case 'ig':
                    $instagram++;
                    break;
                case 'wa':
                    if (!empty($room[$data->_id]) && $room[$data->_id] == env('QONTAK_WA_INTEGRATION_ID')) {
                        $whatsapp++;
                    }
                    break;
                case 'wa_cloud':
                    if (!empty($room[$data->_id]) && $room[$data->_id] == env('QONTAK_WA_INTEGRATION_ID')) {
                        $whatsapp++;
                    }
                    break;
                case 'web_chat':
                    $web_chat++;
                    break;
                default:
                    null;
                    break;
            }
        }


        $pfacebook = 0;
        $pinstagram = 0;
        $pwhatsapp = 0;
        $pweb_chat = 0;

        foreach ($yesterdayRawData as $pdata) {
            switch ($pdata->channel) {
                case 'fb':
                    $pfacebook++;
                    break;
                case 'ig':
                    $pinstagram++;
                    break;
                case 'wa':
                    if (!empty($room[$pdata->_id]) && $room[$pdata->_id] == env('QONTAK_WA_INTEGRATION_ID')) {
                        $pwhatsapp++;
                    }
                    break;
                case 'wa_cloud':
                    if (!empty($room[$data->_id]) && $room[$data->_id] == env('QONTAK_WA_INTEGRATION_ID')) {
                        $pwhatsapp++;
                    }
                    break;
                case 'web_chat':
                    $pweb_chat++;
                    break;
                default:
                    null;
                    break;
            }
        }

        $pfacebook = $this->get_percentage($facebook, $facebook - $pfacebook);
        $pinstagram = $this->get_percentage($instagram, $instagram - $pinstagram);
        $pwhatsapp = $this->get_percentage($whatsapp, $whatsapp - $pwhatsapp);
        $pweb_chat = $this->get_percentage($web_chat, $web_chat - $pweb_chat);

        $object = new stdClass();

        $object->whatsapp = $whatsapp;
        $object->web_chat = $web_chat;
        $object->facebook = $facebook;
        $object->instagram = $instagram;
        $object->pfacebook = $pfacebook;
        $object->pinstagram = $pinstagram;
        $object->pwhatsapp = $pwhatsapp;
        $object->pweb_chat = $pweb_chat;

        return $object;
    }

    public function getCallCenterData(Request $request)
    {
        // $data = CallCenter::where('updated_at', date('Y-m-d', strtotime($request->from_date)))
        //     ->get()->count();

        // $yesterdayData = CallCenter::where('updated_at', date('Y-m-d', strtotime($request->from_date . "-1 days")))
        //     ->get()->count();
        $callAble = Config::get('isCallCenterCallAble');
        switch ($callAble) {
            case true:
                # code...
                $data = CallCenter::whereBetween('calldate', [$request->from_date . ' 00:00:00', $request->from_date . ' 23:23:59'])->get()->count();
                $yesterdayData = CallCenter::whereBetween('calldate', [date('Y-m-d', strtotime($request->from_date . "-1 days")) . ' 00:00:00', date('Y-m-d', strtotime($request->from_date . "-1 days")) . ' 23:23:59'])->get()->count();

                $pcallCenter = $this->get_percentage($data, $data - $yesterdayData);
                break;
            
            case false:
                # code...
                $data = 0;
                $pcallCenter = 0;
                break;
        }

        $object = new stdClass();

        $object->callCenter = $data;
        $object->pcallCenter = $pcallCenter;

        return $object;
    }

    public function getGraphData()
    {
        $roomRaw = Room::all();
        $room = [];
        foreach ($roomRaw as $key => $value) {
            $room[$value->room_id] = $value->data['channel_integration_id'];
        }
        
        $callAble = Config::get('isCallCenterCallAble');
        $daily = [];
        $weekly = [];
        $monthly = [];
        $yearly = [];

        // daily
        $dailyData = QontakDatas::whereYear('_updated_at', date('Y'))
            ->whereMonth('_updated_at', date('m'))
            ->orderBy('_updated_at', 'asc')
            ->get()->groupBy('_updated_at');


        foreach ($dailyData as $key => $value) {
            $date = Carbon::createFromTimestamp(strtotime($key));
            // $callDaily = CallCenter::whereYear('updated_at', $date->format('Y'))
            //     ->whereMonth('updated_at', $date->format('m'))
            //     ->orderBy('updated_at', 'asc')
            //     ->get()->count();
            if ($callAble) {
                $callDaily = CallCenter::whereYear('calldate', $date->format('Y'))
                    ->whereMonth('calldate', $date->format('m'))
                    ->orderBy('calldate', 'asc')
                    ->get()->count();
            } else {
                $callDaily = 0;
            }

            $facebook = 0;
            $instagram = 0;
            $whatsapp = 0;
            $web_chat = 0;
            foreach ($value as $data) {
                # code...
                switch ($data->channel) {
                    case 'fb':
                        $facebook++;
                        break;
                    case 'ig':
                        $instagram++;
                        break;
                    case 'wa':
                        if (!empty($room[$data->_id]) && $room[$data->_id] == env('QONTAK_WA_INTEGRATION_ID')) {
                            $whatsapp++;
                        }
                        break;
                    case 'wa_cloud':
                        if (!empty($room[$data->_id]) && $room[$data->_id] == env('QONTAK_WA_INTEGRATION_ID')) {
                            $whatsapp++;
                        }
                        break;
                    case 'web_chat':
                        $web_chat++;
                        break;
                    default:
                        null;
                        break;
                }
            }
            $daily[] = [
                'date' => date('d M', strtotime($key)),
                'facebook' => (int) $facebook,
                'instagram' => (int) $instagram,
                'whatsapp' => (int) $whatsapp,
                'web_chat' => (int) $web_chat,
                'callcenter' => (int) $callDaily,
            ];
        }

        // weekly
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
                if ($callAble) $callWeekly = CallCenter::whereYear('calldate', date('Y'))->whereMonth('calldate', date('M'))->where('calldate', '<', $week->copy()->endOfWeek())->get()->count();
                else $callWeekly = 0;
                $startDate = $week->copy();
                $weekly["Week ".$startDate->weekOfMonth]  = [
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
                if ($callAble) $callWeekly = CallCenter::whereYear('calldate', date('Y'))->whereMonth('calldate', date('M'))->where('calldate', '<', $week->copy()->endOfWeek())->get()->count();
                else $callWeekly = 0;
                $startDate = $week->copy();
                $weekly["Week ".$startDate->weekOfMonth] = [
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
                    if (!empty($room[$value->_id]) && $room[$value->_id] == env('QONTAK_WA_INTEGRATION_ID')) {
                        $whatsapp++;
                    }
                    break;
                case 'wa_cloud':
                    if (!empty($room[$value->_id]) && $room[$value->_id] == env('QONTAK_WA_INTEGRATION_ID')) {
                        $whatsapp++;
                    }
                    break;
                case 'web_chat':
                    $web_chat++;
                    break;
            }
        }

        // monthly
        $monthlyData = QontakDatas::whereYear('_updated_at', date('Y'))->orWhereYear('_updated_at', date('Y') - 1)
            ->orderBy('_updated_at', 'asc')
            ->get();
        $rawMonthly = [];
        foreach ($monthlyData as $value) {
            $rawMonthly[date('M Y', strtotime($value->_updated_at))][] = $value;
        }

        foreach ($rawMonthly as $k => $data) {
            $facebook = 0;
            $instagram = 0;
            $whatsapp = 0;
            $web_chat = 0;
            $currentMonth = Carbon::createFromTimestamp(strtotime($k));
            // $callMonthly = CallCenter::whereYear('updated_at', $currentMonth->format('Y'))
            //     ->whereMonth('updated_at', $currentMonth->format('m'))
            //     ->orderBy('updated_at', 'asc')
            //     ->get()->count();
            if ($callAble) {
                $callMonthly = CallCenter::whereYear('calldate', $currentMonth->format('Y'))
                    ->whereMonth('calldate', $currentMonth->format('m'))
                    ->orderBy('calldate', 'asc')
                    ->get()->count();
            } else $callMonthly = 0;
            

            foreach ($data as $value) {
                if (empty($monthly[$k]['date'])) {
                    $monthly[$k]['date'] = $k;
                    $monthly[$k]['facebook'] = 0;
                    $monthly[$k]['instagram'] = 0;
                    $monthly[$k]['whatsapp'] = 0;
                    $monthly[$k]['web_chat'] = 0;
                }
                switch ($value->channel) {
                    case 'fb':
                        $facebook++;
                        break;
                    case 'ig':
                        $instagram++;
                        break;
                    case 'wa':
                        if (!empty($room[$value->_id]) && $room[$value->_id] == env('QONTAK_WA_INTEGRATION_ID')) {
                            $whatsapp++;
                        }
                        break;
                    case 'wa_cloud':
                        if (!empty($room[$value->_id]) && $room[$value->_id] == env('QONTAK_WA_INTEGRATION_ID')) {
                            $whatsapp++;
                        }
                        break;
                    case 'web_chat':
                        $web_chat++;
                        break;
                    default:
                        null;
                        break;
                }
            }
            $monthly[$k]['date'] = $k;
            $monthly[$k]['facebook'] = $facebook;
            $monthly[$k]['instagram'] = $instagram;
            $monthly[$k]['whatsapp'] = $whatsapp;
            $monthly[$k]['web_chat'] = $web_chat;
            $monthly[$k]['callcenter'] = $callMonthly;
        }

        // $firstMonth = Carbon::createFromTimestamp(strtotime($monthlyData->first()->_updated_at))->subUnitNoOverflow('day', 31, 'month');
        // $lastMonth = Carbon::createFromTimestamp(strtotime($monthlyData->last()->_updated_at))->subUnitNoOverflow('day', 31, 'month');
        // $diff = $firstMonth->diffInMonths($lastMonth);

        // for ($i = 0; $i <= $diff; $i++) {
        //     $currentMonth = $i != 0 ? $firstMonth->addMonth(1) : $firstMonth;
        //     $month = $currentMonth->format('M Y');

        //     $callMonthly = CallCenter::whereYear('updated_at', $currentMonth->format('Y'))
        //         ->whereMonth('updated_at', $currentMonth->format('m'))
        //         ->orderBy('updated_at', 'asc')
        //         ->get()->count();

        //     $facebook = 0;
        //     $instagram = 0;
        //     $whatsapp = 0;
        //     $web_chat = 0;
        //     foreach ($monthlyData as $value) {
        //         $updatedAt = Carbon::createFromTimestamp(strtotime($value->_updated_at))->subUnitNoOverflow('day', 31, 'month');
        //         if ($updatedAt->equalTo($currentMonth)) {
        //             switch ($data->channel) {
        //                 case 'fb':
        //                     $facebook++;
        //                     break;
        //                 case 'ig':
        //                     $instagram++;
        //                     break;
        //                 case 'wa':
        //                     $whatsapp++;
        //                     break;
        //                 case 'web_chat':
        //                     $web_chat++;
        //                     break;
        //                 default:
        //                     null;
        //                     break;
        //             }
        //         }
        //     }
        //     $monthly[$i]['date'] = $month;
        //     $monthly[$i]['facebook'] = $facebook;
        //     $monthly[$i]['instagram'] = $instagram;
        //     $monthly[$i]['whatsapp'] = $whatsapp;
        //     $monthly[$i]['web_chat'] = $web_chat;
        //     $monthly[$i]['callcenter'] = $callMonthly;
        // }

        $yearlyData = QontakDatas::orderBy('_updated_at', 'asc')
            ->get();
        $rawYearly = [];
        foreach ($yearlyData as $value) {
            $rawYearly[date('Y', strtotime($value->_updated_at))][] = $value;
        }

        if (empty($yearly[date('Y') - 1])) {
            $yearly[date('Y') - 1]['date'] = (date('Y') - 1) . '';
            $yearly[date('Y') - 1]['facebook'] = 0;
            $yearly[date('Y') - 1]['instagram'] = 0;
            $yearly[date('Y') - 1]['whatsapp'] = 0;
            $yearly[date('Y') - 1]['web_chat'] = 0;
            $yearly[date('Y') - 1]['callcenter'] = 0;
        }

        foreach ($rawYearly as $k => $data) {
            $facebook = 0;
            $instagram = 0;
            $whatsapp = 0;
            $web_chat = 0;
            $currentYear = Carbon::createFromTimestamp(strtotime($k));
            // $callYearly = CallCenter::whereYear('updated_at', $currentYear->format('Y'))
            //     ->orderBy('updated_at', 'asc')
            //     ->get()->count();
            if ($callAble) {
                $callYearly = CallCenter::whereYear('calldate', $currentYear->format('Y'))
                    ->orderBy('calldate', 'asc')
                    ->get()->count();
            } else $callYearly = 0;

            foreach ($data as $value) {
                if (empty($yearly[$k]['date'])) {
                    $yearly[$k]['date'] = $k;
                    $yearly[$k]['facebook'] = 0;
                    $yearly[$k]['instagram'] = 0;
                    $yearly[$k]['whatsapp'] = 0;
                    $yearly[$k]['web_chat'] = 0;
                }
                switch ($value->channel) {
                    case 'fb':
                        $facebook++;
                        break;
                    case 'ig':
                        $instagram++;
                        break;
                    case 'wa':
                        if (!empty($room[$value->_id]) && $room[$value->_id] == env('QONTAK_WA_INTEGRATION_ID')) {
                            $whatsapp++;
                        }
                        break;
                    case 'wa_cloud':
                        if (!empty($room[$value->_id]) && $room[$value->_id] == env('QONTAK_WA_INTEGRATION_ID')) {
                            $whatsapp++;
                        }
                        break;
                    case 'web_chat':
                        $web_chat++;
                        break;
                    default:
                        null;
                        break;
                }
            }
            $yearly[$k]['date'] = $k;
            $yearly[$k]['facebook'] = $facebook;
            $yearly[$k]['instagram'] = $instagram;
            $yearly[$k]['whatsapp'] = $whatsapp;
            $yearly[$k]['web_chat'] = $web_chat;
            $yearly[$k]['callcenter'] = $callYearly;
        }

        // yearly
        // $yearlyData = QontakDatas::orderBy('_updated_at', 'asc')
        //     ->get();
        // $firstYear = Carbon::createFromTimestamp(strtotime($yearlyData->first()->_updated_at))->subUnitNoOverflow('day', 366, 'year');
        // $lastYear = Carbon::createFromTimestamp(strtotime($yearlyData->last()->_updated_at))->subUnitNoOverflow('day', 366, 'year');
        // $diff = $lastYear->diffInYears($firstYear);

        // if (empty($yearly)) {
        //     $yearly[date('Y') - 1]['date'] = (date('Y') - 1) . '';
        //     $yearly[date('Y') - 1]['facebook'] = 0;
        //     $yearly[date('Y') - 1]['instagram'] = 0;
        //     $yearly[date('Y') - 1]['whatsapp'] = 0;
        //     $yearly[date('Y') - 1]['web_chat'] = 0;
        // }

        // for ($i = 0; $i <= count(array_fill(0, $diff, '')); $i++) {
        //     $currentYear = $i != 0 ? $firstYear->addYear(1) : $firstYear;
        //     $year = $currentYear->format('Y');

        //     $callYearly = CallCenter::whereYear('updated_at', $currentYear->format('Y'))
        //         ->orderBy('updated_at', 'asc')
        //         ->get()->count();

        //     $facebook = 0;
        //     $instagram = 0;
        //     $whatsapp = 0;
        //     $web_chat = 0;
        //     foreach ($yearlyData as $value) {
        //         # code...
        //         $updatedAt = Carbon::createFromTimestamp(strtotime($value->_updated_at))->subUnitNoOverflow('day', 366, 'year');
        //         if ($updatedAt->equalTo($currentYear)) {
        //             switch ($value->channel) {
        //                 case 'fb':
        //                     $facebook++;
        //                     break;
        //                 case 'ig':
        //                     $instagram++;
        //                     break;
        //                 case 'wa':
        //                     $whatsapp++;
        //                     break;
        //                 case 'web_chat':
        //                     $web_chat++;
        //                     break;
        //                 default:
        //                     null;
        //                     break;
        //             }
        //         }
        //         $yearly[$i]['date'] = $year;
        //         $yearly[$i]['facebook'] = $facebook;
        //         $yearly[$i]['instagram'] = $instagram;
        //         $yearly[$i]['whatsapp'] = $whatsapp;
        //         $yearly[$i]['web_chat'] = $web_chat;
        //         $yearly[$i]['callcenter'] = $callYearly;
        //     }
        // }

        // result
        // dd($daily, $weekly,$monthly);
        $object = new stdClass();
        $object->daily = array_values($daily);
        $object->weekly = array_values($weekly);
        $object->monthly = array_values($monthly);
        $object->yearly = array_values($yearly);

        return $object;
    }

    public function getPieGraph($qontakData)
    {
        $total = $qontakData->facebook + $qontakData->instagram + $qontakData->whatsapp + $qontakData->web_chat;
        $facebook = $qontakData->facebook;
        $instagram = $qontakData->instagram;
        $whatsapp = $qontakData->whatsapp;
        $web_chat = $qontakData->web_chat;

        $pfacebook = $this->get_percentage($total, $facebook);
        $pinstagram = $this->get_percentage($total, $instagram);
        $pwhatsapp = $this->get_percentage($total, $whatsapp);
        $pweb_chat = $this->get_percentage($total, $web_chat);

        $object = new stdClass();

        $object->facebook = $pfacebook;
        $object->instagram = $pinstagram;
        $object->whatsapp = $pwhatsapp;
        $object->web_chat = $pweb_chat;

        return $object;
    }

    public function index(Request $request)
    {
        $callCenter = $this->getCallCenterData($request);
        $qontak = $this->getQontakData($request);
        $graph = $this->getGraphData();
        $pie = $this->getPieGraph($qontak);

        return response()->json([
            'graph' => $graph,
            'pie' => $pie,
            'card' => [
                "facebook" => $qontak->facebook,
                "instagram" => $qontak->instagram,
                "whatsapp" => $qontak->whatsapp,
                "web_chat" => $qontak->web_chat,
                "callcenter" => $callCenter->callCenter,

            ],
            'persentage' => [
                "facebook" => $qontak->pfacebook,
                "instagram" => $qontak->pinstagram,
                "whatsapp" => $qontak->pwhatsapp,
                "web_chat" => $qontak->pweb_chat,
                "callcenter" => $callCenter->pcallCenter,
            ]
        ]);
    }
}
