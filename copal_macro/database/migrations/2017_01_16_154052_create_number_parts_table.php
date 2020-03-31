<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNumberPartsTable extends Migration
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
      Schema::create('seq_numberparts', function (Blueprint $table)
      {
        $table->bigInteger('id');
      });
      /**
      * Estructura de la tabla
      */
      Schema::create('numberparts', function (Blueprint $table)
      {
        $table->bigIncrements('id');
        $table->string('code');
        $table->string('name');
        $table->string('description');
        $table->string('model');
        $table->string('customer');
        $table->string('manufacturer');
        $table->string('package');
        $table->string('note');
        $table->float('large');
        $table->float('width');
        $table->float('height');
        $table->float('weight');
        $table->float('volumetricweightm');
        $table->float('volumetricweighta');
        $table->bigInteger('pieces')->unsigned()->nullable();
        $table->string('sku');
        $table->timestamps();
        $table->softDeletes();
      });
      /**
      * Funcion de Validacion
      */
      DB::connection()->getPdo()->exec('
        drop function if exists seq_numberparts_func;
        create function seq_numberparts_func() returns bigint
          begin
            if(not(exists(select id from seq_numberparts))) then
              insert into seq_numberparts values (0);
            end if;
            update seq_numberparts set id = last_insert_id(id + 1);
            while exists(select null from numberparts where id = last_insert_id()) do
              update seq_numberparts set id = last_insert_id(id + 1);
            end while;
            return last_insert_id();
          end
      ');
      /**
      * Creacion del trigger
      */
      DB::connection()->getPdo()->exec('
        drop trigger if exists seq_typepickup_trigger;
          create trigger seq_numberparts_trigger before insert on numberparts
            for each row
              begin
                if new.id is null or new.id = -1 then
                  set new.id = seq_numberparts_func();
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
      DB::connection()->getPdo()->exec('drop trigger if exists seq_numberparts_trigger');
      DB::connection()->getPdo()->exec('drop function if exists seq_numberparts_func');
      Schema::drop('numberparts');
      Schema::drop('seq_numberparts');
    }
}
