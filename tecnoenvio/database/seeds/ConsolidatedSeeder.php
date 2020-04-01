<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Consolidated;

class ConsolidatedSeeder extends Seeder {

  private $data = [
    ['Code 1'    , 'Consolidado 1', 'Observacion consolidado 1', true],
    ['Code 2'    , 'Consolidado 2', 'Observacion consolidado 2', false]
  ];

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    foreach ($this->data as $row) {
      Consolidated::create([
        'code' => $row[0],
        'description' => $row[1],
        'observation' => $row[2],
        'status' => $row[3]
      ]);
    }
  }

}
