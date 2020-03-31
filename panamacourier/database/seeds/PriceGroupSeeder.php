<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Packages\PriceGroup;

class PriceGroupSeeder extends Seeder {

  /**
   *
   */
  private $data = [
    ['min' =>  0.00 , 'max' =>  0.25],
    ['min' =>  0.50 , 'max' =>  0.75],
    ['min' =>  0.75 , 'max' =>  1.00],
    ['min' =>  1.00 , 'max' =>  3.00],
    ['min' =>  3.00 , 'max' =>  5.00],
    ['min' =>  5.00 , 'max' =>  8.00],
    ['min' =>  8.00 , 'max' => 10.00],
    ['min' => 10.00 , 'max' => 15.00],
  ];

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    foreach ($this->data as $key => $row) {
      PriceGroup::create([
        'spanish' => "Grupo - $key",
        'english' => "Grupo - $key (ingles)",
        'min'     => $row['min'],
        'max'     => $row['max']
      ]);
    }
  }
}
