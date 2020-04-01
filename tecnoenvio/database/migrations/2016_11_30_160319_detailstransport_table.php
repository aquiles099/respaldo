<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DetailstransportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Tabla de eventos
      Schema::create('detailstransport', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('name', 100);
        $table->string('description', 200)->unique();
        $table->bigInteger('transport')->unsigned()->nullable();
        $table->timestamps();
        $table->softDeletes();
      });
      //
      Schema::table('detailstransport', function($table) {
      $table->foreign('transport')
          ->references('id')
          ->on('transport')
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
        //
    }
}
