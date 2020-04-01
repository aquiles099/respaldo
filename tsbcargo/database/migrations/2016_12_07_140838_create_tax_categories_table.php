<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('tax_category', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('category')->unsigned();
        $table->bigInteger('tax')->unsigned();
        $table->timestamps();
        $table->softdeletes();
      });
      /**
      * Se definen las relaciones
      */
      Schema::table('tax_category', function($table)
      {
        /**
        * with category
        */
        $table->foreign('category')
              ->references('id')
              ->on('category')
              ->onDelete('cascade')
              ->onUpdate('cascade');
        /**
        * with tax
        */
        $table->foreign('tax')
              ->references('id')
              ->on('tax')
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
        Schema::drop('tax_categories');
    }
}
