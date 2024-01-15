<?php

namespace App\Http\Controllers;

use App\Models\Tag;

class ReportController extends Controller
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
        $data['description'] = "Report";
        $data['tag'] = Tag::orderBy('name', 'asc')->get();
        
        return view('report', $data);
    }
}
