<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefPendidikanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_pendidikan', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->commonFields();
            // $table->timestamps(); created_at, updated_at, created_by, updated_by
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ref_pendidikan');
    }
}
