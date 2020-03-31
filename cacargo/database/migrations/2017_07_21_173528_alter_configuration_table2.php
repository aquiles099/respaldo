<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterConfigurationTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('configuration', function (Blueprint $table) {
        $table->string('language')->nullable();
        $table->integer('notify_xls')->nullable();
        $table->string('prefix')->nullable();
        $table->string('num_ini')->nullable();
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
