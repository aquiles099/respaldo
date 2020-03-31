<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Configuration;
use Carbon\Carbon;

class ConfigurationSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
      Configuration::create([
        'date_dashboard' => Carbon::today()->format('Y-m-d'),
        'logo_ics'             => '',
        'terms_ics'            => '',
        'header_receipt'       => '',
        'footer_receipt'       => '',
        'header_label'         => '',
        'footer_label'         => '',
        'header_mail'          => '',
        'footer_mail'          => '',
        'option_selected_label'=> 3,
        'name_company'         => 'Sistema Internacional de Carga',
        'dni_company'          => 'J-12345678',
        'country_company'      => 'Venezuela',
        'region_company'       => 'Bolivar',
        'city_company'         => 'Guayana',
        'email_company'        => 'smithvictor.1990@gmail.com',
        'web_site_company'     => 'http://micro.internationalcargosystem.com/'
      ]);
    }
}
