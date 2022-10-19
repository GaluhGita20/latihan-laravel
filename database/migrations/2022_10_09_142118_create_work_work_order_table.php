<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkWorkOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_work_order', function (Blueprint $table) {
            $table->id();
            $table->string('work_order_id')->unique();
            $table->unsignedBigInteger('maintenance_type_id')->nullable();
            $table->unsignedBigInteger('priority_id')->nullable();
            $table->unsignedBigInteger('asset_id')->nullable();
            $table->date('done_target_date')->nullable();
            $table->longText('user_id')->nullable();
            $table->text('description')->nullable();
            $table->bigInteger('estimation_cost')->nullable();
            $table->string('request_by')->nullable();
            $table->string('attachment')->nullable();
            $table->longText('instruction')->nullable();
            $table->longText('other_costs')->nullable();
            $table->integer('status')->nullable();
            $table->commonFields();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_work_order');
    }
}
