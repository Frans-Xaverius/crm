<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pertanyaan;

class PertanyaanController extends Controller
{
    public function index () {

        $pertanyaan = Pertanyaan::all();

        return view ('pertanyaan.index', compact('pertanyaan'));
    }
}
