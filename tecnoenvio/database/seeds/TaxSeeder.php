<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Tax;

class TaxSeeder extends Seeder {

  private $data = [];

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    for( $i = 0; $i < 2; $i++) {
      //$country = rand (0 , 1);
      Tax::create([
        'name'       => "Tax - $i",
        'value'      => ($i + 10),
        'type'       => $i,
        'state'     => 1,
        'country'    => 1
      ]);
      //
      Tax::create([
        'name'       => "Tax - $i",
        'value'      => ($i + 10),
        'type'       => $i,
        'state'     => 1,
        'country'    => 2
      ]);
    }
  }
}
