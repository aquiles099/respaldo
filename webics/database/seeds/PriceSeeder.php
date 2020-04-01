<?php

use Illuminate\Database\Seeder;
use App\Helpers\HProfileType;
use App\Helpers\HYears;
use App\Models\Admin\Price;

class PriceSeeder extends Seeder {

  private $data = [
    ['type' => HProfileType::BASIC,        'years' => HYears::ONE,     'monthly' => 29.99, 'annual' => 359.88],
    ['type' => HProfileType::BASIC,        'years' => HYears::TWO,     'monthly' => 44.99, 'annual' => 299.88],
    ['type' => HProfileType::BASIC,        'years' => HYears::TRHEE,   'monthly' => 22.50, 'annual' => 270   ],
    ['type' => HProfileType::PROFESSIONAL, 'years' => HYears::ONE,     'monthly' => 49.99, 'annual' => 599.88],
    ['type' => HProfileType::PROFESSIONAL, 'years' => HYears::TWO,     'monthly' => 44.99, 'annual' => 539.88],
    ['type' => HProfileType::PROFESSIONAL, 'years' => HYears::TRHEE,   'monthly' => 42.50, 'annual' => 510   ]
 ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run () {
      foreach ($this->data as $row) {
        Price::create($row);
      }
    }
}
