<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      /**
      * Tabla para la sequencia
      */
      Schema::create('seq_booking', function (Blueprint $table)
      {
        $table->bigInteger('id');
      });
        /**
        * Estructura de la tabla
        */
        Schema::create('booking', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('code');
          $table->bigInteger('transport')->unsigned()->nullable();
          $table->string('course')->nullable();
          $table->bigInteger('from_country')->unsigned()->nullable();
          $table->bigInteger('to_country')->unsigned()->nullable();
          $table->string('since_departure_date')->nullable();
          $table->string('until_departure_date')->nullable();
          $table->string('since_arrived_date')->nullable();
          $table->string('until_arrived_date')->nullable();
          $table->string('declarate_goods')->nullable();
          $table->bigInteger('shipper')->unsigned()->nullable();
          $table->bigInteger('consigneer')->unsigned()->nullable();
          $table->bigInteger('agent')->unsigned()->nullable();
          $table->bigInteger('transporter')->unsigned()->nullable();
          $table->string('vessel',100)->nullable();
          $table->bigInteger('employee')->unsigned()->nullable();
          $table->boolean('dangerous')->nullable();
          $table->string('way',100)->nullable();
          $table->string('guide',100)->nullable();
          $table->string('aditional_information')->nullable();
          $table->bigInteger('last_event')->unsigned()->nullable();
          $table->string('start_at',100)->nullable();
          $table->timestamps();
          $table->softDeletes();
        });
        /**
        * Funcion de Validacion
        */
        DB::connection()->getPdo()->exec('
          drop function if exists seq_booking_func;
          create function seq_booking_func() returns bigint
            begin
              if(not(exists(select id from seq_booking))) then
                insert into seq_booking values (0);
              end if;
              update seq_booking set id = last_insert_id(id + 1);
              while exists(select null from booking where id = last_insert_id()) do
                update seq_booking set id = last_insert_id(id + 1);
              end while;
              return last_insert_id();
            end
        ');
        /**
        * Creacion del trigger
        */
        DB::connection()->getPdo()->exec('
          drop trigger if exists seq_booking_trigger;
            create trigger seq_booking_trigger before insert on booking
              for each row
                begin
                  if new.id is null or new.id = -1 then
                    set new.id = seq_booking_func();
                  end if;
                end
        ');
        /**
        * Relaciones
        */
        Schema::table('booking', function($table)
         {
           /**
           * Con transport
           */
            $table->foreign('transport')
                ->references('id')
                ->on('transport')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            /**
            * con country
            */
            $table->foreign('from_country')
                ->references('id')
                ->on('country')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            /**
            * con country
            */
            $table->foreign('to_country')
                ->references('id')
                ->on('country')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            /**
            * con user
            */
            $table->foreign('shipper')
                ->references('id')
                ->on('user')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            /**
            * con user
            */
            $table->foreign('consigneer')
                ->references('id')
                ->on('user')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            /**
            * con event
            */
            $table->foreign('last_event')
            ->references('id')
            ->on('event')
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
      DB::connection()->getPdo()->exec('drop trigger if exists seq_booking_trigger');
      DB::connection()->getPdo()->exec('drop function if exists seq_booking_func');
      Schema::drop('booking');
      Schema::drop('seq_booking');
    }
}
