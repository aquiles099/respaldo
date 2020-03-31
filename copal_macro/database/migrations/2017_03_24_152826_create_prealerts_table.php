<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrealertsTable extends Migration
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
        Schema::create('seq_prealert', function (Blueprint $table) {
          $table->bigInteger('id');
        });
        /**
        *
        */
        Schema::create('prealert', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->bigInteger('user')->unsigned()->nullable();
            $table->string('order_service')->nullable();
            $table->bigInteger('package')->unsigned()->nullable();
            $table->bigInteger('courier')->unsigned()->nullable();
            $table->string('provider')->nullable();
            $table->string('date_arrived')->nullable();
            $table->boolean('complete')->nullable();
            $table->float('value')->nullable();
            $table->string('content')->nullable();
            $table->bigInteger('file')->nullable()->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });
        /**
        *
        */
       Schema::table('prealert', function ($table){
        $table->foreign('package')
        ->references('id')
        ->on('package')
        ->onDelete('cascade')
        ->onUpdate('cascade');
        /**
        *
        */
        $table->foreign('courier')
        ->references('id')
        ->on('courier')
        ->onDelete('cascade')
        ->onUpdate('cascade');
        /**
        *
        */
        $table->foreign('user')
        ->references('id')
        ->on('user')
        ->onDelete('restrict')
        ->onUpdate('cascade');
        /**
        *
        */
        $table->foreign('file')
        ->references('id')
        ->on('file')
        ->onDelete('cascade')
        ->onUpdate('cascade');
       });
        /**
        *
        */
        DB::connection()->getPdo()->exec('
          drop function if exists seq_prealert_func;
          create function seq_prealert_func() returns bigint
            begin
              if(not(exists(select id from seq_prealert))) then
                insert into seq_prealert values (0);
              end if;
              update seq_prealert set id = last_insert_id(id + 1);
              while exists(select null from prealert where id = last_insert_id()) do
                update seq_prealert set id = last_insert_id(id + 1);
              end while;
              return last_insert_id();
            end
        ');
        /**
        *
        */
        DB::connection()->getPdo()->exec('
          drop trigger if exists seq_prealert_trigger;
            create trigger seq_prealert_trigger before insert on prealert
              for each row
                begin
                  if new.id is null or new.id = -1 then
                    set new.id = seq_prealert_func();
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
      DB::connection()->getPdo()->exec('drop trigger if exists seq_prealert_trigger');
      DB::connection()->getPdo()->exec('drop function if exists seq_prealert_func');
      Schema::drop('prealert');
      Schema::drop('seq_prealert');
    }
}
