<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 *
 */
class ProfileRoleTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
      Schema::create('profile_role', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('profile')->unsigned();
        $table->bigInteger('role')->unsigned();
        $table->timestamps();
        $table->softDeletes();
      });
      //
      Schema::table('profile_role', function($table) {
        $table->foreign('profile')
          ->references('id')
          ->on('profile')
          ->onDelete('cascade')
          ->onUpdate('cascade');
        $table->foreign('role')
          ->references('id')
          ->on('role')
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
      Schema::drop('profile_role');
    }
}
