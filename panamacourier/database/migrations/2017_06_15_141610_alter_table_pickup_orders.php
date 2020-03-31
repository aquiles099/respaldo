<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTablePickupOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::table('pickup_orders', function (Blueprint $table) {
              $table->string('country_shipper')->nullable();
              $table->string('region_shipper')->nullable();
              $table->string('city_shipper')->nullable();
              $table->string('address_shipper')->nullable();
              $table->boolean('location_shipper')->nullable();
              $table->string('country_consig')->nullable();
              $table->string('region_consig')->nullable();
              $table->string('city_consig')->nullable();
              $table->string('address_consig')->nullable();
              $table->boolean('location_consig')->nullable();
              $table->bigInteger('provider')->unsigned()->nullable();
              $table->string('po_number')->nullable();
              $table->bigInteger('transporter')->unsigned()->nullable();
              $table->string('trans_tracking')->nullable();
              $table->string('pickup_number')->nullable();
              $table->string('pickup_date')->nullable();
              $table->string('deliver_date')->nullable();
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
