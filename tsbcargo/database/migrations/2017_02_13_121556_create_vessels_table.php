<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVesselsTable extends Migration
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
      Schema::create('seq_vessel', function (Blueprint $table) {
        $table->bigInteger('id');
      });
      /**
      *
      */
        Schema::create('vessel', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->string('name');
            $table->string('flag')->nullable();
            $table->bigInteger('country')->unsigned()->nulable();
            $table->bigInteger('city')->unsigned()->nulable();
            $table->timestamps();
            $table->softDeletes();
        });
        /**
        * Relacion con pais
        */
        Schema::table('vessel', function($table) {
         $table->foreign('country')
         ->references('id')
         ->on('country')
         ->onDelete('cascade')
         ->onUpdate('cascade');
       });
       /**
       * Relacion con ciudad
       */
       Schema::table('vessel', function($table) {
        $table->foreign('city')
        ->references('id')
        ->on('city')
        ->onDelete('cascade')
        ->onUpdate('cascade');
      });
        /**
        * Funcion de validacion
        */
         DB::connection()->getPdo()->exec('
           drop function if exists seq_vessel_func;
           create function seq_vessel_func() returns bigint
             begin
               if(not(exists(select id from seq_vessel))) then
                 insert into seq_vessel values (0);
               end if;
               update seq_vessel set id = last_insert_id(id + 1);
               while exists(select null from vessel where id = last_insert_id()) do
                 update seq_vessel set id = last_insert_id(id + 1);
               end while;
               return last_insert_id();
             end
         ');
         /**
         * Creacion de trigger
         */
         DB::connection()->getPdo()->exec('
           drop trigger if exists seq_vessel_trigger;
             create trigger seq_vessel_trigger before insert on vessel
               for each row
                 begin
                   if new.id is null or new.id = -1 then
                     set new.id = seq_vessel_func();
                   end if;
                 end
         ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::connection()->getPdo()->exec('drop trigger if exists seq_vessel_trigger');
        DB::connection()->getPdo()->exec('drop function if exists seq_vessel_func');
        Schema::drop('vessel');
        Schema::drop('seq_vessel');
    }
}
