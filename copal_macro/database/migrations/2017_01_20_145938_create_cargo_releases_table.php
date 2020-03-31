<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCargoReleasesTable extends Migration
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
      Schema::create('seq_cargo_release', function (Blueprint $table) {
        $table->bigInteger('id');
      });
      /**
      *
      */
      Schema::create('cargo_release', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('code');
          $table->bigInteger('last_event')->unsigned();
          $table->string('release_date')->nullable();
          $table->string('release_time')->nullable();
          $table->bigInteger('user')->nullable()->unsigned();
          $table->string('contact_name')->nullable();
          $table->string('contact_phone')->nullable();
          $table->string('contact_country')->nullable();
          $table->string('contact_region')->nullable();
          $table->string('contact_city')->nullable();
          $table->string('contact_address')->nullable();
          $table->string('contact_postal_code')->nullable();
          $table->string('aditional_information')->nullable();
          $table->string('start_at',100)->nullable();
          $table->timestamps();
          $table->softDeletes();
      });
      /**
      * Relaciones
      */
      Schema::table('cargo_release', function($table) {
       /**
       * Con Usuario
       */
        $table->foreign('user')
          ->references('id')
          ->on('user')
          ->onDelete('restrict')
          ->onUpdate('cascade');
        /**
        * Con Evento
        */
        $table->foreign('last_event')
          ->references('id')
          ->on('event')
          ->onDelete('restrict')
          ->onUpdate('cascade');
      });
      /**
      * Funcion de Validacion
      */
      DB::connection()->getPdo()->exec('
        drop function if exists seq_cargo_release_func;
        create function seq_cargo_release_func() returns bigint
          begin
            if(not(exists(select id from seq_cargo_release))) then
              insert into seq_cargo_release values (0);
            end if;
            update seq_cargo_release set id = last_insert_id(id + 1);
            while exists(select null from cargo_release where id = last_insert_id()) do
              update seq_cargo_release set id = last_insert_id(id + 1);
            end while;
            return last_insert_id();
          end
      ');
      /**
      * Creacion del trigger
      */
      DB::connection()->getPdo()->exec('
        drop trigger if exists seq_cargo_release_trigger;
          create trigger seq_cargo_release_trigger before insert on cargo_release
            for each row
              begin
                if new.id is null or new.id = -1 then
                  set new.id = seq_cargo_release_func();
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
        DB::connection()->getPdo()->exec('drop trigger if exists seq_cargo_release_trigger');
        DB::connection()->getPdo()->exec('drop function if exists seq_cargo_release_func');
        Schema::drop('cargo_release');
        Schema::drop('seq_cargo_release');
    }
}
