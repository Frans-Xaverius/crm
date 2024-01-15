<?php

namespace App\Http\Controllers;

use App\Models\QontakDatas;
use App\Models\SocialbladeDatas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use stdClass;

class FacebookApiController extends Controller
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
        $rawData = QontakDatas::where('channel', 'fb')
            ->where('_updated_at', $request->from_date)
            ->get();

        $yesterdayRawData = QontakDatas::where('channel', 'fb')
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
        $data = SocialbladeDatas::where('chanel', 'facebook')
            ->where('date', date('Y-m-d', strtotime($request->from_date)))
            ->first();

        $yesterdaydata = SocialbladeDatas::where('chanel', 'facebook')
            ->where('date', date('Y-m-d', strtotime($request->from_date . "-1 days")))
            ->first();
            
        $plikes = $this->get_percentage($data->likes, $data->likes - $yesterdaydata->likes);
        $pcomments = $this->get_percentage($data->comments, $data->comments - $yesterdaydata->comments);

        $object = new stdClass();


        $object->likes = $data->likes;
        $object->comments = $data->comments;
        $object->plikes = $plikes;
        $object->pcomments = $pcomments;

        return $object;
    }

    public function getGraphData()
    {
        $daily = [];
        $weekly = [];
        $monthly = [];
        $yearly = [];

        // dayly
        $dailyFb = SocialbladeDatas::where('chanel', 'facebook')
            ->whereYear('date', date('Y'))
            ->whereMonth('date', date('m'))
            ->orderBy('date', 'asc')
            ->get();

        foreach ($dailyFb as $value) {
            $daily[] = [
                'date' => date('d M', strtotime($value->date)),
                'likes' => (int) $value->likes,
                'comments' => (int) $value->comments
            ];;
        }

        $today = Carbon::today();
        $startOfMonth = $today->copy()->startOfMonth();
        $week = $startOfMonth->copy();
        $weekly = [];
        $weeklyData = SocialbladeDatas::where('chanel','facebook')->whereYear('updated_at', date('Y'))->whereMonth('updated_at', date('m'))->orderBy('updated_at', 'asc')->get();
        $likes = 0;
        $comments = 0;
        foreach ($weeklyData as $key => $value) {
            # code...
            $updatedAt = Carbon::createFromTimestamp(strtotime($value->_updated_at));
            $isInThisWeek = $updatedAt->lte($week->copy()->endOfWeek());
            // if in this week then add data to the array and add a week to endofweek
            if (!$isInThisWeek) {
                $startDate = $week->copy();
                $weekly["Week " . $startDate->weekOfMonth]  = [
                    'likes' => (int) $likes,
                    'comments' => (int) $comments
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
                ];
            }
            $likes += (int) $value->likes;
            $comments += (int) $value->comments;
        }

        // monthly
        $rawMonthlyFb = SocialbladeDatas::where('chanel', 'facebook')
            ->where(function ($q) {
                $q->whereYear('date', date('Y'));
                $q->orWhereYear('date', date('Y') - 1);
            })
            ->orderBy('date', 'asc')
            ->get();

        $raw2MonthlyFb = [];
        foreach ($rawMonthlyFb as $value) {
            $raw2MonthlyFb[date('M Y', strtotime($value->date))][] = $value;
        }

        foreach ($raw2MonthlyFb as $k => $v) {
            foreach ($v as $vv) {
                if (empty($monthly[$k]['likes'])) {
                    $monthly[$k]['date'] = $k;
                    $monthly[$k]['likes'] = 0;
                    $monthly[$k]['comments'] = 0;
                }
                $monthly[$k]['likes'] += $vv->likes;
                $monthly[$k]['comments'] += $vv->comments;
            }
        }

        foreach ($monthly as $k => $v) {
            $monthly[$k]['likes'] = (int) ($monthly[$k]['likes'] / count($raw2MonthlyFb[$k]));
            $monthly[$k]['comments'] = (int) ($monthly[$k]['comments'] / count($raw2MonthlyFb[$k]));
        }

        // if (empty($monthly[date('M Y', strtotime('+1 month'))])) {
        //     $monthly[date('M Y', strtotime('+1 month'))]['date'] = (date('M Y', strtotime('+1 month'))) . '';
        //     $monthly[date('M Y', strtotime('+1 month'))]['likes'] = 0;
        //     $monthly[date('M Y', strtotime('+1 month'))]['comments'] = 0;
        // }

        // yearly
        $rawYearlyFb = SocialbladeDatas::where('chanel', 'facebook')
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
        }

        foreach ($raw2YearlyFb as $k => $v) {
            foreach ($v as $vv) {
                if (empty($yearly[$k]['likes'])) {
                    $yearly[$k]['date'] = $k . '';
                    $yearly[$k]['likes'] = 0;
                    $yearly[$k]['comments'] = 0;
                }
                $yearly[$k]['likes'] += $vv->likes;
                $yearly[$k]['comments'] += $vv->comments;
            }
        }

        foreach ($yearly as $k => $v) {
            if ($k != date('Y') - 1) {
                $yearly[$k]['likes'] = (int) ($yearly[$k]['likes'] / count($raw2YearlyFb[$k]));
                $yearly[$k]['comments'] = (int) ($yearly[$k]['comments'] / count($raw2YearlyFb[$k]));
            }
        }


        // result
        $object = new stdClass();
        $object->daily = $daily;
        $object->weekly = $weekly;
        $object->monthly = array_values($monthly);
        $object->yearly = array_values($yearly);

        return $object;
    }

    public function index(Request $request)
    {
        $qontak = $this->getQontakData($request);
        $statistics = $this->getStatisticsData($request);
        $graph = $this->getGraphData();

        return response()->json([
            'graph' => $graph,
            'card' => [
                "likes" => $statistics->likes,
                "comments" => $statistics->comments,
                "message" => $qontak->message,
                "read" => $qontak->read,
                "unread" => $qontak->unread,
                "solved" => $qontak->solved,
                "unsolved" => $qontak->unsolved,

            ],
            'persentage' => [
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
}
