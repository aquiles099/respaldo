<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillingsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
      /**
      * Tabla para la secuencia
      */
      Schema::create('seq_billing', function (Blueprint $table) {
        $table->bigInteger('id');
      });
      /**
      * Estructura de tabla
      */
      Schema::create('billing', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('code');
          $table->bigInteger('solicitude')->unsigned()->nullable();
          $table->double('total', 15, 8)->nullable();
          $table->double('debt', 15, 8)->nullable();
          $table->string('next_pay')->nullable();
          $table->timestamps();
          $table->softDeletes();
      });
      /**
      * Relaciones
      */
      Schema::table('billing', function($table) {
        $table->foreign('solicitude')
        ->references('id')
        ->on('solicitude')
        ->onDelete('cascade')
        ->onUpdate('cascade');
      });
      /**
      * Funcion de validacion
      */
      DB::connection()->getPdo()->exec('
        drop function if exists seq_billing_func;
        create function seq_billing_func() returns bigint
          begin
            if(not(exists(select id from seq_billing))) then
              insert into seq_billing values (0);
            end if;
            update seq_billing set id = last_insert_id(id + 1);
            while exists(select null from billing where id = last_insert_id()) do
              update seq_billing set id = last_insert_id(id + 1);
            end while;
            return last_insert_id();
          end
      ');
      /**
      * Creacion del trigger
      */
      DB::connection()->getPdo()->exec('
        drop trigger if exists seq_billing_trigger;
          create trigger seq_billing_trigger before insert on billing
            for each row
              begin
                if new.id is null or new.id = -1 then
                  set new.id = seq_billing_func();
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
      DB::connection()->getPdo()->exec('drop trigger if exists seq_billing_trigger');
      DB::connection()->getPdo()->exec('drop function if exists seq_billing_func');
      Schema::dropIfExists('billing');
      Schema::dropIfExists('seq_billing');
    }
}
