<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SocialBladeApiController extends Controller
{
    private $data;
    private $info;

    public function getData(Request $request)
    {

        $curl = curl_init();
        $headers = array(
            "clientid:" . env('SOCIAL_BLADE'),
            "token:" . env('SOCIAL_BLADE_TOKEN'),
            "history:" . "default",
            "query:" . $request->id
        );
        $url = "https://matrix.sbapis.com/b/" . $request->platform . "/statistics";
        // dd($headers, $url);

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $response = json_decode(curl_exec($curl));

        curl_close($curl);

        $this->data = $response->data;
        $this->info = $response->info;

        // dd($this->data, $this->info);
        // return response()->json($response);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if (!empty($request->id) && !empty($request->platform)) {
            $this->getData($request);
        }

        $statistics = $this->data->statistics;

        $followers = strtolower($request->platform) == "instagram" ? $statistics->total->followers : 0;
        $likes =  0;
        $comments = 0;

        foreach ($this->data->daily as $data) {
            # code...
            if (strtolower($request->platform) == "facebook"){
                $comments += $data->talking_about;
                $likes += $data->likes;
            } else {
                $comments += $data->avg_comments;
                $likes += $data->avg_likes;
            }
        }

        return response()->json([
            'card' => [
                "followers" => $followers,
                "likes" => $likes,
                "comments" => $comments,
            ],
            "data" => $this->data
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filterByDate(Request $request)
    {
        $fromDate = date('r', strtotime($request->from_date));
        $toDate = date('r', strtotime($request->to_date));

        $datas = $this->data;

        foreach ($datas as $data) {
            if (date('r', strtotime($data->updated_at)) > $fromDate && date('r', strtotime($data->updated_at)) < $toDate) {
                array_push($datas, $data);
            }
        }
        dd($datas);
        $this->data = $datas;
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
