<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterShipmentsTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('shipment', function (Blueprint $table) {
        $table->integer('currency')->unsigned()->nullable();
        $table->integer('payment')->unsigned()->nullable();
        $table->integer('dangerous')->unsigned()->nullable();
        $table->string('agent_charges')->nullable();
        $table->string('transport_charges')->nullable();
        $table->string('tax')->nullable();
        $table->string('insurance')->nullable();
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
