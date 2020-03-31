<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 *
 */
class LogTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

      //Tabla de logs
      Schema::create('log', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('package')->unsigned();
        $table->bigInteger('user')->unsigned();
        $table->bigInteger('event')->unsigned();
        $table->bigInteger('previous_event')->unsigned()->nullable();
        $table->string('observation',255);
        $table->timestamps();
        $table->softDeletes();
      });
      //
      Schema::table('log', function($table) {
        $table->foreign('package')
          ->references('id')
          ->on('package')
          ->onDelete('cascade')
          ->onUpdate('cascade');
       /* $table->foreign('user')
          ->references('id')
          ->on('user')
          ->onDelete('cascade')
          ->onUpdate('cascade');*/
        $table->foreign('event')
          ->references('id')
          ->on('event')
          ->onDelete('cascade')
          ->onUpdate('cascade');
        $table->foreign('previous_event')
          ->references('id')
          ->on('event')
          ->onDelete('cascade')
          ->onUpdate('cascade');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
      Schema::drop('log');
    }
}
