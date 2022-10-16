<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransWorkReqTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trans_work_req', function (Blueprint $table) {
            $table->id();
            $table->string('no_request');
            $table->string('title');
            $table->text('description');
            $table->unsignedBigInteger('aset_id');
            $table->unsignedBigInteger('sub_location_id');
            $table->string('status');
            $table->timestamps();

            $table->foreign('aset_id')->references('id')->on('ref_aset');
            $table->foreign('sub_location_id')->references('id')->on('ref_sub_lokasi');
        });

        Schema::create('trans_work_req_cc', function (Blueprint $table) {
            $table->unsignedBigInteger('work_req_id');
            $table->unsignedBigInteger('user_id');

            $table->foreign('work_req_id')->references('id')->on('trans_work_req')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('sys_users');

            $table->primary(['work_req_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trans_work_req_cc');
        Schema::dropIfExists('trans_work_req');
    }
}
