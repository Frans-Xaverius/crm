<?php

namespace App\Http\Controllers;

class SettingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('accountmg');
    }

    public function accountmg()
    {
        return view('accountmg');
    }

    public function agentmg()
    {
        return view('agentmg');
    }
}
