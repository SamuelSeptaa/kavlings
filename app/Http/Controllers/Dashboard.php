<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Dashboard extends Controller
{
    //
    public $data = array();
    public function index()
    {
        return view('dashboard.index');
    }
}
