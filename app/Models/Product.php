<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'nama','jenis_bordir','deskripsi','store_id','pemilik_id'
    ];
}
