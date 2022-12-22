<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class Testi extends Controller
{
    public function index()
    {
        $this->data['script']   = 'guest.script_contact';
        return view('guest.contact', $this->data);
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'nama'  => 'required|max:100|min:5',
            'testimonial_text'  => 'required|max:255|min:5',
            'g-recaptcha-response' => 'recaptcha'
        ]);

        Testimonial::create($data);

        return response()->json([
            'message' => [
                'title' => "Berhasil",
                'body'  => "Terima kasih telah mengisi ulasan"
            ],
        ], 200);
    }
}
