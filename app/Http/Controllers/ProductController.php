<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use DataTables;

class ProductController extends Controller
{
    public function index()
    {
        return view('dashboard.produk.all');
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
        
    }

    public function getData()
    {
        $pemilik_id = auth()->user()->id;
        $query = Product::select(['id', 'store_id', 'pemilik_id', 'nama', 'jenis_bordir', 'deskripsi', 'created_at'])->where('pemilik_id', $pemilik_id);

        return DataTables::of($query)
            ->addColumn('nama', function($product){
                return ucwords($product->nama);
            })
            ->addColumn('jenis', function($product){
                return $product->jenis_bordir;
            })
            ->addColumn('deskripsi', function($product){
                return $product->deskripsi;
            })
            ->editColumn('action', function ($product) {
                return '
                <a href="' . route('product.edit',$product->id) . '" title="Edit"><span class="fa fa-pencil" style="margin-right:5px;"> </span> </a> | 
                <a type="javascript:;" data-toggle="modal" data-target="#konfirmasi_hapus" data-href="' . route('product.delete',['id'=>$product->id]) . '" title="Delete"> <span class="fa fa-trash" style="margin-left:5px;"> </span></a>';
            })
            ->rawColumns(['nama', 'jenis', 'deskripsi', 'action'])
            ->addIndexColumn()
            ->make(true);
    }
}
