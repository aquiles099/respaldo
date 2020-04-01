<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

      /**
      * Tabla para la secuencia
      */
      Schema::create('seq_client', function (Blueprint $table) {
        $table->bigInteger('id');
      });
      /**
      *
      */
      Schema::create('client', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('code')->nullable();
          $table->string('name')->nullable();
          $table->bigInteger('admin')->unsigned()->nullable();
          $table->string('slug')->nullable();
          $table->string('dni')->nullable();
          $table->bigInteger('country')->unsigned()->nullable();
          $table->string('region')->nullable();
          $table->string('address')->nullable();
          $table->string('city')->nullable();
          $table->string('postal_code')->nullable();
          $table->string('phone')->nullable();
          $table->string('email')->unique();
          $table->string('password', 255)->nullable();
          $table->string('webpage')->nullable();
          $table->string('sub_domain')->nullable();
          $table->bigInteger('status')->unsigned()->nullable();
          $table->string('cutoff_date')->nullable();
          $table->string('name_manager')->nullable();
          $table->string('last_name_manager')->nullable();
          $table->string('phone_manager')->nullable();
          $table->string('email_manager')->unique()->nullable();;
          $table->string('remember_token', 255)->nullable();
          $table->timestamps();
          $table->softDeletes();
      });

      Schema::table('client', function($table) {
        $table->foreign('status')
          ->references('id')
          ->on('status')
          ->onDelete('cascade')
          ->onUpdate('cascade');
      });
      Schema::table('client', function($table) {
        $table->foreign('country')
          ->references('id')
          ->on('country')
          ->onDelete('cascade')
          ->onUpdate('cascade');
      });
      Schema::table('client', function($table) {
        $table->foreign('admin')
          ->references('id')
          ->on('user')
          ->onDelete('cascade')
          ->onUpdate('cascade');
      });
      /**
      * Funcion de validacion
      */
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
      /**
      * Creacion del trigger
      */
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
         Schema::dropIfExists('client');
         Schema::dropIfExists('seq_client');
     }
}
