<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 *
 */
class CompanyTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
      //Tabla para la secuencia
      Schema::create('seq_company', function (Blueprint $table) {
        $table->bigInteger('id');
      });
      //Tabla de compania
      Schema::create('company', function (Blueprint $table) {
        $table->bigInteger('id')->default(-1);
        $table->string('code');
        $table->string('name', 100);
        $table->string('ruc', 25);
        $table->string('direction', 255);
        $table->string('phone_01', 25);
        $table->string('phone_02', 25)->nullable();
        $table->string('email_01', 50);
        $table->string('email_02', 50)->nullable();
        $table->timestamps();
        $table->softDeletes();
        $table->primary('id');
      });
      //Funcion de validacion
      DB::connection()->getPdo()->exec('
        drop function if exists seq_company_func;
        create function seq_company_func() returns bigint
          begin
            if(not(exists(select id from seq_company))) then
              insert into seq_company values (0);
            end if;
            update seq_company set id = last_insert_id(id + 1);
            while exists(select null from company where id = last_insert_id()) do
              update seq_company set id = last_insert_id(id + 1);
            end while;
            return last_insert_id();
          end
      ');
      //Creacion del trigger
      DB::connection()->getPdo()->exec('
        drop trigger if exists seq_company_trigger;
          create trigger seq_company_trigger before insert on company
            for each row
              begin
                if new.id is null or new.id = -1 then
                  set new.id = seq_company_func();
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
      DB::connection()->getPdo()->exec('drop trigger if exists seq_company_trigger');
      DB::connection()->getPdo()->exec('drop function if exists seq_company_func');
      Schema::drop('company');
      Schema::drop('seq_company');
    }
}
