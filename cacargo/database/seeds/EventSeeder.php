<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Event;

class EventSeeder extends Seeder {

  /**
   * @var array
   */
  private $data = [
    [1, 'Recibido en Oficina', 1, 'Status 1', 1],
    [0, 'En Consolidado'     , 2, 'Status 2', 1],
    [1, 'En Transito'        , 3, 'Status 3', 1],
    [1, 'Recibido en Destino', 3, 'Status 4', 1],
    [1, 'Listo para Entregar', 4, 'Status 5', 1],
    [0, 'Entregado'          , 5, 'Status 6', 1]
  ];

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    foreach ($this->data as $row) {
      Event::create([
        'description'  => $row[1],
        'notification' => $row[0],
        'step'         => $row[2],
        'name'         => $row[3],
        'active'       => $row[4]
      ]);
    }
  }

}
