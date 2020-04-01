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
    public function up()
    {
      //Tabla para la secuencia
      Schema::create('seq_receipt', function (Blueprint $table) {
        $table->bigInteger('id');
      });
        //Tabla de logs
      Schema::create('receipt', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('code');
        $table->bigInteger('package')->unsigned();
        $table->string('observation', 255);
        $table->float('subtotal');
        $table->float('total');
        $table->timestamps();
        $table->softDeletes();
      });

       Schema::table('receipt', function($table) {
        $table->foreign('package')
          ->references('id')
          ->on('package')
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
