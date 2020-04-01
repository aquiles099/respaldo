<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIataCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iata_codes', function (Blueprint $table)
        {
          $table->bigIncrements('id');
          $table->string('iata')->nullable();
          $table->string('lon')->nullable();
          $table->string('iso')->nullable();
          $table->string('status')->nullable();
          $table->string('name')->nullable();
          $table->string('continent')->nullable();
          $table->string('type')->nullable();
          $table->string('lat')->nullable();
          $table->string('size')->nullable();
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
      Schema::drop('iata_codes');
    }
}
