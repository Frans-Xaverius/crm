<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QontakDatas;
use App\Models\SentMessage;
use App\Models\SocialbladeDatas;
use Carbon\Carbon;
use DB;

class SyncController extends Controller
{
    private $data;
    private $dataQontak;
    private $qontak_access_token;

    public function getQontakToken()
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

    public function getQontakData()
    {
        try {
            $this->getQontakToken();

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

            $decoded->data = array_filter($decoded->data, fn ($data) => $data != null, 1);
            $decoded->data = array_values($decoded->data);

            $this->dataQontak = $decoded->data;
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
        }
    }

    private function getSocialbladeData($platform)
    {
        try {
            $curl = curl_init();
            $headers = array(
                "clientid:" . env('SOCIAL_BLADE'),
                "token:" . env('SOCIAL_BLADE_TOKEN'),
                "history:" . "default",
                "query:" . "universitaspertamina"
            );
            $url = "https://matrix.sbapis.com/b/" . $platform . "/statistics";
            // dd($headers, $url);

            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $response = json_decode(curl_exec($curl));

            curl_close($curl);

            $this->data = $response->data;
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
        }
    }

    private function addQontakDatas($qontakData, $data, $contactakun, $contactnomor)
    {
        $qontakData->channel = $data->channel;
        $qontakData->_id = $data->id;
        $qontakData->name = $data->name;
        $qontakData->unread_count = $data->unread_count;
        $qontakData->_created_at = !empty($data->created_at) ? date('Y-m-d H:i:s', strtotime($data->created_at)) : null;
        $qontakData->_updated_at = !empty($data->updated_at) ? date('Y-m-d H:i:s', strtotime($data->updated_at)) : null;
        $qontakData->resolved_at = !empty($data->resolved_at) ? date('Y-m-d H:i:s', strtotime($data->resolved_at)) : null;
        $qontakData->resolved_by_id = $data->resolved_by_id;
        $qontakData->resolved_by_type = $data->resolved_by_type;
        $qontakData->agent_ids = json_encode($data->agent_ids);
        $qontakData->sender_id = $data->last_message->sender_id;
        $qontakData->username = $data->channel == "fb" || $data->channel == "ig" || $data->channel == "email" || $data->channel == "web_chat" ? $contactakun : null;
        $qontakData->phone_number = $data->channel == "wa" ? $contactnomor : null;
        $qontakData->status = $data->status;
        $qontakData->rating = null;
        $qontakData->save();
    }

    private function addSentMessage($data)
    {
        $chat = new SentMessage();
        $chat->room_id = $data->id;
        $chat->sender_id = $data->last_message->sender_id;
        $chat->channel = $data->channel;
        $chat->type = $data->last_message->type;
        $chat->text = $data->last_message->text;
        $chat->_created_at = $data->last_message->created_at;
        $chat->avatar = $data->avatar->url;
        $chat->name = $data->name;
        $chat->account_uniq_id = $data->account_uniq_id;
        $chat->channel_account = $data->channel_account;
        $chat->participant_type = $data->last_message->participant_type;
        $chat->save();
    }

    public function index(Request $request)
    {
        DB::beginTransaction();

        try {
            // Socialblade
            $platform = ['facebook', 'instagram'];
            foreach ($platform as $p) {
                $this->getSocialbladeData($p);

                foreach ($this->data->daily as $data) {
                    $cek = SocialbladeDatas::where('chanel', $p)->where('date', $data->date)->count();
                    if ($cek == 0) {
                        $save = new SocialbladeDatas();
                        $save->chanel = $p;
                        $save->date = $data->date;
                        $save->likes = $p == 'facebook' ? $data->likes : $data->avg_likes;
                        $save->comments = $p == 'facebook' ? $data->talking_about : $data->avg_comments;
                        $save->followers = $p == 'facebook' ? "" : $data->followers;
                        $save->save();
                    }
                }

                $save = SocialbladeDatas::where('chanel', $p)->where('date', date('Y-m-d'))->first();
                if (empty($save)) {
                    $save = new SocialbladeDatas();
                }
                $save->chanel = $p;
                $save->date = date('Y-m-d');
                $save->likes = $p == 'facebook' ? $this->data->statistics->total->likes : $this->data->statistics->average->likes;
                $save->comments = $p == 'facebook' ? $this->data->statistics->total->talking_about : $this->data->statistics->average->comments;
                $save->followers = $p == 'facebook' ? "" : $this->data->statistics->total->followers;
                $save->save();
            }

            // Qontak
            $this->getQontakData();
            // $needUpdate = array_filter($this->dataQontak, function ($data) {
            //     $dataUpdatedAt = Carbon::createFromTimestamp(strtotime($data->updated_at));
            //     // start of today time
            //     $now = Carbon::now()->subUnitNoOverflow('hour', 24, 'day');
            //     if ($dataUpdatedAt->greaterThan($now)) {
            //         return $data;
            //     }
            // });

            $needUpdate = $this->dataQontak;

            foreach ($needUpdate as $data) {
                $contactnomor = $data->account_uniq_id;
                $contactakun = $data->channel_account;
                $save = QontakDatas::where('_id', $data->id)->first();
                if (empty($save)) {
                    $save = new QontakDatas();
                }
                $this->addQontakDatas($save, $data, $contactakun, $contactnomor);

                // Save Chat Data
                $lastChat = SentMessage::where('room_id', $data->id)->get()->sortByDesc('_created_at')->first();
                $lastSavedChat = Carbon::createFromTimestamp(strtotime($lastChat ? $lastChat->_created_at :  '1970'));
                if (!$lastChat || Carbon::createFromTimestamp(strtotime($data->last_message->created_at))->greaterThan($lastSavedChat)) {
                    $this->addSentMessage($data);
                }

                if ($data->resolved_at) {
                    $date = date('Y-m-d H:i:s', strtotime($data->resolved_at));
                    SentMessage::where('room_id', $data->id)->update([
                        'resolved_at' => $date
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Sync success'
            ]);
        } catch (\Throwable $th) {
            DB::rollback();

            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ]);
        }
    }
}
