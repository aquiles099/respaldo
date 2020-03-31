<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContainersTable extends Migration
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
      Schema::create('seq_container', function (Blueprint $table)
      {
        $table->bigInteger('id');
      });
      /**
      * Estructura de la tabla
      */
      Schema::create('container', function (Blueprint $table)
      {
        $table->bigIncrements('id');
        $table->string('code');
        $table->string('name');
        $table->string('large');
        $table->string('width');
        $table->integer('unidad');
        $table->string('height');
        $table->timestamps();
        $table->softDeletes();
      });
      /**
      * Funcion de Validacion
      */
      DB::connection()->getPdo()->exec('
        drop function if exists seq_container_func;
        create function seq_container_func() returns bigint
          begin
            if(not(exists(select id from seq_container))) then
              insert into seq_container values (0);
            end if;
            update seq_container set id = last_insert_id(id + 1);
            while exists(select null from container where id = last_insert_id()) do
              update seq_container set id = last_insert_id(id + 1);
            end while;
            return last_insert_id();
          end
      ');
      /**
      * Creacion del trigger
      */
      DB::connection()->getPdo()->exec('
        drop trigger if exists seq_container_trigger;
          create trigger seq_container_trigger before insert on container
            for each row
              begin
                if new.id is null or new.id = -1 then
                  set new.id = seq_container_func();
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
      DB::connection()->getPdo()->exec('drop trigger if exists seq_container_trigger');
      DB::connection()->getPdo()->exec('drop function if exists seq_container_func');
      Schema::drop('container');
      Schema::drop('seq_container');
    }
}
