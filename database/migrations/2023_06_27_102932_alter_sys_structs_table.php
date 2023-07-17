<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSysStructsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'sys_structs',
            function (Blueprint $table) {
                $table->string('website')->after('address')->nullable();
                $table->string('email')->after('phone')->nullable();
                $table->string('province')->after('phone')->nullable();
                $table->string('city')->after('phone')->nullable();

                // $table->foreign('province_id')->references('id')->on('ref_province');
                // $table->foreign('city_id')->references('id')->on('ref_city');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(
            'sys_structs',
            function (Blueprint $table) {
                $table->dropColumn('website');
                $table->dropColumn('email');
                $table->dropColumn('province'); // or province_id?
                $table->dropColumn('city'); // or city_id?
            }
        );
    }
}
