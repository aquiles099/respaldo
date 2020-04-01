<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        /**
        * Tabla para la secuencia
        */
        Schema::create('seq_payment', function (Blueprint $table) {
          $table->bigInteger('id');
        });
        /**
        * Estructura de tabla
        */
        Schema::create('payment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->string('type')->nullable();
            $table->bigInteger('solicitude')->unsigned()->nullable();
            $table->integer('years')->nullable();
            $table->double('amount', 15, 8)->nullable();
            $table->string('bank')->nullable();
            $table->string('transaction')->nullable();
            $table->string('observation')->nullable();
            $table->string('attachment')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        /**
        * Relaciones
        */
        Schema::table('payment', function($table) {
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
          drop function if exists seq_payment_func;
          create function seq_payment_func() returns bigint
            begin
              if(not(exists(select id from seq_payment))) then
                insert into seq_payment values (0);
              end if;
              update seq_payment set id = last_insert_id(id + 1);
              while exists(select null from payment where id = last_insert_id()) do
                update seq_payment set id = last_insert_id(id + 1);
              end while;
              return last_insert_id();
            end
        ');
        /**
        * Creacion del trigger
        */
        DB::connection()->getPdo()->exec('
          drop trigger if exists seq_payment_trigger;
            create trigger seq_payment_trigger before insert on payment
              for each row
                begin
                  if new.id is null or new.id = -1 then
                    set new.id = seq_payment_func();
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
      DB::connection()->getPdo()->exec('drop trigger if exists seq_payment_trigger');
      DB::connection()->getPdo()->exec('drop function if exists seq_payment_func');
      Schema::dropIfExists('payment');
      Schema::dropIfExists('seq_payment');
    }
}
