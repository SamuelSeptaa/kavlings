<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Dashboard extends Controller
{
    //
    public function __construct()
    {
        $this->data['controller'] = 'Dashboard';
    }
    public function index()
    {
        $this->data['title']        = "Dashboard";
        $this->data['script']       = "dashboard.script_index";
        return view('dashboard.index', $this->data);
    }

    public function chart_penjualan(Request $request)
    {
        $pivot =  DB::select(DB::raw('SELECT
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
                JOIN kavlings ON kavlings.id = order_details.kavling_id
                right JOIN blocks ON kavlings.block_id = blocks.id
                GROUP BY
                blocks.id
        '));

        $data = array();
        foreach ($pivot as $p) {
            $dataset =
                [
                    'label'             => $p->block_name,
                    'data'              => [
                        $p->januari, $p->februari, $p->maret, $p->april, $p->mei, $p->juni, $p->juli,
                        $p->agustus, $p->september, $p->oktober, $p->november, $p->desember
                    ],
                    'backgroundColor'   => [
                        "rgba(255, 99, 132, 0.2)",
                        "rgba(54, 162, 235, 0.2)",
                        "rgba(255, 206, 86, 0.2)",
                        "rgba(75, 192, 192, 0.2)",
                        "rgba(153, 102, 255, 0.2)",
                        "rgba(255, 159, 64, 0.2)",
                        "rgba(97, 127, 176, 0.2)",
                        "rgba(146, 121, 247, 0.2)",
                        "rgba(215, 63, 235, 0.2)",
                        "rgba(175, 235, 63, 0.2)",
                        "rgba(153, 54, 29, 0.2)",
                        "rgba(207, 157, 89, 0.2)",
                    ],
                    'borderColor'   => [
                        "rgba(255, 99, 132, 1)",
                        "rgba(54, 162, 235, 1)",
                        "rgba(255, 206, 86, 1)",
                        "rgba(75, 192, 192, 1)",
                        "rgba(153, 102, 255, 1)",
                        "rgba(255, 159, 64, 1)",
                        "rgba(97, 127, 176, 1)",
                        "rgba(146, 121, 247, 1)",
                        "rgba(215, 63, 235, 1)",
                        "rgba(175, 235, 63, 1)",
                        "rgba(153, 54, 29, 1)",
                        "rgba(207, 157, 89, 1)",
                    ],
                    'borderWidth'   => 1
                ];

            array_push($data, $dataset);
        }

        return response()->json([
            'Status'        => 'success',
            'data'          => [
                'dataset'   => $data
            ]
        ], 200);
    }
}
