<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Company;

class CompanySeeder extends Seeder {

  private $data = [
    [
      'name'       => 'Murano International Cargo',
      'ruc'        => 'RUC...',
      'direction'  => 'Dirección...',
      'phone_01'   => '04264855600',
      'email_01'   => 'Murano@gmail.com'
    ],
  ];
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run () {
    foreach ( $this->data as $row ) {
      $company = Company::create( $row );
    }
  }
}
