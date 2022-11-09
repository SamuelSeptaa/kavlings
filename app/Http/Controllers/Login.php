<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{
    public function login()
    {
        return view('dashboard.login');
    }
    public function sign_in(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email:dns|max:100',
            'password' => 'required',
        ]);

        if ($request->remember_me) {
            $cookie = random_string('alnum', 64);
            if (Auth::attempt($credentials, $cookie)) {
                $request->session()->regenerate();
                return redirect()->intended('dashboard');
            }
        }
    }
}
