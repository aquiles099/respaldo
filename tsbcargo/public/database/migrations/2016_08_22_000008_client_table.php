<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 *
 */
class ClientTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
      //Tabla para la secuencia
      Schema::create('seq_client', function (Blueprint $table) {
        $table->bigInteger('id');
      });
      //Tabla de compania
      Schema::create('client', function (Blueprint $table) {
        $table->bigInteger('id')->default(-1);
        $table->string('code');
        $table->string('name', 100);
        $table->string('phone', 25);
        $table->string('email', 50);
        $table->string('direction', 255);
        $table->timestamps();
        $table->softDeletes();
        $table->primary('id');
        $table->bigInteger('company')->nullable();
        $table->string('identifier', 20)->unique();
      });
      //
      Schema::table('client', function($table) {
        $table->foreign('company')
          ->references('id')
          ->on('company')
          ->onDelete('cascade')
          ->onUpdate('cascade');
      });
      //Funcion de validacion
      DB::connection()->getPdo()->exec('
        drop function if exists seq_client_func;
        create function seq_client_func() returns bigint
          begin
            if(not(exists(select id from seq_client))) then
              insert into seq_client values (0);
            end if;
            update seq_client set id = last_insert_id(id + 1);
            while exists(select null from client where id = last_insert_id()) do
              update seq_client set id = last_insert_id(id + 1);
            end while;
            return last_insert_id();
          end
      ');
      //Creacion del trigger
      DB::connection()->getPdo()->exec('
        drop trigger if exists seq_client_trigger;
          create trigger seq_client_trigger before insert on client
            for each row
              begin
                if new.id is null or new.id = -1 then
                  set new.id = seq_client_func();
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
      DB::connection()->getPdo()->exec('drop trigger if exists seq_client_trigger');
      DB::connection()->getPdo()->exec('drop function if exists seq_client_func');
      Schema::drop('client');
      Schema::drop('seq_client');
    }
}
