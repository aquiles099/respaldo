<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Client;

class ClientSeeder extends Seeder
{

  private $data= [
      [
        'name'              => 'International Cargo System',
        'admin'             => '1',
        'dni'               => '0123456789',
        'country'           => '186',
        'region'            => 'Bolivar',
        'address'           => 'Puerto ordaz',
        'city'              => 'Ciudad Guayana',
        'postal_code'       => '0158',
        'phone'             => '123456789',
        'email'             => 'info@internationalcargosystem.com',
        'password'          => '12345678',
        'webpage'           => 'www.ics.com',
        'name_manager'      => 'daniel',
        'last_name_manager' => 'sifontes',
        'phone_manager'     => '12345678',
        'status'            => '1',
        'cutoff_date'       => '2017-05-05',
        'email_manager'     => 'danielsifontes@ingbasica.net'
       ],
       [
        'name'              => 'MuranoCargo',
        'admin'             => '1',
        'dni'               => '012345',
        'country'           => '186',
        'region'            => 'Bolivar',
        'address'           => 'Puerto ordaz',
        'city'              => 'Ciudad Guayana',
        'postal_code'       => '0158',
        'phone'             => '123456789',
        'email'             => 'info@muranocargo.com',
        'password'          => '12345678',
        'webpage'           => 'www.muranocargo.com',
        'name_manager'      => 'daniel',
        'last_name_manager' => 'sifontes',
        'phone_manager'     => '12345678',
        'status'            => '4',
        'cutoff_date'       => '2017-05-05',
        'email_manager'     => 'danielsifontes@gmail.net'
       ],
       [
        'name'              => 'DHL',
        'admin'             => '2',
        'dni'               => '51536456',
        'country'           => '181',
        'region'            => 'Bolivar',
        'address'           => 'Puerto ordaz',
        'city'              => 'Ciudad Guayana',
        'postal_code'       => '0158',
        'phone'             => '123456789',
        'email'             => 'ventas@dhl.com',
        'password'          => '12345678',
        'webpage'           => 'www.dhl.com',
        'name_manager'      => 'daniel',
        'last_name_manager' => 'sifontes',
        'phone_manager'     => '12345678',
        'status'            => '2',
        'cutoff_date'       => '2017-05-05',
        'email_manager'     => 'danielsifontes@dhl.net'
       ],
       [
        'name'              => 'Fedex',
        'admin'             => '2',
        'dni'               => '365236895',
        'country'           => '181',
        'region'            => 'Bolivar',
        'address'           => 'Puerto ordaz',
        'city'              => 'Ciudad Guayana',
        'postal_code'       => '0158',
        'phone'             => '123456789',
        'email'             => 'contacto@fedex.com',
        'password'          => '12345678',
        'webpage'           => 'www.muranocargo.com',
        'name_manager'      => 'daniel',
        'last_name_manager' => 'sifontes',
        'phone_manager'     => '12345678',
        'status'            => '3',
        'cutoff_date'       => '2017-05-05',
        'email_manager'     => 'danielsifontes@fedex.net'
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
        Client::create($row);
      }
    }
}
