<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoticesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        /**
        * Tabla para la secuencia
        */
        Schema::create('seq_notice', function (Blueprint $table) {
          $table->bigInteger('id');
        });
        /**
        *
        */
        Schema::create('notice', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->string('title')->nullable();
            $table->boolean('published')->nullable();
            $table->string('extract')->nullable();
            $table->longText('description')->nullable();
            $table->bigInteger('admin')->unsigned()->nullable();
            $table->string('img')->nullable();
            $table->string('slug')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('notice', function($table) {
          $table->foreign('admin')
            ->references('id')
            ->on('user')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
        /**
        * Funcion de validacion
        */
        DB::connection()->getPdo()->exec('
          drop function if exists seq_notice_func;
          create function seq_notice_func() returns bigint
            begin
              if(not(exists(select id from seq_notice))) then
                insert into seq_notice values (0);
              end if;
              update seq_notice set id = last_insert_id(id + 1);
              while exists(select null from notice where id = last_insert_id()) do
                update seq_notice set id = last_insert_id(id + 1);
              end while;
              return last_insert_id();
            end
        ');
        /**
        * Creacion del trigger
        */
        DB::connection()->getPdo()->exec('
          drop trigger if exists seq_notice_trigger;
            create trigger seq_notice_trigger before insert on notice
              for each row
                begin
                  if new.id is null or new.id = -1 then
                    set new.id = seq_notice_func();
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
      DB::connection()->getPdo()->exec('drop trigger if exists seq_notice_trigger');
      DB::connection()->getPdo()->exec('drop function if exists seq_notice_func');
      Schema::dropIfExists('notice');
      Schema::dropIfExists('seq_notice');
    }
}
