<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudesTable extends Migration {

    public function up() {
        /**
        * Tabla para la secuencia
        */
        Schema::create('seq_solicitude', function (Blueprint $table) {
          $table->bigInteger('id');
        });
        /**
        * Estructura de la tabla usuario
        */
        Schema::create('solicitude', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->bigInteger('status')->unsigned()->nullable();
            $table->bigInteger('admin')->unsigned()->nullable();
            $table->bigInteger('client')->unsigned()->nullable();
            $table->string('subject')->nullable();
            $table->string('profile')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('solicitude', function($table) {
          $table->foreign('admin')
            ->references('id')
            ->on('user')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
        Schema::table('solicitude', function($table) {
          $table->foreign('client')
            ->references('id')
            ->on('client')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
        Schema::table('solicitude', function($table) {
          $table->foreign('status')
            ->references('id')
            ->on('status')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
        /**
        * Funcion de validacion
        */
        DB::connection()->getPdo()->exec('
          drop function if exists seq_solicitude_func;
          create function seq_solicitude_func() returns bigint
            begin
              if(not(exists(select id from seq_solicitude))) then
                insert into seq_solicitude values (0);
              end if;
              update seq_solicitude set id = last_insert_id(id + 1);
              while exists(select null from solicitude where id = last_insert_id()) do
                update seq_solicitude set id = last_insert_id(id + 1);
              end while;
              return last_insert_id();
            end
        ');
        /**
        * Creacion del trigger
        */
        DB::connection()->getPdo()->exec('
          drop trigger if exists seq_solicitude_trigger;
            create trigger seq_solicitude_trigger before insert on solicitude
              for each row
                begin
                  if new.id is null or new.id = -1 then
                    set new.id = seq_solicitude_func();
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
        DB::connection()->getPdo()->exec('drop trigger if exists seq_solicitude_trigger');
        DB::connection()->getPdo()->exec('drop function if exists seq_solicitude_func');
        Schema::dropIfExists('solicitude');
        Schema::dropIfExists('seq_solicitude');
    }
}
