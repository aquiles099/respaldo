<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Route;

class RouteSeeder extends Seeder
{
  private $data = [
    ['code'=> 'ROU-0001','name'=> 'test_route_1','transport'=> '1' ,'origin_country'=> '1','origin_city'=> '1','destiny_country'=> '2','destiny_city'=> '1','description'=>'test_descripton_route1'],
    ['code'=> 'ROU-0002','name'=> 'test_route_2','transport'=> '2' ,'origin_country'=> '2','origin_city'=> '2','destiny_country'=> '2','destiny_city'=> '2','description'=>'test_descripton_route2'],
    ['code'=> 'ROU-0003','name'=> 'test_route_2','transport'=> '3' ,'origin_country'=> '2','origin_city'=> '3','destiny_country'=> '2','destiny_city'=> '3','description'=>'test_descripton_route3']
  ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
      foreach ($this->data as $key => $value) {
          Route::create($value);
      }
    }
}
