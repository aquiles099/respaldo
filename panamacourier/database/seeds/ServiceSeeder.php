<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Service;

class ServiceSeeder extends Seeder
{
   private $data = [
    [
      'id'         => 1,
      'code'       => 'SRV-0001',
      'name'       => 'Size-little',
      'transport'  => 1,
      'description'=> 'Box Little',
      'value'      => 10

    ],
    [
      'id'         => 2,
      'code'       => 'SRV-0002',
      'name'       => 'Size-Medium',
      'transport'  => 1,
      'description'=> 'Box Medium',
      'value'      => 20
    ],
    [
      'id'         => 3,
      'code'       => 'SRV-0003',
      'name'       => 'Size-Big',
      'transport'  => 2,
      'description'=> 'Box Big',
      'value'      => 40
    ],
    [
      'id'         => 4,
      'code'       => 'SRV-0004',
      'name'       => 'Size- Very Big',
      'transport'  => 2,
      'description'=> 'Box Very Big',
      'value'      => 60
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
	      $addcharge = Service::create($row);
	     }
    }
}
