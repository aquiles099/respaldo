<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Company;

class CompanySeeder extends Seeder {

  private $data = [
    [
      'id'         => 0,
      'name'       => 'Murano International Cargo',
      'ruc'        => 'RUC...',
      'direction'  => 'Dirección...',
      'phone_01'   => '04264855600',
      'email_01'   => 'Murano@gmail.com'
    ],
    [
      'id'         => 4000,
      'name'       => 'BoxShop',
      'ruc'        => 'RUC...',
      'direction'  => 'Dirección...',
      'phone_01'   => '04264855600',
      'email_01'   => 'BOXshop@gmail.com'
    ],
    [
      'id'         => 6000,
      'name'       => 'Panama Shop',
      'ruc'        => 'RUC...',
      'direction'  => 'Dirección...',
      'phone_01'   => '04264855600',
      'email_01'   => 'panamashop@gmail.com'
    ],
    [
      'id'         => 7000,
      'name'       => 'Miami Shop',
      'ruc'        => 'RUC...',
      'direction'  => 'Dirección...',
      'phone_01'   => '04264855600',
      'email_01'   => 'miamishop@gmail.com'
    ]

  ];
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    foreach ($this->data as $row) {
      $company = Company::create($row);
    }
    ////////////////////////////////////////////////////////////////////////////
   /* for( $i = 0; $i < 10; $i++) {
      Company::create([
        'name'       => 'BoxShop',
        'ruc'        => 'RUC...',
        'direction'  => 'Dirección...',
        'phone_01'   => '04264855600',
        'email_01'   => 'BOXshop@gmail.com'
      ]);
    }*/
    ////////////////////////////////////////////////////////////////////////////
  }
}
