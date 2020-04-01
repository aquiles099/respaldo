<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\UserType;

class UserTypeSeeder extends Seeder
{
  private $data= [
    [
      'name' => 'master',
      'description' => 'Administrador con dominio total'
    ],
    [
      'name' => 'vendedor',
      'description' => 'Administrador con dominio limitado solo a sus clientes'
    ],
    [
      'name' => 'editor',
      'description' => 'administrador con acceso a redactar noticias'
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
        UserType::create($row);
      }
    }
}
