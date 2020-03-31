<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Log;

class LogSeeder extends Seeder {

  private $data = [
    [1, 1, 1,  'Observacion 1'],
    [2, 1, 1,  'Observacion 2'],
    [3, 1, 1,  'Observacion 3'],
    [4, 1, 1,  'Observacion 4'],
    [5, 1, 1,  'Observacion 5'],
    [6, 1, 1,  'Observacion 6']
  ];


  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    foreach ($this->data as $row) {
      Log::create([
        'package'     => $row[0],
        'user'        => $row[1],
        'event'       => $row[2],
        'observation' => $row[3]
      ]);
    }
  }

}
