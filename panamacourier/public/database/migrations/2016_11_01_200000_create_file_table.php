<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('file', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('path')->nullable();
            $table->bigInteger('id_package')->unsigned()->nullable();
            $table->bigInteger('carrier')->unsigned()->nullable();
            $table->string('contentPackage')->nullable();
            $table->string('pricePackage')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('file', function ($table) {
          $table->foreign('id_package')
            ->references('id')
            ->on('package')
            ->onDelete('cascade')
            ->onUpdate('cascade');
          $table->foreign('carrier')
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
        Schema::drop('file');
    }
}
