<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRefInstruksiKerja extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'ref_instruksi_kerja',
            function (Blueprint $table) {
                $table->dropColumn(['struct_id']);
                $table->string('code')->nullable();
                $table->unsignedBigInteger('aset_id')->nullable();
                $table->unsignedBigInteger('part_id')->nullable();
                $table->unsignedBigInteger('assemblies_id')->nullable();
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
            'ref_instruksi_kerja',
            function (Blueprint $table) {
                $table->unsignedBigInteger('struct_id');
                $table->dropColumn(['code']);
                $table->dropColumn(['aset_id']);
                $table->dropColumn(['part_id']);
                $table->dropColumn(['assemblies_id']);
            }
        );
    }
}
