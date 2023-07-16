<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RecreateRefAsets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'trans_purchase_order_detail',
            function (Blueprint $table) {
                $table->dropForeign(['barang_id']);
            }
        );

        Schema::create(
            'ref_asets',
            function (Blueprint $table) {
                $table->id();
                $table->string('id_aset');
                $table->string('name');
                $table->string('struktur_aset');
                $table->text('harga_per_unit');
                $table->commonFields();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ref_asets');
    }
}
