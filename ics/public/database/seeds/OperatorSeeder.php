<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Operator;

class OperatorSeeder extends Seeder {

  private $data = [
    [
      'username' => 'admin',
      'name'     => 'Administrador',
      'email'    => 'administrador@muranocargo.com',
      'lastname' => null,
      'profile'  => '1',
      'active'   => '1' 
    ]
  ];

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    foreach ($this->data as $key => $row) {
      Operator::create([
        'id'        => $key + 1,
        'password'  => '12345678',
        'name'      => $row['name'],
        'username'  => $row['username'],
        'lastname'  => $row['lastname'],
        'email'     => $row['email'],
        'profile'   => $row['profile'],
        'active'    => $row['active']
      ]);
    }
  }
}
