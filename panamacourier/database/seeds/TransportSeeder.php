<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Packages\Transport;

class TransportSeeder extends Seeder {

  private $data = [
    ['code' => 'TRN-0003','spanish' => 'Terrestre', 'english' => 'Ground', 'price' => '3' ]
  ];

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run () {
    foreach ($this->data as $row) {
      Transport::create($row);
    }
  }
}
