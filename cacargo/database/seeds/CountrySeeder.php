<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Country;

class CountrySeeder extends Seeder {

  private $data = [
    [
      'name' => 'Panama'
    ],
    [
      'name' => 'USA'
    ]
  ];

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    foreach ($this->data as $key => $row) {
      Country::create([
        'name'      => $row['name']
      ]);
    }
  }
}
