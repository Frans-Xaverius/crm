<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    // }


    // new --------

    /**
     * Login username to be used by the controller.
     *
     * @var string
     */
    protected $username;
 
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
 
        $this->username = $this->findUsername();
    }

    public function showLoginForm()
    {
        $url = env('APP_URL');

        if (env('APP_ENV') == 'local') {
            $login_url = 'https://sso-dev.universitaspertamina.ac.id/sso-login?redirect_url=' . $url . ':8000/auth/callback';
        } elseif (env('APP_ENV') == 'dev') {
            $login_url = 'https://sso-dev.universitaspertamina.ac.id/sso-login?redirect_url=' . $url . '/auth/callback';
        } else {
            $login_url = 'https://sso.universitaspertamina.ac.id/sso-login?redirect_url=' . $url . '/auth/callback';
        }
        return redirect()->to($login_url);
        // dd($login_url);
        // return Redirect::to($login_url);
    }
 
    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function findUsername()
    {
        $login = request()->input('email');
 
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'sso';
 
        request()->merge([$fieldType => $login]);
 
        return $fieldType;
    }
 
    /**
     * Get username property.
     *
     * @return string
     */
    public function username()
    {
        return $this->username;
    }

    public function auth()
    {

        if (isset($_GET['username'])) {
            $username = $_GET['username'];
            $token_login = $_GET['token'];

            setcookie('username', $username, time() + (86400 * 30), "/");
            setcookie('token_login', $token_login, time() + (86400 * 30), "/");

            $user = User::where('name', $username)->first();

            if ($user != null) {
                $user = User::find($user->id);
                // dd($user->id);
                Auth::loginUsingId([$user->id]);
                return redirect()->intended($this->redirectPath());
            } else {
                $user = User::create([
                    'name' => $username,
                    'email' => '',
                    'password' => Hash::make($username),
                    'department_id' => 5,
                    'email_verified_at' => now()
                ]);

                return redirect()->intended($this->redirectPath());
            }
        } else {
            $login_url = 'https://sso-dev.universitaspertamina.ac.id/sso-login?redirect_url=http://localhost:8000/auth/redirect';
            return Redirect::to($login_url);
        }
    }

    public function logout(Request $request)
    {
        Session::flush();
        if (isset($_COOKIE['token_login']) || isset($_COOKIE['username'])) {
            $token_login = $_COOKIE['token_login'];
            $username = $_COOKIE['username'];
            if (isset($_SERVER['HTTP_COOKIE'])) {
                $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
                foreach ($cookies as $cookie) {
                    $parts = explode('=', $cookie);
                    $name = trim($parts[0]);
                    setcookie($name, '', time() - 1000);
                    setcookie($name, '', time() - 1000, '/');
                }
            }
            $clear_session = 'https://sso-dev.universitaspertamina.ac.id/sso-logout?token=' . $token_login . '&username=' . $username;
            $url = env('APP_URL');
            $logout_url = $url . ':8000';

            return Redirect::to($clear_session);

            // $logout_url = 'https://sso.universitaspertamina.ac.id/sso-logout?token='.$token_login.'&username='.$username;

        }
    }
}
