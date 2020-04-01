<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 *
 */
class CourierTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
      //Tabla para la secuencia
      Schema::create('seq_courier', function (Blueprint $table) {
        $table->bigInteger('id');
      });
      //Tabla de paises
      Schema::create('courier', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('code');
        $table->string('name', 100);
        $table->integer('status');
        $table->timestamps();
        $table->softDeletes();
      });
      //Funcion de validacion
DB::connection()->getPdo()->exec('
  drop function if exists seq_courier_func;
  create function seq_courier_func() returns bigint
    begin
      if(not(exists(select id from seq_courier))) then
        insert into seq_courier values (0);
      end if;
      update seq_courier set id = last_insert_id(id + 1);
      while exists(select null from courier where id = last_insert_id()) do
        update seq_courier set id = last_insert_id(id + 1);
      end while;
      return last_insert_id();
    end
');
//Creacion del trigger
DB::connection()->getPdo()->exec('
  drop trigger if exists seq_courier_trigger;
    create trigger seq_courier_trigger before insert on courier
      for each row
        begin
          if new.id is null or new.id = -1 then
            set new.id = seq_courier_func();
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
      DB::connection()->getPdo()->exec('drop trigger if exists seq_courier_trigger');
      DB::connection()->getPdo()->exec('drop function if exists seq_courier_func');
      Schema::drop('courier');
      Schema::drop('seq_courier');
    }
}
