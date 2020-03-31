<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPackageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('package', function (Blueprint $table) {
        $table->integer('shipper_is')->unsigned()->nullable();
        $table->integer('transporter')->unsigned()->nullable();
        $table->integer('company')->unsigned()->nullable();
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
