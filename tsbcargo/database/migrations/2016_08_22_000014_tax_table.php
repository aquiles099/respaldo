<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 *
 */
class TaxTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
      //Tabla para la secuencia
      Schema::create('seq_tax', function (Blueprint $table) {
        $table->bigInteger('id');
      });
      //Tabla de paises
      Schema::create('tax', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('code');
        $table->string('name', 100);
        $table->float('value');
        $table->integer('type');
        $table->integer('state');
        $table->timestamps();
        $table->softDeletes();
        $table->bigInteger('country')->unsigned();
      });
      //
      Schema::table('tax', function($table) {
        $table->foreign('country')
          ->references('id')
          ->on('country')
          ->onDelete('cascade')
          ->onUpdate('cascade');
      });
      //Funcion de validacion
      DB::connection()->getPdo()->exec('
        drop function if exists seq_tax_func;
        create function seq_tax_func() returns bigint
          begin
            if(not(exists(select id from seq_tax))) then
              insert into seq_tax values (0);
            end if;
            update seq_tax set id = last_insert_id(id + 1);
            while exists(select null from tax where id = last_insert_id()) do
              update seq_tax set id = last_insert_id(id + 1);
            end while;
            return last_insert_id();
          end
      ');
      //Creacion del trigger
      DB::connection()->getPdo()->exec('
        drop trigger if exists seq_tax_trigger;
          create trigger seq_tax_trigger before insert on tax
            for each row
              begin
                if new.id is null or new.id = -1 then
                  set new.id = seq_tax_func();
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
      DB::connection()->getPdo()->exec('drop trigger if exists seq_tax_trigger');
      DB::connection()->getPdo()->exec('drop function if exists seq_tax_func');
      Schema::drop('tax');
      Schema::drop('seq_tax');
    }
}
