<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('admin')->unsigned()->nullable();
            $table->bigInteger('client')->unsigned()->nullable();
            $table->bigInteger('notice')->unsigned()->nullable();
            $table->bigInteger('solicitude')->unsigned()->nullable();
            $table->bigInteger('test')->unsigned()->nullable();
            $table->bigInteger('contact')->unsigned()->nullable();
            $table->bigInteger('contract')->unsigned()->nullable();
            $table->bigInteger('status')->unsigned()->nullable();
            $table->bigInteger('payment')->unsigned()->nullable();
            $table->bigInteger('billing')->unsigned()->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        /**
        *
        */
        Schema::table('log', function($table) {
          $table->foreign('admin')
          ->references('id')
          ->on('user')
          ->onDelete('cascade')
          ->onUpdate('cascade');
          /**
          *
          */
          $table->foreign('client')
          ->references('id')
          ->on('client')
          ->onDelete('cascade')
          ->onUpdate('cascade');
          /**
          *
          */
          $table->foreign('notice')
          ->references('id')
          ->on('notice')
          ->onDelete('cascade')
          ->onUpdate('cascade');
          /**
          *
          */
          $table->foreign('solicitude')
          ->references('id')
          ->on('solicitude')
          ->onDelete('cascade')
          ->onUpdate('cascade');
          /**
          *
          */
          $table->foreign('contract')
          ->references('id')
          ->on('contract')
          ->onDelete('cascade')
          ->onUpdate('cascade');
          /**
          *
          */
          $table->foreign('test')
          ->references('id')
          ->on('test')
          ->onDelete('cascade')
          ->onUpdate('cascade');
          /**
          *
          */
          $table->foreign('contact')
          ->references('id')
          ->on('contact')
          ->onDelete('cascade')
          ->onUpdate('cascade');
          /**
          *
          */
          $table->foreign('status')
          ->references('id')
          ->on('status')
          ->onDelete('cascade')
          ->onUpdate('cascade');
          /**
          *
          */
          $table->foreign('payment')
          ->references('id')
          ->on('payment')
          ->onDelete('cascade')
          ->onUpdate('cascade');
          /**
          *
          */
          $table->foreign('billing')
          ->references('id')
          ->on('billing')
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
        Schema::dropIfExists('log');
    }
}
