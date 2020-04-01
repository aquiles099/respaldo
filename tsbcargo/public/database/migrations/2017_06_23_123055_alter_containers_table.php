<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterContainersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('container', function (Blueprint $table)
      {
        $table->string('large_door')->nullable();
        $table->string('widht_door')->nullable();
        $table->string('cube_capacity')->nullable(); // PRODUCT OF LARGE x WIDHT x HEIGTH
        $table->string('max_weight')->nullable();
        $table->string('info')->nullable();
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
