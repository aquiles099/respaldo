<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\AddCharge;

class AddChargerSeeder extends Seeder
{
    private $data = [
    [
      'id'         => 1,
      'name'       => 'Container 1',
      'description'=> 'Container 1',
      'value'      => 5
      
    ],
    [
      'id'         => 2,
      'name'       => 'Container 2',
      'description'=> 'Container 2',
      'value'      => 10
    ],
    [
      'id'         => 3,
      'name'       => 'Container 3',
      'description'=> 'Container 3',
      'value'      => 20
    ],
    [
      'id'         => 4,
      'name'       => 'Container 4',
      'description'=> 'Container 4',
      'value'      => 30
    ]

  ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	     foreach ($this->data as $row) {
	      $addcharge = AddCharge::create($row);
	     }
    }
}
