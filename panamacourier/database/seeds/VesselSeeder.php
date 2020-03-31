<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Vessel;

class VesselSeeder extends Seeder
{
  /**
  *
  */
  private $data = [
    ['code'=> 'VES-0001','name'=> 'test_vessel_1','flag' => 'test_flag' ,'country'=> 1,'city'=> 1],
    ['code'=> 'VES-0002','name'=> 'test_vessel_2','flag' => 'test_flag' ,'country'=> 2,'city'=> 1]
  ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      foreach ($this->data as $key => $value) {
          Vessel::create([
            'name'    => $value['name'],
            'flag'    => $value['flag'],
            'country' => $value['country'],
            'city'    => $value['city']
          ]);
      }
    }
}
