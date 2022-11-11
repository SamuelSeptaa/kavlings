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
    public $data = array();

    public function __construct()
    {
        $this->data['controller'] = 'kavlingcontroller';
    }

    public function index()
    {
        $this->data['script']   = 'dashboard.kavling.script_index';
        $this->data['blocks'] = Block::select(['id', 'block_name'])->get();

        return view('dashboard.kavling.index', $this->data);
    }

    public function show(Request $request)
    {
        $kavlings = Kavling::with('block');

        return DataTables::of($kavlings)
            ->addColumn('action', function ($kavlings) {
                return '
                <div class="btn-group">
                        <a class="btn btn-primary icons-action" href="' . route('detail-user-list', "userid=$kavlings->id") . '"><i class="mdi mdi-eye"></i></a>
                        <button type="button" class="btn btn-danger icons-action" onclick="deleteData(' . $kavlings->id . ')"><i class="mdi mdi-delete"></i></button>
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
}
