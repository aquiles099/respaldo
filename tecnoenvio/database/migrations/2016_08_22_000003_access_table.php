<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 *
 */
class AccessTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
      //Tabla para la secuencia
      Schema::create('seq_access', function (Blueprint $table) {
        $table->bigInteger('id');
      });
      //Tabla de accesos
      Schema::create('access', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('code');
        $table->string('name', 100)->unique();
        $table->timestamps();
        $table->softDeletes();
      });
      //Funcion de validacion
      DB::connection()->getPdo()->exec('
        drop function if exists seq_access_func;
        create function seq_access_func() returns bigint
          begin
            if(not(exists(select id from seq_access))) then
              insert into seq_access values (0);
            end if;
            update seq_access set id = last_insert_id(id + 1);
            while exists(select null from access where id = last_insert_id()) do
              update seq_access set id = last_insert_id(id + 1);
            end while;
            return last_insert_id();
          end
      ');
      //Creacion del trigger
      DB::connection()->getPdo()->exec('
        drop trigger if exists seq_access_trigger;
          create trigger seq_access_trigger before insert on access
            for each row
              begin
                if new.id is null or new.id = -1 then
                  set new.id = seq_access_func();
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
      DB::connection()->getPdo()->exec('drop trigger if exists seq_access_trigger');
      DB::connection()->getPdo()->exec('drop function if exists seq_access_func');
      Schema::drop('access');
      Schema::drop('seq_access');
    }
}
