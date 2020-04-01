<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncidencesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('incidence', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type');
            $table->bigInteger('test')->unsigned()->nullable();
            $table->bigInteger('contract')->unsigned()->nullable();
            $table->string('subject')->nullable();
            $table->longText('description')->nullable();
            $table->string('img')->nullable();
            $table->string('profile')->nullable();
            $table->boolean('status')->nullable();
            $table->bigInteger('admin')->unsigned()->nullable();
            $table->longText('asnwer')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        /**
        * Relaciones
        */
        Schema::table('incidence', function($table) {
        /* 1 */ $table->foreign('test')->references('id')->on('test')->onDelete('cascade')->onUpdate('cascade');
        /* 2 */ $table->foreign('contract')->references('id')->on('contract')->onDelete('cascade')->onUpdate('cascade');
        /* 3 */ $table->foreign('admin')->references('id')->on('user')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('incidence');
    }
}
