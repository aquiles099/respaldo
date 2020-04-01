<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Event;

class EventSeeder extends Seeder {

  /**
   * @var array
   */
  private $data = [
    [1, 'Recibido en Oficina', 1],
    [0, 'En Consolidado'     , 2],
    [1, 'En Transito'        , 3],
    [1, 'Recibido en Destino', 3],
    [1, 'Listo para Entregar', 4],
    [0, 'Entregado'          , 5]
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
      ]);
    }
  }

}
