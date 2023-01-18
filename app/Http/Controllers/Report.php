<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class Report extends Controller
{

    public function __construct()
    {
        $this->data['controller'] = 'report';
    }
    public function index()
    {
        $this->data['title']                = 'Laporan Penjualan Bulanan';
        $this->data['script']               = 'dashboard.report.script_index';
        return view('dashboard.report.index', $this->data);
    }

    public function show(Request $request)
    {
        $year = date('Y');
        if ($request->year)
            $year = $request->year;
        $query  =  DB::select(DB::raw("SELECT
                                        SUM( IF( MONTH(created_at) = 1, total, 0) ) AS jan,
                                        SUM( IF( MONTH(created_at) = 2, total, 0) ) AS feb,
                                        SUM( IF( MONTH(created_at) = 3, total, 0) ) AS mar,
                                        SUM( IF( MONTH(created_at) = 4, total, 0) ) AS apr,
                                        SUM( IF( MONTH(created_at) = 5, total, 0) ) AS mei,
                                        SUM( IF( MONTH(created_at) = 6, total, 0) ) AS jun,
                                        SUM( IF( MONTH(created_at) = 7, total, 0) ) AS jul,
                                        SUM( IF( MONTH(created_at) = 8, total, 0) ) AS agt,
                                        SUM( IF( MONTH(created_at) = 9, total, 0) ) AS sep,
                                        SUM( IF( MONTH(created_at) = 10, total, 0) ) AS okt,
                                        SUM( IF( MONTH(created_at) = 11, total, 0) ) AS nov,
                                        SUM( IF( MONTH(created_at) = 12, total, 0) ) AS des

                                    FROM orders
                                    WHERE YEAR(created_at) = $year;
                                "));

        return DataTables::of($query)
            ->addColumn('january', function ($query) {
                return currencyIDR($query->jan);
            })
            ->addColumn('february', function ($query) {
                return currencyIDR($query->feb);
            })
            ->addColumn('maret', function ($query) {
                return currencyIDR($query->mar);
            })
            ->addColumn('april', function ($query) {
                return currencyIDR($query->apr);
            })
            ->addColumn('mei_', function ($query) {
                return currencyIDR($query->mei);
            })
            ->addColumn('juni', function ($query) {
                return currencyIDR($query->jun);
            })
            ->addColumn('juli', function ($query) {
                return currencyIDR($query->jul);
            })
            ->addColumn('agustus', function ($query) {
                return currencyIDR($query->agt);
            })
            ->addColumn('sept', function ($query) {
                return currencyIDR($query->sep);
            })
            ->addColumn('oktober', function ($query) {
                return currencyIDR($query->okt);
            })
            ->addColumn('november', function ($query) {
                return currencyIDR($query->nov);
            })
            ->addColumn('desember', function ($query) {
                return currencyIDR($query->des);
            })
            ->make();
    }

    public function show_report_block(Request $request)
    {
        $year = date('Y');
        if ($request->year)
            $year = $request->year;
        $query  =  DB::select(DB::raw("SELECT
                                            COUNT( IF( MONTH(order_details.created_at) = 1, order_details.id, null) ) AS januari,
                                            COUNT( IF( MONTH(order_details.created_at) = 2, order_details.id, null) ) AS februari,
                                            COUNT( IF( MONTH(order_details.created_at) = 3, order_details.id, null) ) AS maret,
                                            COUNT( IF( MONTH(order_details.created_at) = 4, order_details.id, null) ) AS april,
                                            COUNT( IF( MONTH(order_details.created_at) = 5, order_details.id, null) ) AS mei,
                                            COUNT( IF( MONTH(order_details.created_at) = 6, order_details.id, null) ) AS juni,
                                            COUNT( IF( MONTH(order_details.created_at) = 7, order_details.id, null) ) AS juli,
                                            COUNT( IF( MONTH(order_details.created_at) = 8, order_details.id, null) ) AS agustus,
                                            COUNT( IF( MONTH(order_details.created_at) = 9, order_details.id, null) ) AS september,
                                            COUNT( IF( MONTH(order_details.created_at) = 10, order_details.id, null) ) AS oktober,
                                            COUNT( IF( MONTH(order_details.created_at) = 11, order_details.id, null) ) AS november,
                                            COUNT( IF( MONTH(order_details.created_at) = 12, order_details.id, null) ) AS desember,
                                            blocks.block_name
                                            
                                        FROM order_details
                                        JOIN orders ON orders.id = order_details.order_id
                                        JOIN kavlings ON kavlings.id = order_details.kavling_id
                                        right JOIN blocks ON kavlings.block_id  = blocks.id
                                        WHERE YEAR(order_details.created_at)    = $year
                                        AND orders.status = 'SELESAI'
                                        GROUP BY
                                        blocks.id, blocks.block_name
                                "));

        return DataTables::of($query)
            ->make();
    }
}
