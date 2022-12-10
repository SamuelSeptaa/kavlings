<?php

namespace App\Http\Controllers;

use App\Models\Block;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BlockController extends Controller
{
    public function __construct()
    {
        $this->data['controller'] = 'block';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['title']   = 'Daftar Blok';
        $this->data['script']   = 'dashboard.block.script_index';
        return view('dashboard.block.index', $this->data);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $query = Block::select(['*'])->with('kavlings');

        return DataTables::of($query)
            ->addColumn('action', function ($query) {
                return '
                <a class="btn btn-primary icons-action" href="' . route('detail-block', "id=$query->id") . '"><i class="mdi mdi-eye"></i></a>
                ';
            })
            ->addColumn('total_kavling', function ($query) {
                return $query->kavlingCounts($query->id);
            })
            ->addColumn('total_kavling_sold', function ($query) {
                return $query->kavlingSoldCounts($query->id);
            })
            ->addColumn('harga_per_kavling', function ($query) {
                return currencyIDR($query->harga);
            })
            ->filter(function ($query) use ($request) {
                $this->YajraColumnSearch(
                    $query,
                    ['block_name'],
                    $request->search
                );
            })
            ->make(true);
    }

    public function detail(Request $request)
    {
        $detail = Block::findOrFail($request->id);
        $forms = [
            array('harga', 'text', 'Harga Per Kavling'),
        ];
        $this->data['title']        = "Edit Block Kavling";
        $this->data['forms']        = $forms;
        $this->data['detail']       = $detail;

        return view('layout.detail', $this->data);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'harga'              => 'required|integer',
        ]);

        Block::where('id', $request->id)
            ->update($data);

        return redirect()->route('block')->with('success', 'Berhasil mengubah data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
