<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 *
 */
class OperatorTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
      Schema::create('operator', function (Blueprint $table) {
        $table->increments('id');
        $table->string('code')->nullable();
        $table->string('username', 15)->unique();
        $table->string('name', 30);
        $table->string('lastname', 30)->nullable();
        $table->string('email')->unique();
        $table->string('password');
        $table->integer('profile');
        $table->boolean('active');
        $table->string('remember_token');
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
      Schema::drop('operator');
    }
}
