<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 *
 */
class PackageTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

      //Tabla de paises
      Schema::create('package', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('from_courier')->unsigned()->nullable();
        $table->bigInteger('from_user')->unsigned()->nullable();
        $table->bigInteger('to_client')->nullable();
        $table->bigInteger('to_user')->unsigned()->nullable();
        $table->bigInteger('consigner_user')->unsigned()->nullable();
        $table->string('tracking', 100)->nullable();
        $table->float('value')->nullable();
        $table->bigInteger('type')->unsigned()->nullable();
        $table->bigInteger('details_type')->unsigned()->nullable();
        $table->bigInteger('category')->unsigned()->nullable();
        $table->bigInteger('office')->unsigned()->nullable();
        $table->integer('invoice')->nullable();
        $table->integer('unidad')->nullable();
        $table->boolean('aduana')->nullable();
        $table->string('description_aduana', 100)->nullable();
        $table->string('observation',255)->nullable();
        $table->integer('last_event')->nullable();
        $table->string('code', 100)->nullable();
        $table->string('start_at',100)->nullable();
        $table->boolean('booked')->nullable();
        $table->string('process')->nullable();
        $table->timestamps();
        $table->softDeletes();
      });
      //
      Schema::table('package', function($table) {
        $table->foreign('to_client')
          ->references('id')
          ->on('client')
          ->onDelete('cascade')
          ->onUpdate('cascade');
        $table->foreign('type')
          ->references('id')
          ->on('transport')
          ->onDelete('cascade')
          ->onUpdate('cascade');
        $table->foreign('category')
          ->references('id')
          ->on('category')
          ->onDelete('cascade')
          ->onUpdate('cascade');
        $table->foreign('from_courier')
          ->references('id')
          ->on('courier')
          ->onDelete('cascade')
          ->onUpdate('cascade');
        $table->foreign('to_user')
          ->references('id')
          ->on('user')
          ->onDelete('cascade')
          ->onUpdate('cascade');
        $table->foreign('from_user')
          ->references('id')
          ->on('user')
          ->onDelete('cascade')
          ->onUpdate('cascade');
        $table->foreign('consigner_user')
          ->references('id')
          ->on('user')
          ->onDelete('cascade')
          ->onUpdate('cascade');
        $table->foreign('office')
          ->references('id')
          ->on('office')
          ->onDelete('cascade')
          ->onUpdate('cascade');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
      Schema::drop('package');
    }
}
