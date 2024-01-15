<?php

namespace App\Http\Controllers;

use App\Models\ApplicationStatistics;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{
    private $qontak_access_token;
    private $qontakData;
    private $facebookData;
    private $instagramData;

    // public function __construct()
    // {
    //     $this->getQontakAccessToken();
    //     $this->getQontakData();
    //     $this->getSocialBladeData("instagram");
    //     $this->getSocialBladeData("facebook");

    //     $date = '';
    //     $read_count = 0;
    //     $unread_count = 0;
    //     $solved_count = 0;
    //     $unsolved_count = 0;
    //     $ig_followers_count = 0;
    //     $ig_likes_count = 0;
    //     $ig_comments_count = 0;
    //     $fb_likes_count = 0;
    //     $fb_comments_count = 0;

    //     $date = Carbon::now()->endOfMonth()->toDateString();

    //     // fb
    //     $fb_likes_count = $this->facebookData->statistics->total->likes;
    //     foreach ($this->facebookData->daily as $daily) {
    //         # code...
    //         $fb_comments_count += $daily->talking_about;
    //     }

    //     // ig
    //     $ig_followers_count = $this->instagramData->statistics->total->followers;
    //     foreach ($this->instagramData->daily as $daily) {
    //         # code...
    //         $ig_comments_count += $daily->avg_comments;
    //         $ig_likes_count += $daily->avg_likes;
    //     }

    //     // qontak
    //     foreach ($this->qontakData->daily as $data) {
    //         # code...
    //         if ($data->resolved_at != null) {
    //             $solved_count;
    //         } else {
    //             $unsolved_count;
    //         }

    //         if ($data->unread_count == 0) {
    //             $read_count;
    //         } else {
    //             $unread_count;
    //         }
    //     }
    //     $this->updateApplicationStatistics([
    //         $date,
    //         $read_count,
    //         $unread_count,
    //         $solved_count,
    //         $unsolved_count,
    //         $ig_followers_count,
    //         $ig_likes_count,
    //         $ig_comments_count,
    //         $fb_likes_count,
    //         $fb_comments_count
    //     ]);
    // }

    public function getQontakAccessToken()
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
        // else {
        //     echo $response;
        // }
        $decodedResponse = json_decode($response);
        $this->qontak_access_token = $decodedResponse->access_token;
    }

    public function getQontakData()
    {
        $this->getQontakAccessToken();
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://service-chat.qontak.com/api/open/v1/rooms",
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
        $channel_integration_ids = [];
        foreach ($decoded->data as $data) {
            # code...
            $channel_integration_ids[] = $data->channel_integration_id;
        }
        dd($channel_integration_ids, $this->qontak_access_token);
    }

    public function getSocialBladeData($platform)
    {
        $curl = curl_init();
        $headers = array(
            "clientid:" . env('SOCIAL_BLADE'),
            "token:" . env('SOCIAL_BLADE_TOKEN'),
            "history:" . "default",
            "query: universitaspertamina"
        );
        $url = "https://matrix.sbapis.com/b/" . $platform . "/statistics";
        // dd($headers, $url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $response = json_decode(curl_exec($curl));

        curl_close($curl);

        if ($platform == "instagram") {
            $this->instagramData = $response->data;
        } else {
            $this->facebookData = $response->data;
        }
    }

    public function updateApplicationStatistics($attr)
    {
        $data = ApplicationStatistics::find($attr['date'])->first();
        if (!$data) {
            $data = ApplicationStatistics::create(
                ['date' => $attr['date']],
                ['read_count' => $attr['read_count']],
                ['unread_count' => $attr['unread_count']],
                ['solved_count' => $attr['solved_count']],
                ['unsolved_count' => $attr['unsolved_count']],
                ['ig_followers_count' => $attr['ig_followers_count']],
                ['ig_likes_count' => $attr['ig_likes_count']],
                ['ig_comments_count' => $attr['ig_comments_count']],
                ['fb_likes_count' => $attr['fb_likes_count']],
                ['fb_comments_count' => $attr['fb_comments_count']],
            );
        } else {
            foreach ($attr as $key => $value) {
                # code...
                $data[$key] = $value;
            }
            $data->save();
        }
    }


    public function index()
    {
        return view('fb');
    }

    private function getTotalPerUser()
    {
        $aggregate = DB::table('historical_fb')
            ->select(DB::raw('MAX(date) as date'))
            ->groupBy('user_id');

        $result = DB::table('historical_fb')
            ->select(DB::raw('SUM("followers") as followers, SUM("likes") as likes, SUM("comments") as comments'))
            ->whereIn('date', $aggregate)
            ->get()->toArray();

        return $result[0];
    }

    private function getTotal($historical)
    {
        $last_data = $historical[count($historical) - 1];
        $result['followers'] = $last_data->followers;
        $result['likes'] = $last_data->likes;
        $result['comments'] = $last_data->comments;
        $yesterday_data = $historical[count($historical) - 2];
        $result['yesterday_followers'] = $yesterday_data->followers;
        $result['yesterday_likes'] = $yesterday_data->likes;
        $result['yesterday_comments'] = $yesterday_data->comments;
        $result['calculate_followers'] = $last_data->followers - $yesterday_data->followers;
        $result['calculate_likes'] = $last_data->likes - $yesterday_data->likes;
        $result['calculate_comments'] = $last_data->comments - $yesterday_data->comments;
        $result['percentage_followers'] = $last_data->followers ? ($result['calculate_followers'] / $last_data->followers) * 100 : 0;
        $result['percentage_likes'] = $last_data->likes ? ($result['calculate_likes'] / $last_data->likes) * 100 : 0;
        $result['percentage_comments'] = $last_data->comments ? ($result['calculate_comments'] / $last_data->comments) * 100 : 0;
        // $result['followers'] = 0;
        // $result['likes'] = 0;
        // $result['comments'] = 0;
        // foreach($historical as $val){
        //     $result['followers'] += $val->followers;
        //     $result['likes'] += $val->likes;
        //     $result['comments'] += $val->comments;
        // }
        return $result;
    }

    private function getHistorical()
    {
        if (isset($_GET['date'])) {
            $result = DB::table('historical_fb')
                ->select('date', DB::raw('SUM("followers") as followers, SUM("likes") as likes, SUM("comments") as comments'))
                ->where('date', '<=', $_GET['date'])
                ->groupBy('date')
                ->orderBy('date', 'ASC')
                ->get()->toArray();
        } else {
            $result = DB::table('historical_fb')
                ->select('date', DB::raw('SUM("followers") as followers, SUM("likes") as likes, SUM("comments") as comments'))
                ->groupBy('date')
                ->orderBy('date', 'ASC')
                ->get()->toArray();
        }

        return $result;
    }

    // app
    public function facebook($page = NULL)
    {
        $data['page'] = $page;
        $data['description'] = "Facebook";
        // $data['historical'] = $this->getHistorical();
        // $data['total'] = $this->getTotal($data['historical']);
        $fileview = 'fb';

        if ($page) {
            $data['description'] .= " (" . ucfirst($page) . ")";
            // if (isset($_GET['date'])) {
            //     $aggregate = DB::table('historical_fb')
            //         ->select(DB::raw('MAX(date) as date'))
            //         ->where('date', '<=', $_GET['date'])
            //         ->groupBy('user_id');
            // } else {
            //     $aggregate = DB::table('historical_fb')
            //         ->select(DB::raw('MAX(date) as date'))
            //         ->groupBy('user_id');
            // }
            // $data['db'] = DB::table('historical_fb')
            //     ->join('config_user', 'historical_fb.user_id', '=', 'config_user.user_id')
            //     ->select('historical_fb.*', 'config_user.name', 'config_user.email')
            //     ->whereIn('date', $aggregate)
            //     ->get()->toArray();
            $fileview = 'fb-detail';
        }

        if (isset($_GET['debug_data'])) {
            print_r($data);
            exit;
        }

        return view($fileview, $data);
    }

    public function instagram($page = NULL)
    {
        $data['page'] = $page;
        $data['description'] = "Instagram";
        $fileview = 'ig';
        if (is_null($page)) {
            //
        } else {
            $data['description'] .= " (" . ucfirst($page) . ")";
            $fileview = 'ig-detail';
        }

        if (isset($_GET['debug_data'])) {
            print_r($data);
            exit;
        }

        return view($fileview, $data);
    }

    public function wa($page = NULL)
    {
        $data['page'] = $page;
        $data['description'] = "WhatsApp";
        $fileview = 'wa';
        if (is_null($page)) {
        } else {
            $fileview = 'wa-detail';
        }

        if (isset($_GET['debug_data'])) {
            print_r($data);
            exit;
        }

        return view($fileview, $data);
    }

    public function callcenter($page = NULL)
    {
        $data['page'] = $page;
        $data['description'] = "Call Center";
        $fileview = 'cc';
        if (is_null($page)) {
        } else {
            $fileview = 'cc-detail';
        }

        if (isset($_GET['debug_data'])) {
            print_r($data);
            exit;
        }

        return view($fileview, $data);
    }

    public function webchat($page = NULL)
    {
        $data['page'] = $page;
        $data['description'] = "Web Chat";
        $fileview = 'wc';
        if (is_null($page)) {
        } else {
            $fileview = 'wc-detail';
        }

        if (isset($_GET['debug_data'])) {
            print_r($data);
            exit;
        }

        return view($fileview, $data);
    }

    public function email($page = NULL)
    {
        $fileview = 'email';
        if (is_null($page)) {
        } else {
            $fileview = 'email-detail';
        }

        return view($fileview);
    }
}
