<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Packages\Transport;

class TransportSeeder extends Seeder {

  private $data = [
    ['TRN-0001','Marítimo' , 'Maritime', '10'],
    ['TRN-0002','Aéreo'    , 'Aerial'  , '5' ],
    ['TRN-0003','Terrestre', 'Ground'  , '3' ]

  ];

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    foreach ($this->data as $row) {
      Transport::create([
        'code'    => $row[0],
        'spanish' => $row[1],
        'english' => $row[2],
        'price'   => $row[3]
      ]);
    }
  }

}
