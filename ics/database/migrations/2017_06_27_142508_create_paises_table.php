<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('Paises', function (Blueprint $table)
      {
        $table->bigIncrements('id');
        $table->string('code')->nullable();
        $table->string('name')->nullable();
        $table->timestamps();
        $table->softDeletes();

      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::drop('Paises');
    }
}
