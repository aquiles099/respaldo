<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWarehouseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      //Tabla de accesos
      Schema::create('warehouses', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('warehouse')->unsigned()->nullable();
        $table->bigInteger('pickup')->unsigned()->nullable();
        $table->timestamps();
        $table->softDeletes();
      });
      /**
       * relacion con pickup
       */
      Schema::table('warehouses', function($table) {
        $table->foreign('pickup')
          ->references('id')
          ->on('pickup_orders')
          ->onDelete('cascade')
          ->onUpdate('cascade');
      });
      /**
      * relacion con warehouse
      */
      Schema::table('warehouses', function($table) {
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
        Schema::drop('warehouses');
    }
}
