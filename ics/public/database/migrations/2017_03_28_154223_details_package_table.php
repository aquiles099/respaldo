<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DetailsPackageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detailspackage', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description', 200);
            $table->float('large');
            $table->float('width');
            $table->float('height');
            $table->float('weight');
            $table->float('volumetricweightm');
            $table->float('volumetricweighta');
            $table->string('order_service', 100);
            $table->bigInteger('courier')->unsigned()->nullable();
            $table->bigInteger('pieces')->unsigned()->nullable();
            $table->float('value');
            $table->bigInteger('package')->unsigned();
            $table->bigInteger('addcharge');
            $table->string('start_at',100)->nullable();
            $table->timestamps();
            $table->softDeletes();
      });

        Schema::table('detailspackage', function($table) {
        $table->foreign('package')
          ->references('id')
          ->on('package')
          ->onDelete('cascade')
          ->onUpdate('cascade');
        });

      Schema::table('detailspackage', function($table) {
        $table->foreign('courier')
        ->references('id')
        ->on('courier')
        ->onDelete('cascade')
        ->onUpdate('cascade');
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
