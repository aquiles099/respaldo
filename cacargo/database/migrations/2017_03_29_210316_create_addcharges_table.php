<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddchargesTable extends Migration
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
      Schema::create('seq_addcharges', function (Blueprint $table)
      {
        $table->bigInteger('id');
      });
      
      Schema::create('addcharges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();;
            $table->string('name', 100)->nullable();
            $table->string('description', 200)->nullable();
            $table->float('value')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

      /**
      * Funcion de Validacion
      */
      DB::connection()->getPdo()->exec('
        drop function if exists seq_container_func;
        create function seq_addcharges_func() returns bigint
          begin
            if(not(exists(select id from seq_addcharges))) then
              insert into seq_addcharges values (0);
            end if;
            update seq_addcharges set id = last_insert_id(id + 1);
            while exists(select null from addcharges where id = last_insert_id()) do
              update seq_addcharges set id = last_insert_id(id + 1);
            end while;
            return last_insert_id();
          end
      ');
      /**
      * Creacion del trigger
      */
      DB::connection()->getPdo()->exec('
        drop trigger if exists seq_addcharges_trigger;
          create trigger seq_addcharges_trigger before insert on addcharges
            for each row
              begin
                if new.id is null or new.id = -1 then
                  set new.id = seq_addcharges_func();
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
      DB::connection()->getPdo()->exec('drop trigger if exists seq_addcharges_trigger');
      DB::connection()->getPdo()->exec('drop function if exists seq_addcharges_func');
      Schema::drop('addcharges');
      Schema::drop('seq_addcharges');
    }
}
