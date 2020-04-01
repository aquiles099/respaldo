<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotifiablesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('notifiable', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('status')->unsigned()->nullable();
            $table->bigInteger('admin')->unsigned()->nullable();
            $table->timestamps();
        });
        /**
        * Relaciones
        */
        Schema::table('notifiable', function($table) {
            $table->foreign('status')->references('id')->on('status')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('admin')->references('id')->on('user')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('notifiable');
    }
}
