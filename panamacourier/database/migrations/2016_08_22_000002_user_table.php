<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    //Tabla para la secuencia
    Schema::create('seq_user', function (Blueprint $table) {
      $table->bigInteger('id');
    });
    /**
    *
    */
    Schema::create('user', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('code')->nullable();
        $table->string('name')->nullable();
        $table->string('last_name')->nullable();
        $table->string('dni')->nullable();
        $table->string('country')->nullable();
        $table->string('region')->nullable();
        $table->string('address')->nullable();
        $table->string('city')->nullable();
        $table->string('postal_code')->nullable();
        $table->string('local_phone')->nullable();
        $table->string('celular')->nullable();
        $table->string('email')->unique();
        $table->string('password');
        $table->bigInteger('company')->nullable();
        $table->bigInteger('user_type')->unsigned();
        $table->boolean('active');
        $table->string('remember_token');
        $table->string('sex',1)->nullable();
        $table->string('avatar')->nullable();
        $table->timestamps();
        $table->softDeletes();
    });
    //
    Schema::table('user', function($table) {
      $table->foreign('company')
        ->references('id')
        ->on('company')
        ->onDelete('restrict')
        ->onUpdate('cascade');
        /**
        *
        */
      $table->foreign('user_type')
        ->references('id')
        ->on('user_type')
        ->onDelete('restrict')
        ->onUpdate('cascade');
    });
    //Funcion de validacion
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
    //Creacion del trigger
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
    Schema::drop('user');
    Schema::drop('seq_user');
  }

}
