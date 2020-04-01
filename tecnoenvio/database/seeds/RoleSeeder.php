<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Security\Access;
use App\Models\Admin\Security\Role;

class RoleSeeder extends Seeder {

  private $rows = [
    [ 'Administrador', true]
  ];

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    foreach($this->rows as $row) {
      $role = Role::create([
        'name' => $row[0]
      ]);
      $list = [];
      if(is_bool($row[1]) && $row[1]) {
        foreach (Access::all() as $access) {
          $list[] = $access->id;
        }
      }
      $role->access()->attach(array_unique($list));
    }
  }
}
