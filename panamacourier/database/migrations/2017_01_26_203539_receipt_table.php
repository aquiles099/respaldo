<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReceiptTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
      //Tabla para la secuencia
      Schema::create('seq_receipt', function (Blueprint $table) {
        $table->bigInteger('id');
      });
      /**
      * Se define estructura de la tabla
      */
      Schema::create('receipt', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('code');
        $table->bigInteger('package')->unsigned()->nullable();
        $table->bigInteger('pickup')->unsigned()->nullable();
        $table->string('observation', 255)->nullable();
        $table->float('subtotal')->nullable();
        $table->float('total')->nullable();
        $table->bigInteger('invoice')->unsigned()->nullable();
        $table->timestamps();
        $table->softDeletes();
      });
      /**
      * Relacion con facturas
      */
      Schema::table('receipt', function($table) {
       $table->foreign('invoice')
         ->references('id')
         ->on('invoice')
         ->onDelete('cascade')
         ->onUpdate('cascade');
     });
     /**
     * Relacion con paquete o wr
     */
     Schema::table('receipt', function($table) {
      $table->foreign('package')
        ->references('id')
        ->on('package')
        ->onDelete('cascade')
        ->onUpdate('cascade');
    });
    /**
    * relacion con pickup
    */
    Schema::table('receipt', function($table) {
     $table->foreign('pickup')
       ->references('id')
       ->on('pickup_orders')
       ->onDelete('cascade')
       ->onUpdate('cascade');
   });
  /**
  * Funcion de validacion
  */
   DB::connection()->getPdo()->exec('
     drop function if exists seq_receipt_func;
     create function seq_receipt_func() returns bigint
       begin
         if(not(exists(select id from seq_receipt))) then
           insert into seq_receipt values (0);
         end if;
         update seq_receipt set id = last_insert_id(id + 1);
         while exists(select null from receipt where id = last_insert_id()) do
           update seq_receipt set id = last_insert_id(id + 1);
         end while;
         return last_insert_id();
       end
   ');
   //Creacion del trigger
   DB::connection()->getPdo()->exec('
     drop trigger if exists seq_receipt_trigger;
       create trigger seq_receipt_trigger before insert on receipt
         for each row
           begin
             if new.id is null or new.id = -1 then
               set new.id = seq_receipt_func();
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
      DB::connection()->getPdo()->exec('drop trigger if exists seq_receipt_trigger');
      DB::connection()->getPdo()->exec('drop function if exists seq_receipt_func');
      Schema::drop('receipt');
      Schema::drop('seq_receipt');
    }
}
