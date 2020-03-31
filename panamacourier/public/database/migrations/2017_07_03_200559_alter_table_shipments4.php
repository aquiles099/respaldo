<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableShipments4 extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('shipment', function (Blueprint $table) {
      $table->integer('type_file')->unsigned()->nullable();
      $table->string('invoice_number')->nullable();
      $table->string('po_number')->nullable();      
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
