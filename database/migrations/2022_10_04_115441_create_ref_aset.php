<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefAset extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_aset', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kondisi_aset_id');
            $table->unsignedBigInteger('status_aset_id');
            $table->string('code');
            $table->string('name');
            $table->commonFields();

            $table->foreign('kondisi_aset_id')
                    ->on('ref_kondisi_aset')
                    ->references('id');
            
            $table->foreign('status_aset_id')
                    ->on('ref_status_aset')
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
        Schema::dropIfExists('ref_aset');
    }
}
