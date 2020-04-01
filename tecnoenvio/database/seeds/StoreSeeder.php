<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Store;

class StoreSeeder extends Seeder {
  private $data = [
    ['code' => 'STO-0001', 'name' => 'Amazon'  , 'description' => 'Tienda Virtual'],
    ['code' => 'STO-0002', 'name' => 'Ebay'    , 'description' => 'Tienda Virtual'],
    ['code' => 'STO-0003', 'name' => 'Ali-Baba', 'description' => 'Tienda Virtual']
  ];
    public function run() {
      foreach($this->data as $key => $value ) {
        $store = Store::create($value);
      }
    }
}
