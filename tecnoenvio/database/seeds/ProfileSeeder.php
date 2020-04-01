<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Security\Profile;
use App\Models\Admin\Security\Role;

class ProfileSeeder extends Seeder
{
	private $rows = [
    	[ 'Administrador', true]
  	];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        foreach($this->rows as $row) {
     	$profile = Profile::create([
        'name' => $row[0]
      	]);
      	$list = [];
      	if(is_bool($row[1]) && $row[1]) {
        	foreach (Role::all() as $role) {
          	$list[] = $role->id;
        	}
      	}
     	$profile->roles()->attach(array_unique($list));
    	}
    }
}
