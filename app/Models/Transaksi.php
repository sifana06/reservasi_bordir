<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = "transactions";
    protected $fillable = [
        "order_id",
        "pemilik_id",
        "pelanggan_id",
        "product_id",
        "rekening_id",
        "toko_id",
        "bukti_pembayaran",
        "tanggal_transaksi",
    ];
}
