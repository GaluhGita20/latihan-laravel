<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRefItemPemeliharaanAddTipePemeliharaan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ref_item_pemeliharaan', function (Blueprint $table) {
            $table->unsignedBigInteger('tipe_pemeliharaan_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ref_item_pemeliharaan', function (Blueprint $table) {
            $table->dropColumn('tipe_pemeliharaan_id');
        });
    }
}
