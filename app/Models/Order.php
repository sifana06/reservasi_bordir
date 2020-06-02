<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'user_id','pemilik_id','store_id','product_id','order_number','foto','jenis_bordir','keterangan','nama_pelanggan','email','telepon','kabupaten','kecamatan','desa','alamat','catatan','deadline','jumlah','harga','total','status_order','status_pengiriman','tipe_pembayaran','tipe_pengiriman','order_at','received_at'
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function user_customer()
    {
        return $this->belongsTo('App\User');
    }

    public function store_product()
    {
        return $this->belongsTo('App\Models\Store');
    }
}
