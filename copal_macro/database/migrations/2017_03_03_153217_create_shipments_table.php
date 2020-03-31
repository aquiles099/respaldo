<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
        * Tabla para la secuencia
        */
        Schema::create('seq_shipment', function (Blueprint $table) {
          $table->bigInteger('id');
        });
        /**
        * estuctura de la tabla
        */
        Schema::create('shipment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->string('name')->nullable();
            $table->integer('operator')->unsigned()->nullable();
            $table->string('number_reservation')->nullable();
            $table->string('number_guide')->nullable();
            $table->float('declarate_value')->nullable();
            $table->string('realizate_city_place')->nullable();
            $table->string('realizate_city_date')->nullable();
            $table->string('realizate_city_hour')->nullable();
            $table->string('description')->nullable();
            $table->bigInteger('transport')->unsigned()->nullable();
            $table->string('departure_date_mar')->nullable();
            $table->string('departure_hour_mar')->nullable();
            $table->string('arrived_date_mar')->nullable();
            $table->string('arrived_hour_mar')->nullable();
            $table->bigInteger('transporter')->unsigned()->nullable();
            $table->bigInteger('shipper')->unsigned()->nullable();
            $table->string('for_aduana')->nullable();
            $table->bigInteger('entity_to_notify')->unsigned()->nullable();
            $table->bigInteger('cargo_agent')->unsigned()->nullable();
            $table->bigInteger('consigner')->unsigned()->nullable();
            $table->bigInteger('intermediary')->unsigned()->nullable();
            $table->bigInteger('destiny_agent')->unsigned()->nullable();
            $table->bigInteger('last_event')->unsigned();
            $table->string('start_at',100)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        /**
        * Funcion de validacion
        */
         DB::connection()->getPdo()->exec('
           drop function if exists seq_shipment_func;
           create function seq_shipment_func() returns bigint
             begin
               if(not(exists(select id from seq_shipment))) then
                 insert into seq_shipment values (0);
               end if;
               update seq_shipment set id = last_insert_id(id + 1);
               while exists(select null from shipment where id = last_insert_id()) do
                 update seq_shipment set id = last_insert_id(id + 1);
               end while;
               return last_insert_id();
             end
         ');
         /**
         * Creacion de trigger
         */
         DB::connection()->getPdo()->exec('
           drop trigger if exists seq_shipment_trigger;
             create trigger seq_shipment_trigger before insert on shipment
               for each row
                 begin
                   if new.id is null or new.id = -1 then
                     set new.id = seq_shipment_func();
                   end if;
                 end
         ');
         /**
         * Relacion con operador
         */
        Schema::table('shipment', function($table) {
          $table->foreign('operator')
          ->references('id')
          ->on('operator')
          ->onDelete('cascade')
          ->onUpdate('cascade');
        });
        /**
        * Relacion con transporte
        */
        Schema::table('shipment', function($table) {
          $table->foreign('transport')
           ->references('id')
           ->on('transport')
           ->onDelete('cascade')
           ->onUpdate('cascade');
        });
        /**
        * Relacion con transporte
        */
        Schema::table('shipment', function($table) {
          $table->foreign('transporter')
          ->references('id')
          ->on('transporters')
          ->onDelete('cascade')
          ->onUpdate('cascade');
        });
        /**
        *
        */
        Schema::table('shipment', function($table) {
          $table->foreign('shipper')
          ->references('id')
          ->on('user')
          ->onDelete('cascade')
          ->onUpdate('cascade');
        });
        /**
        *
        */
        Schema::table('shipment', function($table) {
          $table->foreign('entity_to_notify')
          ->references('id')
          ->on('user')
          ->onDelete('cascade')
          ->onUpdate('cascade');
        });
        /**
        *
        */
        Schema::table('shipment', function($table) {
          $table->foreign('cargo_agent')
          ->references('id')
          ->on('user')
          ->onDelete('cascade')
          ->onUpdate('cascade');
        });
        /**
        *
        */
        Schema::table('shipment', function($table) {
          $table->foreign('consigner')
          ->references('id')
          ->on('user')
          ->onDelete('cascade')
          ->onUpdate('cascade');
        });
        /**
        *
        */
        Schema::table('shipment', function($table) {
          $table->foreign('intermediary')
          ->references('id')
          ->on('user')
          ->onDelete('cascade')
          ->onUpdate('cascade');
        });
        /**
        *
        */
        Schema::table('shipment', function($table) {
          $table->foreign('destiny_agent')
          ->references('id')
          ->on('user')
          ->onDelete('cascade')
          ->onUpdate('cascade');
        });
        /**
        * con event
        */
        Schema::table('shipment', function($table) {
          $table->foreign('last_event')
          ->references('id')
          ->on('event')
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
      DB::connection()->getPdo()->exec('drop trigger if exists seq_shipment_trigger');
      DB::connection()->getPdo()->exec('drop function if exists seq_shipment_func');
      Schema::drop('shipment');
      Schema::drop('seq_shipment');
    }
}
