<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersStoreRequest;
use App\User;
use DataTables;
use Illuminate\Support\Facades\Mail;
use App\Mail\InviteUsers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function index()
    {
        $data['pengguna'] = User::all();

        return view('dashboard.users.all', $data);
    }

    public function create()
    {
        //
    }

    public function store(UsersStoreRequest $request)
    {
        $messages = [
            'required' => ':attribute tidak boleh kosong.',
            'regex'    => ':attribute harus berupa karakter alphabet.',
            'unique'   => ':attribute sudah digunakan',
        ];

        $customAttributes = [
            'name' => 'Nama',
            'email' => 'Email',
            'phone' => 'Telepon',
            'role' => 'Role'
        ];

        $posted = $request->validated($messages,$customAttributes);

        $pwd = Str::random(10);

        $posted['password'] = bcrypt($pwd);

        $user = User::create($posted);
        Mail::to($user->email)->send(new InviteUsers($user, $pwd));
            
        return redirect()->route('user.index')->with('success','Users created successfully.');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function getData()
    {
        $query = User::select(['id', 'name', 'email', 'role', 'phone', 'alamat', 'created_at']);

        return DataTables::of($query)
            ->addColumn('name', function($user){
                return ucwords($user->name) . '<span style="color:#3c8dbc;">  (' . $user->role . ')</span>';
            })
            ->addColumn('kontak', function($user){
                return $user->email . '<br><span style="color: #3c8dbc;">' . $user->phone . '</span>';
            })
            ->addColumn('alamat', function($user){
                return $user->alamat;
            })
            ->editColumn('action', function ($user) {
                return '<a href="' . route('user.edit',$user->id) . '"><span class="fa fa-pencil" style="margin-right:5px;"> </span> </a> | <a type="javascript:;" data-toggle="modal" data-target="#konfirmasi_hapus" data-href="' . route('user.delete',['id'=>$user->id]) . '" title="Delete"> <span class="fa fa-trash" style="margin-left:5px;"> </span></a>';
            })
            ->rawColumns(['name', 'kontak', 'alamat', 'action'])
            ->addIndexColumn()
            ->make(true);
    }
}
