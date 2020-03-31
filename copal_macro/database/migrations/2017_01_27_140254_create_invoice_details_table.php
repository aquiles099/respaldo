<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
        * Estructura de la tabla
        */
        Schema::create('invoice_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('invoice')->unsigned();
            $table->float('paidOut')->unsigned();
            $table->float('debt')->unsigned();
            $table->string('type');
            $table->string('observation');
            $table->timestamps();
            $table->softDeletes();
        });
        /**
        * Relacion con la tabla factura
        */
        Schema::table('invoice_detail', function ($table)
        {
          $table->foreign('invoice')
            ->references('id')
            ->on('invoice')
            ->onDelete('restrict')
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
        Schema::drop('invoice_detail');
    }
}
