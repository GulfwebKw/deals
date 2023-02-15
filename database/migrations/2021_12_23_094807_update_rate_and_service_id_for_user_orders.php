<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRateAndServiceIdForUserOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('service_user_orders')){
            Schema::create('service_user_orders', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('order_id')->unsigned();
                $table->foreign('order_id')->references('id')->on('user_orders')->onDelete('cascade');
                $table->unsignedBigInteger('service_id')->unsigned();
                $table->foreign('service_id')->references('id')->on('freelancer_services')->onDelete('cascade');
                $table->float('rate')->nullable()->default(null);
                $table->softDeletes();
                $table->timestamps();
            });
        }

        Schema::table('user_orders', function($table) {
            $table->dropForeign('user_orders_service_id_foreign');
            $table->dropColumn('service_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_user_orders');
        Schema::table('user_orders', function($table) {
            $table->unsignedBigInteger('service_id')->after('user_id');
            $table->foreign('service_id')->references('id')->on('freelancer_services')->onDelete('cascade');
        });
    }
}
