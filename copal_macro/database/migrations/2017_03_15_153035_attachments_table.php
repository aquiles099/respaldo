<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AttachmentsTable extends Migration
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
      Schema::create('seq_attachment', function (Blueprint $table) {
        $table->bigInteger('id');
      });
      /**
      *
      */
      Schema::create('attachment', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('code');
        $table->bigInteger('shipment')->unsigned()->nullable();
        $table->bigInteger('booking')->unsigned()->nullable();
        $table->bigInteger('warehouse')->unsigned()->nullable();
        $table->bigInteger('pickup')->unsigned()->nullable();
        $table->bigInteger('cargo_release')->unsigned()->nullable();
        $table->bigInteger('transporters')->unsigned()->nullable();
        $table->bigInteger('suppliers')->unsigned()->nullable();
        $table->string('path')->nullable();
        $table->string('name_path')->nullable();
        $table->Integer('operator')->unsigned()->nullable();
        $table->timestamps();
        $table->softDeletes();
      });
      /**
      *
      */
      Schema::table('attachment', function($table) {
        $table->foreign('shipment')
        ->references('id')
        ->on('shipment')
        ->onDelete('cascade')
        ->onUpdate('cascade');
        /**
        *
        */
        $table->foreign('booking')
        ->references('id')
        ->on('booking')
        ->onDelete('cascade')
        ->onUpdate('cascade');
        /**
        *
        */
        $table->foreign('warehouse')
        ->references('id')
        ->on('package')
        ->onDelete('cascade')
        ->onUpdate('cascade');
        /**
        *
        */
        $table->foreign('pickup')
        ->references('id')
        ->on('pickup_orders')
        ->onDelete('cascade')
        ->onUpdate('cascade');
        /**
        *
        */
        $table->foreign('cargo_release')
        ->references('id')
        ->on('cargo_release')
        ->onDelete('cascade')
        ->onUpdate('cascade');
        /**
        *
        */
        $table->foreign('transporters')
        ->references('id')
        ->on('transporters')
        ->onDelete('cascade')
        ->onUpdate('cascade');
        /**
        *
        */

        $table->foreign('suppliers')
        ->references('id')
        ->on('suppliers')
        ->onDelete('cascade')
        ->onUpdate('cascade');
        /**
        *
        */
        $table->foreign('operator')
        ->references('id')
        ->on('operator')
        ->onDelete('cascade')
        ->onUpdate('cascade');
      });
      /**
      * Funcion de validacion
      */
       DB::connection()->getPdo()->exec('
         drop function if exists seq_attachment_func;
         create function seq_attachment_func() returns bigint
           begin
             if(not(exists(select id from seq_attachment))) then
               insert into seq_attachment values (0);
             end if;
             update seq_attachment set id = last_insert_id(id + 1);
             while exists(select null from attachment where id = last_insert_id()) do
               update seq_attachment set id = last_insert_id(id + 1);
             end while;
             return last_insert_id();
           end
       ');
       /**
       * Creacion de trigger
       */
       DB::connection()->getPdo()->exec('
         drop trigger if exists seq_attachment_trigger;
           create trigger seq_attachment_trigger before insert on attachment
             for each row
               begin
                 if new.id is null or new.id = -1 then
                   set new.id = seq_attachment_func();
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
      DB::connection()->getPdo()->exec('drop trigger if exists seq_attachment_trigger');
      DB::connection()->getPdo()->exec('drop function if exists seq_attachment_func');
      Schema::drop('attachment');
      Schema::drop('seq_attachment');
    }
}
