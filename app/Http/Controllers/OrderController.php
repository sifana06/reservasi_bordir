<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Product;
use App\Models\Order;
use App\Models\Store;
use App\Models\Kabupaten;
use Carbon\Carbon;

class OrderController extends Controller
{

    public function index()
    {
        $check = auth()->user()->role;
        $check_id = auth()->user()->id;
        $order = Order::find($check_id);
        if($check == "pelanggan"){
            return view('pelanggan.order.all', ['order' => $order]);
        }else{
            return view('dashboard.order.all', ['order' => $order]);
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

    public function getData()
    {
        $pemilik_id = auth()->user()->id;
        $query = Order::with(['product','user_customer','store_product'])->select(['id', 'user_id','store_id','product_id','order_number','foto','jenis_bordir','keterangan','nama_pelanggan','email','telepon','kabupaten','kecamatan','desa','alamat','catatan','deadline','jumlah','harga','total','status_order','status_pengiriman','tipe_pembayaran','tipe_pengiriman','order_at','received_at', 'created_at'])->where('pemilik_id', $pemilik_id);

        return DataTables::of($query)
            ->addColumn('order_number', function($order){
                $output = $order->order_number.'<div><span class="text-warning"><b>Deadline : '.Carbon::parse($order->deadline)->format('d/M/y').'</b></span></div>';
                return $output;
            })
            ->addColumn('customers', function($order){
                return $order->nama_pelanggan;
            })
            ->addColumn('products', function($order){
                return $order->product->nama.'<div>Jenis Bordir: '.$order->jenis_bordir.'</div>';
            })
            ->addColumn('status', function($order){
                return '<div class="small text-muted">Status Pesanan </div><div> <small><li class="fa fa-circle fa-xs" style="color:#f1c40f;"></li></small> '.ucwords($order->status_order).'</div>
                <div class="small text-muted">Status Pengiriman </div><div> <small><li class="fa fa-circle fa-xs"></li></small> ------</div>';
            })
            ->addColumn('total', function($order){
                return $order->total;
            })
            ->editColumn('action', function ($order) {
                return '<div class="input-group-btn">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="fa fa-bars"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="#">Jadi Order</a></li>
                                <li><a href="#">Candel Order</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Edit Order</a></li>
                            </ul>
                        </div>';
            })
            ->rawColumns(['order_number', 'customers', 'products', 'status', 'total', 'action'])
            ->addIndexColumn()
            ->make(true);
    }

    public function order()
    {

        return view('pelanggan.order.all');
    }

    public function createOrder($id)
    {
        $data['kabupaten'] = Kabupaten::select(['id','nama'])->get();
        $data['ambilProduk'] = Product::find($id);
        return view('pelanggan.order.checkout', $data);
    }
    
    public function buatOrder()
    {
        $data['kabupaten'] = Kabupaten::select(['id','nama'])->get();
        $data['ambilStore'] = Store::all();
        return view('pelanggan.order.create', $data);
    }

    public function saveCheckout(Request $request)
    {
        $user_id = auth()->user()->id;
        $messages = [
            'required' => ':attribute tidak boleh kosong.'
        ];
        $customAttributes = [
            'user_id' => 'User ID',
            'store_id'=> 'Store ID',
            'product_id' => 'Product ID',
            'order_number' => 'Order Number',
            'foto'=> 'Foto Bordir',
            'jenis_bordir' => 'Jenis Bordir',
            'keterangan' => 'Keterangan',
            'nama_pelanggan'=> 'Nama Pelanggan',
            'email' => 'Email',
            'telepon' => 'Telepon',
            'kabupaten'=> 'Kabupaten',
            'kecamatan' => 'Kecamatan',
            'desa' => 'Desa',
            'alamat'=> 'Alamat',
            'catatan' => 'Catatan',
            'deadline' => 'Deadline',
            'jumlah'=> 'Jumlah',
            'harga' => 'Harga',
        ];

        $valid = $request->validate([
            'product_id' => 'required',
            // 'foto' => 'required',
            'jenis_bordir' => 'required',
            'nama_pelanggan' => 'required',
            'telepon' => 'required',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'desa' => 'required',
            'alamat' => 'required',
            'catatan' => 'required',
            'deadline' => 'required',
            'jumlah' => 'required',
            'harga' => 'required',
        ],$messages,$customAttributes);

        // //cek foto
        // $cover = $request->file('foto');
        // $extension = $cover->getClientOriginalExtension();
        // Storage::disk('public')->put($cover->getFilename().'.'.$extension,  File::get($cover));
    
        //Cek apakah validasi di atas benar
        if($valid == true){
            $total = $request->jumlah*$request->harga;
            $data_store = Order::create([
                'user_id' => $user_id,
                'store_id' => $request->get('store_id'),
                'product_id' => $request->get('product_id'),
                'pemilik_id' => $request->get('pemilik_id'),
                'order_number' =>  "RO".Carbon::now()->format('Y/m/d')."-".Carbon::now()->format('His'),
                'jenis_bordir' => $request->get('jenis_bordir'),
                'keterangan' => $request->get('keterangan'),
                'nama_pelanggan' => $request->get('nama_pelanggan'),
                'email' => $request->get('email'),
                'telepon' => $request->get('telepon'),
                'kabupaten' => $request->get('kabupaten'),
                'kecamatan' => $request->get('kecamatan'),
                'desa' => $request->get('desa'),
                'alamat' => $request->get('alamat'),
                'catatan' => $request->get('catatan'),
                'deadline' => Carbon::parse($request->get('deadline'))->format('y/m/d'),
                'jumlah' => $request->get('jumlah'),
                'harga' => $request->get('harga'),
                'total' => $total,
                'status_order' => "pending",
            ]);
            
            return redirect()->route('po.index')->with('success','Pesanan Berhasil Dibuat.');
        }
        else {
            return view('pelanggan.order.checkout')->withInput();
        }
    }

    public function saveOrder(Request $request)
    {
        $user_id = auth()->user()->id;
        $messages = [
            'required' => ':attribute tidak boleh kosong.'
        ];
        $customAttributes = [
            'user_id' => 'User ID',
            'store_id'=> 'Store ID',
            'product_id' => 'Product ID',
            'order_number' => 'Order Number',
            'foto'=> 'Foto Bordir',
            'jenis_bordir' => 'Jenis Bordir',
            'keterangan' => 'Keterangan',
            'nama_pelanggan'=> 'Nama Pelanggan',
            'email' => 'Email',
            'telepon' => 'Telepon',
            'kabupaten'=> 'Kabupaten',
            'kecamatan' => 'Kecamatan',
            'desa' => 'Desa',
            'alamat'=> 'Alamat',
            'catatan' => 'Catatan',
            'deadline' => 'Deadline',
            'jumlah'=> 'Jumlah',
            'harga' => 'Harga',
        ];

        $valid = $request->validate([
            'product_id' => 'required',
            // 'foto' => 'required',
            'jenis_bordir' => 'required',
            'nama_pelanggan' => 'required',
            'telepon' => 'required',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'desa' => 'required',
            'alamat' => 'required',
            'catatan' => 'required',
            'deadline' => 'required',
            'jumlah' => 'required',
            'harga' => 'required',
        ],$messages,$customAttributes);

        // //cek foto
        // $cover = $request->file('foto');
        // $extension = $cover->getClientOriginalExtension();
        // Storage::disk('public')->put($cover->getFilename().'.'.$extension,  File::get($cover));
    
        //Cek apakah validasi di atas benar
        if($valid == true){
            $total = $request->jumlah*$request->harga;
            $data_store = Order::create([
                'user_id' => $user_id,
                'store_id' => $request->get('store_id'),
                'pemilik_id' => $request->get('pemilik_id'),
                'order_number' =>  "RO".Carbon::now()->format('Y/m/d')."-".Carbon::now()->format('His'),
                'jenis_bordir' => $request->get('jenis_bordir'),
                'keterangan' => $request->get('keterangan'),
                'nama_pelanggan' => $request->get('nama_pelanggan'),
                'email' => $request->get('email'),
                'telepon' => $request->get('telepon'),
                'kabupaten' => $request->get('kabupaten'),
                'kecamatan' => $request->get('kecamatan'),
                'desa' => $request->get('desa'),
                'alamat' => $request->get('alamat'),
                'catatan' => $request->get('catatan'),
                'deadline' => Carbon::parse($request->get('deadline'))->format('y/m/d'),
                'jumlah' => $request->get('jumlah'),
                'harga' => $request->get('harga'),
                'total' => $total,
                'status_order' => "pending",
            ]);
            
            return redirect()->route('po.index')->with('success','Pesanan Berhasil Dibuat.');
        }
        else {
            return view('pelanggan.order.checkout')->withInput();
        }
    }

    public function getDataPelanggan()
    {
        $user_id = auth()->user()->id;
        $query = Order::with(['product','user_customer','store_product'])->select(['id', 'user_id','store_id','product_id','order_number','foto','jenis_bordir','keterangan','nama_pelanggan','email','telepon','kabupaten','kecamatan','desa','alamat','catatan','deadline','jumlah','harga','total','status_order','status_pengiriman','tipe_pembayaran','tipe_pengiriman','order_at','received_at', 'created_at'])->where('user_id', $user_id);

        return DataTables::of($query)
            ->addColumn('order', function($order){
                $output = $order->order_number;
                return $output;
            })
            ->addColumn('customer', function($order){
                return $order->nama_pelanggan;
            })
            ->addColumn('produk', function($order){
                return $order->product->nama.'<div>Jenis Bordir: '.$order->jenis_bordir.'</div>';
            })
            ->addColumn('status', function($order){
                return '<div class="small text-muted">Status Pesanan </div><div> <small><li class="fa fa-circle fa-xs" style="color:#f1c40f;"></li></small> '.ucwords($order->status_order).'</div>
                <div class="small text-muted">Status Pengiriman </div><div> <small><li class="fa fa-circle fa-xs"></li></small> ------</div>';
            })
            ->addColumn('total', function($order){
                return '<span>'.$order->jumlah.' Pcs</span><div><span>Rp. '.$order->total.'</span></div>';
            })
            // ->editColumn('action', function ($store) {
            //     return '<a href="' . route('toko.edit',$store->id) . '"><span class="fa fa-pencil" style="margin-right:5px;"> </span> </a> | <a type="javascript:;" data-toggle="modal" data-target="#konfirmasi_hapus" data-href="' . route('toko.delete',['id'=>$store->id]) . '" title="Delete"> <span class="fa fa-trash" style="margin-left:5px;"> </span></a>';
            // })
            ->rawColumns(['order', 'customer', 'produk', 'status', 'total'])
            ->addIndexColumn()
            ->make(true);
    }
}
