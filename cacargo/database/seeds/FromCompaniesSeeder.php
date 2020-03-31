<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\FromCompany;

class FromCompaniesSeeder extends Seeder {

  private $data = [
    [
      'package'   => 5,
      'company'   => 1,
      'tracking'    => 'tracking 131415'
    ],
    [
      'package'   => 6,
      'company'   => 2,
      'tracking'    => 'tracking 161718'
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
      $package = FromCompany::create($row);
    }
  }
}
