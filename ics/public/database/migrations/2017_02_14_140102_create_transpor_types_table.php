<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransporTypesTable extends Migration
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
        Schema::create('seq_transport_type', function (Blueprint $table) {
          $table->bigInteger('id');
        });
        /**
        *
        */
        Schema::create('transport_type', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->string('name');
            $table->bigInteger('transport')->unsigned();
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();
        });
        /**
        * Relacion con transporte
        */
        Schema::table('transport_type', function($table) {
         $table->foreign('transport')
           ->references('id')
           ->on('transport')
           ->onDelete('cascade')
           ->onUpdate('cascade');
       });
       /**
       * Funcion de validacion
       */
        DB::connection()->getPdo()->exec('
          drop function if exists seq_transport_type_func;
          create function seq_transport_type_func() returns bigint
            begin
              if(not(exists(select id from seq_transport_type))) then
                insert into seq_transport_type values (0);
              end if;
              update seq_transport_type set id = last_insert_id(id + 1);
              while exists(select null from transport_type where id = last_insert_id()) do
                update seq_transport_type set id = last_insert_id(id + 1);
              end while;
              return last_insert_id();
            end
        ');
        /**
        * Creacion de trigger
        */
        DB::connection()->getPdo()->exec('
          drop trigger if exists seq_transport_type_trigger;
            create trigger seq_transport_type_trigger before insert on transport_type
              for each row
                begin
                  if new.id is null or new.id = -1 then
                    set new.id = seq_transport_type_func();
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
      DB::connection()->getPdo()->exec('drop trigger if exists seq_transport_type_trigger');
      DB::connection()->getPdo()->exec('drop function if exists seq_transport_type_func');
      Schema::drop('transport_type');
      Schema::drop('seq_transport_type');
    }
}
