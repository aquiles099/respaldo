<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DetailsReceiptTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('detailsreceipt', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('receipt')->unsigned()->nullable();
        $table->integer('type_cost')->unsigned()->nullable();
        $table->string('type_attribute', 10)->nullable();
        $table->integer('id_complemento')->unsigned()->nullable();
        $table->string('name_oring', 200)->nullable();
        $table->float('value_oring')->nullable();
        $table->float('value_package')->nullable();
        $table->timestamps();
        $table->softDeletes();
      });

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
