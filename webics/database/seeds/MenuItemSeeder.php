<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\ItemMenu;
class MenuItemSeeder extends Seeder
{
  private $data= [
    [
      'icon'              => 'fa fa-user fa-fw',
      'description'       => 'Posibles Clientes',
      'path'              => 'admin/users'
    ],
    [
      'icon'              => 'fa fa-bullhorn fa-fw',
      'description'       => 'Solicitud de Prueba',
      'path'              => 'admin/solicitudes'
    ],
    [
      'icon'              => 'fa fa-inbox',
      'description'       => 'Contacto Web',
      'path'              => 'admin/contacts'
    ],
    [
      'icon'              => 'fa fa-search',
      'description'       => 'Pruebas',
      'path'              => 'admin/test'
    ],
    [
      'icon'              => 'fa fa-handshake-o fa-fw',
      'description'       => 'Clientes',
      'path'              => 'admin/contracts'
    ],
    [
      'icon'              => 'fa fa-money fa-fw',
      'description'       => 'Pagos',
      'path'              => 'admin/payments'
    ],
    [
      'icon'              => 'fa fa-users fa-fw',
      'description'       => 'Usuarios',
      'path'              => 'admin/users'
    ],
    [
      'icon'              => 'fa fa-file-text-o fa-fw',
      'description'       => 'Noticias',
      'path'              => 'admin/notices'
    ],
    [
      'icon'              => 'fa fa-line-chart fa-fw',
      'description'       => 'Actividad',
      'path'              => 'admin/activity'
    ],
    [
      'icon'              => 'fa fa-usd fa-fw',
      'description'       => 'Precios',
      'path'              => 'admin/prices'
    ],
    [
      'icon'              => 'fa fa-envelope fa-fw',
      'description'       => 'Correos',
      'path'              => 'admin/mails'
    ]
 ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      foreach ($this->data as $row) {
        ItemMenu::create($row);
      }  //
    }
}
