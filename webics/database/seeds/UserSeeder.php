<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\User;

class UserSeeder extends Seeder {
  private $data= [
    [
      'name'              => 'Daniel Sifontes',
      'email'             => 'info@internationalcargosystem.com',
      'password'          => '12345678',
      'phone'             => '123456789',
      'user_type'         => '1'
    ],
    [
      'name'              => 'Victor Smith',
      'email'             => 'smith@gmail.com',
      'password'          => '12345678',
      'phone'             => '123456789',
      'user_type'         => '2'
    ],
    [
      'name'              => 'Angel Barreto',
      'email'             => 'angel@gmail.com',
      'password'          => '12345678',
      'phone'             => '123456789',
      'user_type'         => '3'
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
