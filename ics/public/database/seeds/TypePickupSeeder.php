<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\TypePickup;

class TypePickupSeeder extends Seeder
{
    private $data = [
    [
      'name'       => 'Tipo 1',
      'description'=> 'Tipo 1'
    ],
    [
      'name'       => 'Tipo 2',
      'description'=> 'Tipo 2'
    ],
    [
      'name'       => 'Tipo 3',
      'description'=> 'Tipo 3'
    ],
    [
      'name'       => 'Tipo 4',
      'description'=> 'Tipo 4'
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
