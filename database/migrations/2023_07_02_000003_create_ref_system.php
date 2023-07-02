<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefSystem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_system', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plant_id');
            $table->text('name');
            $table->longText('description')->nullable();
            $table->commonFields();

            $table->foreign('plant_id')->references('id')->on('ref_plant');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ref_system');
    }
}