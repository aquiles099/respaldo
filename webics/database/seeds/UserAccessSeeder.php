<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\UserAccess;


class UserAccessSeeder extends Seeder
{
  private $data= [
    [
      'user'       => '1',
      'item'       => '1'
    ],
    [
      'user'       => '1',
      'item'       => '2'
    ],
    [
      'user'       => '1',
      'item'       => '3'
    ],
    [
      'user'       => '1',
      'item'       => '4'
    ],
    [
      'user'       => '1',
      'item'       => '5'
    ],
    [
      'user'       => '1',
      'item'       => '6'
    ],
    [
      'user'       => '1',
      'item'       => '7'
    ],
    [
      'user'       => '1',
      'item'       => '8'
    ],
    [
      'user'       => '1',
      'item'       => '9'
    ],
    [
      'user'       => '1',
      'item'       => '10'
    ],
    [
      'user'       => '1',
      'item'       => '11'
    ],
    [
      'user'       => '2',
      'item'       => '2'
    ],
    [
      'user'       => '2',
      'item'       => '5'
    ],
    [
      'user'       => '2',
      'item'       => '7'
    ],
    [
      'user'       => '3',
      'item'       => '1'
    ],
    [
      'user'       => '3',
      'item'       => '3'
    ],
    [
      'user'       => '3',
      'item'       => '6'
    ],
    [
      'user'       => '3',
      'item'       => '9'
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
        UserAccess::create($row);
      }
    }
}
