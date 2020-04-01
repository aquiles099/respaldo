<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountrysTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    //Tabla para la secuencia
    Schema::create('seq_country', function (Blueprint $table) {
      $table->bigInteger('id');
    });
    //Tabla de paises
    Schema::create('country', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('code');
      $table->string('name', 100)->unique();
      $table->timestamps();
      $table->softDeletes();
    });
    //Funcion de validacion
    DB::connection()->getPdo()->exec('
      drop function if exists seq_country_func;
      create function seq_country_func() returns bigint
        begin
          if(not(exists(select id from seq_country))) then
            insert into seq_country values (0);
          end if;
          update seq_country set id = last_insert_id(id + 1);
          while exists(select null from country where id = last_insert_id()) do
            update seq_country set id = last_insert_id(id + 1);
          end while;
          return last_insert_id();
        end
    ');
    //Creacion del trigger
    DB::connection()->getPdo()->exec('
      drop trigger if exists seq_country_trigger;
        create trigger seq_country_trigger before insert on country
          for each row
            begin
              if new.id is null or new.id = -1 then
                set new.id = seq_country_func();
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
    DB::connection()->getPdo()->exec('drop trigger if exists seq_country_trigger');
    DB::connection()->getPdo()->exec('drop function if exists seq_country_func');
    Schema::drop('country');
    Schema::drop('seq_country');
  }
}
