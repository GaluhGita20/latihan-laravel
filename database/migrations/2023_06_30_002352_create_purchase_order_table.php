<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trans_purchase_order', function (Blueprint $table) {
            $table->id();
            $table->string('id_purchase_order');
            $table->date('tgl_purchase_order');
            $table->date('tgl_kirim');
            $table->unsignedBigInteger('vendor_id');
            $table->longText('catatan')->nullable();
            $table->string('status');
            $table->commonFields();

            $table->foreign('vendor_id')->references('id')->on('ref_vendor_aset');
        });

        Schema::create('trans_purchase_order_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_order_id');
            $table->unsignedBigInteger('barang_id');
            // $table->date('bulan')->comment('Bulan: month year');
            $table->text('jumlah');
            $table->text('harga_per_unit');
            $table->text('total_harga');
            $table->commonFields();
            
            $table->foreign('purchase_order_id')->references('id')->on('trans_purchase_order');
            $table->foreign('barang_id')->references('id')->on('ref_aset');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trans_purchase_order_detail');
        Schema::dropIfExists('trans_purchase_order');
    }
}
