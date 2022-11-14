<?php

namespace App\Http\Controllers;

use App\Models\AddOn;
use Cart;
use Illuminate\Http\Request;

class Checkout extends Controller
{
    public function index()
    {
        $this->data['title']    = "Checkout";
        $this->data['carts']    = Cart::getContent();
        $this->data['addons']    = AddOn::where('status', 'ON')->get();
        $this->data['total']    = Cart::getSubTotal();


        $this->data['script']   = 'guest.script_checkout';

        return view('guest.checkout', $this->data);
    }

    public function makePayment()
    {
    }
}
