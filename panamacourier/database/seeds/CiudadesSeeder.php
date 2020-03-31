<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Ciudad;

class CiudadesSeeder extends Seeder {
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    echo "Ejecutando ".'http://macro.internationalcargosystem.com'.'/tmpreport'."/client.txt";
    $archivo = file('http://macro.internationalcargosystem.com'.'/tmpreport'."/client.txt");
    $lineas = count( $archivo );
    for( $i = 0; $i < $lineas; $i++ ){
      $str = $archivo[$i];
      $row = explode(" ",$str);
      $percent = ($i / $lineas) * 100;
      echo("Progreso--> ".number_format($percent,0,',','.').'%'."\n");
      Ciudad::create([
        'id'        => $row[0],
        'code'      => $row[1],
        'name'      => $row[2]
      ]);
    }
  }
}
