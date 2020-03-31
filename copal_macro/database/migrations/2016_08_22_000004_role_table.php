<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 *
 */
class RoleTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
      /**
      * Tabla para la secuencia
      */
      Schema::create('seq_role', function (Blueprint $table) {
        $table->bigInteger('id');
      });
      /**
      * estructuta para la tabla
      */
      Schema::create('role', function (Blueprint $table) {
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
         drop function if exists seq_role_func;
         create function seq_role_func() returns bigint
           begin
             if(not(exists(select id from seq_role))) then
               insert into seq_role values (0);
             end if;
             update seq_role set id = last_insert_id(id + 1);
             while exists(select null from role where id = last_insert_id()) do
               update seq_role set id = last_insert_id(id + 1);
             end while;
             return last_insert_id();
           end
       ');
       /**
       * Creacion de trigger
       */
       DB::connection()->getPdo()->exec('
         drop trigger if exists seq_role_trigger;
           create trigger seq_role_trigger before insert on role
             for each row
               begin
                 if new.id is null or new.id = -1 then
                   set new.id = seq_role_func();
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
      DB::connection()->getPdo()->exec('drop trigger if exists seq_role_trigger');
      DB::connection()->getPdo()->exec('drop function if exists seq_role_func');
      Schema::drop('role');
      Schema::drop('seq_role');
    }
}
