<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 *
 */
class OfficeTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
      //Tabla para la secuencia
      Schema::create('seq_office', function (Blueprint $table) {
        $table->bigInteger('id');
      });
      //Tabla de paises
      Schema::create('office', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('name', 100);
        $table->string('phone', 25);
        $table->string('direction', 255);
        $table->string('code');
        $table->timestamps();
        $table->softDeletes();
        $table->bigInteger('country')->unsigned();
      });
      //
      Schema::table('office', function($table) {
        $table->foreign('country')
          ->references('id')
          ->on('country')
          ->onDelete('cascade')
          ->onUpdate('cascade');
      });
      /**
      *
      */
      DB::connection()->getPdo()->exec('
        drop function if exists seq_office_func;
        create function seq_office_func() returns bigint
          begin
            if(not(exists(select id from seq_office))) then
              insert into seq_office values (0);
            end if;
            update seq_office set id = last_insert_id(id + 1);
            while exists(select null from office where id = last_insert_id()) do
              update seq_office set id = last_insert_id(id + 1);
            end while;
            return last_insert_id();
          end
      ');
      /**
      *
      */
      DB::connection()->getPdo()->exec('
        drop trigger if exists seq_office_trigger;
          create trigger seq_office_trigger before insert on office
            for each row
              begin
                if new.id is null or new.id = -1 then
                  set new.id = seq_office_func();
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
      DB::connection()->getPdo()->exec('drop trigger if exists seq_office_trigger');
      DB::connection()->getPdo()->exec('drop function if exists seq_office_func');
      Schema::drop('office');
      Schema::drop('seq_office');
    }
}
