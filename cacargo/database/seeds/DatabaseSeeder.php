<?php

use Illuminate\Database\Seeder;

/**
 *
 */
class DatabaseSeeder extends Seeder {

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    $this->call(OperatorSeeder::class);
    //$this->call(CompanySeeder::class);
    //$this->call(ClientSeeder::class);
    $this->call(UserTypeSeeder::class);
    $this->call(UserSeeder::class);
    $this->call(CountrySeeder::class);
    $this->call(OfficeSeeder::class);
    $this->call(TaxSeeder::class);
    $this->call(AccessSeeder::class);
    $this->call(ProfileSeeder::class);
    $this->call(RoleSeeder::class);
    $this->call(TransportSeeder::class);
    $this->call(CourierSeeder::class);
    $this->call(CategorySeeder::class);
    $this->call(PriceGroupSeeder::class);
    $this->call(EventSeeder::class);
    $this->call(PromotionSeeder::class);
    $this->call(ProfileRoleSeeder::class);
    $this->call(ConfigurationSeeder::class);
    $this->call(StoreSeeder::class);
    $this->call(AddChargers::class);

  }

}
