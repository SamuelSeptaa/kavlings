<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use DataTables;

class UserList extends Controller
{
    //
    public $data = array();

    public function __construct()
    {
        $this->data['controller'] = 'userlist';
    }
    public function index()
    {
        $this->data['script']   = 'dashboard.user.script_index';
        return view('dashboard.user.index', $this->data);
    }

    public function show()
    {
        $users = User::select(['id', 'name', 'email']);

        return DataTables::of($users)
            ->addColumn('action', function ($user) {
                return '
                <div class="btn-group">
                        <a class="btn btn-primary icons-action" href="' . route('detail-user-list', "userid=$user->id") . '"><i class="mdi mdi-eye"></i></a>
                        <button type="button" class="btn btn-danger icons-action" onclick="deleteData(' . $user->id . ')"><i class="mdi mdi-delete"></i></button>
                    </div> 
                ';
            })
            ->editColumn('id', 'ID: {{$id}}')
            ->removeColumn('id')
            ->make();
    }

    public function detail(Request $request)
    {
        if (!$request->userid) return redirect()->route('eror404');
        $user = User::findOrFail($request->userid);

        $forms = [
            array('name', 'text', "Nama"),
            array('email', 'text', "Email"),
            array('password', 'password', "Password"),
            array('password_confirm', 'password', "Konfirmasi Password"),
        ];

        $this->data['forms'] = $forms;
        $this->data['detail'] = $user;
        $this->data['title'] = "Detail User";
        return view('layout.detail', $this->data);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:5|max:100|regex:/^[a-zA-Z ]*$/',
            'email' => 'required|email:dns|max:100|unique:users,email,' . $request->id . '',
            'password' => 'max:100',
            'password_confirm' => 'same:password',
        ]);

        unset($data['id']);
        unset($data['password']);
        unset($data['password_confirm']);
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        User::where('id', $request->id)
            ->update($data);

        return redirect()->route('userlist')->with('success', 'User berhasil diubah');
    }

    public function delete(Request $request)
    {
        if ($request->id == 1)
            return response()->json(
                ['message' => 'Dilarang Menghapus user ini!'],
                403
            );
        $user = User::findOrFail($request->id);
        $user->delete();

        return response()->json(
            ['message' => 'Success menghapus'],
            200
        );
    }

    public function add()
    {
        $forms = [
            array('name', 'text', "Nama"),
            array('email', 'text', "Email"),
            array('password', 'password', "Password"),
            array('password_confirm', 'password', "Konfirmasi Password"),
        ];

        $this->data['forms'] = $forms;
        $this->data['title'] = "Tambah User";
        return view('layout.add', $this->data);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:5|max:100|regex:/^[a-zA-Z ]*$/',
            'email' => 'required|email:dns|max:100|unique:users,email',
            'password' => 'required|max:100',
            'password_confirm' => 'required|same:password',
        ]);

        unset($data['password_confirm']);
        $data['password'] = bcrypt($request->password);
        User::insert($data);
        return redirect()->route('userlist')->with('success', 'User baru ditambahkan');
    }
}
