<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 *
 */
class CreatePickupStatusTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

      //Tabla de Estados
      Schema::create('pickup_status', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('name', 100);
        $table->string('description', 100);
        $table->boolean('notification');
        $table->integer('step');
        $table->integer('active');
        $table->timestamps();
        $table->softDeletes();
      });
      //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
      Schema::drop('pickup_status');
    }
}
