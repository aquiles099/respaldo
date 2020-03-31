<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 *
 */
class UserTypeTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

      //Tabla de accesos
      Schema::create('user_type', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('spanish', 100)->unique();
        $table->string('english', 100)->unique();
        $table->timestamps();
        $table->softDeletes();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
      Schema::drop('user_type');
    }
}
