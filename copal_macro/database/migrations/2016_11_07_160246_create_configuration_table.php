<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigurationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('configuration', function (Blueprint $table) {
            $table->increments('id');
            $table->string('date_dashboard')->nullable();
            $table->string('logo_ics')->nullable();
            $table->longText('terms_ics')->nullable();
            $table->longText('header_receipt')->nullable();
            $table->longText('footer_receipt')->nullable();
            $table->longText('header_label')->nullable();
            $table->longText('footer_label')->nullable();
            $table->longText('header_mail')->nullable();
            $table->longText('footer_mail')->nullable();
            $table->Integer('option_selected_label')->nullable();
            $table->string('name_company')->nullable();
            $table->string('dni_company')->nullable();
            $table->string('country_company')->nullable();
            $table->string('region_company')->nullable();
            $table->string('city_company')->nullable();
            $table->string('email_company')->nullable();
            $table->string('web_site_company')->nullable();
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
        Schema::drop('configuration');
    }
}
