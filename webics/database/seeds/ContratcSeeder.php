<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Contract;

class ContratcSeeder extends Seeder
{
  private $data= [
    [
      'code'            => 'CTC-0001',
      'solicitude'         => '1',
      'status'          => '1',
      'register_date'   => '25/03/217',
      'cut_off_date'    => '25/03/2017',
      'version'         => 'ICS MACRO v2.0'
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
    Contract::create($row);
  }
}
}
