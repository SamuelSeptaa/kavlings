<?php

namespace App\Http\Controllers;

use App\Models\AddOn;
use App\Models\Order;
use App\Models\Kavling;
use App\Models\OrderDetail;
use App\Mail\PaymentSuccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->data['controller'] = 'orders';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['title']                = 'Daftar Pemesanan Kavling';
        $this->data['script']               = 'dashboard.order.script_index';
        $this->data['filter_status']        = get_enum_values('orders', 'status');
        return view('dashboard.order.index', $this->data);
    }

    public function add()
    {
        $kavlings = Kavling::select(['*'])->where('status', 'AVAILABLE')->get();

        $kavlings = $kavlings->map(function ($item) {
            return (object)
            [
                'id' => $item->id,
                'text'    => $item->nama_kavling
            ];
        });

        $metode_pembayaran = [
            (object)[
                'id'    => 'CASH',
                'text'    => 'CASH'
            ],
            (object)[
                'id'    => 'TRANSFER',
                'text'    => 'TRANSFER'
            ]
        ];

        $addons = AddOn::select(['*'])->where('status', 'ON')->get();
        $addons = $addons->map(function ($item) {
            return (object)
            [
                'id' => $item->id,
                'text'    => $item->nama_add_on
            ];
        });

        $forms = [
            array('nama_pemesan', 'text', 'Nama Pemesan'),
            array('email_pemesan', 'text', 'Email Pemesan'),
            array('nomor_pemesan', 'text', 'Nomor HP Pemesan'),
            array('nama_terhibah', 'text', 'Nama Terhibah'),
            array('nomor_hp_terhibah', 'text', 'Nomor HP terhibah'),
            array('kavling_list', 'multipleselect', 'List Kavling yang dibeli', $kavlings),
            array('add_on_list', 'multipleselect', 'List Add On', $addons),
            array('metode_pembayaran', 'select', 'Metode Pembayaran', $metode_pembayaran),
        ];
        $this->data['title']        = "Tambah Pesanan";
        $this->data['forms']        = $forms;
        return view('layout.add', $this->data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_pemesan'          => 'required|min:5|max:100|regex:/^[A-Za-z\s]*$/',
            'email_pemesan'         => 'required|email:dns',
            'nomor_pemesan'         => 'required|digits_between:10,13|regex:/^(^08)(\d{3,4}-?){2}\d{3,4}$/',
            'nama_terhibah'         => 'nullable|min:5|max:100|regex:/^[A-Za-z\s]*$/',
            'nomor_hp_terhibah'     => 'nullable|digits_between:10,13|regex:/^(^08)(\d{3,4}-?){2}\d{3,4}$/',
            'kavling_list'        => 'required',
            'add_on_list'        => 'nullable',
            'metode_pembayaran'     => 'required',
        ]);



        $total_kavling = count($data['kavling_list']);
        $total = $total_kavling * 1500000;
        unset($data['add_on_list']);
        unset($data['kavling_list']);

        $nomorInvoice = generateOrderNumber();
        $data['nomor_invoice'] = $nomorInvoice;
        $data['total'] = $total;
        $data['status'] = 'SELESAI';
        $data['status_pembayaran'] = 'SUCCESS';
        $data['tanggal_pembayaran'] = date('Y-m-d H:i:s');
        $order = Order::create($data);

        if ($request->add_on_list != null)
            foreach ($request->add_on_list as $addons_id) {
                $add_ons = AddOn::find($addons_id);
                $total += $add_ons->harga * $total_kavling;
                OrderDetail::create(
                    [
                        'order_id'      => $order->id,
                        'nama'          => $add_ons->nama_add_on,
                        'jumlah'        => $total_kavling,
                        'subtotal'      => $add_ons->harga * $total_kavling,
                    ]
                );
            }

        foreach ($request->kavling_list as $kavling_id) {
            $kavling = Kavling::find($kavling_id);
            OrderDetail::create(
                [
                    'order_id'      => $order->id,
                    'nama'          => $kavling->nama_kavling,
                    'jumlah'        => 1,
                    'subtotal'      => 1500000,
                    'kavling_id'    => $kavling->id,
                ]
            );
            Kavling::where('id', $kavling->id)
                ->update(['status'  => 'UNAVAILABLE']);
        }

        Order::where('id', $order->id)
            ->update([
                'total'         => $total,
            ]);


        return redirect()->route('orders')->with('success', "Pesanan dengan nomor Invoice $nomorInvoice ditambahkan");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $query = Order::select(['*']);

        return DataTables::of($query)
            ->addColumn('action', function ($query) {
                return '
                    <a class="btn btn-primary icons-action" href="' . route('detail-orders', "orderid=$query->id") . '"><i class="mdi mdi-eye"></i></a>
                ';
            })
            ->addColumn('statusOrderBadge', function ($query) {
                switch ($query->status) {
                    case 'BARU':
                        return '<span class="badge badge-primary">' . $query->status . '</span>';
                        break;
                    case 'PEMBAYARAN':
                        return '<span class="badge badge-warning">' . $query->status . '</span>';
                        break;
                    case 'SELESAI':
                        return '<span class="badge badge-success">' . $query->status . '</span>';
                        break;
                    case 'CANCEL':
                        return '<span class="badge badge-danger">' . $query->status . '</span>';
                        break;
                }
            })
            ->addColumn('totalIDR', function ($query) {
                return currencyIDR($query->total);
            })
            ->addColumn('statusPembayaranBadge', function ($query) {
                switch ($query->status_pembayaran) {
                    case 'PENDING':
                        return '<span class="badge badge-warning">' . $query->status_pembayaran . '</span>';
                        break;
                    case 'SUCCESS':
                        return '<span class="badge badge-success">' . $query->status_pembayaran . '</span>';
                        break;
                    case 'FAILED':
                        return '<span class="badge badge-danger">' . $query->status_pembayaran . '</span>';
                        break;
                }
            })
            ->addColumn('kontak', function ($query) {
                return '
                    <div class="flex-column">
                        <div class="mb-2"><a href="mailto:' . $query->email_pemesan . '">' . $query->email_pemesan . '</a></div>
                        <div><a href="tel:' . $query->nomor_pemesan . '">' . $query->nomor_pemesan . '</a></div>
                    </div>
                ';
            })
            ->addColumn('metodePembayaran', function ($query) {
                switch ($query->metode_pembayaran) {
                    case 'TRANSFER':
                        return '<span class="badge badge-primary">' . $query->metode_pembayaran . '</span>';
                        break;
                    case 'CASH':
                        return '<span class="badge badge-secondary">' . $query->metode_pembayaran . '</span>';
                        break;
                }
            })
            ->addColumn('tanggalPesanan', function ($query) {
                return parseTanggal($query->created_at);
            })
            ->rawColumns(['statusPembayaranBadge', 'statusOrderBadge', 'action', 'kontak', 'metodePembayaran'])
            ->filter(function ($query) use ($request) {
                $this->YajraFilterValue($request->filterValue, $query, 'status');
                $this->YajraColumnSearch($query, ['nomor_invoice', 'nama_pemesan'], $request->search);
            })
            ->removeColumn([
                'id', 'total', 'status', 'metode_pembayaran', 'status_pembayaran', 'tanggal_pembayaran',
                'email_pemesan', 'nomor_pemesan'
            ])
            ->make();
    }


    public function detail(Request $request)
    {
        if (!$request->orderid) return redirect()->route('eror404');
        $order = Order::findOrFail($request->orderid);

        $this->data['order']        = $order;
        $this->data['title']        = "Detail Pesanan Nomor $order->nomor_invoice";

        return view('dashboard.order.detail', $this->data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    public function verifikasiCash(Request $request)
    {
        $order = Order::findOrFail($request->orderid);

        Order::where('id', $request->orderid)
            ->update([
                'status_pembayaran'     => 'SUCCESS',
                'tanggal_pembayaran'    => date('Y-m-d H:i:s'),
                'status'                => 'SELESAI'
            ]);

        Mail::to($order->email_pemesan)->send(new PaymentSuccess($order));
        return redirect()->route('orders')->with('success', "Pesanan dengan nomor Invoice $order->nomor_invoice berhasil diverifikasi");
    }
}
