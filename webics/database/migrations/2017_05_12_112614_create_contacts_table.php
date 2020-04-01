<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        /**
        * Tabla para la secuencia
        */
        Schema::create('seq_contact', function (Blueprint $table) {
          $table->bigInteger('id');
        });
        /**
        *
        */
        Schema::create('contact', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('subject')->nullable();
            $table->string('message')->nullable();
            $table->boolean('answered')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        /**
        *
        */
        /**
        * Funcion de validacion
        */
        DB::connection()->getPdo()->exec('
          drop function if exists seq_contact_func;
          create function seq_contact_func() returns bigint
            begin
              if(not(exists(select id from seq_contact))) then
                insert into seq_contact values (0);
              end if;
              update seq_contact set id = last_insert_id(id + 1);
              while exists(select null from contact where id = last_insert_id()) do
                update seq_contact set id = last_insert_id(id + 1);
              end while;
              return last_insert_id();
            end
        ');
        /**
        * Creacion del trigger
        */
        DB::connection()->getPdo()->exec('
          drop trigger if exists seq_contact_trigger;
            create trigger seq_contact_trigger before insert on contact
              for each row
                begin
                  if new.id is null or new.id = -1 then
                    set new.id = seq_contact_func();
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
        Schema::dropIfExists('contact');
    }
}
