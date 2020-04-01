<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePricesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up () {
        /**
        * Tabla para la secuencia
        */
        Schema::create('seq_price', function (Blueprint $table) {
          $table->bigInteger('id');
        });
        /**
        *
        */
        Schema::create('price', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->integer('type')->nullable();
            $table->string('years')->nullable();
            $table->double('monthly', 15, 8)->nullable();
            $table->double('annual', 15, 8)->nullable();
            $table->timestamps();
        });
        /**
        * Funcion de validacion
        */
        DB::connection()->getPdo()->exec('
          drop function if exists seq_price_func;
          create function seq_price_func() returns bigint
            begin
              if(not(exists(select id from seq_price))) then
                insert into seq_price values (0);
              end if;
              update seq_price set id = last_insert_id(id + 1);
              while exists(select null from price where id = last_insert_id()) do
                update seq_price set id = last_insert_id(id + 1);
              end while;
              return last_insert_id();
            end
        ');
        /**
        * Creacion del trigger
        */
        DB::connection()->getPdo()->exec('
          drop trigger if exists seq_price_trigger;
            create trigger seq_price_trigger before insert on price
              for each row
                begin
                  if new.id is null or new.id = -1 then
                    set new.id = seq_price_func();
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
      DB::connection()->getPdo()->exec('drop trigger if exists seq_price_trigger');
      DB::connection()->getPdo()->exec('drop function if exists seq_price_func');
      Schema::drop('price');
      Schema::drop('seq_price');
    }
}
