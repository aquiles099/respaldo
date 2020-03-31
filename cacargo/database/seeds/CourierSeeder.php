<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Courier;

class CourierSeeder extends Seeder {

  private $data = [
    [
      'name' => 'DHL',
      'status'     => 1
    ],
    [
      'name' => 'UPS',
      'status'     => 1
    ],
    [
      'name' => 'USPS',
      'status'     => 1
    ],
    [
      'name' => 'FEDEX',
      'status'     => 1
    ],
    [
      'name' => 'AMAZON',
      'status'     => 1
    ],
    [
      'name' => 'BRIEF INTERNATIONAL',
      'status'     => 1
    ],
    [
      'name' => 'CHINA POST',
      'status'     => 1
    ],
    [
      'name' => 'LASERSHIP',
      'status'     => 1
    ],
     [
      'name' => 'LASERSHIP',
      'status'     => 1
    ],
    [
      'name' => 'POSTEXPRESS',
      'status'     => 1
    ],
    [
      'name' => 'ROYALMAIL',
      'status'     => 1
    ]
  ];

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    foreach ($this->data as $row)
    {
      $package = Courier::create($row);
    }
  }
}
