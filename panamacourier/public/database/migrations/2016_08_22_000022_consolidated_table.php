<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 *
 */
class ConsolidatedTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

      //Tabla de eventos
      Schema::create('consolidated', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('code', 100)->unique();
        $table->string('description', 100)->unique();
        $table->string('observation', 255);
        $table->boolean('status');
        $table->integer('last_event');
        $table->bigInteger('office')->unsigned();
        $table->bigInteger('transport')->unsigned();
        $table->bigInteger('detailstransport')->unsigned();
        $table->timestamps();
        $table->softDeletes();
      });
      //

    Schema::table('consolidated', function ($table){
            $table->foreign('office')
                  ->references('id')
                  ->on('office')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            $table->foreign('transport')
                  ->references('id')
                  ->on('transport')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
       
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
      Schema::drop('consolidated');
    }
}
