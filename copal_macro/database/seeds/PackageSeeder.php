<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Package;

class PackageSeeder extends Seeder {

  private $data = [
    [
      'from_client' =>  1,
      'to_client'   =>  10,
      'width'       =>  10.5,
      'height'      =>  15.5,
      'weight'      =>  20.5,
      'value'       =>  200,
      'type'        =>  1,
      'category'    =>  1,
      'invoice'     =>  '1',
      'last_event'  =>  1
    ],
    [
      'from_client' =>  2,
      'to_client'   =>  20,
      'width'       =>  10.5,
      'height'      =>  15.5,
      'weight'      =>  20.5,
      'value'       =>  200,
      'type'        =>  2,
      'category'    =>  1,
      'invoice'     =>  '0',
      'last_event'  =>  1
    ],
    [
      'from_courier'  =>  1,
      'to_user'       =>  1,
      'tracking'      => 'tracking 789',
      'width'         =>  10.5,
      'height'        =>  15.5,
      'weight'        =>  20.5,
      'value'         =>  200,
      'type'          =>  1,
      'category'      =>  1,
      'invoice'       =>  '1',
      'last_event'  =>  1
    ]
    ,
    [
      'from_courier'  =>  2,
      'to_user'       =>  1,
      'tracking'      => 'tracking 101112',
      'width'         =>  10.5,
      'height'        =>  15.5,
      'weight'        =>  20.5,
      'value'         =>  200,
      'type'          =>  2,
      'category'      =>  1,
      'invoice'       =>  '0',
      'last_event'  =>  1
    ],
    [
      'from_courier'  =>  3,
      'to_user'       =>  1,
      'tracking'      => 'tracking 131415',
      'width'         =>  10.5,
      'height'        =>  15.5,
      'weight'        =>  20.5,
      'value'         =>  200,
      'type'          =>  1,
      'category'      =>  1,
      'invoice'       =>  '1',
      'last_event'  =>  1
    ]
    ,
    [
      'from_client' =>  3,
      'to_client'   =>  30,
      'width'       =>  10.5,
      'height'      =>  15.5,
      'weight'      =>  20.5,
      'value'       =>  200,
      'type'        =>  2,
      'category'    =>  1,
      'invoice'     =>  '0',
      'last_event'  =>  1
    ]
  ];

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    foreach ($this->data as $row) {
      $package = Package::create($row);
    }
  }
}
