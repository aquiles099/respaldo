<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoutesTable extends Migration
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
        Schema::create('seq_route', function (Blueprint $table) {
          $table->bigInteger('id');
        });
        /**
        * Estructura de la tabla
        */
        Schema::create('route', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->string('name');
            $table->bigInteger('transport')->unsigned();
            $table->bigInteger('origin_country')->unsigned();
            $table->bigInteger('origin_city')->unsigned();
            $table->bigInteger('destiny_country')->unsigned();
            $table->bigInteger('destiny_city')->unsigned();
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();
        });
        /**
        * Relacion con transporte
        */
        Schema::table('route', function($table) {
         $table->foreign('transport')
           ->references('id')
           ->on('transport')
           ->onDelete('cascade')
           ->onUpdate('cascade');
       });
       /**
       * Relacion con pais
       */
       Schema::table('route', function($table) {
        $table->foreign('origin_country')
          ->references('id')
          ->on('country')
          ->onDelete('cascade')
          ->onUpdate('cascade');
      });
      /**
      * Relacion con pais
      */
      Schema::table('route', function($table) {
       $table->foreign('destiny_country')
         ->references('id')
         ->on('country')
         ->onDelete('cascade')
         ->onUpdate('cascade');
     });
     /**
     * Relacion con pais
     */
     Schema::table('route', function($table) {
      $table->foreign('origin_city')
        ->references('id')
        ->on('city')
        ->onDelete('cascade')
        ->onUpdate('cascade');
    });
    /**
    * Relacion con pais
    */
    Schema::table('route', function($table) {
     $table->foreign('destiny_city')
       ->references('id')
       ->on('city')
       ->onDelete('cascade')
       ->onUpdate('cascade');
   });
      /**
      * Funcion de validacion
      */
       DB::connection()->getPdo()->exec('
         drop function if exists seq_route_func;
         create function seq_route_func() returns bigint
           begin
             if(not(exists(select id from seq_route))) then
               insert into seq_route values (0);
             end if;
             update seq_route set id = last_insert_id(id + 1);
             while exists(select null from route where id = last_insert_id()) do
               update seq_route set id = last_insert_id(id + 1);
             end while;
             return last_insert_id();
           end
       ');
       /**
       * Creacion de trigger
       */
       DB::connection()->getPdo()->exec('
         drop trigger if exists seq_route_trigger;
           create trigger seq_route_trigger before insert on route
             for each row
               begin
                 if new.id is null or new.id = -1 then
                   set new.id = seq_route_func();
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
        DB::connection()->getPdo()->exec('drop trigger if exists seq_route_trigger');
        DB::connection()->getPdo()->exec('drop function if exists seq_route_func');
        Schema::drop('route');
        Schema::drop('seq_route');
    }
}
