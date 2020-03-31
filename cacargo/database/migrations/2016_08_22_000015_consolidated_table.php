<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 *
 */
class ConsolidatedTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
      //Tabla para la secuencia
      Schema::create('seq_consolidated', function (Blueprint $table) {
        $table->bigInteger('id');
      });
      //Tabla de eventos
      Schema::create('consolidated', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('code');
        $table->string('description');
        $table->string('observation');
        $table->boolean('status');
        $table->integer('last_event');
        $table->timestamps();
        $table->softDeletes();
      });
      //Funcion de validacion
      DB::connection()->getPdo()->exec('
        drop function if exists seq_consolidated_func;
        create function seq_consolidated_func() returns bigint
          begin
            if(not(exists(select id from seq_consolidated))) then
              insert into seq_consolidated values (0);
            end if;
            update seq_consolidated set id = last_insert_id(id + 1);
            while exists(select null from consolidated where id = last_insert_id()) do
              update seq_consolidated set id = last_insert_id(id + 1);
            end while;
            return last_insert_id();
          end
      ');
      //Creacion del trigger
      DB::connection()->getPdo()->exec('
        drop trigger if exists seq_consolidated_trigger;
          create trigger seq_consolidated_trigger before insert on consolidated
            for each row
              begin
                if new.id is null or new.id = -1 then
                  set new.id = seq_consolidated_func();
                end if;
              end
      ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
      DB::connection()->getPdo()->exec('drop trigger if exists seq_consolidated_trigger');
      DB::connection()->getPdo()->exec('drop function if exists seq_consolidated_func');
      Schema::drop('consolidated');
      Schema::drop('seq_consolidated');
    }
}
