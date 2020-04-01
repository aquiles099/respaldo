<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\TaxCategory;

class TaxCategorySeeder extends Seeder
{
  private $data = [
    [
      'category' => 1,
      'tax'      => 1
    ]
  ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      foreach ($this->data as $row)
      {
        TaxCategory::create([
          'category' => $row['category'],
          'tax'      => $row['tax']
        ]);
      }
    }
}
