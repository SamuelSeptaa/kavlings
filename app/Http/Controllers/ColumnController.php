<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Kavling;
use App\Models\RowBlock;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ColumnController extends Controller
{
    public function __construct()
    {
        $this->data['controller'] = 'column';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['title']   = 'Daftar Colom Denah Kavling';
        $this->data['script']   = 'dashboard.column.script_index';
        return view('dashboard.column.index', $this->data);
    }


    public function add()
    {
        $this->data['title']    = "Tambah Barisan Blok";
        $select = [
            (object)[
                'id' => 'block-a',
                'text'    => '13 Kolom x 17 Baris kavling'
            ],
            (object)[
                'id' => 'block-b',
                'text'    => '6 Kolom x 17 Baris kavling'
            ],
            (object)[
                'id' => 'block-c',
                'text'    => '26 Kolom x 17 Baris kavling'
            ],
        ];

        $forms = [
            array('classname', 'select', 'Tipe Baris Blok', $select),
            array('block_name', 'text', 'Nama atau Inisial Baris Block'),
        ];
        $this->data['forms'] = $forms;
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
            'classname'              => 'required',
            'block_name'              => 'required',
        ]);

        // dd($data);
        $row = RowBlock::create(
            [
                'classname'     => $data['classname'],
                'rowname'       => ''
            ]
        );
        RowBlock::where('id', $row->id)->update(['rowname' => $row->id]);

        $dataKavling = array();
        if ($data['classname'] == 'block-a') {
            $firstRow   = 156;
            $secondRow  = 221;
        }
        if ($data['classname'] == 'block-b') {
            $firstRow   = 72;
            $secondRow  = 102;
        }
        if ($data['classname'] == 'block-c') {
            $firstRow   = 312;
            $secondRow  = 442;
        }
        for ($i = 1; $i <= 3; $i++) {
            $newBlock = Block::create([
                'block_name'    => $data['block_name'] . "-$i",
                'is_parking'    => ($i == 1) ? 'YES' : 'NO',
                'row_block_id'  => $row->id
            ]);

            if ($i == 1)
                $batas = $firstRow;
            else
                $batas = $secondRow;

            for ($j = 1; $j <= $batas; $j++) {
                array_push(
                    $dataKavling,
                    [
                        'nama_kavling'      => $newBlock->block_name . "-$j",
                        'block_id'          => $newBlock->id
                    ]
                );
            }
        }
        $collection = collect($dataKavling);   //turn data into collection
        $chunks = $collection->chunk(100); //chunk into smaller pieces
        $chunks->toArray(); //convert chunk to array

        //loop through chunks:
        foreach ($chunks as $chunk) {
            Kavling::insert($chunk->toArray());
        }

        return redirect()->route('column')->with('success', 'Barisan Block Baru ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $query = RowBlock::select(['*'])->with('blocks');

        return DataTables::of($query)
            ->addColumn('action', function ($query) {
                return '
                    <button type="button" class="btn btn-danger icons-action" onclick="remove(' . $query->id . ')" ><i class="mdi mdi-delete"></i></button>
                ';
            })
            ->addColumn('total_kavling', function ($query) {
                return $query->kavlingCounts($query->id);
            })
            ->addColumn('total_kavling_sold', function ($query) {
                return $query->kavlingSoldCounts($query->id);
            })
            ->make(true);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
