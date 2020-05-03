<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use DataTables;

class StoreController extends Controller
{

    public function index()
    {
        return view('dashboard.toko.all');
    }

    public function create()
    {
        return view('dashboard.toko.create');
    }

    public function store(Request $request)
    {
        //ambil id user yg sedang login
        $pemilik_id = auth()->user()->id;
        /**
         * Baris ini untuk menampilkan pesan saat validasi tidak sesuai
         */
        $messages = [
            'required' => ':attribute tidak boleh kosong.'
        ];
        
        /**
         * CustomAttributes -> untuk mengubah nama attribute
         * misal nama field di tabel database phone terus mau di ubah jadi nomor hp, dll.
         */
        $customAttributes = [
            'nama' => 'Nama',
            'phone'=> 'Nomor Telepon',
            'alamat' => 'Alamat',
        ];

        /**
         * rule validasi (contoh: required->harus di isi, nanti kamu lanjutin kolom yg belum ada validasinya)
         * contohnya lainnya lihat validasi usercontroller
         * atau liat di dokumentasi validation laravel.com
        */
        $valid = $request->validate([
            'nama' => 'required',
            'phone' => 'required',
            'alamat' => 'required'
        ],$messages,$customAttributes);

        //Cek apakah validasi di atas benar
        if($valid == true){
            $data_store = new Store([
                'pemilik_id' => $pemilik_id,
                'nama' => $request->get('nama'),
                'phone' => $request->get('phone'),
                'alamat' => $request->get('alamat')
            ]);
            
            $data_store->save();
            
            return redirect()->route('toko.index')->with('success','Toko berhasil ditambahkan.');
        }
        else {
            return view('dashboard.toko.create')->withInput();
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //cari data berdasarkan id
        $data['store'] = Store::find($id);

        return view('dashboard.toko.edit', $data);
    }

    public function update(Request $request, $id)
    {
        //VALIDASI UPDATE DATA DI SAMAKAN SEPERTI CREATE DATA 
        $messages = [
            'required' => ':attribute tidak boleh kosong.'
        ];
        
        /**
         * CustomAttributes -> untuk mengubah nama attribute
         * misal nama field di tabel database phone terus mau di ubah jadi nomor hp, dll.
         */
        $customAttributes = [
            'nama' => 'Nama',
            'phone'=> 'Nomor Telepon',
            'alamat' => 'Alamat',
        ];

        /**
         * rule validasi (contoh: required->harus di isi, nanti kamu lanjutin kolom yg belum ada validasinya)
         * contohnya lainnya lihat validasi usercontroller
         * atau liat di dokumentasi validation laravel.com
        */
        $valid = $request->validate([
            'nama' => 'required',
            'phone' => 'required',
            'alamat' => 'required'
        ],$messages,$customAttributes);

        //Cek apakah validasi di atas benar
        if($valid == true){
            $store = Store::find($id);
            $store->nama = $request->nama;
            $store->phone = $request->phone;
            $store->alamat = $request->alamat;
            $store->save();
            
            return redirect()->route('toko.index')->with('success','Toko berhasil diubah.');
        }
        else {
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        $store = Store::find($id);
        $store->delete();
        return redirect()->route('toko.index');
    }

    public function getData()
    {
        $pemilik_id = auth()->user()->id;
        $query = Store::select(['id', 'nama', 'phone', 'alamat', 'created_at'])->where('pemilik_id', $pemilik_id);

        return DataTables::of($query)
            ->addColumn('nama', function($store){
                return ucwords($store->nama);
            })
            ->addColumn('kontak', function($store){
                return $store->phone;
            })
            ->addColumn('alamat', function($store){
                return $store->alamat;
            })
            ->editColumn('action', function ($store) {
                return '<a href="' . route('toko.edit',$store->id) . '"><span class="fa fa-pencil" style="margin-right:5px;"> </span> </a> | <a type="javascript:;" data-toggle="modal" data-target="#konfirmasi_hapus" data-href="' . route('toko.delete',['id'=>$store->id]) . '" title="Delete"> <span class="fa fa-trash" style="margin-left:5px;"> </span></a>';
            })
            ->rawColumns(['nama', 'kontak', 'alamat', 'action'])
            ->addIndexColumn()
            ->make(true);        
    }

    public function indexStore()
    {
        return view('pelanggan.toko.all');
    }

    public function getDataStore()
    {
        $pemilik_id = auth()->user()->id;
        $query = Store::select(['id', 'nama', 'phone', 'alamat', 'created_at'])->where('pemilik_id', $pemilik_id);

        return DataTables::of($query)
            ->addColumn('nama', function($store){
                return ucwords($store->nama);
            })
            ->addColumn('kontak', function($store){
                return $store->phone;
            })
            ->addColumn('alamat', function($store){
                return $store->alamat;
            })
            ->editColumn('action', function ($store) {
                return '<a href="' . route('toko.edit',$store->id) . '"><span class="fa fa-pencil" style="margin-right:5px;"> </span> </a> | <a type="javascript:;" data-toggle="modal" data-target="#konfirmasi_hapus" data-href="' . route('toko.delete',['id'=>$store->id]) . '" title="Delete"> <span class="fa fa-trash" style="margin-left:5px;"> </span></a>';
            })
            ->rawColumns(['nama', 'kontak', 'alamat', 'action'])
            ->addIndexColumn()
            ->make(true);        
    }
}
