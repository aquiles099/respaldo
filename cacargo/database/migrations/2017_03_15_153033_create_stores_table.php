<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
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
      Schema::create('seq_store', function (Blueprint $table) {
        $table->bigInteger('id');
      });
      /**
      *
      */
      Schema::create('store', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('code');
          $table->string('name')->nullable();
          $table->string('description')->nullable();
          $table->timestamps();
          $table->softDeletes();
      });
      /**
      *
      */
      DB::connection()->getPdo()->exec('
        drop function if exists seq_store_func;
        create function seq_store_func() returns bigint
          begin
            if(not(exists(select id from seq_store))) then
              insert into seq_store values (0);
            end if;
            update seq_store set id = last_insert_id(id + 1);
            while exists(select null from store where id = last_insert_id()) do
              update seq_store set id = last_insert_id(id + 1);
            end while;
            return last_insert_id();
          end
      ');
      /**
      *
      */
      DB::connection()->getPdo()->exec('
        drop trigger if exists seq_store_trigger;
          create trigger seq_store_trigger before insert on store
            for each row
              begin
                if new.id is null or new.id = -1 then
                  set new.id = seq_store_func();
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
      DB::connection()->getPdo()->exec('drop trigger if exists seq_store_trigger');
      DB::connection()->getPdo()->exec('drop function if exists seq_store_func');
      Schema::drop('store');
      Schema::drop('seq_store');
    }
}
