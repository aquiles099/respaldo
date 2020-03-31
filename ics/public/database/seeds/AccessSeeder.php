<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Security\Access;

class AccessSeeder extends Seeder {

  private $rows = [
    ['code'=>'PRM-0001', 'name'=>'Administracion de Dasboard'],
    ['code'=>'PRM-0002', 'name'=>'Administracion de Paquetes'],
    ['code'=>'PRM-0003', 'name'=>'Administracion de Consolidados'],
    ['code'=>'PRM-0004', 'name'=>'Administracion de Facturacion'],
    ['code'=>'PRM-0005', 'name'=>'Administracion de Reportes'],
    ['code'=>'PRM-0006', 'name'=>'Administracion de General'],
    ['code'=>'PRM-0007', 'name'=>'Administracion de Seguridad'],
    ['code'=>'PRM-0008', 'name'=>'Administracion de Atencion al Cliente'],
    ['code'=>'PRM-0009', 'name'=>'Administracion de Bookings'],
    ['code'=>'PRM-000A', 'name'=>'Administracion de Pickup Orders'],
    ['code'=>'PRM-000B', 'name'=>'Administracion de Master Bill of Lading'],
    ['code'=>'PRM-000C', 'name'=>'Administracion de Cargo Release'],
    ['code'=>'PRM-000D', 'name'=>'Administracion de Shipments'],
    ['code'=>'PRM-000E', 'name'=>'Administracion de Proveedores'],
    ['code'=>'PRM-000F', 'name'=>'Administracion de Transporte'],
    ['code'=>'PRM-000G', 'name'=>'Administracion de Membresia']
  ];
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    foreach($this->rows as $row) {
      Access::create([
        'code' => $row['code'],
        'name' => $row['name']
      ]);
    }
  }

}
