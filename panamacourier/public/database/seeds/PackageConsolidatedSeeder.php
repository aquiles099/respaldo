<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\PackageConsolidated;

class PackageConsolidatedSeeder extends Seeder {

  private $data = [
    [1, 1, 'Paquete 1'],
    [2, 1, 'Paquete 2'],
    [3, 2, 'Paquete 3'],
    [4, 2, 'Paquete 4']
  ];

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    foreach ($this->data as $row) {
      PackageConsolidated::create([
        'package'       => $row[0],
        'consolidated'  => $row[1],
        'observation'   => $row[2]
      ]);
    }
  }

}
