<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDescriptionColumnInPayment extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up () {
      \DB::statement("ALTER TABLE payment ADD COLUMN `description` VARCHAR(191) NULL");
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down () {
      Schema::table('payment', function (Blueprint $table) {
          $table->dropColumn('description');
      });
    }
}
