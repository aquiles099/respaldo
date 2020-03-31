<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShipmentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipment_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('shipment')->unsigned();
            $table->bigInteger('pickup')->unsigned()->nullable();
            $table->bigInteger('warehouse')->unsigned()->nullable();
            $table->float('volume')->nullable();
            $table->float('weight')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        /**
        * relacion con shipment
        */
       Schema::table('shipment_detail', function($table) {
         $table->foreign('shipment')
           ->references('id')
           ->on('shipment')
           ->onDelete('cascade')
           ->onUpdate('cascade');
       });
       /**
       * relacion con pickup
       */
      Schema::table('shipment_detail', function($table) {
        $table->foreign('pickup')
          ->references('id')
          ->on('pickup_orders')
          ->onDelete('cascade')
          ->onUpdate('cascade');
      });
      /**
      * relacion con warehouse
      */
      Schema::table('shipment_detail', function($table) {
       $table->foreign('warehouse')
         ->references('id')
         ->on('package')
         ->onDelete('cascade')
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
        Schema::drop('shipment_detail');
    }
}
