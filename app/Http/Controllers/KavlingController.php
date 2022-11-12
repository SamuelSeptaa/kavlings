<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Kavling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class KavlingController extends Controller
{
    //
    public function __construct()
    {
        $this->data['controller'] = 'kavlingcontroller';
    }

    public function index()
    {
        $this->data['title']   = 'Daftar Kavling';
        $this->data['script']   = 'dashboard.kavling.script_index';
        $this->data['blocks'] = Block::select(['id', 'block_name'])->get();
        return view('dashboard.kavling.index', $this->data);
    }

    public function show(Request $request)
    {
        $kavlings = Kavling::select(['kavlings.*', 'block_name'])->with('block');

        return DataTables::of($kavlings)
            ->addColumn('action', function ($kavlings) {
                return '
                <div class="btn-group">
                        <button type="button" class="btn btn-success icons-action" onclick="activingKavling(' . $kavlings->id . ')" ><i class="mdi mdi-checkbox-marked-circle-outline"></i></button>
                        <button type="button" class="btn btn-danger icons-action" onclick="nonacitiveKavling(' . $kavlings->id . ')"><i class="mdi  mdi-block-helper"></i></button>
                    </div> 
                ';
            })
            ->addColumn('statusbadge', function ($kavlings) {
                if ($kavlings->status == 'AVAILABLE')
                    return '<span class="badge badge-primary">' . $kavlings->status . '</span>';
                return '<span class="badge badge-danger">' . $kavlings->status . '</span>';
            })
            ->removeColumn('id')
            ->rawColumns(['statusbadge', 'action'])
            ->removeColumn('status')
            ->filter(function ($query) use ($request) {
                $this->YajraFilterValue($request->filterValue, $query, "block_id", true, "kavlings", "block_id", "blocks");
                $this->YajraColumnSearch(
                    $query,
                    ['block_name', 'nama_kavling'],
                    $request->search
                );
            })
            ->make(true);
    }

    public function destroy(Request $request)
    {
        $kavling = Kavling::findOrFail($request->id);
        Kavling::where('id', $request->id)
            ->update(['status' => 'UNAVAILABLE']);

        return response()->json(
            ['message' => 'Success menonaktifkan'],
            200
        );
    }

    public function activing(Request $request)
    {
        $kavling = Kavling::findOrFail($request->id);
        Kavling::where('id', $request->id)
            ->update(['status' => 'AVAILABLE']);

        return response()->json(
            ['message' => 'Success mengaktifkan'],
            200
        );
    }
}
