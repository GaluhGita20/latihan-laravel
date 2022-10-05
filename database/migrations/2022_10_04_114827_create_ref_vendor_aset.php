<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefVendorAset extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_vendor_aset', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('city_id');
            $table->string('code');
            $table->string('name');
            $table->string('alamat');
            $table->string('kodepos');
            $table->string('telepon');
            $table->string('email');
            $table->string('pic');
            $table->string('website');
            $table->commonFields();

            $table->foreign('city_id')
                     ->on('ref_city')
                    ->references('id');
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
        Schema::dropIfExists('ref_vendor_aset');
    }
}
