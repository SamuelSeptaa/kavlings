<?php

namespace App\Http\Controllers;

use Cart;
use App\Models\AddOn;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Mail\OrderNotification;
use App\Models\Kavling;
use Illuminate\Support\Facades\Mail;

class Checkout extends Controller
{
    public function index()
    {

        if (Cart::isEmpty())
            return redirect()->route('kavling');
        $this->data['title']    = "Checkout";
        $this->data['carts']    = Cart::getContent();
        $this->data['addons']    = AddOn::where('status', 'ON')->get();
        $this->data['total']    = Cart::getSubTotal();

        $this->data['script']   = 'guest.script_checkout';

        return view('guest.checkout', $this->data);
    }

    public function placeOrder(Request $request)
    {
        $data = $request->validate([
            'email_pemesan' => 'required|email:dns|max:100|min:8',
            'nama_pemesan' => 'required|max:100|min:5',
            'nomor_pemesan' => 'required|numeric|digits_between:10,13',
            'nama_terhibah' => 'nullable|max:100|min:8',
            'nomor_hp_terhibah' => 'nullable|digits_between:10,13|numeric',
            'metode_pembayaran' => 'required'
        ]);

        $nomorInvoice   = generateOrderNumber();
        $cartItems      = Cart::getContent();
        $total          = Cart::getSubTotal();


        $order = Order::create(
            [
                'nomor_invoice'     => $nomorInvoice,
                'total'             => $total,
                'metode_pembayaran' => $data['metode_pembayaran'],
                'nama_pemesan'      => $data['nama_pemesan'],
                'email_pemesan'     => $data['email_pemesan'],
                'nomor_pemesan'     => $data['nomor_pemesan'],
                'nama_tehibah'      => $data['nama_terhibah'],
                'nomor_hp_terhibah' => $data['nomor_hp_terhibah']
            ]
        );

        $products = [];
        $qty = [];
        $price = [];

        foreach ($cartItems as $cart) {
            OrderDetail::create(
                [
                    'order_id'      => $order->id,
                    'nama'          => $cart->name,
                    'kavling_id'    => $cart->id,
                    'jumlah'        => 1,
                    'subtotal'      => $cart->price,
                ]
            );

            $products[] = "Kavling - $cart->name";
            $qty[] = 1;
            $price[] = $cart->price;

            Kavling::where('id', $cart->id)
                ->update(['status'  => 'UNAVAILABLE']);
        }

        if ($request->add_ons != null)
            foreach ($request->add_ons as $key => $value) {
                $addons = AddOn::find($value);
                $total += $addons->harga * $cartItems->count();

                OrderDetail::create(
                    [
                        'order_id'      => $order->id,
                        'nama'          => $addons->nama_add_on,
                        'jumlah'        => $cartItems->count(),
                        'subtotal'      => $addons->harga * $cartItems->count(),
                    ]
                );
                $products[] = $addons->nama_add_on;
                $qty[] = $cartItems->count();
                $price[] = $addons->harga;
            }
        //Hapus isi cart;

        Cart::clear();

        if ($data['metode_pembayaran'] == "TRANSFER") {
            $payment_detail = $this->createPaymentIpaymu($products, $qty, $price, $nomorInvoice, $data);
            if ($payment_detail['status']) {
                Order::where('id', $order->id)
                    ->update([
                        'url_payment'   => $payment_detail['url'],
                        'total'         => $total,
                        'status'        => 'PEMBAYARAN'
                    ]);

                $orderNew = Order::find($order->id);
                Mail::to($data['email_pemesan'])->send(new OrderNotification($orderNew));

                return response()->json([
                    'message' => [
                        'title' => "Berhasil",
                        'body'  => "Berhasil membuat pesanan"
                    ],
                    'data'  => [
                        'url_payment'   =>  $payment_detail['url']
                    ]
                ], 200);
            }
        } else {
            $orderNew = Order::find($order->id);
            Order::where('id', $order->id)
                ->update([
                    'total'         => $total
                ]);
            $orderNew = Order::find($order->id);
            Mail::to($data['email_pemesan'])->send(new OrderNotification($orderNew));
            return response()->json([
                'message' => [
                    'title' => "Berhasil",
                    'body'  => "Berhasil membuat pesanan"
                ],
                'data'  => [
                    'url_payment'   =>  null
                ]
            ], 200);
        }
    }

    private function createPaymentIpaymu($products, $qty, $price, $nomorInvoice, $dataPemesan)
    {
        $url          = 'https://sandbox.ipaymu.com/api/v2/payment'; // for development mode
        $va           = "0000002350781100"; //get on iPaymu dashboard
        $secret       = "SANDBOX9ED77FBD-75A5-4C6F-B884-1EB7565BEBA5"; //get on iPaymu dashboard

        $method       = 'POST'; //method
        //Request Body//
        $body['product']    = $products;
        $body['qty']        = $qty;
        $body['price']      = $price;
        $body['returnUrl']  = route('index');
        $body['cancelUrl']  = route('index');
        $body['notifyUrl']  = route('payment-notify');
        $body['referenceId'] = $nomorInvoice; //your reference id

        //get data user agar payment page langsung terisi
        $body['buyerName'] = $dataPemesan['nama_pemesan'];
        $body['buyerEmail'] = $dataPemesan['email_pemesan'];
        $body['buyerPhone'] = $dataPemesan['nomor_pemesan'];
        //End Request Body//

        //Generate Signature
        // *Don't change this
        $jsonBody     = json_encode($body, JSON_UNESCAPED_SLASHES);
        $requestBody  = strtolower(hash('sha256', $jsonBody));
        $stringToSign = strtoupper($method) . ':' . $va . ':' . $requestBody . ':' . $secret;
        $signature    = hash_hmac('sha256', $stringToSign, $secret);
        $timestamp    = Date('YmdHis');
        //End Generate Signature


        $ch = curl_init($url);

        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
            'va: ' . $va,
            'signature: ' . $signature,
            'timestamp: ' . $timestamp
        );

        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_POST, count($body));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonBody);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $err = curl_error($ch);
        $ret = curl_exec($ch);
        curl_close($ch);

        if ($err) {
            echo [
                'status' => FALSE
            ];
        } else {
            $ret = json_decode($ret);
            if ($ret->Status == 200) {
                $sessionId  = $ret->Data->SessionID;
                $url        =  $ret->Data->Url;
                return [
                    'status' => TRUE,
                    'url' => $url,
                    'sessionId' => $sessionId
                ];
            } else {
                echo "<pre>";
                var_dump($ret);
            }
            //End Response
        }
    }
}
