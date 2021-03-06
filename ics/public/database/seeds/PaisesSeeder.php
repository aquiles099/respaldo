<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Pais;

class PaisesSeeder extends Seeder {

  private $data = [
    [
      'code' => 'AU',
      'name' => 'Australia'
    ],
    [
      'code' => 'CN',
      'name' => 'China'
    ],
    [
      'code' => 'JP',
      'name' => 'Japan'
    ],
    [
      'code' => 'TH',
      'name' => 'Thailand'
    ],
    [
      'code' => 'IN',
      'name' => 'India'
    ],
    [
      'code' => 'MY',
      'name' => 'Malaysia'
    ],
    [
      'code' => 'KR',
      'name' => 'Kore'
    ],
    [
      'code' => 'HK',
      'name' => 'Hong Kong'
    ],
    [
      'code' => 'TW',
      'name' => 'Taiwan'
    ],
    [
      'code' => 'PH',
      'name' => 'Philippines'
    ],
    [
      'code' => 'VN',
      'name' => 'Vietnam'
    ],
    [
      'code' => 'FR',
      'name' => 'France'
    ],
    [
      'code' => 'EU',
      'name' => 'Europe'
    ],
    [
      'code' => 'DE',
      'name' => 'Germany'
    ],
    [
      'code' => 'SE',
      'name' => 'Sweden'
    ],
    [
      'code' => 'IT',
      'name' => 'Italy'
    ],
    [
      'code' => 'GR',
      'name' => 'Greece'
    ],
    [
      'code' => 'ES',
      'name' => 'Spain'
    ],
    [
      'code' => 'AT',
      'name' => 'Austria'
    ],
    [
      'code' => 'GB',
      'name' => 'United Kingdom'
    ],
    [
      'code' => 'NL',
      'name' => 'Netherlands'
    ],
    [
      'code' => 'BE',
      'name' => 'Belgium'
    ],
    [
      'code' => 'CH',
      'name' => 'Switzerland'
    ],
    [
      'code' => 'AE',
      'name' => 'United Arab Emirates'
    ],
    [
      'code' => 'IL',
      'name' => 'Israel'
    ],
    [
      'code' => 'UA',
      'name' => 'Ukraine'
    ],
    [
      'code' => 'RU',
      'name' => 'Russian Federation'
    ],
    [
      'code' => 'KZ',
      'name' => 'Kazakhstan'
    ],
    [
      'code' => 'PT',
      'name' => 'Portugal'
    ],
    [
      'code' => 'SA',
      'name' => 'Saudi Arabia'
    ],
    [
      'code' => 'DK',
      'name' => 'Denmark'
    ],
    [
      'code' => 'IR',
      'name' => 'Ira'
    ],
    [
      'code' => 'NO',
      'name' => 'Norway'
    ],
    [
      'code' => 'US',
      'name' => 'United States'
    ],
    [
      'code' => 'MX',
      'name' => 'Mexico'
    ],
    [
      'code' => 'CA',
      'name' => 'Canada'
    ],
    [
      'code' => 'A1',
      'name' => 'Anonymous Proxy'
    ],
    [
      'code' => 'SY',
      'name' => 'Syrian Arab Republic'
    ],
    [
      'code' => 'CY',
      'name' => 'Cyprus'
    ],
    [
      'code' => 'CZ',
      'name' => 'Czech Republic'
    ],
    [
      'code' => 'IQ',
      'name' => 'Iraq'
    ],
    [
      'code' => 'TR',
      'name' => 'Turkey'
    ],
    [
      'code' => 'RO',
      'name' => 'Romania'
    ],
    [
      'code' => 'LB',
      'name' => 'Lebanon'
    ],
    [
      'code' => 'HU',
      'name' => 'Hungary'
    ],
    [
      'code' => 'GE',
      'name' => 'Georgia'
    ],
    [
      'code' => 'BR',
      'name' => 'Brazil'
    ],
    [
      'code' => 'AZ',
      'name' => 'Azerbaijan'
    ],
    [
      'code' => 'A2',
      'name' => 'Satellite Provider'
    ],
    [
      'code' => 'PS',
      'name' => 'Palestinian Territory'
    ],
    [
      'code' => 'LT',
      'name' => 'Lithuania'
    ],
    [
      'code' => 'OM',
      'name' => 'Oman'
    ],
    [
      'code' => 'SK',
      'name' => 'Slovakia'
    ],
    [
      'code' => 'RS',
      'name' => 'Serbia'
    ],
    [
      'code' => 'FI',
      'name' => 'Finland'
    ],
    [
      'code' => 'IS',
      'name' => 'Iceland'
    ],
    [
      'code' => 'BG',
      'name' => 'Bulgaria'
    ],
    [
      'code' => 'SI',
      'name' => 'Slovenia'
    ],
    [
      'code' => 'MD',
      'name' => 'Moldov'
    ],
    [
      'code' => 'MK',
      'name' => 'Macedonia'
    ],
    [
      'code' => 'LI',
      'name' => 'Liechtenstein'
    ],
    [
      'code' => 'JE',
      'name' => 'Jersey'
    ],
    [
      'code' => 'PL',
      'name' => 'Poland'
    ],
    [
      'code' => 'HR',
      'name' => 'Croatia'
    ],
    [
      'code' => 'BA',
      'name' => 'Bosnia and Herzegovina'
    ],
    [
      'code' => 'EE',
      'name' => 'Estonia'
    ],
    [
      'code' => 'LV',
      'name' => 'Latvia'
    ],
    [
      'code' => 'JO',
      'name' => 'Jordan'
    ],
    [
      'code' => 'KG',
      'name' => 'Kyrgyzstan'
    ],
    [
      'code' => 'RE',
      'name' => 'Reunion'
    ],
    [
      'code' => 'IE',
      'name' => 'Ireland'
    ],
    [
      'code' => 'LY',
      'name' => 'Libya'
    ],
    [
      'code' => 'LU',
      'name' => 'Luxembourg'
    ],
    [
      'code' => 'AM',
      'name' => 'Armenia'
    ],
    [
      'code' => 'VG',
      'name' => 'Virgin Island'
    ],
    [
      'code' => 'YE',
      'name' => 'Yemen'
    ],
    [
      'code' => 'BY',
      'name' => 'Belarus'
    ],
    [
      'code' => 'GI',
      'name' => 'Gibraltar'
    ],
    [
      'code' => 'MQ',
      'name' => 'Martinique'
    ],
    [
      'code' => 'PA',
      'name' => 'Panama'
    ],
    [
      'code' => 'DO',
      'name' => 'Dominican Republic'
    ],
    [
      'code' => 'GU',
      'name' => 'Guam'
    ],
    [
      'code' => 'PR',
      'name' => 'Puerto Rico'
    ],
    [
      'code' => 'VI',
      'name' => 'Virgin Island'
    ],
    [
      'code' => 'MN',
      'name' => 'Mongolia'
    ],
    [
      'code' => 'NZ',
      'name' => 'New Zealand'
    ],
    [
      'code' => 'SG',
      'name' => 'Singapore'
    ],
    [
      'code' => 'ID',
      'name' => 'Indonesia'
    ],
    [
      'code' => 'NP',
      'name' => 'Nepal'
    ],
    [
      'code' => 'PG',
      'name' => 'Papua New Guinea'
    ],
    [
      'code' => 'PK',
      'name' => 'Pakistan'
    ],
    [
      'code' => 'AP',
      'name' => 'Asia/Pacific Region'
    ],
    [
      'code' => 'BS',
      'name' => 'Bahamas'
    ],
    [
      'code' => 'LC',
      'name' => 'Saint Lucia'
    ],
    [
      'code' => 'AR',
      'name' => 'Argentina'
    ],
    [
      'code' => 'BD',
      'name' => 'Bangladesh'
    ],
    [
      'code' => 'TK',
      'name' => 'Tokelau'
    ],
    [
      'code' => 'KH',
      'name' => 'Cambodia'
    ],
    [
      'code' => 'MO',
      'name' => 'Macau'
    ],
    [
      'code' => 'MV',
      'name' => 'Maldives'
    ],
    [
      'code' => 'AF',
      'name' => 'Afghanistan'
    ],
    [
      'code' => 'NC',
      'name' => 'New Caledonia'
    ],
    [
      'code' => 'FJ',
      'name' => 'Fiji'
    ],
    [
      'code' => 'WF',
      'name' => 'Wallis and Futuna'
    ],
    [
      'code' => 'QA',
      'name' => 'Qatar'
    ],
    [
      'code' => 'AL',
      'name' => 'Albania'
    ],
    [
      'code' => 'BZ',
      'name' => 'Belize'
    ],
    [
      'code' => 'UZ',
      'name' => 'Uzbekistan'
    ],
    [
      'code' => 'KW',
      'name' => 'Kuwait'
    ],
    [
      'code' => 'ME',
      'name' => 'Montenegro'
    ],
    [
      'code' => 'PE',
      'name' => 'Peru'
    ],
    [
      'code' => 'BM',
      'name' => 'Bermuda'
    ],
    [
      'code' => 'CW',
      'name' => 'Curacao'
    ],
    [
      'code' => 'CO',
      'name' => 'Colombia'
    ],
    [
      'code' => 'VE',
      'name' => 'Venezuela'
    ],
    [
      'code' => 'CL',
      'name' => 'Chile'
    ],
    [
      'code' => 'EC',
      'name' => 'Ecuador'
    ],
    [
      'code' => 'ZA',
      'name' => 'South Africa'
    ],
    [
      'code' => 'IM',
      'name' => 'Isle of Man'
    ],
    [
      'code' => 'BO',
      'name' => 'Bolivia'
    ],
    [
      'code' => 'GG',
      'name' => 'Guernsey'
    ],
    [
      'code' => 'MT',
      'name' => 'Malta'
    ],
    [
      'code' => 'TJ',
      'name' => 'Tajikistan'
    ],
    [
      'code' => 'SC',
      'name' => 'Seychelles'
    ],
    [
      'code' => 'BH',
      'name' => 'Bahrain'
    ],
    [
      'code' => 'EG',
      'name' => 'Egypt'
    ],
    [
      'code' => 'ZW',
      'name' => 'Zimbabwe'
    ],
    [
      'code' => 'LR',
      'name' => 'Liberia'
    ],
    [
      'code' => 'KE',
      'name' => 'Kenya'
    ],
    [
      'code' => 'GH',
      'name' => 'Ghana'
    ],
    [
      'code' => 'NG',
      'name' => 'Nigeria'
    ],
    [
      'code' => 'TZ',
      'name' => 'Tanzani'
    ],
    [
      'code' => 'ZM',
      'name' => 'Zambia'
    ],
    [
      'code' => 'MG',
      'name' => 'Madagascar'
    ],
    [
      'code' => 'AO',
      'name' => 'Angola'
    ],
    [
      'code' => 'NA',
      'name' => 'Namibia'
    ],
    [
      'code' => 'CI',
      'name' => 'Cote D'."'".'Ivoire'
    ],
    [
      'code' => 'SD',
      'name' => 'Sudan'
    ],
    [
      'code' => 'CM',
      'name' => 'Cameroon'
    ],
    [
      'code' => 'MW',
      'name' => 'Malawi'
    ],
    [
      'code' => 'GA',
      'name' => 'Gabon'
    ],
    [
      'code' => 'ML',
      'name' => 'Mali'
    ],
    [
      'code' => 'BJ',
      'name' => 'Benin'
    ],
    [
      'code' => 'TD',
      'name' => 'Chad'
    ],
    [
      'code' => 'BW',
      'name' => 'Botswana'
    ],
    [
      'code' => 'CV',
      'name' => 'Cape Verde'
    ],
    [
      'code' => 'RW',
      'name' => 'Rwanda'
    ],
    [
      'code' => 'CG',
      'name' => 'Congo'
    ],
    [
      'code' => 'UG',
      'name' => 'Uganda'
    ],
    [
      'code' => 'MZ',
      'name' => 'Mozambique'
    ],
    [
      'code' => 'GM',
      'name' => 'Gambia'
    ],
    [
      'code' => 'LS',
      'name' => 'Lesotho'
    ],
    [
      'code' => 'MU',
      'name' => 'Mauritius'
    ],
    [
      'code' => 'MA',
      'name' => 'Morocco'
    ],
    [
      'code' => 'DZ',
      'name' => 'Algeria'
    ],
    [
      'code' => 'GN',
      'name' => 'Guinea'
    ],
    [
      'code' => 'CD',
      'name' => 'Cong'
    ],
    [
      'code' => 'SZ',
      'name' => 'Swaziland'
    ],
    [
      'code' => 'BF',
      'name' => 'Burkina Faso'
    ],
    [
      'code' => 'SL',
      'name' => 'Sierra Leone'
    ],
    [
      'code' => 'SO',
      'name' => 'Somalia'
    ],
    [
      'code' => 'NE',
      'name' => 'Niger'
    ],
    [
      'code' => 'CF',
      'name' => 'Central African Republic'
    ],
    [
      'code' => 'TG',
      'name' => 'Togo'
    ],
    [
      'code' => 'BI',
      'name' => 'Burundi'
    ],
    [
      'code' => 'GQ',
      'name' => 'Equatorial Guinea'
    ],
    [
      'code' => 'SS',
      'name' => 'South Sudan'
    ],
    [
      'code' => 'SN',
      'name' => 'Senegal'
    ],
    [
      'code' => 'MR',
      'name' => 'Mauritania'
    ],
    [
      'code' => 'DJ',
      'name' => 'Djibouti'
    ],
    [
      'code' => 'KM',
      'name' => 'Comoros'
    ],
    [
      'code' => 'IO',
      'name' => 'British Indian Ocean Territory'
    ],
    [
      'code' => 'TN',
      'name' => 'Tunisia'
    ],
    [
      'code' => 'GL',
      'name' => 'Greenland'
    ],
    [
      'code' => 'VA',
      'name' => 'Holy See [Vatican City State]'
    ],
    [
      'code' => 'CR',
      'name' => 'Costa Rica'
    ],
    [
      'code' => 'KY',
      'name' => 'Cayman Islands'
    ],
    [
      'code' => 'JM',
      'name' => 'Jamaica'
    ],
    [
      'code' => 'GT',
      'name' => 'Guatemala'
    ],
    [
      'code' => 'MH',
      'name' => 'Marshall Islands'
    ],
    [
      'code' => 'AQ',
      'name' => 'Antarctica'
    ],
    [
      'code' => 'BB',
      'name' => 'Barbados'
    ],
    [
      'code' => 'AW',
      'name' => 'Aruba'
    ],
    [
      'code' => 'MC',
      'name' => 'Monaco'
    ],
    [
      'code' => 'AI',
      'name' => 'Anguilla'
    ],
    [
      'code' => 'KN',
      'name' => 'Saint Kitts and Nevis'
    ],
    [
      'code' => 'GD',
      'name' => 'Grenada'
    ],
    [
      'code' => 'PY',
      'name' => 'Paraguay'
    ],
    [
      'code' => 'MS',
      'name' => 'Montserrat'
    ],
    [
      'code' => 'TC',
      'name' => 'Turks and Caicos Islands'
    ],
    [
      'code' => 'AG',
      'name' => 'Antigua and Barbuda'
    ],
    [
      'code' => 'TV',
      'name' => 'Tuvalu'
    ],
    [
      'code' => 'PF',
      'name' => 'French Polynesia'
    ],
    [
      'code' => 'SB',
      'name' => 'Solomon Islands'
    ],
    [
      'code' => 'VU',
      'name' => 'Vanuatu'
    ],
    [
      'code' => 'ER',
      'name' => 'Eritrea'
    ],
    [
      'code' => 'TT',
      'name' => 'Trinidad and Tobago'
    ],
    [
      'code' => 'AD',
      'name' => 'Andorra'
    ],
    [
      'code' => 'HT',
      'name' => 'Haiti'
    ],
    [
      'code' => 'SH',
      'name' => 'Saint Helena'
    ],
    [
      'code' => 'FM',
      'name' => 'Micronesi'
    ],
    [
      'code' => 'SV',
      'name' => 'El Salvador'
    ],
    [
      'code' => 'HN',
      'name' => 'Honduras'
    ],
    [
      'code' => 'UY',
      'name' => 'Uruguay'
    ],
    [
      'code' => 'LK',
      'name' => 'Sri Lanka'
    ],
    [
      'code' => 'EH',
      'name' => 'Western Sahara'
    ],
    [
      'code' => 'CX',
      'name' => 'Christmas Island'
    ],
    [
      'code' => 'WS',
      'name' => 'Samoa'
    ],
    [
      'code' => 'SR',
      'name' => 'Suriname'
    ],
    [
      'code' => 'CK',
      'name' => 'Cook Islands'
    ],
    [
      'code' => 'KI',
      'name' => 'Kiribati'
    ],
    [
      'code' => 'NU',
      'name' => 'Niue'
    ],
    [
      'code' => 'TO',
      'name' => 'Tonga'
    ],
    [
      'code' => 'TF',
      'name' => 'French Southern Territories'
    ],
    [
      'code' => 'YT',
      'name' => 'Mayotte'
    ],
    [
      'code' => 'NF',
      'name' => 'Norfolk Island'
    ],
    [
      'code' => 'BN',
      'name' => 'Brunei Darussalam'
    ],
    [
      'code' => 'TM',
      'name' => 'Turkmenistan'
    ],
    [
      'code' => 'PN',
      'name' => 'Pitcairn Islands'
    ],
    [
      'code' => 'SM',
      'name' => 'San Marino'
    ],
    [
      'code' => 'AX',
      'name' => 'Aland Islands'
    ],
    [
      'code' => 'FO',
      'name' => 'Faroe Islands'
    ],
    [
      'code' => 'SJ',
      'name' => 'Svalbard and Jan Mayen'
    ],
    [
      'code' => 'CC',
      'name' => 'Cocos [Keeling] Islands'
    ],
    [
      'code' => 'NR',
      'name' => 'Nauru'
    ],
    [
      'code' => 'GS',
      'name' => 'South Georgia and the South Sandwich Islands'
    ],
    [
      'code' => 'UM',
      'name' => 'United States Minor Outlying Islands'
    ],
    [
      'code' => 'GW',
      'name' => 'Guinea-Bissau'
    ],
    [
      'code' => 'PW',
      'name' => 'Palau'
    ],
    [
      'code' => 'AS',
      'name' => 'American Samoa'
    ],
    [
      'code' => 'BT',
      'name' => 'Bhutan'
    ],
    [
      'code' => 'GF',
      'name' => 'French Guiana'
    ],
    [
      'code' => 'GP',
      'name' => 'Guadeloupe'
    ],
    [
      'code' => 'MF',
      'name' => 'Saint Martin'
    ],
    [
      'code' => 'VC',
      'name' => 'Saint Vincent and the Grenadines'
    ],
    [
      'code' => 'PM',
      'name' => 'Saint Pierre and Miquelon'
    ],
    [
      'code' => 'BL',
      'name' => 'Saint Barthelemy'
    ],
    [
      'code' => 'DM',
      'name' => 'Dominica'
    ],
    [
      'code' => 'ST',
      'name' => 'Sao Tome and Principe'
    ],
    [
      'code' => 'KP',
      'name' => 'Kore'
    ],
    [
      'code' => 'FK',
      'name' => 'Falkland Islands [Malvinas]'
    ],
    [
      'code' => 'MP',
      'name' => 'Northern Mariana Islands'
    ],
    [
      'code' => 'TL',
      'name' => 'Timor-Leste'
    ],
    [
      'code' => 'BQ',
      'name' => 'Bonair'
    ],
    [
      'code' => 'MM',
      'name' => 'Myanmar'
    ],
    [
      'code' => 'NI',
      'name' => 'Nicaragua'
    ],
    [
      'code' => 'SX',
      'name' => 'Sint Maarten [Dutch part]'
    ],
    [
      'code' => 'GY',
      'name' => 'Guyana'
    ],
    [
      'code' => 'LA',
      'name' => 'Lao People'."'".'s Democratic Republic'
    ],
    [
      'code' => 'CU',
      'name' => 'Cuba'
    ],
    [
      'code' => 'ET',
      'name' => 'Ethiopia
    ']
  ];

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    foreach ($this->data as $key => $row) {
      Pais::create([
        'code'      => $row['code'],
        'name'      => $row['name']
      ]);
    }
  }
}
