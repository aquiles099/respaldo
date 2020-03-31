<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 *
 */
class CategoryTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
    //Tabla para la secuencia
      Schema::create('seq_category', function (Blueprint $table) {
        $table->bigInteger('id');
      });
      //Tabla de eventos
      Schema::create('category', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('code');
        $table->string('label', 100)->unique();
        $table->float('percentage');
        $table->timestamps();
        $table->softDeletes();
      });
      //Funcion de validacion
      DB::connection()->getPdo()->exec('
        drop function if exists seq_category_func;
        create function seq_category_func() returns bigint
          begin
            if(not(exists(select id from seq_category))) then
              insert into seq_category values (0);
            end if;
            update seq_category set id = last_insert_id(id + 1);
            while exists(select null from category where id = last_insert_id()) do
              update seq_category set id = last_insert_id(id + 1);
            end while;
            return last_insert_id();
          end
      ');
      //Creacion del trigger
      DB::connection()->getPdo()->exec('
        drop trigger if exists seq_category_trigger;
          create trigger seq_category_trigger before insert on category
            for each row
              begin
                if new.id is null or new.id = -1 then
                  set new.id = seq_category_func();
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
      DB::connection()->getPdo()->exec('drop trigger if exists seq_category_trigger');
      DB::connection()->getPdo()->exec('drop function if exists seq_category_func');
      Schema::drop('category');
      Schema::drop('seq_category');
    }
}
