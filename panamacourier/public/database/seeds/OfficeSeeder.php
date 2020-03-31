<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Office;

class OfficeSeeder extends Seeder {

  private $data = [];

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    for( $i = 1; $i < 3; $i++) {
      Office::create([
        'name'       => "Oficina $i",
        'direction'  => 'Dirección...',
        'phone'      => '04264855600',
        'code'       => 'OFI-000'.$i,
        'country'    =>  $i
      ]);
    }
  }
}
