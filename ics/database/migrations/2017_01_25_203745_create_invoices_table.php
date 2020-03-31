<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
      /**
      * Tabla para la secuencia
      */
      Schema::create('seq_invoice', function (Blueprint $table) {
        $table->bigInteger('id');
      });
      /**
      * Estructura de la tabla
      */
        Schema::create('invoice', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->boolean('status');
            $table->float('value');
            $table->bigInteger('receipt')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        /**
        * Funcion de validacion
        */
         DB::connection()->getPdo()->exec('
           drop function if exists seq_invoice_func;
           create function seq_invoice_func() returns bigint
             begin
               if(not(exists(select id from seq_invoice))) then
                 insert into seq_invoice values (0);
               end if;
               update seq_invoice set id = last_insert_id(id + 1);
               while exists(select null from invoice where id = last_insert_id()) do
                 update seq_invoice set id = last_insert_id(id + 1);
               end while;
               return last_insert_id();
             end
         ');
         /**
         * Creacion de trigger
         */
         DB::connection()->getPdo()->exec('
           drop trigger if exists seq_invoice_trigger;
             create trigger seq_invoice_trigger before insert on invoice
               for each row
                 begin
                   if new.id is null or new.id = -1 then
                     set new.id = seq_invoice_func();
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
      DB::connection()->getPdo()->exec('drop trigger if exists seq_invoice_trigger');
      DB::connection()->getPdo()->exec('drop function if exists seq_invoice_func');
      Schema::drop('invoice');
      Schema::drop('seq_invoice');
    }
}
