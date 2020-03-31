<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DetailsReceiptTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('detailsreceipt', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->biginteger('receipt')->unsigned();
        $table->integer('type_cost')->unsigned();
        $table->string('type_attribute', 10);
        $table->integer('id_complemento')->unsigned();
        $table->float('value_oring');
        $table->float('value_package');
        $table->timestamps();
        $table->softDeletes();
      });
      /**
      *
      */
        Schema::table('detailsreceipt', function($table) {
        $table->foreign('receipt')
          ->references('id')
          ->on('receipt')
          ->onDelete('cascade')
          ->onUpdate('cascade');
      });
    }

    /**s
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('detailsreceipt');
    }
}
