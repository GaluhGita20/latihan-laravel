<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefSubLokasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_sub_lokasi', function (Blueprint $table) {
            $table->id();
            $table->string('name', 32);
            $table->unsignedBigInteger('struct_id')->nullable();
            $table->unsignedBigInteger('location_id');
            $table->commonFields();

            $table->foreign('location_id')
                ->on('ref_location')
                ->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ref_sub_lokasi');
    }
}
