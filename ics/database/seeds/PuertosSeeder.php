<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\DetailsTransport;
class PuertosSeeder extends Seeder
{
   private $data = [
    ['code' => 'PRT-0001','name' => 'Puerto 1'    , 'description' => 'Puerto 1'    , 'transport' => 1 ],
    ['code' => 'PRT-0002','name' => 'Puerto 2'    , 'description' => 'Puerto 2'    , 'transport' => 1 ],
    ['code' => 'PRT-0003','name' => 'Aeropuerto 1', 'description' => 'Aeropuerto 1', 'transport' => 2 ],
    ['code' => 'PRT-0004','name' => 'Aeropuerto 2', 'description' => 'Aeropuerto 2', 'transport' => 2 ],
    ['code' => 'PRT-0005','name' => 'Recogida 1'  , 'description' => 'Recogida 1'  , 'transport' => 3 ],
    ['code' => 'PRT-0006','name' => 'Recogida 2'  , 'description' => 'Recogida 2'  , 'transport' => 3 ]
   ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
       foreach ($this->data as $value) {
        DetailsTransport::create([
          'code'        => $value['code'],
          'name'        => $value['name'],
          'description' => $value['description'],
          'transport'   => $value['transport']
        ]);
       }
    }
}
