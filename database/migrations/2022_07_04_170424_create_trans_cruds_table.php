<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransCrudsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trans_cruds', function (Blueprint $table) {
            $table->id();
            $table->year('year');
            $table->date('date');
            $table->date('range_start');
            $table->date('range_end');
            $table->string('input');
            $table->text('textarea');
            $table->tinyInteger('option')->default(1)->comment('1:Option A, 2:Option B');

            $table->string('status')->default('new');
            $table->commonFields();
        });

        Schema::create('trans_cruds_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('crud_id');
            $table->unsignedBigInteger('example_id');
            $table->unsignedBigInteger('user_id');
            $table->text('description');
            $table->commonFields();

            $table->foreign('crud_id')->references('id')->on('trans_cruds')->onDelete('cascade');
            $table->foreign('example_id')->references('id')->on('ref_examples'); //Berbeda modul jangan cascade
            $table->foreign('user_id')->references('id')->on('sys_users'); //Berbeda modul jangan cascade
        });

        Schema::create('trans_cruds_cc', function (Blueprint $table) {
            $table->unsignedBigInteger('crud_id');
            $table->unsignedBigInteger('user_id');

            $table->foreign('crud_id')->references('id')->on('trans_cruds')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('sys_users'); //Berbeda modul jangan cascade

            $table->primary(['crud_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trans_cruds_cc');
        Schema::dropIfExists('trans_cruds_details');
        Schema::dropIfExists('trans_cruds');
    }
}
