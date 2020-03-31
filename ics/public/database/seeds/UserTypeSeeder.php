<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Security\UserType;

class UserTypeSeeder extends Seeder {

  private $data = [
    ['Persona Natural'    , 'Natural Person'],
    ['Empresa'            , 'Company'],
    ['Empresa Revendedora', 'Reseller'],
    ['Operador'           , 'Operator']
  ];

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    foreach ($this->data as $row) {
      UserType::create([
        'spanish' => $row[0],
        'english' => $row[1]
      ]);
    }
  }

}
