<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShipmentRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipment_route', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('shipment')->unsigned();
            $table->integer('service_type')->nullable();
            $table->bigInteger('transport_type')->unsigned()->nullable();
            $table->bigInteger('route')->unsigned()->nullable();
            $table->string('fly_number')->nullable();
            $table->string('vehicle_number')->nullable();
            $table->string('pro_number')->nullable();
            $table->string('tracking_number')->nullable();
            $table->string('driver_name')->nullable();
            $table->string('licence_number')->nullable();
            $table->bigInteger('from_city_departure')->unsigned()->nullable();
            $table->string('date_city_departure')->nullable();
            $table->string('hour_city_departure')->nullable();
            $table->bigInteger('from_city_arrived')->unsigned()->nullable();
            $table->string('date_city_arrived')->nullable();
            $table->string('hour_city_arrived')->nullable();
            $table->string('origin_point')->nullable();       
            $table->bigInteger('pre_transporter')->unsigned()->nullable();
            $table->bigInteger('origin_pre_transporter')->unsigned()->nullable();
            $table->string('dock_terminal')->nullable();
            $table->bigInteger('port')->unsigned()->nullable();
            $table->bigInteger('export_transporter')->unsigned()->nullable();
            $table->string('travel_identifier')->nullable();
            $table->bigInteger('vessel')->unsigned()->nullable();
            $table->string('vessel_flag')->nullable();
            $table->bigInteger('download_port')->unsigned()->nullable();
            $table->bigInteger('deliver_transporter')->unsigned()->nullable();
            $table->bigInteger('deliver_city_place')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
         /**
         * Relacion con shipment
         */
        Schema::table('shipment_route', function($table) {
          $table->foreign('shipment')
          ->references('id')
          ->on('shipment')
          ->onDelete('cascade')
          ->onUpdate('cascade');
        });
        /**
         * Relacion con tipo de transporte
         */
        Schema::table('shipment_route', function($table) {
          $table->foreign('transport_type')
          ->references('id')
          ->on('transport_type')
          ->onDelete('cascade')
          ->onUpdate('cascade');
        });
        /**
         *
         */
        Schema::table('shipment_route', function($table) {
          $table->foreign('route')
          ->references('id')
          ->on('route')
          ->onDelete('cascade')
          ->onUpdate('cascade');
        });
        /**
         *
         */
        Schema::table('shipment_route', function($table) {
          $table->foreign('from_city_departure')
          ->references('id')
          ->on('city')
          ->onDelete('cascade')
          ->onUpdate('cascade');
        });
        /**
         *
         */
        Schema::table('shipment_route', function($table) {
          $table->foreign('from_city_arrived')
          ->references('id')
          ->on('city')
          ->onDelete('cascade')
          ->onUpdate('cascade');
        });
        /**
         *
         */
        Schema::table('shipment_route', function($table) {
          $table->foreign('pre_transporter')
          ->references('id')
          ->on('transporters')
          ->onDelete('cascade')
          ->onUpdate('cascade');
        });
        /**
         *
         */
        Schema::table('shipment_route', function($table) {
          $table->foreign('origin_pre_transporter')
          ->references('id')
          ->on('transporters')
          ->onDelete('cascade')
          ->onUpdate('cascade');
        });
        /**
         *
         */
        Schema::table('shipment_route', function($table) {
          $table->foreign('port')
          ->references('id')
          ->on('detailstransport')
          ->onDelete('cascade')
          ->onUpdate('cascade');
        });
        /**
         *
         */
        Schema::table('shipment_route', function($table) {
          $table->foreign('export_transporter')
          ->references('id')
          ->on('transporters')
          ->onDelete('cascade')
          ->onUpdate('cascade');
        });
        /**
         *
         */
        Schema::table('shipment_route', function($table) {
          $table->foreign('vessel')
          ->references('id')
          ->on('vessel')
          ->onDelete('cascade')
          ->onUpdate('cascade');
        });
        /**
         *
         */
        Schema::table('shipment_route', function($table) {
          $table->foreign('download_port')
          ->references('id')
          ->on('detailstransport')
          ->onDelete('cascade')
          ->onUpdate('cascade');
        });
        /**
         *
         */
        Schema::table('shipment_route', function($table) {
          $table->foreign('deliver_transporter')
          ->references('id')
          ->on('transporters')
          ->onDelete('cascade')
          ->onUpdate('cascade');
        });
        /**
         *
         */
        Schema::table('shipment_route', function($table) {
          $table->foreign('deliver_city_place')
          ->references('id')
          ->on('city')
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
        Schema::drop('shipment_route');
    }
}
