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
         'header_receipt'       => 'Ut a nisl id ante tempus hendrerit. In ut quam vitae odio lacinia tincidunt. Etiam sollicitudin, ipsum eu pulvinar rutrum, tellus ipsum laoreet sapien, quis venenatis ante odio sit amet eros. Phasellus consectetuer vestibulum elit. Curabitur at lacus ac velit ornare lobortis.Donec venenatis vulputate lorem. Aenean imperdiet. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus.',
         'footer_receipt'       => 'Ut a nisl id ante tempus hendrerit. In ut quam vitae odio lacinia tincidunt. Etiam sollicitudin, ipsum eu pulvinar rutrum, tellus ipsum laoreet sapien, quis venenatis ante odio sit amet eros. Phasellus consectetuer vestibulum elit. Curabitur at lacus ac velit ornare lobortis.Donec venenatis vulputate lorem. Aenean imperdiet. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus.',
         'header_label'         => 'Ut a nisl id ante tempus hendrerit. In ut quam vitae odio lacinia tincidunt. Etiam sollicitudin, ipsum eu pulvinar rutrum, tellus ipsum laoreet sapien, quis venenatis ante odio sit amet eros. Phasellus consectetuer vestibulum elit. Curabitur at lacus ac velit ornare lobortis.Donec venenatis vulputate lorem. Aenean imperdiet. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus.',
         'footer_label'         => 'Ut a nisl id ante tempus hendrerit. In ut quam vitae odio lacinia tincidunt. Etiam sollicitudin, ipsum eu pulvinar rutrum, tellus ipsum laoreet sapien, quis venenatis ante odio sit amet eros. Phasellus consectetuer vestibulum elit. Curabitur at lacus ac velit ornare lobortis.Donec venenatis vulputate lorem. Aenean imperdiet. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus.',
         'header_mail'          => 'Ut a nisl id ante tempus hendrerit. In ut quam vitae odio lacinia tincidunt. Etiam sollicitudin, ipsum eu pulvinar rutrum, tellus ipsum laoreet sapien, quis venenatis ante odio sit amet eros. Phasellus consectetuer vestibulum elit. Curabitur at lacus ac velit ornare lobortis.Donec venenatis vulputate lorem. Aenean imperdiet. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus.',
         'footer_mail'          => 'Ut a nisl id ante tempus hendrerit. In ut quam vitae odio lacinia tincidunt. Etiam sollicitudin, ipsum eu pulvinar rutrum, tellus ipsum laoreet sapien, quis venenatis ante odio sit amet eros. Phasellus consectetuer vestibulum elit. Curabitur at lacus ac velit ornare lobortis.Donec venenatis vulputate lorem. Aenean imperdiet. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus.',
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
