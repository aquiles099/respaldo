<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserNotificationsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
      /**
      *
      */
      Schema::create('seq_user_notifications', function (Blueprint $table) {
        $table->bigInteger('id');
      });
      /**
      *
      */
      Schema::create('user_notifications', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('code');
          $table->bigInteger('user')->unsigned()->nullable();
          $table->bigInteger('event')->unsigned()->nullable();
          $table->timestamps();
          $table->softDeletes();
      });
      /**
      *
      */
      Schema::table('user_notifications', function ($table) {
        $table->foreign('user')
        ->references('id')
        ->on('user')
        ->onDelete('cascade')
        ->onUpdate('cascade');
        /**
        *
        */
        $table->foreign('event')
        ->references('id')
        ->on('event')
        ->onDelete('cascade')
        ->onUpdate('cascade');
      });
            //Funcion de validacion
      DB::connection()->getPdo()->exec('
       drop function if exists seq_user_notifications_func;
       create function seq_user_notifications_func() returns bigint
         begin
           if(not(exists(select id from seq_user_notifications))) then
             insert into seq_user_notifications values (0);
           end if;
           update seq_user_notifications set id = last_insert_id(id + 1);
           while exists(select null from user_notifications where id = last_insert_id()) do
             update seq_user_notifications set id = last_insert_id(id + 1);
           end while;
           return last_insert_id();
         end
      ');
      //Creacion del trigger
      DB::connection()->getPdo()->exec('
       drop trigger if exists seq_user_notifications_trigger;
         create trigger seq_user_notifications_trigger before insert on user_notifications
           for each row
             begin
               if new.id is null or new.id = -1 then
                 set new.id = seq_user_notifications_func();
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
      DB::connection()->getPdo()->exec('drop trigger if exists seq_user_notifications_trigger');
      DB::connection()->getPdo()->exec('drop function if exists seq_user_notifications_func');
      Schema::drop('user_notifications');
      Schema::drop('seq_user_notifications');
    }
}
