<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\TypePickup;

class TypePickupSeeder extends Seeder
{
  private $data = [
    [
      'id'         => 1,
      'name'       => 'DHL Envelope',
      'description'=> 'A'
    ],
    [
      'id'         => 2,
      'name'       => 'DHL Package',
      'description'=> 'B'
    ],
    [
      'id'         => 3,
      'name'       => 'Fedex Envelope',
      'description'=> 'C'
    ],
    [
      'id'         => 4,
      'name'       => 'Fedex Pak',
      'description'=> 'D'
    ],
    [
      'id'         => 5,
      'name'       => 'Fedex Package',
      'description'=> 'E'
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
	      $addtypepickup = TypePickup::create($row);
	     }
    }
}
