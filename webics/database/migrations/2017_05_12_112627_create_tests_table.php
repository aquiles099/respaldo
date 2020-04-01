<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        /**
        * Tabla para la secuencia
        */
        Schema::create('seq_test', function (Blueprint $table) {
          $table->bigInteger('id');
        });
        /**
        *
        */
        Schema::create('test', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->bigInteger('client')->unsigned()->nullable();
            $table->bigInteger('admin')->unsigned()->nullable();
            $table->bigInteger('solicitude')->unsigned()->nullable();
            $table->boolean('accept_terms')->nullable();
            $table->string('date_accept_terms')->nullable();
            $table->string('cutoff_date')->nullable();
            $table->bigInteger('status')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        /**
        *
        */
        Schema::table('test', function($table) {
          $table->foreign('client')
            ->references('id')
            ->on('client')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            /**
            *
            */
          $table->foreign('solicitude')
            ->references('id')
            ->on('solicitude')
            ->onDelete('cascade')
            ->onUpdate('cascade');
          /**
          *
          */
          $table->foreign('admin')
            ->references('id')
            ->on('user')
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
        });
        /**
        * Funcion de validacion
        */
        DB::connection()->getPdo()->exec('
          drop function if exists seq_test_func;
          create function seq_test_func() returns bigint
            begin
              if(not(exists(select id from seq_test))) then
                insert into seq_test values (0);
              end if;
              update seq_test set id = last_insert_id(id + 1);
              while exists(select null from test where id = last_insert_id()) do
                update seq_test set id = last_insert_id(id + 1);
              end while;
              return last_insert_id();
            end
        ');
        /**
        * Creacion del trigger
        */
        DB::connection()->getPdo()->exec('
          drop trigger if exists seq_test_trigger;
            create trigger seq_test_trigger before insert on test
              for each row
                begin
                  if new.id is null or new.id = -1 then
                    set new.id = seq_test_func();
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
      DB::connection()->getPdo()->exec('drop trigger if exists seq_test_trigger');
      DB::connection()->getPdo()->exec('drop function if exists seq_test_func');
      Schema::dropIfExists('test');
      Schema::dropIfExists('seq_test');
    }
}
