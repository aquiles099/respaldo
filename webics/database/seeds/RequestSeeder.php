<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Request;

class RequestSeeder extends Seeder {
      private $data= [
        [
          'admin'         => '1',
          'client'        => '1',
          'subject'       => 'Subject to ICS',
          'description'   => 'Request to ICS',
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
        Request::create($row);
      }
    }
}
