<?php

namespace App\Http\Controllers;

use App\Mail\PaymentSuccess;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class Payment extends Controller
{
    //
    public function index(Request $request)
    {
        $arrayUpdate = array();
        $now = date('Y-m-d H:i:s');
        if ($request->status_code == 1) {
            $arrayUpdate['status_pembayaran']   = 'SUCCESS';
            $arrayUpdate['tanggal_pembayaran']  = $now;
            $arrayUpdate['status']  = "SELESAI";

            $order = Order::where('nomor_invoice', $request->reference_id)->first();

            Mail::to($order->email_pemesan)->send(new PaymentSuccess($order));
        } elseif ($request->status_code == 0) {
            $arrayUpdate['status_pembayaran']   = 'PENDING';
        } elseif ($request->status_code == 2) {
            $arrayUpdate['status_pembayaran']   = 'FAILED';
        }

        Order::where('nomor_invoice', $request->reference_id)
            ->update(
                $arrayUpdate
            );

        return response()->json(
            [
                'message' => 'Success',
            ]
        );
    }
}
