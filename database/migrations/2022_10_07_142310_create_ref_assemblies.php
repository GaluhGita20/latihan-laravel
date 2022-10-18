<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefAssemblies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'ref_assemblies',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('status_aset_id');
                $table->unsignedBigInteger('kondisi_aset_id');
                $table->unsignedBigInteger('tipe_aset_id');
                $table->unsignedBigInteger('location_id');
                $table->unsignedBigInteger('sub_lokasi_id');
                $table->unsignedBigInteger('aset_id');
                $table->string('code');
                $table->string('name');
                $table->commonFields();

                $table->foreign('status_aset_id')
                    ->on('ref_status_aset')
                    ->references('id');

                $table->foreign('kondisi_aset_id')
                    ->on('ref_kondisi_aset')
                    ->references('id');

                $table->foreign('tipe_aset_id')
                    ->on('ref_asset_type')
                    ->references('id');

                $table->foreign('location_id')
                    ->on('ref_location')
                    ->references('id');

                $table->foreign('sub_lokasi_id')
                    ->on('ref_sub_lokasi')
                    ->references('id');

                $table->foreign('aset_id')
                    ->on('ref_aset')
                    ->references('id');
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
        Schema::dropIfExists('ref_assemblies');
    }
}
