<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUserAcces extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_access', function (Blueprint $table) {
          $table->increments('id');
          $table->bigInteger('user')->unsigned();
          $table->integer('item')->unsigned();
          $table->timestamps();
          /*foreing key for menu items*/
          $table->foreign('item')
            ->references('id')
            ->on('item_menu')
            ->onDelete('cascade')
            ->onUpdate('cascade');
          /*foreing key for user id*/
          $table->foreign('user')
            ->references('id')
            ->on('user')
            ->onDelete('cascade')
            ->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_access', function (Blueprint $table) {
            //
        });
    }
}
