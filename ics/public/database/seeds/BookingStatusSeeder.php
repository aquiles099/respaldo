<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\BookingStatus;

class BookingStatusSeeder extends Seeder {
  private $data = [
   ['name'=> 'Estatus 1' ,'description'=>'Descripcion del estado', 'notification' => '','step' => '','active'=>'1'],
   ['name'=> 'Estatus 2' ,'description'=>'Descripcion del estado', 'notification' => '','step' => '','active'=>'1'],
   ['name'=> 'Estatus 3' ,'description'=>'Descripcion del estado', 'notification' => '','step' => '','active'=>'1'],
   ['name'=> 'Estatus 4' ,'description'=>'Descripcion del estado', 'notification' => '','step' => '','active'=>'1'],
   ['name'=> 'Estatus 5' ,'description'=>'Descripcion del estado', 'notification' => '','step' => '','active'=>'1'],
   ['name'=> 'Estatus 6' ,'description'=>'Descripcion del estado', 'notification' => '','step' => '','active'=>'1']
  ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      foreach ($this->data as $key => $value) {
          BookingStatus::create($value);
      }
    }

}
