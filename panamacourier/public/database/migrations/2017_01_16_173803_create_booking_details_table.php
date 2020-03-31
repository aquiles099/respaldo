<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
      /**
      * Estructura de la tabla
      */
        Schema::create('booking_detail', function (Blueprint $table) {
          $table->increments('id');
          $table->bigInteger('booking')->unsigned()->nullable();
          $table->string('description')->nullable();
          $table->bigInteger('container')->unsigned()->nullable();
          $table->integer('pieces')->nullable();
          $table->float('large')->nullable();
          $table->float('width')->nullable();
          $table->float('height')->nullable();
          $table->float('maritime_volume')->nullable();
          $table->float('aerial_volume')->nullable();
          $table->float('weight')->nullable();
          $table->timestamps();
          $table->softDeletes();
        });
        /**
        * Relacion con booking
        */
        Schema::table('booking_detail', function($table) {
          $table->foreign('booking')
            ->references('id')
            ->on('booking')
            ->onDelete('restrict')
            ->onUpdate('cascade');
          /**
          * Relacion con container
          */    
          $table->foreign('container')
            ->references('id')
            ->on('container')
            ->onDelete('restrict')
            ->onUpdate('cascade');
        });
      }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('booking_detail');
    }
}
