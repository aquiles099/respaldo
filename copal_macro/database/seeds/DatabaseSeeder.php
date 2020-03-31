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
  //  $this->call(StatusSeeder::class);
    $this->call(OperatorSeeder::class);
    $this->call(CompanySeeder::class);
    $this->call(ClientSeeder::class);
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
    /*$this->call(PackageSeeder::class);
    $this->call(FromCouriersSeeder::class);
    $this->call(FromCompaniesSeeder::class);*/
    $this->call(PriceGroupSeeder::class);
    $this->call(EventSeeder::class);
   /* $this->call(LogSeeder::class);
    $this->call(ConsolidatedSeeder::class);
    $this->call(PackageConsolidatedSeeder::class);*/
    $this->call(PromotionSeeder::class);
    $this->call(ConfigurationSeeder::class);
    $this->call(TaxCategorySeeder::class);
    $this->call(ServiceSeeder::class);
    $this->call(AddChargerSeeder::class);
    $this->call(ContainerSeeder::class);
    $this->call(ProfileRoleSeeder::class);
    $this->call(TypePickupSeeder::class);
    $this->call(NumberPartsseeder::class);
    $this->call(StateSeeder::class);
    $this->call(CitySeeder::class);
    $this->call(RouteSeeder::class);
    $this->call(VesselSeeder::class);
    $this->call(PuertosSeeder::class);
    $this->call(TypeTransportSeeder::class);
  }
}
