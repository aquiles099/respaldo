<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BillOfLadingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
      /**
      * Tabla para la sequencia
      */
      Schema::create('seq_billoflading', function (Blueprint $table)
      {
        $table->bigInteger('id');
      });
      /**
      * Estructura de la tabla
      */
      Schema::create('billoflading', function (Blueprint $table)
      {
        $table->bigIncrements('id');
        $table->string('code');
        $table->string('exporter');
        $table->string('consignedto');
        $table->string('document');
        $table->string('notify');
        $table->string('blnumber');
        $table->string('exportreference');
        $table->string('exporting');
        $table->string('forwarding');
        $table->string('foreing');
        $table->string('point');
        $table->string('place');
        $table->string('placedeli');
        $table->string('port');
        $table->string('precarri');
        $table->string('purchaseorder');
        $table->string('loadingpier');
        $table->string('typemovie');
        $table->string('containerized');
        $table->string('package');
        $table->string('pickup');
        $table->timestamps();
        $table->softDeletes();
      });
      /**
      * Funcion de Validacion
      */
      DB::connection()->getPdo()->exec('
        drop function if exists seq_billoflading_func;
        create function seq_billoflading_func() returns bigint
          begin
            if(not(exists(select id from seq_billoflading))) then
              insert into seq_billoflading values (0);
            end if;
            update seq_billoflading set id = last_insert_id(id + 1);
            while exists(select null from billoflading where id = last_insert_id()) do
              update seq_billoflading set id = last_insert_id(id + 1);
            end while;
            return last_insert_id();
          end
      ');
      /**
      * Creacion del trigger
      */
      DB::connection()->getPdo()->exec('
        drop trigger if exists seq_billoflading_trigger;
          create trigger seq_billoflading_trigger before insert on billoflading
            for each row
              begin
                if new.id is null or new.id = -1 then
                  set new.id = seq_billoflading_func();
                end if;
              end
      ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      DB::connection()->getPdo()->exec('drop trigger if exists seq_billoflading_trigger');
      DB::connection()->getPdo()->exec('drop function if exists seq_billoflading_func');
      Schema::drop('billoflading');
      Schema::drop('seq_billoflading');
    }
}
