<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefEquipment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_equipment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('system_id');
            $table->text('name');
            $table->longText('description')->nullable();
            $table->commonFields();

            $table->foreign('system_id')->references('id')->on('ref_system');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ref_equipment');
    }
}