<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DetailstransportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        /**
        *
        */
      Schema::create('seq_detailstransport', function (Blueprint $table) {
        $table->bigInteger('id');
      });
        /**
        *
        */
      Schema::create('detailstransport', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('code');
        $table->string('name', 100);
        $table->string('description', 200)->unique();
        $table->bigInteger('transport')->unsigned()->nullable();
        $table->timestamps();
        $table->softDeletes();
      });
        /**
        *
        */
      Schema::table('detailstransport', function($table) {
        $table->foreign('transport')
          ->references('id')
          ->on('transport')
          ->onDelete('cascade')
          ->onUpdate('cascade');
        });
        /**
        *
        */
       DB::connection()->getPdo()->exec('
         drop function if exists seq_detailstransport_func;
         create function seq_detailstransport_func() returns bigint
           begin
             if(not(exists(select id from seq_detailstransport))) then
               insert into seq_detailstransport values (0);
             end if;
             update seq_detailstransport set id = last_insert_id(id + 1);
             while exists(select null from detailstransport where id = last_insert_id()) do
               update seq_detailstransport set id = last_insert_id(id + 1);
             end while;
             return last_insert_id();
           end
       ');
       //Creacion del trigger
       DB::connection()->getPdo()->exec('
         drop trigger if exists seq_detailstransport_trigger;
           create trigger seq_detailstransport_trigger before insert on detailstransport
             for each row
               begin
                 if new.id is null or new.id = -1 then
                   set new.id = seq_detailstransport_func();
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
        DB::connection()->getPdo()->exec('drop trigger if exists seq_detailstransport_trigger');
        DB::connection()->getPdo()->exec('drop function if exists seq_detailstransport_func');
        Schema::drop('detailstransport');
        Schema::drop('seq_detailstransport');
    }
}
