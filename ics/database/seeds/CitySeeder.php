<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\City;

class CitySeeder extends Seeder
{
  private $data = [
    ['code'=> 'CIT-0001','name'=> 'Valencia','country'=> '186','state'=>'18', 'description'=>'test_descripton_city1'],
    ['code'=> 'CIT-0001','name'=> 'Pto la Cruz','country'=> '186','state'=>'19', 'description'=>'test_descripton_city1'],
    ['code'=> 'CIT-0001','name'=> 'Maracaibo','country'=> '186','state'=>'20', 'description'=>'test_descripton_city1'],
    ['code'=> 'CIT-0002','name'=> 'Los Angeles','country'=> '181','state'=>'5', 'description'=>'test_descripton_city2'],
    ['code'=> 'CIT-0003','name'=> 'San Francisco','country'=> '181','state'=>'5', 'description'=>'SF']
  ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
      foreach ($this->data as $key => $value) {
          City::create($value);
      }
    }
}
