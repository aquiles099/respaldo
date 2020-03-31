<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Container;

class ContainerSeeder extends Seeder
{

  private $data = [
    ['CTN-0001' , 'box 1'],
    ['CTN-0002' , 'box 2']
  ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      foreach ($this->data as $row) {
        Container::create([
          'code' => $row[0],
          'name' => $row[1]
        ]);
      }
    }
}
