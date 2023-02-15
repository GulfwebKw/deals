<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimePiecesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_pieces', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('date_id')->unsigned();
            $table->foreign('date_id')->references('id')->on('date_calenders')->onDelete('cascade');
            $table->unsignedBigInteger('time_id')->unsigned();
            $table->foreign('time_id')->references('id')->on('time_calenders')->onDelete('cascade');
            $table->time('start');
            $table->time('end');
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
        Schema::dropIfExists('time_pieces');
    }
}
