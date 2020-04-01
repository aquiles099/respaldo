<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        /**
        * Tabla para la secuencia
        */
        Schema::create('seq_user', function (Blueprint $table) {
          $table->bigInteger('id');
        });
        /**
        * Estructura de la tabla usuario
        */
        Schema::create('user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('password', 255)->nullable();
            $table->string('phone')->nullable();
            $table->bigInteger('user_type')->unsigned()->nullable();
            $table->string('remember_token', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('user', function($table) {
          $table->foreign('user_type')
            ->references('id')
            ->on('user_type')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
        /**
        * Funcion de validacion
        */
        DB::connection()->getPdo()->exec('
          drop function if exists seq_user_func;
          create function seq_user_func() returns bigint
            begin
              if(not(exists(select id from seq_user))) then
                insert into seq_user values (0);
              end if;
              update seq_user set id = last_insert_id(id + 1);
              while exists(select null from user where id = last_insert_id()) do
                update seq_user set id = last_insert_id(id + 1);
              end while;
              return last_insert_id();
            end
        ');
        /**
        * Creacion del trigger
        */
        DB::connection()->getPdo()->exec('
          drop trigger if exists seq_user_trigger;
            create trigger seq_user_trigger before insert on user
              for each row
                begin
                  if new.id is null or new.id = -1 then
                    set new.id = seq_user_func();
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
        DB::connection()->getPdo()->exec('drop trigger if exists seq_user_trigger');
        DB::connection()->getPdo()->exec('drop function if exists seq_user_func');
        Schema::dropIfExists('user');
        Schema::dropIfExists('seq_user');
    }
}
