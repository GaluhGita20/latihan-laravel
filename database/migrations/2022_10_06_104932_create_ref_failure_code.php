<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefFailureCode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_failure_code', function (Blueprint $table) {
            $table->id();
                $table->unsignedBigInteger('aset_id');
                $table->string('name');
                $table->string('desc');
                $table->commonFields();

                $table->foreign('aset_id')
                    ->on('ref_aset')
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
        Schema::dropIfExists('ref_failure_code');
    }
}
