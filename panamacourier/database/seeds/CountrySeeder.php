<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Country;

class CountrySeeder extends Seeder {

  private $data = [
    [
      'name' => 'Afghanistan',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Albania',
      'dhl_zone' => '6',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Alemania',
      'dhl_zone' => '',
      'fedex_zone' => 'F'
    ],
    [
      'name' => 'Algeria',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'American Samoa',
      'dhl_zone' => '5',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Andorra',
      'dhl_zone' => '5',
      'fedex_zone' => 'F'
    ],
    [
      'name' => 'Angola',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Anguilla',
      'dhl_zone' => '4',
      'fedex_zone' => 'E'
    ],
    [
      'name' => 'Antigua',
      'dhl_zone' => '4',
      'fedex_zone' => 'E'
    ],
    [
      'name' => 'Argentina',
      'dhl_zone' => '3',
      'fedex_zone' => 'D'
    ],
    [
      'name' => 'Armenia',
      'dhl_zone' => '6',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Aruba',
      'dhl_zone' => '4',
      'fedex_zone' => 'E'
    ],
    [
      'name' => 'Australia',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Austria',
      'dhl_zone' => '5',
      'fedex_zone' => 'F'
    ],
    [
      'name' => 'Azerbaijan',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Bahamas',
      'dhl_zone' => '4',
      'fedex_zone' => 'E'
    ],
    [
      'name' => 'Bahrain',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Bangladesh',
      'dhl_zone' => '6',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Barbados',
      'dhl_zone' => '4',
      'fedex_zone' => 'E'
    ],
    [
      'name' => 'Belarus',
      'dhl_zone' => '6',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Belgium',
      'dhl_zone' => '5',
      'fedex_zone' => 'F'
    ],
    [
      'name' => 'Belize',
      'dhl_zone' => '4',
      'fedex_zone' => 'A'
    ],
    [
      'name' => 'Benin',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Bermuda',
      'dhl_zone' => '4',
      'fedex_zone' => 'E'
    ],
    [
      'name' => 'Bhutan',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Bolivia',
      'dhl_zone' => '3',
      'fedex_zone' => 'D'
    ],
    [
      'name' => 'Bonaire',
      'dhl_zone' => '4',
      'fedex_zone' => 'E'
    ],
    [
      'name' => 'Bosnia and Herzegovina',
      'dhl_zone' => '6',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Brazil',
      'dhl_zone' => '3',
      'fedex_zone' => 'D'
    ],
    [
      'name' => 'Brunei',
      'dhl_zone' => '7',
      'fedex_zone' => 'G'
    ],
    [
      'name' => 'Bulgaria',
      'dhl_zone' => '5',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Burkina Faso',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Burundi',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Cambodia',
      'dhl_zone' => '6',
      'fedex_zone' => 'G'
    ],
    [
      'name' => 'Cameroon',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Canada',
      'dhl_zone' => '2',
      'fedex_zone' => 'C'
    ],
    [
      'name' => 'Canary Islands',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Cape Verde',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Cayman Islands',
      'dhl_zone' => '4',
      'fedex_zone' => 'E'
    ],
    [
      'name' => 'Central African Republic',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Chad',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Chile',
      'dhl_zone' => '3',
      'fedex_zone' => 'D'
    ],
    [
      'name' => 'China',
      'dhl_zone' => '6',
      'fedex_zone' => 'G'
    ],
    [
      'name' => 'Colombia',
      'dhl_zone' => '1',
      'fedex_zone' => 'D'
    ],
    [
      'name' => 'Comoros',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Congo (Brazzaville)',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Congo',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Cook Islands',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Costa Rica',
      'dhl_zone' => '7',
      'fedex_zone' => 'A'
    ],
    [
      'name' => 'Cote d Ivoire',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Croatia',
      'dhl_zone' => '5',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Cuba',
      'dhl_zone' => '4',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Curacao',
      'dhl_zone' => '4',
      'fedex_zone' => 'E'
    ],
    [
      'name' => 'Cyprus',
      'dhl_zone' => '5',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Czech Republic',
      'dhl_zone' => '5',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Denmark',
      'dhl_zone' => '5',
      'fedex_zone' => 'F'
    ],
    [
      'name' => 'Djibouti',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Dominica',
      'dhl_zone' => '4',
      'fedex_zone' => 'E'
    ],
    [
      'name' => 'Dominican Republic',
      'dhl_zone' => '1',
      'fedex_zone' => 'E'
    ],
    [
      'name' => 'East Timor (Timor Timur)',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Ecuador',
      'dhl_zone' => '3',
      'fedex_zone' => 'D'
    ],
    [
      'name' => 'Egypt',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'El Salvador',
      'dhl_zone' => '1',
      'fedex_zone' => 'A'
    ],
    [
      'name' => 'Equatorial Guinea',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Eritrea',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Estonia',
      'dhl_zone' => '5',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Ethiopia',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Falkland Islands',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Feroe Islands',
      'dhl_zone' => '6',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Fiji',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Finland',
      'dhl_zone' => '5',
      'fedex_zone' => 'F'
    ],
    [
      'name' => 'France',
      'dhl_zone' => '5',
      'fedex_zone' => 'F'
    ],
    [
      'name' => 'French Guyana',
      'dhl_zone' => '4',
      'fedex_zone' => 'D'
    ],
    [
      'name' => 'Gabon',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Gambia, The',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Georgia',
      'dhl_zone' => '6',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Germany',
      'dhl_zone' => '5',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Ghana',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Gibraltar',
      'dhl_zone' => '6',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Greece',
      'dhl_zone' => '5',
      'fedex_zone' => 'F'
    ],
    [
      'name' => 'Greenland',
      'dhl_zone' => '6',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Grenada',
      'dhl_zone' => '4',
      'fedex_zone' => 'E'
    ],
    [
      'name' => 'Guadeloupe',
      'dhl_zone' => '4',
      'fedex_zone' => 'E'
    ],
    [
      'name' => 'Guam',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Guatemala',
      'dhl_zone' => '1',
      'fedex_zone' => 'A'
    ],
    [
      'name' => 'Guernsey',
      'dhl_zone' => '6',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Guinea',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Guinea-Bissau',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Guyana',
      'dhl_zone' => '4',
      'fedex_zone' => 'D'
    ],
    [
      'name' => 'Haiti',
      'dhl_zone' => '4',
      'fedex_zone' => 'E'
    ],
    [
      'name' => 'Honduras',
      'dhl_zone' => '1',
      'fedex_zone' => 'A'
    ],
    [
      'name' => 'Hungary',
      'dhl_zone' => '5',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Hong Kong',
      'dhl_zone' => '5',
      'fedex_zone' => 'G'
    ],
    [
      'name' => 'Iceland',
      'dhl_zone' => '6',
      'fedex_zone' => 'F'
    ],
    [
      'name' => 'India',
      'dhl_zone' => '6',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Indonesia',
      'dhl_zone' => '6',
      'fedex_zone' => 'G'
    ],
    [
      'name' => 'Iran',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Iraq',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Ireland',
      'dhl_zone' => '5',
      'fedex_zone' => 'F'
    ],
    [
      'name' => 'Israel',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Italy',
      'dhl_zone' => '5',
      'fedex_zone' => 'F'
    ],
    [
      'name' => 'Jamaica',
      'dhl_zone' => '3',
      'fedex_zone' => 'E'
    ],
    [
      'name' => 'Japan',
      'dhl_zone' => '6',
      'fedex_zone' => 'G'
    ],
    [
      'name' => 'Jordan',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Kazakhstan',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Kenya',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Kiribati',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Korea, North',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Korea, South',
      'dhl_zone' => '6',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Kosovo',
      'dhl_zone' => '6',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Kuwait',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Kyrgyzstan',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Laos',
      'dhl_zone' => '6',
      'fedex_zone' => 'G'
    ],
    [
      'name' => 'Latvia',
      'dhl_zone' => '6',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Lebanon',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Lesotho',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Liberia',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Libya',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Liechtenstein',
      'dhl_zone' => '5',
      'fedex_zone' => 'F'
    ],
    [
      'name' => 'Lithuania',
      'dhl_zone' => '5',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Luxembourg',
      'dhl_zone' => '5',
      'fedex_zone' => 'F'
    ],
    [
      'name' => 'Macau',
      'dhl_zone' => '7',
      'fedex_zone' => 'G'
    ],
    [
      'name' => 'Macedonia',
      'dhl_zone' => '6',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Madagascar',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Malawi',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Malaysia',
      'dhl_zone' => '6',
      'fedex_zone' => 'G'
    ],
    [
      'name' => 'Maldives',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Mali',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Malta',
      'dhl_zone' => '5',
      'fedex_zone' => 'F'
    ],
    [
      'name' => 'Marshall Islands',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Mauritania',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Mauritius',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Mexico',
      'dhl_zone' => '3',
      'fedex_zone' => 'C'
    ],
    [
      'name' => 'Micronesia',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Moldova',
      'dhl_zone' => '6',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Monaco',
      'dhl_zone' => '5',
      'fedex_zone' => 'F'
    ],
    [
      'name' => 'Mongolia',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Montenegro',
      'dhl_zone' => '6',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Monsterrat',
      'dhl_zone' => '4',
      'fedex_zone' => 'E'
    ],
    [
      'name' => 'Morocco',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Mozambique',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Myanmar',
      'dhl_zone' => '6',
      'fedex_zone' => 'G'
    ],
    [
      'name' => 'Namibia',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Nauru',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Nepal',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Netherlands',
      'dhl_zone' => '5',
      'fedex_zone' => 'F'
    ],
    [
      'name' => 'New Zealand',
      'dhl_zone' => '7',
      'fedex_zone' => 'G'
    ],
    [
      'name' => 'Nicaragua',
      'dhl_zone' => '1',
      'fedex_zone' => 'A'
    ],
    [
      'name' => 'Niger',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Nigeria',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Norway',
      'dhl_zone' => '6',
      'fedex_zone' => 'F'
    ],
    [
      'name' => 'Oman',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Pakistan',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Palau',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Panama',
      'dhl_zone' => '0',
      'fedex_zone' => '0'
    ],
    [
      'name' => 'Papua New Guinea',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Paraguay',
      'dhl_zone' => '3',
      'fedex_zone' => 'D'
    ],
    [
      'name' => 'Peru',
      'dhl_zone' => '3',
      'fedex_zone' => 'D'
    ],
    [
      'name' => 'Philippines',
      'dhl_zone' => '7',
      'fedex_zone' => 'G'
    ],
    [
      'name' => 'Poland',
      'dhl_zone' => '5',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Portugal',
      'dhl_zone' => '5',
      'fedex_zone' => 'F'
    ],
    [
      'name' => 'Puerto Rico',
      'dhl_zone' => '6',
      'fedex_zone' => 'C'
    ],
    [
      'name' => 'Qatar',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Romania',
      'dhl_zone' => '5',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Russia',
      'dhl_zone' => '6',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Rwanda',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Samoa',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'San Marino',
      'dhl_zone' => '5',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Sao Tome and Principe',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Saudi Arabia',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Senegal',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Serbia',
      'dhl_zone' => '6',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Seychelles',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Sierra Leone',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Singapore',
      'dhl_zone' => '6',
      'fedex_zone' => 'G'
    ],
    [
      'name' => 'Slovakia',
      'dhl_zone' => '5',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Slovenia',
      'dhl_zone' => '5',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Solomon Islands',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Somalia',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'South Africa',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Spain',
      'dhl_zone' => '5',
      'fedex_zone' => 'F'
    ],
    [
      'name' => 'Sri Lanka',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Sta Helena',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'St Barthelemy',
      'dhl_zone' => '4',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Sudan',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'St Eustatius',
      'dhl_zone' => '4',
      'fedex_zone' => 'E'
    ],
    [
      'name' => 'Kitts',
      'dhl_zone' => '4',
      'fedex_zone' => ''
    ],
    [
      'name' => 'St Lucia',
      'dhl_zone' => '4',
      'fedex_zone' => 'E'
    ],
    [
      'name' => 'Maarten',
      'dhl_zone' => '4',
      'fedex_zone' => 'E'
    ],
    [
      'name' => 'Vincent',
      'dhl_zone' => '4',
      'fedex_zone' => 'E'
    ],
    [
      'name' => 'Suriname',
      'dhl_zone' => '4',
      'fedex_zone' => 'D'
    ],
    [
      'name' => 'Swaziland',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Sweden',
      'dhl_zone' => '5',
      'fedex_zone' => 'F'
    ],
    [
      'name' => 'Switzerland',
      'dhl_zone' => '5',
      'fedex_zone' => 'F'
    ],
    [
      'name' => 'Syria',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Tahiti',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Taiwan',
      'dhl_zone' => '6',
      'fedex_zone' => 'G'
    ],
    [
      'name' => 'Tajikistan',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Tanzania',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Thailand',
      'dhl_zone' => '6',
      'fedex_zone' => 'G'
    ],
    [
      'name' => 'Togo',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Tonga',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Trinidad and Tobago',
      'dhl_zone' => '3',
      'fedex_zone' => 'E'
    ],
    [
      'name' => 'Tunisia',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Turkey',
      'dhl_zone' => '5',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Turkmenistan',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Tuvalu',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Uganda',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Ukraine',
      'dhl_zone' => '6',
      'fedex_zone' => ''
    ],
    [
      'name' => 'United Arab Emirates',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'United Kingdom',
      'dhl_zone' => '5',
      'fedex_zone' => ''
    ],
    [
      'name' => 'United States',
      'dhl_zone' => '2',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Uruguay',
      'dhl_zone' => '3',
      'fedex_zone' => 'D'
    ],
    [
      'name' => 'Uzbekistan',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Vanuatu',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Venezuela',
      'dhl_zone' => '3',
      'fedex_zone' => 'D'
    ],

    [
      'name' => 'Vietnam',
      'dhl_zone' => '6',
      'fedex_zone' => 'G'
    ],
    [
      'name' => 'Yemen',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Zambia',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ],
    [
      'name' => 'Zimbabwe',
      'dhl_zone' => '7',
      'fedex_zone' => ''
    ]
  ];

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    foreach ($this->data as $key => $row) {
      Country::create([
        'name'       => $row['name'],
        'dhl_zone'   => $row['dhl_zone'],
        'fedex_zone'  => $row['fedex_zone']
      ]);
    }
  }
}
