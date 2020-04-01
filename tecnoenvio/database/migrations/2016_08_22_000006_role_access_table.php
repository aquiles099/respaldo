<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 *
 */
class RoleAccessTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
      Schema::create('role_access', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('role')->unsigned();
        $table->bigInteger('access')->unsigned();
        $table->timestamps();
        $table->softDeletes();
      });
      //
      Schema::table('role_access', function($table) {
        $table->foreign('role')
          ->references('id')
          ->on('role')
          ->onDelete('cascade')
          ->onUpdate('cascade');
        $table->foreign('access')
          ->references('id')
          ->on('access')
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
      Schema::drop('role_access');
    }
}
