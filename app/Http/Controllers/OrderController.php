<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
                    <a class="btn btn-primary icons-action" href="' . route('detail-add-ons', "orderid=$query->id") . '"><i class="mdi mdi-eye"></i></a>
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
}