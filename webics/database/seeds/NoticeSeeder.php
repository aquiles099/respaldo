<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Notice;
class NoticeSeeder extends Seeder {
    private $data= [
  	
  	];
    /**
    *
    */
    public function run() {
      foreach ($this->data as $row) {
        Notice::create($row);
      }
    }
}
