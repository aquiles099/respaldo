<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypePickupTable extends Migration
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
      Schema::create('seq_typepickup', function (Blueprint $table)
      {
        $table->bigInteger('id');
      });
      /**
      * Estructura de la tabla
      */
      Schema::create('typepickup', function (Blueprint $table)
      {
        $table->bigIncrements('id');
        $table->string('code');
        $table->string('name');
        $table->string('description');
        $table->timestamps();
        $table->softDeletes();
      });
      /**
      * Funcion de Validacion
      */
      DB::connection()->getPdo()->exec('
        drop function if exists seq_typepickup_func;
        create function seq_typepickup_func() returns bigint
          begin
            if(not(exists(select id from seq_typepickup))) then
              insert into seq_typepickup values (0);
            end if;
            update seq_container set id = last_insert_id(id + 1);
            while exists(select null from typepickup where id = last_insert_id()) do
              update seq_typepickup set id = last_insert_id(id + 1);
            end while;
            return last_insert_id();
          end
      ');
      /**
      * Creacion del trigger
      */
      DB::connection()->getPdo()->exec('
        drop trigger if exists seq_typepickup_trigger;
          create trigger seq_typepickup_trigger before insert on typepickup
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
      DB::connection()->getPdo()->exec('drop trigger if exists seq_typepickup_trigger');
      DB::connection()->getPdo()->exec('drop function if exists seq_typepickup_func');
      Schema::drop('typepickup');
      Schema::drop('seq_typepickup');
    }
}
