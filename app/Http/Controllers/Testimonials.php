<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class Testimonials extends Controller
{

    public function __construct()
    {
        $this->data['controller'] = 'testimonials';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['title']        = 'List Testimonial';
        $this->data['script']       = 'dashboard.testimonials.script_index';
        return view('dashboard.testimonials.index', $this->data);
    }

    public function add()
    {
        $forms = [
            array('nama', 'text', 'Nama'),
            array('testimonial_text', 'textarea', 'Teks Testimonial')
        ];
        $this->data['title']        = "Tambah Testimonial";
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
            'nama'              => 'required|min:5|max:100',
            'testimonial_text'  => 'required|min:50|max:255'
        ]);

        Testimonial::create($data);

        return redirect()->route('testimonials')->with('success', 'Testimonials ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
        $testimonial = Testimonial::select('*');
        return DataTables::of($testimonial)
            ->addColumn('action', function ($query) {
                return '
                <div class="btn-group">
                    <a class="btn btn-primary icons-action" href="' . route('detail-testimonials', "id=$query->id") . '"><i class="mdi mdi-eye"></i></a>
                    <button type="button" class="btn btn-danger icons-action" onclick="deleteItem(' . $query->id . ')"><i class="mdi mdi-delete"></i></button>
                </div> 
            ';
            })
            ->make(true);
    }


    public function detail(Request $request)
    {
        $detail = Testimonial::findOrFail($request->id);
        $forms = [
            array('nama', 'text', 'Nama'),
            array('testimonial_text', 'textarea', 'Teks Testimonial')
        ];
        $this->data['title']        = "Edit Testimonial";
        $this->data['forms']        = $forms;
        $this->data['detail']       = $detail;

        return view('layout.detail', $this->data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'nama'              => 'required|min:5|max:100',
            'testimonial_text'  => 'required|min:50|max:255'
        ]);

        Testimonial::where('id', $request->id)
            ->update($data);

        return redirect()->route('testimonials')->with('success', 'Berhasil mengubah data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Testimonial::findOrFail($request->id);
        Testimonial::where('id', $request->id)
            ->delete();

        return response()->json(['message' => 'Berhasil dihapus']);
    }
}
