<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_activities', function (Blueprint $table) {
            $table->id();
            $table->string('aktivitas');
            $table->text('deskripsi')->nullable();
            $table->integer('target_daily')->default(0);
            $table->integer('target')->default(0);
            $table->float('bobot')->default(0);
            $table->integer('real')->default(0);
            $table->float('nilai')->default(0);


            // Kolom tanggal 1 sampai 31
            for ($i = 1; $i <= 31; $i++) {
                $table->integer('tanggal_' . $i)->nullable();
            }
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
        Schema::dropIfExists('daily_activities');
    }
}
