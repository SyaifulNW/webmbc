<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crms', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('leads')->unique();
            $table->string('kota');
            $table->string('nama_bisnis');
            $table->string('no_wa');
            $table->string('total_omset')->nullable();
            $table->string('kendala')->nullable();
            $table->string('fu1')->nullable();
            $table->string('fu2')->nullable();
            $table->string('fu3')->nullable();
            // status, cold, warm, hot
            $table->enum('status', ['cold', 'warm', 'hot'])->default('cold');
            // level, 1, 2, 3
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crms');
    }
}
