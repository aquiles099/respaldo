<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('mail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('subject')->nullable();
            $table->longText('message')->nullable();
            $table->bigInteger('contact')->unsigned()->nullable();
            $table->bigInteger('admin')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        /**
        *
        */
        Schema::table('mail', function($table) {
          $table->foreign('admin')
            ->references('id')
            ->on('user')
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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('mail');
    }
}
