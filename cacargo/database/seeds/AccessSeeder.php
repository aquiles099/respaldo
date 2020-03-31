<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Security\Access;

class AccessSeeder extends Seeder {

  private $rows = [
    'Administracion de Dasboard',
    'Administracion de Paquetes',
    'Administracion de Consolidados',
    'Administracion de Facturacion',
    'Administracion de Reportes',
    'Administracion de General',
    'Administracion de Seguridad',
    'Administracion de Atencion al Cliente'
   
  ];

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    foreach($this->rows as $row) {
      Access::create([
        'name' => $row,
      ]);
    }
  }

}
