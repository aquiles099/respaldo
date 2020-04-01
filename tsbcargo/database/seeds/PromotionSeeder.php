<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Promotion;

class PromotionSeeder extends Seeder
{
    private $data = [
      [
        'name'        =>    'promocion nueva',
        'type_value'  =>    '0', 
        'value'       =>    2.0, 
        'user_type'   =>    1, 
        'transport'   =>    1,
        'start_date'  =>    '12/03/2016',
        'end_date'    =>    '12/03/2016'
      ]
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
     foreach ($this->data as $row) {
        Promotion::create([
          'name'          => $row['name'],
          'type_value'    => $row['type_value'],
          'value'         => $row['value'],
          'user_type'     => $row['user_type'],
          'transport'     => $row['transport'],
          'start_date'    => $row['start_date'],
          'end_date'      => $row['end_date']
        ]);
      }
    }
}
