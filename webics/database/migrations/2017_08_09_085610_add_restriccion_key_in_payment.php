<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRestriccionKeyInPayment extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up () {

      \DB::statement("ALTER TABLE payment ADD COLUMN `billing` BIGINT UNSIGNED NULL");

      Schema::table('payment', function (Blueprint $table) {
         $table->foreign('billing')
         ->references('id')
         ->on('billing')
         ->onDelete('cascade')
         ->onUpdate('cascade');
      });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down () {
      Schema::table('payment', function (Blueprint $table) {
          $table->dropColumn('billing');
      });
    }
}
