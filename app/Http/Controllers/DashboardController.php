<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

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
            'numeric'  => ':attribute harus berupa karakter angka.',
            'alpha'    => ':attribute harus berupa karakter alphabet.',
        ];

        $customAttributes = [
            'name' => 'Nama',
            'phone' => 'Telepon',
            'no_ijin' => 'Nomor Izin Usaha',
        ];

        $valid = $request->validate([
            'name' => 'required|alpha',
            'phone' => 'required|numeric|digits_between:11,13',
            'no_ijin' => 'numeric'
        ],$messages,$customAttributes);

        if($valid == true){
            $user = auth()->user();
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->no_ijin = $request->no_ijin;
            $user->foto = $request->foto;
    
            if (isset($request->new_password) && $request->new_password == $request->confirm_password) {
                $user->password = bcrypt($request->new_password);
            }
            $user->save();

            return redirect()->route('profile')->with('success', 'Profile updated successfully.');
        }
        return redirect()->route('profile')->with('error', 'Profile updated is failed.');
    }

    public function updateFotoProfile(Request $request)
    {
        $valid = $request->validate([
            'foto' => 'required|mimes:jpg,png,jpeg,gif,svg'
        ]);

        if($valid == true){
            //cek foto
            $cover = $request->file('foto');
            $extension = $cover->getClientOriginalExtension();
            Storage::disk('public')->put($cover->getFilename().'.'.$extension,  File::get($cover));

            $user = auth()->user();
            $user->foto = $cover->getFilename().'.'.$extension;
    
            $user->save();

            return redirect()->route('profile')->with('success', 'Profile updated successfully.');
        }
        return redirect()->route('profile')->with('error', 'Profile updated is failed.');
    }
}
