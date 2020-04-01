<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Solicitude;

class SolicitudeSeeder extends Seeder {
	private $data= [
		[
			'admin'         => '1',
			'client'        => '2',
			'subject'       => 'Subject to ICS',
			'description'   => 'Request to ICS',
		],
		[
			'admin'         => '1',
			'client'        => '3',
			'subject'       => 'Subject to ICS',
			'description'   => 'prueba2',
		],
		[
			'admin'         => '2',
			'client'        => '1',
			'subject'       => 'Subject to ICS',
			'description'   => 'prueba3',
		],
		[
			'admin'         => '2',
			'client'        => '1',
			'subject'       => 'Subject to ICS',
			'description'   => 'prueba4',
		]
	];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
      foreach ($this->data as $row) {
        Solicitude::create($row);
      }
    }
}
