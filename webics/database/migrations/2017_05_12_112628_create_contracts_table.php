<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        /**
        * Tabla para la secuencia
        */
        Schema::create('seq_contract', function (Blueprint $table) {
          $table->bigInteger('id');
        });
        /**
        *
        */
        Schema::create('contract', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->bigInteger('solicitude')->unsigned()->nullable();
            $table->bigInteger('test')->unsigned()->nullable();
            $table->bigInteger('status')->unsigned()->nullable();
            $table->string('register_date')->nullable()->nullable();
            $table->string('cut_off_date')->nullable()->nullable();
            $table->string('version')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        /**
        *
        */
        Schema::table('contract', function($table) {
          $table->foreign('solicitude')
            ->references('id')
            ->on('solicitude')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            /**
            *
            */
          $table->foreign('status')
            ->references('id')
            ->on('status')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            /**
            *
            */
          $table->foreign('test')
            ->references('id')
            ->on('test')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
        /**
        * Funcion de validacion
        */
        DB::connection()->getPdo()->exec('
          drop function if exists seq_contract_func;
          create function seq_contract_func() returns bigint
            begin
              if(not(exists(select id from seq_contract))) then
                insert into seq_contract values (0);
              end if;
              update seq_contract set id = last_insert_id(id + 1);
              while exists(select null from contract where id = last_insert_id()) do
                update seq_contract set id = last_insert_id(id + 1);
              end while;
              return last_insert_id();
            end
        ');
        /**
        * Creacion del trigger
        */
        DB::connection()->getPdo()->exec('
          drop trigger if exists seq_contract_trigger;
            create trigger seq_contract_trigger before insert on contract
              for each row
                begin
                  if new.id is null or new.id = -1 then
                    set new.id = seq_contract_func();
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
      DB::connection()->getPdo()->exec('drop trigger if exists seq_contract_trigger');
      DB::connection()->getPdo()->exec('drop function if exists seq_contract_func');
      Schema::dropIfExists('contract');
      Schema::dropIfExists('seq_contract');
    }
}
