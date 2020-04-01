<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 *
 */
class PackageConsolidatedTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

      //Tabla de logs
      Schema::create('package_consolidated', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('package')->unsigned();
        $table->bigInteger('consolidated')->unsigned();
        $table->timestamps();
        $table->softDeletes();
      });
      //
      Schema::table('package_consolidated', function($table) {
        $table->foreign('package')
          ->references('id')
          ->on('package')
          ->onDelete('cascade')
          ->onUpdate('cascade');
        $table->foreign('consolidated')
          ->references('id')
          ->on('consolidated')
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
      Schema::drop('package_consolidated');
    }
}
