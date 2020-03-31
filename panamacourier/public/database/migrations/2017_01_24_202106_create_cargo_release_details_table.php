<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCargoReleaseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cargo_release_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('cargo_release')->unsigned();
            $table->bigInteger('warehouse_receipt')->nullable()->unsigned();
            $table->bigInteger('pickup_order')->nullable()->unsigned();
            $table->float('weight')->nullable();
            $table->float('volume')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        /**
        * Relaciones
        */
        Schema::table('cargo_release_detail', function($table) {
         
          /**
           * Con CargoRelease
           */
          $table->foreign('cargo_release')
            ->references('id')
            ->on('cargo_release')
            ->onDelete('restrict')
            ->onUpdate('cascade');
          /**
         * Con Warehouse
         */
          $table->foreign('warehouse_receipt')
            ->references('id')
            ->on('package')
            ->onDelete('restrict')
            ->onUpdate('cascade');
          /**
          * Con PickupOrders
          */
           $table->foreign('pickup_order')
            ->references('id')
            ->on('pickup_orders')
            ->onDelete('restrict')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cargo_release_detail');
    }
}
