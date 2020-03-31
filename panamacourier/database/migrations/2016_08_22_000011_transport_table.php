<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 *
 */
class TransportTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
      //Tabla para la secuencia
      Schema::create('seq_transport', function (Blueprint $table) {
        $table->bigInteger('id');
      });
      //Tabla de accesos
      Schema::create('transport', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('code');
        $table->string('spanish', 100);
        $table->string('english', 100);
        $table->float('price');
        $table->timestamps();
        $table->softDeletes();
      });
      //
      //Funcion de validacion
      DB::connection()->getPdo()->exec('
        drop function if exists seq_transport_func;
        create function seq_transport_func() returns bigint
          begin
            if(not(exists(select id from seq_transport))) then
              insert into seq_transport values (0);
            end if;
            update seq_transport set id = last_insert_id(id + 1);
            while exists(select null from transport where id = last_insert_id()) do
              update seq_transport set id = last_insert_id(id + 1);
            end while;
            return last_insert_id();
          end
      ');
      //Creacion del trigger
      DB::connection()->getPdo()->exec('
        drop trigger if exists seq_transport_trigger;
          create trigger seq_transport_trigger before insert on transport
            for each row
              begin
                if new.id is null or new.id = -1 then
                  set new.id = seq_transport_func();
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
      DB::connection()->getPdo()->exec('drop trigger if exists seq_transport_trigger');
      DB::connection()->getPdo()->exec('drop function if exists seq_transport_func');
      Schema::drop('transport');
      Schema::drop('seq_transport');
    }
}
