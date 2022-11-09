<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Kavling extends Controller
{
    public function index()
    {
        return view('guest.kavling');
    }
}
