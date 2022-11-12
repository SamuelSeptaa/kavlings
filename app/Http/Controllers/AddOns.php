<?php

namespace App\Http\Controllers;

use App\Models\AddOn;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AddOns extends Controller
{
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



    public function add()
    {
        $this->data['title']    = 'Tambah Add On';
        $forms = [
            array('nama_add_on', 'text', 'Nama Add On'),
            array('harga', 'number', 'Harga Add On'),
            array('keterangan', 'textarea', 'Keterangan')
        ];

        $this->data['forms']     = $forms;

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
        $data = $request->validate(
            [
                'nama_add_on'   => 'required|min:5|max:255',
                'harga'         => 'required',
                'keterangan'    => 'required'
            ],
        );
        AddOn::create($data);
        return redirect()->route('add-ons')->with('success', 'Add on baru ditambahkan');
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
                    <a class="btn btn-primary icons-action" href="' . route('detail-add-ons', "addons_id=$query->id") . '"><i class="mdi mdi-eye"></i></a>
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


    public function detail(Request $request)
    {
        if (!$request->addons_id) return redirect()->route('eror404');
        $detail = AddOn::findOrFail($request->addons_id);

        $this->data['title']    = "Detail $detail->nama_add_on";

        $forms = [
            array('nama_add_on', 'text', 'Nama Add On'),
            array('harga', 'number', 'Harga Add On'),
            array('keterangan', 'textarea', 'Keterangan')
        ];

        $this->data['forms']    = $forms;
        $this->data['detail']   = $detail;
        return view('layout.detail', $this->data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AddOn  $addOn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->validate(
            [
                'nama_add_on'   => 'required|min:5|max:255',
                'harga'         => 'required',
                'keterangan'    => 'required'
            ],
        );
        AddOn::where('id', $request->id)->update($data);
        return redirect()->route('add-ons')->with('success', 'Add on berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AddOn  $addOn
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $detail = AddOn::findOrFail($request->id);
        AddOn::where('id', $request->id)
            ->update(['status' => 'OFF']);

        return response()->json(['message' => 'Berhasil menonaktfikan']);
    }

    public function activing(Request $request)
    {
        $detail = AddOn::findOrFail($request->id);

        AddOn::where('id', $request->id)
            ->update(['status' => 'ON']);

        return response()->json(['message' => 'Berhasil mengaktifkan']);
    }
}
