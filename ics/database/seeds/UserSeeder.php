<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\User;

class UserSeeder extends Seeder {

 private $data= [
   [
     'code'           => 'USR-0001',
     'name'           => 'test_name',
     'last_name'      => 'test_last_name',
     'dni'            => '0123456789',
     'country'        => 'test_country',
     'region'         => 'test_region',
     'address'        => 'test_address',
     'city'           => 'test_city',
     'postal_code'    => 'test_postal_code',
     'local_phone'    => 'test_local_phone',
     'celular'        => 'test_celular',
     'email'          => 'test_email',
     'password'       => 'test_password',
     'company'        => '1',
     'user_type'      => '1',
     'active'         => '1',
     'remember_token' => 'test_remembertoken'
    ]
];
  /**
   * Run the database seeds.
   *
   * @return void
   */
public function run() {
    foreach ($this->data as $row) {
      User::create($row);
    }
  }
}
