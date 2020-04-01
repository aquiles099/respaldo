<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
        * Tabla para la secuencia
        */
        Schema::create('seq_city', function (Blueprint $table) {
          $table->bigInteger('id');
        });
        /**
        *
        */
        Schema::create('city', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->string('name');
            $table->bigInteger('country')->unsigned();
            $table->bigInteger('state')->unsigned();
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();
        });
        /**
        * Relacion con Pais
        */
        Schema::table('city', function($table) {
         $table->foreign('country')
           ->references('id')
           ->on('country')
           ->onDelete('cascade')
           ->onUpdate('cascade');
       });
       /**
       * Relacion con Estado
       */
       Schema::table('city', function($table) {
        $table->foreign('state')
          ->references('id')
          ->on('state')
          ->onDelete('cascade')
          ->onUpdate('cascade');
      });
       /**
       * Funcion de validacion
       */
        DB::connection()->getPdo()->exec('
          drop function if exists seq_city_func;
          create function seq_city_func() returns bigint
            begin
              if(not(exists(select id from seq_city))) then
                insert into seq_city values (0);
              end if;
              update seq_city set id = last_insert_id(id + 1);
              while exists(select null from city where id = last_insert_id()) do
                update seq_city set id = last_insert_id(id + 1);
              end while;
              return last_insert_id();
            end
        ');
        /**
        * Creacion de trigger
        */
        DB::connection()->getPdo()->exec('
          drop trigger if exists seq_city_trigger;
            create trigger seq_city_trigger before insert on city
              for each row
                begin
                  if new.id is null or new.id = -1 then
                    set new.id = seq_city_func();
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
        DB::connection()->getPdo()->exec('drop trigger if exists seq_city_trigger');
        DB::connection()->getPdo()->exec('drop function if exists seq_city_func');
        Schema::drop('city');
        Schema::drop('seq_city');
    }
}
