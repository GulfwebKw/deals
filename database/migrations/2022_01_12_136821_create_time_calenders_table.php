<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimeCalendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_calenders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('date_id')->unsigned();
            $table->foreign('date_id')->references('id')->on('date_calenders')->onDelete('cascade');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('buffer');
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
        Schema::dropIfExists('time_calenders');
    }
}
