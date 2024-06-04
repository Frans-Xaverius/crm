<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InstagramToken;
use Carbon\Carbon;

class InstagramController extends Controller {

    protected $access = null;
    protected $refreshUrl = 'https://api.instagram.com/oauth/authorize?client_id=882283413896676&redirect_uri=https://crm.local/media/instagram/auth&scope=user_profile,user_media&response_type=code';
    
    public function auth (Request $request) {

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.instagram.com/oauth/access_token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_POSTFIELDS => http_build_query([
                'client_id' => '882283413896676',
                'client_secret' => '2348bf7db5790f5db1ea3576426b3372',
                'grant_type' => 'authorization_code',
                'redirect_uri' => 'https://crm.local/media/instagram/auth',
                'code' => $request->get('code')
            ])
        ));

        $response = json_decode(curl_exec($curl));
        curl_close($curl);

        $token = $response->access_token ?? '';

        InstagramToken::create([
            'token' => $token,
            'expired' => Carbon::now()->addMinutes(20)
        ]);

        return redirect()->route('media.instagram');
    }

    public function index () {

        $refreshUrl = $this->refreshUrl;
        $token = InstagramToken::orderBy('expired', 'DESC')->first()->token;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://graph.instagram.com/me/media?fields=id,media_type,media_url,username,caption&access_token={$token}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_SSL_VERIFYPEER => false,
        ));

        $response = json_decode(curl_exec($curl));
        curl_close($curl);

        return view ('media.instagram.index', compact('refreshUrl', 'response'));
    }
}
