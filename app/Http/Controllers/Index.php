<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class Index extends Controller
{
    //
    public function index()
    {
        $this->data['testimonials'] = Testimonial::where('status', 'APPROVED')->get();
        return view('guest.index', $this->data);
    }
}
