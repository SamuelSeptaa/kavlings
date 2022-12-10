<?php

namespace App\Http\Controllers;

use App\Models\Kavling;
use Cart;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class CartController extends Controller
{
    //
    public function addtocart(Request $request)
    {
        $kavlings = json_decode($request->kavlings);

        $carts = [];
        foreach ($kavlings as $kavling) {
            $K = Kavling::with('block')->find($kavling);
            if ($K->status == 'UNAVAILABLE')
                return response()->json(['message' => "Terdapat kavling yang tidak tersedia!"], 500);
            array_push(
                $carts,
                [
                    'id'        => $K->id,
                    'name'      => $K->nama_kavling,
                    'price'     => $K->block->harga,
                    'quantity'  => 1
                ]
            );
        }
        Cart::add(
            $carts
        );
        return response()->json(
            [
                'message' => "Berhasil"
            ],
            200
        );
    }

    public function cartcontent()
    {
        dd(\Cart::getContent());
    }
}
