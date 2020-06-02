<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Desa;
use DataTables;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class StoreController extends Controller
{

    public function index()
    {
        return view('dashboard.toko.all');
    }

    public function create()
    {
        $data['kabupaten'] = Kabupaten::select(['id','nama'])->get();
        return view('dashboard.toko.create',$data);
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
            'alamat' => 'required',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'desa' => 'required'
        ],$messages,$customAttributes);

        //cek foto
        $cover = $request->file('foto');
        $extension = $cover->getClientOriginalExtension();
        Storage::disk('public')->put($cover->getFilename().'.'.$extension,  File::get($cover));
    
        //Cek apakah validasi di atas benar
        if($valid == true){
            $data_store = new Store([
                'pemilik_id' => $pemilik_id,
                'nama' => $request->get('nama'),
                'phone' => $request->get('phone'),
                'kabupaten' => $request->get('kabupaten'),
                'kecamatan' => $request->get('kecamatan'),
                'desa' => $request->get('desa'),
                'alamat' => $request->get('alamat'),
                'foto' => $cover->getFilename().'.'.$extension,
                'aktif' => 1,
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

    public function delete($id)
    {
        $store = Store::find($id);
        $store->aktif = 0;
        $store->save();
        return redirect()->route('toko.index')->with('succcess', 'Toko berhasil dihapus!');
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
        // $query = Store::select(['id', 'nama', 'foto', 'phone', 'alamat', 'created_at'])->where('pemilik_id', $pemilik_id);
        $query = DB::table("stores")
        ->join('kabupaten', 'stores.kabupaten', '=', 'kabupaten.id')
        ->join('kecamatan', 'stores.kecamatan', '=', 'kecamatan.id')
        ->join('desa', 'stores.desa', '=', 'desa.id')
        ->select('stores.*', 'kabupaten.nama as nama_kab', 'kecamatan.nama as nama_kec', 'desa.nama as nama_desa')
        ->where('pemilik_id', $pemilik_id)
        ->where('aktif',1)
        ->get();

        return DataTables::of($query)
            ->addColumn('nama', function($store){
                // return ucwords($store->nama);
                if($store->foto != NULL){
                    $output = '<img src="/uploads/' . $store->foto . '" alt="' . $store->nama . '" width="60" class="mr-3 pull-left">' . ucwords($store->nama);
                }else{
                    $output = '<img src="/uploads/image_not_found.png" alt="' . $store->nama . '" width="60" class="mr-3 pull-left">' . ucwords($store->nama);
                }
                return $output;
            })
            ->addColumn('kontak', function($store){
                return $store->phone;
            })
            ->addColumn('alamat', function($store){
                return $store->alamat . ', ' . $store->nama_desa . ', ' . $store->nama_kec . ', ' . $store->nama_kab;
            })
            ->editColumn('action', function ($store) {
                return '<a href="' . route('toko.edit',$store->id) . '"><span class="fa fa-pencil" style="margin-right:5px;"> </span> </a> | 
                <a type="javascript:;" data-toggle="modal" data-target="#konfirmasi_hapus" data-href="' . route('toko.hapus',['id'=>$store->id]) . '" title="Delete"> <span class="fa fa-trash" style="margin-left:5px;"> </span></a>';
            })
            ->rawColumns(['nama', 'kontak', 'alamat', 'action'])
            ->addIndexColumn()
            ->make(true);
    }

    public function indexStore()
    {
        $data['toko'] = Store::paginate(12);
        $data['kecamatan'] = Kecamatan::all();
        $data['desa'] = Desa::all();
        return view('pelanggan.toko.all',$data);
    }

    public function getDataStore()
    {
        $pemilik_id = auth()->user()->id;
        $query = Store::select(['id', 'nama', 'foto', 'phone', 'alamat', 'created_at'])->where('pemilik_id', $pemilik_id);

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

    public function getKecamatan($id)
    {
        // $kecamatan = Kecamatan::select(['kabupaten_id','nama'])->where('kabupaten_id', $id)->get();
        $kecamatan = DB::table("kecamatan")->where("kabupaten_id",$id)->pluck("nama","id");
        return json_encode($kecamatan);
    }
    
    public function getDesa($id)
    {
        // $kecamatan = Kecamatan::select(['kabupaten_id','nama'])->where('kabupaten_id', $id)->get();
        $desa = DB::table("desa")->where("kecamatan_id",$id)->pluck("nama","id");
        return json_encode($desa);
    }

    public function filter(Request $request)
    {
        $request_filter = $request->all();
        if($request_filter->filter_kecamatan);
        
    }

    public function detailStore($id)
    {
        $ptoko = Store::with(['product','pemilik','cek_kabupaten','cek_kecamatan','cek_desa'])->find($id);
        $tproduk =  DB::table("products")
                                ->join('stores', 'stores.id', '=', 'products.store_id')
                                ->select('stores.*','stores.foto as foto_toko', 'products.*', 'products.foto as foto_produk')
                                ->where('stores.id', $id)
                                ->paginate(10);
        return view('pelanggan.toko.view', ['ptoko' => $ptoko, 'tproduk' => $tproduk]);
    }

    public function getDataDetail($id)
    {
        $query = DB::table("products")
                ->join('stores', 'stores.id', '=', 'products.store_id')
                ->where('stores.id', $id)
                ->get();

        return DataTables::of($query)
            ->addColumn('nama', function($produk_toko){
                return 'dasdasdasdasdsad';
            })
            ->editColumn('action', function ($produk_toko) {
                return '<a href="#"><span class="fa fa-pencil" style="margin-right:5px;"> </span> </a>';
            })
            ->rawColumns(['nama', 'action'])
            ->addIndexColumn()
            ->make(true);
    }
}
