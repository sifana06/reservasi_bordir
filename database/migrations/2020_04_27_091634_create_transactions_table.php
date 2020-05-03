<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('pemilik_id')->nullable();
            $table->integer('pelanggan_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->integer('rekening_id')->nullable();
            $table->integer('toko_id')->nullable();
            $table->string('kode_transaksi', 15);
            $table->date('tanggal_transaksi');
            $table->string('status',15);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
