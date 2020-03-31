<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ServicesTable extends Migration
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
      Schema::create('seq_service', function (Blueprint $table) {
        $table->bigInteger('id');
      });
      /**
      *
      */
      Schema::create('service', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('code');
          $table->string('name', 100);
          $table->bigInteger('transport')->unsigned();
          $table->string('description', 200)->unique();
          $table->float('value');
          $table->timestamps();
          $table->softDeletes();
        });

      Schema::table('service', function($table) {
         $table->foreign('transport')
           ->references('id')
           ->on('transport')
           ->onDelete('cascade')
           ->onUpdate('cascade');
       });
        /**
        * Funcion de validacion
        */
         DB::connection()->getPdo()->exec('
           drop function if exists seq_service_func;
           create function seq_service_func() returns bigint
             begin
               if(not(exists(select id from seq_service))) then
                 insert into seq_service values (0);
               end if;
               update seq_service set id = last_insert_id(id + 1);
               while exists(select null from service where id = last_insert_id()) do
                 update seq_service set id = last_insert_id(id + 1);
               end while;
               return last_insert_id();
             end
         ');
         /**
         * Creacion de trigger
         */
         DB::connection()->getPdo()->exec('
           drop trigger if exists seq_service_trigger;
             create trigger seq_service_trigger before insert on service
               for each row
                 begin
                   if new.id is null or new.id = -1 then
                     set new.id = seq_service_func();
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
      DB::connection()->getPdo()->exec('drop trigger if exists seq_service_trigger');
      DB::connection()->getPdo()->exec('drop function if exists seq_service_func');
      Schema::drop('service');
      Schema::drop('seq_service');
    }
}
