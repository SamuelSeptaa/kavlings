<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Dashboard extends Controller
{
    //
    public function __construct()
    {
        $this->data['controller'] = 'Dashboard';
    }
    public function index()
    {
        $this->data['title']        = "Dashboard";
        return view('dashboard.index', $this->data);
    }
}
