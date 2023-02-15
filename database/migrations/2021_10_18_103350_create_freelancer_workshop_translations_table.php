<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFreelancerWorkshopTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('freelancer_workshop_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('workshop_id')->unsigned();
            $table->foreign('workshop_id')->references('id')->on('freelancer_workshops')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('name');
            $table->text('description');
            $table->unique(['workshop_id','locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('freelancer_workshop_translations');
    }
}
