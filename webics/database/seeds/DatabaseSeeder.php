<?php
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run () {
        $this->call(CountrySeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(UserTypeSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ClientSeeder::class);
        $this->call(SolicitudeSeeder::class);
        $this->call(NoticeSeeder::class);
        $this->call(PriceSeeder::class);
        $this->call(MenuItemSeeder::class);
        $this->call(UserAccessSeeder::class);
    }
}
