<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysStructsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_structs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('level')->comment('root, bod, division, branch, dll');
            $table->string('type')->nullable()->comment('presdir, direktur, ia, it');
            $table->string('name');
            $table->unsignedInteger('code');
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->commonFields();

            $table->foreign('parent_id')->references('id')->on('sys_structs');
        });

        Schema::create('sys_positions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('location_id')->nullable();
            $table->string('name');
            $table->unsignedInteger('code');
            $table->commonFields();

            $table->foreign('location_id')->references('id')->on('sys_structs');
        });

        Schema::table('sys_users', function (Blueprint $table) {
            $table->unsignedBigInteger('position_id')->nullable()->after('password');
            $table->foreign('position_id')->references('id')->on('sys_positions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sys_users', function (Blueprint $table) {
            $table->dropForeign(['position_id']);
            $table->dropColumn(['position_id']);
        });
        
        Schema::dropIfExists('sys_positions');
        Schema::dropIfExists('sys_structs');
    }
}
