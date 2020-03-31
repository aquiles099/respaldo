<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\TransportType;

class TypeTransportSeeder extends Seeder
{
  private $data = [
    ['name' => 'barcaza', 'transport' => '1', 'description' => 'mi barcaza'],
    ['name' => 'helicoptero', 'transport' => '2', 'description' => 'mi helicoptero'],
    ['name' => 'camion', 'transport' => '3', 'description' => 'mi camion']
  ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
      foreach ($this->data as $key => $value) {
        TransportType::create($value);
      }
    }
}
