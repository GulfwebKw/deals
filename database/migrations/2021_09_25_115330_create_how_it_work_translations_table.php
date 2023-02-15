<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHowItWorkTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('how_it_work_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('how_it_work_id')->unsigned();
            $table->string('locale')->index();
            $table->string('title');
            $table->string('sub_title');
            $table->string('description');
            $table->unique(['how_it_work_id','locale']);
            $table->foreign('how_it_work_id')->references('id')->on('how_it_works')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('how_it_work_translations');
    }
}
