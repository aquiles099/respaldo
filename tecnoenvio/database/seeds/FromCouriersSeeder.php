<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\FromCourier;

class FromCouriersSeeder extends Seeder {

  private $data = [
    [
      'package'   => 3,
      'courier'   => 1,
      'tracking'    => 'tracking 789'
    ],
    [
      'package'   => 4,
      'courier'   => 2,
      'tracking'    => 'tracking 101112'
    ],
    [
      'package'   => 5,
      'courier'   => 3,
      'tracking'    => 'tracking 131415'
    ],
  ];

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    foreach ($this->data as $row)
    {
      $package = FromCourier::create($row);
    }
  }
}
