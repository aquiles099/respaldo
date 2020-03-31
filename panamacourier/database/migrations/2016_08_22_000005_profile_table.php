<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 *
 */
class ProfileTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
      /**
      * Tabla para la secuencia
      */
      Schema::create('seq_profile', function (Blueprint $table) {
        $table->bigInteger('id');
      });
      /**
      * tabla para perfiles
      */
      Schema::create('profile', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('code');
        $table->string('name', 100)->unique();
        $table->timestamps();
        $table->softDeletes();
      });
      /**
      * Funcion de validacion
      */
       DB::connection()->getPdo()->exec('
         drop function if exists seq_profile_func;
         create function seq_profile_func() returns bigint
           begin
             if(not(exists(select id from seq_profile))) then
               insert into seq_profile values (0);
             end if;
             update seq_profile set id = last_insert_id(id + 1);
             while exists(select null from profile where id = last_insert_id()) do
               update seq_profile set id = last_insert_id(id + 1);
             end while;
             return last_insert_id();
           end
       ');
       /**
       * Creacion de trigger
       */
       DB::connection()->getPdo()->exec('
         drop trigger if exists seq_profile_trigger;
           create trigger seq_profile_trigger before insert on profile
             for each row
               begin
                 if new.id is null or new.id = -1 then
                   set new.id = seq_profile_func();
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
      DB::connection()->getPdo()->exec('drop trigger if exists seq_profile_trigger');
      DB::connection()->getPdo()->exec('drop function if exists seq_profile_func');
      Schema::drop('profile');
      Schema::drop('seq_profile');
    }
}
