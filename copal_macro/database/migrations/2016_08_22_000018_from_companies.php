<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 *
 */
class FromCompanies extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

      //Tabla de paises
      Schema::create('fromcompanies', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('package')->unsigned();
        $table->bigInteger('company');
        $table->string('tracking', 100);
        $table->timestamps();
        $table->softDeletes();
      });
      //
      Schema::table('fromcompanies', function($table) {
        $table->foreign('package')
          ->references('id')
          ->on('package')
          ->onDelete('restrict')
          ->onUpdate('cascade');
      });
      //
      Schema::table('fromcompanies', function($table) {
        $table->foreign('company')
          ->references('id')
          ->on('company')
          ->onDelete('restrict')
          ->onUpdate('cascade');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
      Schema::drop('fromcompanies');
    }
}
