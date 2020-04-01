<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Security\Access;
use App\Models\Admin\Security\Role;

class RoleSeeder extends Seeder {

  private $rows = [
    ['ROL-0001', 'Administrador', true]
  ];

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    foreach($this->rows as $row) {
      $role = Role::create([
        'code' => $row[0],
        'name' => $row[1]
      ]);
      $list = [];
      if(is_bool($row[2]) && $row[2]) {
        foreach (Access::all() as $access) {
          $list[] = $access->id;
        }
      }
      $role->access()->attach(array_unique($list));
    }
  }
}
