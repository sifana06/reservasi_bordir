<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('store_id')->nullable();
            $table->unsignedInteger('product_id')->nullable();
            $table->string('order_number')->unique();
            $table->string('foto',191)->nullable();
            $table->string('jenis_bordir', 15)->nullable();
            $table->text('keterangan')->nullable();
            
            $table->string('nama_pelanggan', 35);
            $table->string('email',50)->unique()->nullable();
            $table->string('telepon', 13);
            $table->integer('kabupaten');
            $table->integer('kecamatan');
            $table->integer('desa');
            $table->text('alamat');

            $table->text('catatan');
            $table->date('deadline');
            $table->string('jumlah',3);
            $table->string('harga',7)->nullable();
            $table->string('total', 8)->nullable();
            $table->string('status_order',15)->nullable();
            $table->string('status_pengiriman',15)->nullable();
            $table->string('tipe_pembayaran', 15)->nullable();
            $table->string('tipe_pengiriman', 15)->nullable();

            $table->timestamp('order_at')->nullable();
            $table->timestamp('received_at')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
