<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\State;

class StateSeeder extends Seeder
{
   private $data = [
    ['name'=> 'Nueva York' ,'country'=> '181','description'=>'Nueva York'],
    ['name'=> 'Florida' ,'country'=> '181','description'=>'Florida'],
    ['name'=> 'Pensilvania' ,'country'=> '181','description'=>'Pensilvania'],
    ['name'=> 'Colorado' ,'country'=> '181','description'=>'Colorado'],
    ['name'=> 'California' ,'country'=> '181','description'=>'California'],
    ['name'=> 'Hawái' ,'country'=> '181','description'=>'Hawái'],
    ['name'=> 'Washington' ,'country'=> '181','description'=>'Washington'],
    ['name'=> 'San Jose' ,'country'=> '38','description'=>'San Jose'],
    ['name'=> 'Alajuela' ,'country'=> '38','description'=>'Alajuela'],
    ['name'=> 'Heredia' ,'country'=> '38','description'=>'Heredia'],
    ['name'=> 'Limón' ,'country'=> '38','description'=>'Limón'],
    ['name'=> 'Bocas del Toro' ,'country'=> '130','description'=>'Bocas del Toro'],
    ['name'=> 'Colón' ,'country'=> '130','description'=>'Colón'],
    ['name'=> 'Chiriquí' ,'country'=> '130','description'=>'Chiriquí'],
    ['name'=> 'Coclé' ,'country'=> '130','description'=>'Coclé'],
    ['name'=> 'Panamá' ,'country'=> '130','description'=>'Panamá'],
    ['name'=> 'Distrito Capital' ,'country'=> '186','description'=>'Distrito Capita'],
    ['name'=> 'Carabobo' ,'country'=> '186','description'=>'Carabobo'],
    ['name'=> 'Anzoategui' ,'country'=> '186','description'=>'Anzoategui'],
    ['name'=> 'Zulia' ,'country'=> '186','description'=>'Zulia']
  	];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
      foreach ($this->data as $key => $value) {
          State::create($value);
      }
    }
}
