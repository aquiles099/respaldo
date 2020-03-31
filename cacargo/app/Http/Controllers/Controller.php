<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Pagination\Paginator;
use Illuminate\Http\Request;

use App\Models\Admin\Log;
use App\Models\Admin\Receipt;
use App\Models\Admin\Package;
use App\Models\Admin\User;
use App\Models\Admin\Event;
use App\Models\Admin\UserNotifications;
use App\Models\Admin\Configuration;
use \Mail;
use App\Helpers\HConstants;

class Controller extends BaseController {
  use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

  /**
   * @var string
   */
  protected $host = 'localhost/Docs/Local/murano-app/public';

  /**
   * @var string
   */
  protected $from = 'development@sps-pa.com';

  /**
   *
   */
  protected $pageSize = 10;

  /**
   *
   */
  protected $muranoId = 1;

  /**
   *
   */
  protected function setCurrentPage($page = 1) {
    Paginator::currentPageResolver(function () use ($page) {
      return $page;
    });
  }

  /**
   *
   */
  protected function checkAuthorization() {
    //throw new Exception("Error Processing Request", 1);
  }

  /**
   *
   */
  protected function doRedirect(Request $request, $path) {
    $from = $request->input('from');
    return redirect(is_null($from)? $path : $from);
  }
  /**
   *
   */
  protected function isGET(Request $request) {
    return $request->method() == 'GET';
  }
  /**
   *
   */
  protected function getCompany($company) {
    return $company;
  }
  /**
   *
   */
  protected function clear($data) {
    return clear($data);
  }
  /**
   *
   */
  protected function insertLog($idPackage, $idEvent, $observation, $idPreviousEvent = null, $idUser = 4) {
    // TODO ENVIAR EL CORREO DE LAS NOTIFICACIONES SI ES QUE EL EVENTO TIENE QUE ENVIAR NOTIFICACIONES.
    $log = Log::create([
      'package' => $idPackage,
      'user'    => $idUser,
      'event'   => $idEvent,
      'previous_event'=> $idPreviousEvent,
      'observation' => $observation
    ]);

    $package = Package::find($idPackage);
    $package->update(['last_event' => $idEvent]);
    $package->save();

    return $log;

  }
  /**
  *
  */
  protected function setreceipt($idPackage, $observation, $subtotal,$total) {
    // TODO ENVIAR EL CORREO DE LAS NOTIFICACIONES SI ES QUE EL EVENTO TIENE QUE ENVIAR NOTIFICACIONES.
    $recive = Receipt::create([
      'package'     => $idPackage,
      'observation' => $observation,
      'subtotal'    => $subtotal,
      'total'       => $total
    ]);
    return $recive;
  }

  /**
  *
  */

  protected function updatereceipt($idPackage, $observation, $subtotal,$total) {
    //Actualiza campos en el correo
    $receipt = Receipt::find($idPackage);
    $receipt->update(['subtotal' => $subtotal, 'total' => $total]);
    $receipt->save();
    return $receipt;
  }
  /**
  *
  */
  protected function sex_user() {
    $sex_user = [
      ['id' => 'm', 'text' => trans('messages.male')],
      ['id' => 'f', 'text' => trans('messages.female')]
    ];
    return $sex_user;
  }
    /**
  *
  */
  protected function optionUserData() {
    $optionUserData = [
      ['id' => 1, 'text' => trans('configuration.basicName') ],
      ['id' => 2, 'text' => trans('configuration.fullName') ],
      ['id' => 3, 'text' => trans('configuration.fulldata') ],
    ];
    return $optionUserData;
  }
  /**
  *
  */
  protected function insertUserNotifications($user, $event) {
      $user_notifications = UserNotifications::create([
        'user'  => $user,
        'event' => $event
      ]);
      return $user_notifications;
  }
  /**
   *
   */
   protected function notifyUserStatus($user, $event, $package) {

     $user_notifications   = UserNotifications::byUser($user)->get();
     $to_user       = User::find($user);
     $user_package  = Package::find($package);
     $current_event = Event::find($event);
     $configuration = Configuration::find(HConstants::FIRST_CONFIGURATION);
     /**
     * se envia el correo al usuario
     */
     foreach ($user_notifications as $key => $value) {
       if ($value->event == $event) {
         Mail::send('emails.notify_to_user', [
           'event'                  => $event,
           'current_event'          => strtoupper($current_event->description),
           'host'                   => $this->host,
           'name'                   => $to_user->name,
           'last_name'              => $to_user->last_name,
           'user_code'              => $to_user->code,
           'configuration'          => $configuration,
           'package_type'           => isset($user_package->getCategory->label) ? $user_package->getCategory->label : null,
           'package_code'           => $user_package->code,
           'package_value'          => $user_package->value,
           'package_tracking'       => $user_package->tracking,
           'package_weight'         => $user_package->weight,
           'package_destiny_country'=> $user_package->getToUser->country,
           'package_destiny_region' => $user_package->getToUser->region,
           'package_destiny_city'   => $user_package->getToUser->city,
           'package_invoice'        => $user_package->invoice,
           'package_office'         => isset($user_package->getOficce) ? $user_package->getOficce->direction: trans('prealert.unknown')
         ],
         function($mail) use ($to_user, $current_event) {
           $mail->from($this->from);
           $mail->to($to_user->email , "$to_user->name $to_user->lastname")
             ->subject(strtoupper($current_event->description));
         });
       }
     }
   }
   /**
   *
   */
  protected function clearString($string) {
    $search  = ['\'', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ', 'á', 'é', 'í', 'ó', 'ú', 'ñ'];
    $replace = [''  , 'A', 'E', 'I', 'O', 'U', 'N', 'A', 'E', 'I', 'O', 'U', 'N'];
    return preg_replace('/[^a-zA-Z_]/', '', preg_replace('/\s/', '_', str_replace($search, $replace, strtoupper($string))));
  }
  /**
  * Valida una fecha con formato yyyy-mm-dd retorna verdadero
  */
  protected function longDate($date) {
    return preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $date);
  }
  /**
  *
  */
   protected function countrys() {
    $countrys = array(
        "Afghanistan",
        "Albania",
        "Algeria",
        "Andorra",
        "Angola",
        "Antigua and Barbuda",
        "Argentina",
        "Armenia",
        "Australia",
        "Austria",
        "Azerbaijan",
        "Bahamas",
        "Bahrain",
        "Bangladesh",
        "Barbados",
        "Belarus",
        "Belgium",
        "Belize",
        "Benin",
        "Bhutan",
        "Bolivia",
        "Bosnia and Herzegovina",
        "Brazil",
        "Brunei",
        "Bulgaria",
        "Burkina Faso",
        "Burundi",
        "Cambodia",
        "Cameroon",
        "Canada",
        "Cape Verde",
        "Central African Republic",
        "Chad",
        "Chile",
        "China",
        "Colombia",
        "Comoros",
        "Congo (Brazzaville)",
        "Congo",
        "Costa Rica",
        "Cote d'Ivoire",
        "Croatia",
        "Cuba",
        "Cyprus",
        "Czech Republic",
        "Denmark",
        "Djibouti",
        "Dominica",
        "Dominican Republic",
        "East Timor (Timor Timur)",
        "Ecuador",
        "Egypt",
        "El Salvador",
        "Equatorial Guinea",
        "Eritrea",
        "Estonia",
        "Ethiopia",
        "Fiji",
        "Finland",
        "France",
        "Gabon",
        "Gambia, The",
        "Georgia",
        "Germany",
        "Ghana",
        "Greece",
        "Grenada",
        "Guatemala",
        "Guinea",
        "Guinea-Bissau",
        "Guyana",
        "Haiti",
        "Honduras",
        "Hungary",
        "Iceland",
        "India",
        "Indonesia",
        "Iran",
        "Iraq",
        "Ireland",
        "Israel",
        "Italy",
        "Jamaica",
        "Japan",
        "Jordan",
        "Kazakhstan",
        "Kenya",
        "Kiribati",
        "Korea, North",
        "Korea, South",
        "Kuwait",
        "Kyrgyzstan",
        "Laos",
        "Latvia",
        "Lebanon",
        "Lesotho",
        "Liberia",
        "Libya",
        "Liechtenstein",
        "Lithuania",
        "Luxembourg",
        "Macedonia",
        "Madagascar",
        "Malawi",
        "Malaysia",
        "Maldives",
        "Mali",
        "Malta",
        "Marshall Islands",
        "Mauritania",
        "Mauritius",
        "Mexico",
        "Micronesia",
        "Moldova",
        "Monaco",
        "Mongolia",
        "Morocco",
        "Mozambique",
        "Myanmar",
        "Namibia",
        "Nauru",
        "Nepa",
        "Netherlands",
        "New Zealand",
        "Nicaragua",
        "Niger",
        "Nigeria",
        "Norway",
        "Oman",
        "Pakistan",
        "Palau",
        "Panama",
        "Papua New Guinea",
        "Paraguay",
        "Peru",
        "Philippines",
        "Poland",
        "Portugal",
        "Qatar",
        "Romania",
        "Russia",
        "Rwanda",
        "Saint Kitts and Nevis",
        "Saint Lucia",
        "Saint Vincent",
        "Samoa",
        "San Marino",
        "Sao Tome and Principe",
        "Saudi Arabia",
        "Senegal",
        "Serbia and Montenegro",
        "Seychelles",
        "Sierra Leone",
        "Singapore",
        "Slovakia",
        "Slovenia",
        "Solomon Islands",
        "Somalia",
        "South Africa",
        "Spain",
        "Sri Lanka",
        "Sudan",
        "Suriname",
        "Swaziland",
        "Sweden",
        "Switzerland",
        "Syria",
        "Taiwan",
        "Tajikistan",
        "Tanzania",
        "Thailand",
        "Togo",
        "Tonga",
        "Trinidad and Tobago",
        "Tunisia",
        "Turkey",
        "Turkmenistan",
        "Tuvalu",
        "Uganda",
        "Ukraine",
        "United Arab Emirates",
        "United Kingdom",
        "United States",
        "Uruguay",
        "Uzbekistan",
        "Vanuatu",
        "Vatican City",
        "Venezuela",
        "Vietnam",
        "Yemen",
        "Zambia",
        "Zimbabwe"
    );
    return $countrys;
  }
}
