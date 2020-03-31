<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTablePickups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('pickup_orders', function (Blueprint $table) {
          $table->string('destin_phone')->nullable();
          $table->string('shipper_phone')->nullable();
          $table->integer('type_destin')->nullable();
          $table->string('destin_name')->nullable();
          $table->string('price')->nullable();
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
