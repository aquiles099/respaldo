<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PromotionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      //Tabla para la secuencia
      Schema::create('seq_promotion', function (Blueprint $table) {
        $table->bigInteger('id');
      });
        /**
        * Se crea la tabla 'promotion'
        */
       Schema::create('promotion', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('code');
        $table->string('name');
        $table->string('type_value');
        $table->float('value');
        $table->bigInteger('user_type')->unsigned();
        $table->bigInteger('transport')->unsigned();
        $table->string('start_date');
        $table->string('end_date');
        $table->integer('status');
        $table->timestamps();
        $table->softDeletes();
       });
        /**
        * Se crea la relacion entre la promocion y el tipo de usuario
        */
       Schema::table('promotion', function ($table){
        $table->foreign('user_type')
              ->references('id')
              ->on('user_type')
              ->onDelete('cascade')
              ->onUpdate('cascade');
        /**
        * Se crea la relacion entre la promocion y el tipo de envio
        */
        $table->foreign('transport')
              ->references('id')
              ->on('transport')
              ->onDelete('cascade')
              ->onUpdate('cascade');
       });
       //Funcion de validacion
DB::connection()->getPdo()->exec('
  drop function if exists seq_promotion_func;
  create function seq_promotion_func() returns bigint
    begin
      if(not(exists(select id from seq_promotion))) then
        insert into seq_promotion values (0);
      end if;
      update seq_promotion set id = last_insert_id(id + 1);
      while exists(select null from promotion where id = last_insert_id()) do
        update seq_promotion set id = last_insert_id(id + 1);
      end while;
      return last_insert_id();
    end
');
//Creacion del trigger
DB::connection()->getPdo()->exec('
  drop trigger if exists seq_promotion_trigger;
    create trigger seq_promotion_trigger before insert on promotion
      for each row
        begin
          if new.id is null or new.id = -1 then
            set new.id = seq_promotion_func();
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
      DB::connection()->getPdo()->exec('drop trigger if exists seq_promotion_trigger');
      DB::connection()->getPdo()->exec('drop function if exists seq_promotion_func');
      Schema::drop('promotion');
      Schema::drop('seq_promotion');
    }
}
