<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterShipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('shipment', function (Blueprint $table) {
        $table->integer('from_country')->unsigned()->nullable();
        $table->integer('from_airport')->unsigned()->nullable();
        $table->integer('to_country')->unsigned()->nullable();
        $table->integer('to_airport')->unsigned()->nullable();
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
