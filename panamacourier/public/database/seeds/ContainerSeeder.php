<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Container;

class ContainerSeeder extends Seeder
{

  private $data = [
    ['CTN-0001' , '20 Feet 20'."'".'x8'."'".'x 8'."'".'6" Standard Container', '19.4','7.9','7.10','0','7.8','7.6','1172','62130',''],
    ['CTN-0002' , '40 Feet 40'."'".'x8'."'".'x 8'."'".'6" Standard Container', '39.6','7.9','7.10','0','7.8','7.6','2390','63385',''],
    ['CTN-0003' , '40 Feet 40'."'".'x8'."'".'x 9'."'".'6" Standard Container', '39.6','7.9','8.10','0','7.8','8.6','2700','62965',''],

    ['CTN-0004' , '20 Feet 20'."'".'x8'."'".'x 8'."'".'6" Refrigerated Container', '17.10','7.5','7.15','0','7.5','7.5','992','60410',''],
    ['CTN-0005' , '40 Feet 40'."'".'x8'."'".'x 8'."'".'6" Refrigerated Container', '37.11','7.5','7.5','0','7.5','7.3','2075','61070',''],
    ['CTN-0006' , '40 Feet 40'."'".'x8'."'".'x 9'."'".'6" Refrigerated Container', '37.11','7.5','8.4','0','7.5','8.2','2366','64270',''],

    ['CTN-0010' , '20 Feet 20'."'".'x8'."'".'x 8'."'".'6" Open Top Container', '19.4','7.9','7.10','0','7.8','7.6','1172','62130',''],
    ['CTN-0011' , '40 Feet 40'."'".'x8'."'".'x 8'."'".'6" Open Top Container', '39.6','7.9','7.10','0','7.8','7.6','2390','63385',''],
    ['CTN-0012' , '40 Feet 40'."'".'x8'."'".'x 9'."'".'6" Open Top Container', '39.6','7.9','8.10','0','7.8','8.6','2700','62965',''],

    ['CTN-0013' , '20 Feet 20'."'".' Non-Collapsible Flatrack', '19.4','7.9','7.10','0','7.8','7.6','1172','62130',''],
    ['CTN-0014' , '40 Feet 40'."'".' Non-Collapsible Flatrack', '39.6','7.9','7.10','0','7.8','7.6','2390','63385',''],

    ['CTN-0015' , '20 Feet 20'."'".' Platform', '19.4','7.9','7.10','0','7.8','7.6','1172','62130',''],
    ['CTN-0016' , '40 Feet 40'."'".' Platform', '39.6','7.9','7.10','0','7.8','7.6','2390','63385',''],

    ['CTN-0017' , '20 Feet 20'."'".' Bulk Carrier Container', '19.4','7.9','7.10','0','7.8','7.6','1172','62130','']
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
          'name' => $row[1],
          'large' => $row[2],
          'width' => $row[3],
          'height' => $row[4],
          'unidad' => $row[5],
          'large_door' => $row[6],
          'widht_door' => $row[7],
          'cube_capacity' => $row[8],
          'max_weight' => $row[9],
          'info' => $row[10]
        ]);
      }
    }
}
