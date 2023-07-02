<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefKomponen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_komponen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sub_unit_id');
            $table->text('name');
            $table->longText('description')->nullable();
            $table->commonFields();

            $table->foreign('sub_unit_id')->references('id')->on('ref_sub_unit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ref_komponen');
    }
}