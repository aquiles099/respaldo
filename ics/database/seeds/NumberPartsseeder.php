<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\NumberParts;

class NumberPartsseeder extends Seeder
{
	private $data = [
    [
      'name'                => 'Celulares',
      'description'         => 'Celulares',
      'model'               => 'GT-B678',
      'customer'            => 'SVM',
      'manufacturer'        => 'Kudai',
      'package'             => 'WR-F458',
      'note'                => 'Sin novedad',
      'large'               => '20',
      'width'               => '20',
      'height'              => '20',
      'weight'              => '20',
      'volumetricweightm'   => '30',
      'volumetricweighta'   => '35',
      'pieces'              => '20',
      'sku'                 => 'KKJIJ'

    ],
    [
      'name'                => 'Zapatos',
      'description'         => 'Zapatos Adidas',
      'model'               => 'BLACL-8596',
      'customer'            => 'SVMBLACK',
      'manufacturer'        => 'Sin Despertar',
      'package'             => 'WR-0024',
      'note'                => 'Sin novedad',
      'large'               => '50',
      'width'               => '80',
      'height'              => '10',
      'weight'              => '60',
      'volumetricweightm'   => '95',
      'volumetricweighta'   => '91',
      'pieces'              => '30',
      'sku'                 => 'WWWWXXX'
    ]
    

  ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       foreach ($this->data as $row) {
	      $addnumberparts = NumberParts::create($row);
	     }
    }
}
