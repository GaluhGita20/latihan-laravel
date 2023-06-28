<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransJadwalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trans_jadwal', function (Blueprint $table) {
            $table->id();
            $table->year('year');
            $table->unsignedBigInteger('unit_kerja_id');
            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('sub_location_id');
            $table->unsignedBigInteger('aset_id');
            $table->longText('uraian');
            $table->string('status');
            $table->commonFields();

            $table->foreign('unit_kerja_id')->references('id')->on('sys_structs');
            $table->foreign('location_id')->references('id')->on('ref_location');
            $table->foreign('sub_location_id')->references('id')->on('ref_sub_lokasi');
            $table->foreign('aset_id')->references('id')->on('ref_aset');
        });

        Schema::create('trans_detail_jadwal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tipe_pemeliharaan_id');
            $table->unsignedBigInteger('item_pemeliharaan_id');
            $table->unsignedBigInteger('jadwal_id');
            $table->date('bulan');
            $table->commonFields();

            $table->foreign('tipe_pemeliharaan_id')->references('id')->on('ref_tipe_maintenance');
            $table->foreign('item_pemeliharaan_id')->references('id')->on('ref_item_pemeliharaan');
            $table->foreign('jadwal_id')->references('id')->on('trans_jadwal');
        });

        Schema::create('trans_jadwal_detail_pelaksana', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('detail_jadwal_id');
            $table->unsignedBigInteger('pelaksana_id');
            $table->commonFields();

            $table->foreign('pelaksana_id')->references('id')->on('sys_users');
            $table->foreign('detail_jadwal_id')->references('id')->on('trans_detail_jadwal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trans_jadwal_detail_pelaksana');
        Schema::dropIfExists('trans_detail_jadwal');
        Schema::dropIfExists('trans_jadwal');
    }
}
