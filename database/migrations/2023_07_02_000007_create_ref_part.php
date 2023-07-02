<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefPart extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_part', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('komponen_id');
            $table->text('name');
            $table->longText('description')->nullable();
            $table->commonFields();

            $table->foreign('komponen_id')->references('id')->on('ref_komponen');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ref_part');
    }
}