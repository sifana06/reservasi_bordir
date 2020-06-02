<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }
    
    public function index()
    {
        return redirect()->route('dashboard');
    }

    public function dashboard()
    {
        $check = auth()->user()->role;
        if($check == 'pelanggan'){
            return redirect()->route('home');
        }else{
            return view('dashboard.dashboard');
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
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

    public function profile()
    {
        $user = auth()->user()->role;
        if($user == 'pelanggan'){
            return view('pelanggan.profile');
        }else{
            return view('dashboard.profile');
        }
    }
    
    public function profileUpdate(Request $request)
    {
        $messages = [
            'required' => ':attribute tidak boleh kosong.',
            'regex'    => ':attribute harus berupa karakter alphabet.',
        ];

        $customAttributes = [
            'name' => 'Nama',
            'phone' => 'Telepon',
            'no_ijin' => 'Nomor Izin Usaha',
        ];

        $valid = $request->validate([
            'name' => 'required|regex:/^[\pL\s\-]+$/u',
            'phone' => 'required',
        ],$messages,$customAttributes);

        if($valid == true){
            $user = auth()->user();
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->no_ijin = $request->no_ijin;
    
            if (isset($request->new_password) && $request->new_password == $request->confirm_password) {
                $user->password = bcrypt($request->new_password);
            }
            $user->save();

            return redirect()->route('profile')->with('success', 'Profile updated successfully.');
        }
        return redirect()->route('profile')->with('error', 'Profile updated is failed.');
    }
}
