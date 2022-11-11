<?php

namespace App\Http\Controllers;

use App\Models\AddOn;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AddOns extends Controller
{

    public $data = array();

    public function __construct()
    {
        $this->data['controller'] = 'add-ons';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['title']    = 'List Add Ons';
        $this->data['script']   = 'dashboard.addons.script_index';

        $this->data['filter']   = get_enum_values('add_ons', 'status');
        return view('dashboard.addons.index', $this->data);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $query = AddOn::select(['add_ons.*']);

        return DataTables::of($query)
            ->addColumn('action', function ($query) {
                return '
                <div class="btn-group">
                    <button type="button" class="btn btn-success icons-action" onclick="activingAddOns(' . $query->id . ')" ><i class="mdi mdi-checkbox-marked-circle-outline"></i></button>
                    <button type="button" class="btn btn-danger icons-action" onclick="nonactivingAddOns(' . $query->id . ')"><i class="mdi  mdi-block-helper"></i></button>
                </div> 
            ';
            })
            ->addColumn('statusbadge', function ($query) {
                if ($query->status == 'ON')
                    return '<span class="badge badge-primary">' . $query->status . '</span>';
                return '<span class="badge badge-danger">' . $query->status . '</span>';
            })
            ->addColumn('hargaIDR', function ($query) {
                return currencyIDR($query->harga);
            })
            ->removeColumn('id')
            ->rawColumns(['statusbadge', 'action'])
            ->removeColumn('status')
            ->filter(function ($query) use ($request) {
                $this->YajraFilterValue($request->filterValue, $query, 'status');
                $this->YajraColumnSearch($query, ['nama_add_on'], $request->search);
            })
            ->make(true);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AddOn  $addOn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AddOn $addOn)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AddOn  $addOn
     * @return \Illuminate\Http\Response
     */
    public function destroy(AddOn $addOn)
    {
        //
    }
}
