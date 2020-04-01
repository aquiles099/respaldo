<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\ProfileRole;

class ProfileRoleSeeder extends Seeder
{
  private $data = [
    [
      'profile'        => '1',
      'role'           => '1'
    ]
  ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      foreach ($this->data as $key => $value)
      {
        ProfileRole::create([
          'profile' => $value['profile'],
          'role'    => $value['role']
        ]);
      }
    }
}
