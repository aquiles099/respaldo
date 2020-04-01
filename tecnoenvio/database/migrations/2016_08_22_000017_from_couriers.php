<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 *
 */
class FromCouriers extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

      //Tabla de paises
      Schema::create('fromcouriers', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('package')->unsigned();
        $table->bigInteger('courier')->unsigned();
        $table->string('tracking', 100);
        $table->timestamps();
        $table->softDeletes();
      });
      //
      Schema::table('fromcouriers', function($table) {
        $table->foreign('package')
          ->references('id')
          ->on('package')
          ->onDelete('cascade')
          ->onUpdate('cascade');
      });
      //
      Schema::table('fromcouriers', function($table) {
        $table->foreign('courier')
          ->references('id')
          ->on('courier')
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
      Schema::drop('fromcouriers');
    }
}
