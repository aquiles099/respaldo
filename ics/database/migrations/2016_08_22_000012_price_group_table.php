<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 *
 */
class PriceGroupTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

      //Tabla de accesos
      Schema::create('price_group', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('spanish', 100)->unique();
        $table->string('english', 100)->unique();
        $table->float('min');
        $table->float('max');
        $table->timestamps();
        $table->softDeletes();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
      Schema::drop('price_group');
    }
}
