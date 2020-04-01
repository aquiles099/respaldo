<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Status;

class StatusSeeder extends Seeder {
  private $data= [
    ['name' => 'Activo'               , 'description' => 'nuevo'],
    ['name' => 'Inactivo'             , 'description' => 'viejo'],
    ['name' => 'Por vencer'           , 'description' => 'viejo'],
    ['name' => 'Vencido'              , 'description' => 'viejo'],
    ['name' => 'Prorrogado'           , 'description' => 'viejo'],
    ['name' => 'Generada'             , 'description' => 'Pertinente a Solicitudes'],
    ['name' => 'Formulario Enviado'   , 'description' => 'Pertinente a Solicitudes'],
    ['name' => 'Formulario Recibido'  , 'description' => 'Pertinente a Solicitudes'],
    ['name' => 'En Curso'             , 'description' => 'Pertinente a Solicitudes'],
    ['name' => 'Procesada'            , 'description' => 'Pertinente a Solicitudes'],
    ['name' => 'Aprobada'             , 'description' => 'Pertinente a Solicitudes'],
    ['name' => 'Negada'               , 'description' => 'Pertinente a Solicitudes'],
    ['name' => 'Pagado'               , 'description' => 'Pertinente a Pruebas'],
    ['name' => 'Contratado'           , 'description' => 'Pertinente a Pruebas']
 ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
      foreach ($this->data as $key => $value) {
        Status::create($value);
      }
    }
}
