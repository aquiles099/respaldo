<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStateTable extends Migration
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
        Schema::create('seq_state', function (Blueprint $table) {
          $table->bigInteger('id');
        });
        /**
        *
        */
        Schema::create('state', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->string('name');
            $table->bigInteger('country')->unsigned();
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();
        });
        /**
        * Relacion con transporte
        */
        Schema::table('state', function($table) {
         $table->foreign('country')
           ->references('id')
           ->on('country')
           ->onDelete('cascade')
           ->onUpdate('cascade');
       });
       /**
       * Funcion de validacion
       */
        DB::connection()->getPdo()->exec('
          drop function if exists seq_state_func;
          create function seq_state_func() returns bigint
            begin
              if(not(exists(select id from seq_state))) then
                insert into seq_state values (0);
              end if;
              update seq_state set id = last_insert_id(id + 1);
              while exists(select null from state where id = last_insert_id()) do
                update seq_state set id = last_insert_id(id + 1);
              end while;
              return last_insert_id();
            end
        ');
        /**
        * Creacion de trigger
        */
        DB::connection()->getPdo()->exec('
          drop trigger if exists seq_state_trigger;
            create trigger seq_state_trigger before insert on state
              for each row
                begin
                  if new.id is null or new.id = -1 then
                    set new.id = seq_state_func();
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
        DB::connection()->getPdo()->exec('drop trigger if exists seq_state_trigger');
        DB::connection()->getPdo()->exec('drop function if exists seq_state_func');
        Schema::drop('state');
        Schema::drop('seq_state');
    }
}
