<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('messages', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->integer('user')->nullable();;
        $table->string('subject', 100)->nullable();
        $table->string('description', 250)->nullable();
        $table->string('email', 100)->nullable();
        $table->string('image', 100)->nullable();
        $table->timestamps();
        $table->softDeletes();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
