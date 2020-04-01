<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsInTest extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
      \DB::statement("ALTER TABLE test ADD COLUMN `operators` INTEGER NULL");
      \DB::statement("ALTER TABLE test ADD COLUMN `clients` INTEGER NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
      Schema::table('test', function (Blueprint $table) {
          $table->dropColumn('operators');
          $table->dropColumn('clients');
      });
    }
}
