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
            $table->id();
            $table->string('nomor_invoice');
            $table->integer('total');
            $table->enum('status', ['BARU', 'PEMBAYARAN', 'SELESAI', 'BATAL']);
            $table->enum('status_pembayaran', ['PENDING', 'SUCCESS', 'FAILED']);
            $table->dateTime('tanggal_pembayaran');
            $table->string('nama_pemesan');
            $table->string('email_pemesan');
            $table->string('nomor_pemesan');
            $table->string('nama_terhibah')->nullable();
            $table->string('nomor_hp_terhibah')->nullable();
            $table->string('url_payment')->nullable();
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
