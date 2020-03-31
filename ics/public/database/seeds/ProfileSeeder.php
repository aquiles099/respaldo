<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Security\Profile;
use App\Models\Admin\Security\Role;

class ProfileSeeder extends Seeder
{
	private $rows = [
    	['PRF-0001', 'Administrador', true]
  	];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      foreach($this->rows as $row) {
     	$profile = Profile::create([
				'code' => $row[0],
        'name' => $row[1]
      	]);
				/**
				*
				*/
      	$list = [];
      	if(is_bool($row[2]) && $row[2]) {
        	foreach (Role::all() as $role) {
          	$list[] = $role->id;
        	}
      	}
				/**
				*
				*/
     	$profile->roles()->attach(array_unique($list));
    	}
    }
}
