<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\HConstants;
use Input;
use App\Models\Admin\Configuration;
use App\Models\Admin\Status;
use App\Models\Admin\PickupStatus;
use App\Models\Admin\ReleaseStatus;
use App\Models\Admin\BookingStatus;
use App\Models\Admin\ShipmentStatus;
use App\Models\Admin\Country;
use App\Models\Admin\Event;
use App\Models\Admin\User;
use Validator;
use App;
use Excel;
use App\Helpers\HUserType;
use Illuminate\Support\Facades\Session;

class ConfigurationController extends Controller {
    /**
    *
    */
    public function __construct () {
      $this->middleware('admin:' . HUserType::OPERATOR);
    }
    /**
    *
    */
    public function ratesFormat (Request $request) {
      $file = resource_path() . '/assets/docs/tarifas.xls';
      return response()->download($file);
    }
    /**
    *
    */
    public function index( Request $request ) {

      $session = $request->session()->get('key-sesion');
      $configuration  = Configuration::find(HConstants::FIRST_CONFIGURATION); /** Siempre deberia ser una sola configuracion **/
      $optionUserData = $this->optionUserData();
      $countrys = Country::all();
      /**
      *
      */
      if ( $configuration->time_zone == null ) {
        $configuration->time_zone = 'America/Caracas (UTC-04:30)';
        $configuration->save();
      }
      /**
      * se valida session
      */
      if ( $session == null ) {
        return redirect('/');
      }
      /**
      *
      */
      App::setLocale( $configuration->language );
      $time_zone =  array (
          'Midway Island' => 'Pacific/Midway (UTC-11:00)',
          'Samoa' => 'Pacific/Samoa (UTC-11:00)',
          'Hawaii' => 'Pacific/Honolulu (UTC-10:00)',
          'Alaska' => 'US/Alaska (UTC-09:00)',
          'Pacific Time (US &amp; Canada)' => 'America/Los_Angeles (UTC-08:00)',
          'Tijuana' => 'America/Tijuana (UTC-08:00)',
          'Arizona' => 'US/Arizona (UTC-07:00)',
          'Chihuahua' => 'America/Chihuahua (UTC-07:00)',
          'La Paz' => 'America/Chihuahua (UTC-07:00)',
          'Mazatlan' => 'America/Mazatlan (UTC-07:00)',
          'Mountain Time (US &amp; Canada)' => 'US/Mountain/Canada (UTC-07:00)',
          'Central America' => 'America/Managua (UTC-06:00)',
          'Central Time (US &amp; Canada)' => 'US/Central/Canada (UTC-06:00)',
          'Guadalajara' => 'America/Mexico_City (UTC-06:00)',
          'Mexico City' => 'America/Mexico_City (UTC-06:00)',
          'Monterrey' => 'America/Monterrey (UTC-06:00)',
          'Saskatchewan' => 'Canada/Saskatchewan (UTC-06:00)',
          'Bogota' => 'America/Bogota (UTC-05:00)',
          'Eastern Time (US &amp; Canada)' => 'US/Eastern (UTC-05:00)',
          'Indiana (East)' => 'US/East-Indiana (UTC-05:00)',
          'Lima' => 'America/Lima (UTC-05:00)',
          'Quito' => 'America/Bogota (UTC-05:00)',
          'Quito' => 'America/Panama (UTC-05:00)',
          'Atlantic Time (Canada)' => 'Canada/Atlantic (UTC-04:00)',
          'Caracas' => 'America/Caracas (UTC-04:30)',
          'La Paz' => 'America/La_Paz (UTC-04:00)',
          'Santiago' => 'America/Santiago (UTC-04:00)',
          'Newfoundland' => 'Canada/Newfoundland (UTC-03:30)',
          'Brasilia' => 'America/Sao_Paulo (UTC-03:00)',
          'Buenos Aires' => 'America/Argentina/Buenos_Aires (UTC-03:00)',
          'Greenland' => 'America/Godthab (UTC-03:00)',
          'Mid-Atlantic' => 'America/Noronha (UTC-02:00)',
          'Azores' => 'Atlantic/Azores (UTC-01:00)',
          'Cape Verde Is.' => 'Atlantic/Cape_Verde (UTC-01:00)',
          'Casablanca' => 'Africa/Casablanca (UTC+00:00)',
          'Edinburgh' => 'Europe/London (UTC+00:00)',
          'Greenwich Mean Time : Dublin' => 'Etc/Greenwich (UTC+00:00)',
          'Lisbon' => 'Europe/Lisbon (UTC+00:00)',
          'London' => 'Europe/London (UTC+00:00)',
          'Monrovia' => 'Africa/Monrovia (UTC+00:00)',
          'UTC' => 'UTC (UTC+00:00)',
          'Amsterdam' => 'Europe/Amsterdam (UTC+01:00)',
          'Belgrade' => 'Europe/Belgrade (UTC+01:00)',
          'Berlin' => 'Europe/Berlin (UTC+01:00)',
          'Bern' => 'Europe/Berlin (UTC+01:00)',
          'Bratislava' => 'Europe/Bratislava (UTC+01:00)',
          'Brussels' => 'Europe/Brussels (UTC+01:00)',
          'Budapest' => 'Europe/Budapest (UTC+01:00)',
          'Copenhagen' => 'Europe/Copenhagen (UTC+01:00)',
          'Ljubljana' => 'Europe/Ljubljana (UTC+01:00)',
          'Madrid' => 'Europe/Madrid (UTC+01:00)',
          'Paris' => 'Europe/Paris (UTC+01:00)',
          'Prague' => 'Europe/Prague (UTC+01:00)',
          'Rome' => 'Europe/Rome (UTC+01:00)',
          'Sarajevo' => 'Europe/Sarajevo (UTC+01:00)',
          'Skopje' => 'Europe/Skopje (UTC+01:00)',
          'Stockholm' => 'Europe/Stockholm (UTC+01:00)',
          'Vienna' => 'Europe/Vienna (UTC+01:00)',
          'Warsaw' => 'Europe/Warsaw (UTC+01:00)',
          'West Central Africa' => 'Africa/Lagos (UTC+01:00)',
          'Zagreb' => 'Europe/Zagreb (UTC+01:00)',
          'Athens' => 'Europe/Athens (UTC+02:00)',
          'Bucharest' => 'Europe/Bucharest (UTC+02:00)',
          'Cairo' => 'Africa/Cairo (UTC+02:00)',
          'Harare' => 'Africa/Harare (UTC+02:00)',
          'Helsinki' => 'Europe/Helsinki (UTC+02:00)',
          'Istanbul' => 'Europe/Istanbul (UTC+02:00)',
          'Jerusalem' => 'Asia/Jerusalem (UTC+02:00)',
          'Kyiv' => 'Europe/Helsinki (UTC+02:00)',
          'Pretoria' => 'Africa/Johannesburg (UTC+02:00)',
          'Riga' => 'Europe/Riga (UTC+02:00)',
          'Sofia' => 'Europe/Sofia (UTC+02:00)',
          'Tallinn' => 'Europe/Tallinn (UTC+02:00)',
          'Vilnius' => 'Europe/Vilnius (UTC+02:00)',
          'Baghdad' => 'Asia/Baghdad (UTC+03:00)',
          'Kuwait' => 'Asia/Kuwait (UTC+03:00)',
          'Minsk' => 'Europe/Minsk (UTC+03:00)',
          'Nairobi' => 'Africa/Nairobi (UTC+03:00)',
          'Riyadh' => 'Asia/Riyadh (UTC+03:00)',
          'Volgograd' => 'Europe/Volgograd (UTC+03:00)',
          'Tehran' => 'Asia/Tehran (UTC+03:30)',
          'Abu Dhabi' => 'Asia/Muscat (UTC+04:00)',
          'Baku' => 'Asia/Baku (UTC+04:00)',
          'Moscow' => 'Europe/Moscow (UTC+04:00)',
          'Muscat' => 'Asia/Muscat (UTC+04:00)',
          'St. Petersburg' => 'Europe/Moscow (UTC+04:00)',
          'Tbilisi' => 'Asia/Tbilisi (UTC+04:00)',
          'Yerevan' => 'Asia/Yerevan (UTC+04:00)',
          'Kabul' => 'Asia/Kabul (UTC+04:30)',
          'Islamabad' => 'Asia/Karachi (UTC+05:00)',
          'Karachi' => 'Asia/Karachi (UTC+05:00)',
          'Tashkent' => 'Asia/Tashkent (UTC+05:00)',
          'Chennai' => 'Asia/Calcutta (UTC+05:30)',
          'Kolkata' => 'Asia/Kolkata (UTC+05:30)',
          'Mumbai' => 'Asia/Calcutta (UTC+05:30)',
          'New Delhi' => 'Asia/Calcutta (UTC+05:30)',
          'Sri Jayawardenepura' => 'Asia/Calcutta (UTC+05:30)',
          'Kathmandu' => 'Asia/Katmandu (UTC+05:45)',
          'Almaty' => 'Asia/Almaty (UTC+06:00)',
          'Astana' => 'Asia/Dhaka (UTC+06:00)',
          'Dhaka' => 'Asia/Dhaka (UTC+06:00)',
          'Ekaterinburg' => 'Asia/Yekaterinburg (UTC+06:00)',
          'Rangoon' => 'Asia/Rangoon (UTC+06:30)',
          'Bangkok' => 'Asia/Bangkok(UTC+07:00)',
          'Hanoi' => 'Asia/Bangkok(UTC+07:00)',
          'Jakarta' => 'Asia/Jakarta(UTC+07:00)',
          'Novosibirsk' => 'Asia/Novosibirsk(UTC+07:00)',
          'Beijing' => 'Asia/Hong_Kong (UTC+08:00)',
          'Chongqing' => 'Asia/Chongqing (UTC+08:00)',
          'Hong Kong' => 'Asia/Hong_Kong (UTC+08:00)',
          'Krasnoyarsk' => 'Asia/Krasnoyarsk (UTC+08:00)',
          'Kuala Lumpur' => 'Asia/Kuala_Lumpur (UTC+08:00)',
          'Perth' => 'Australia/Perth (UTC+08:00)',
          'Singapore' => 'Asia/Singapore (UTC+08:00)',
          'Taipei' => 'Asia/Taipei (UTC+08:00)',
          'Ulaan Bataar' => 'Asia/Ulan_Bator (UTC+08:00)',
          'Urumqi' => 'Asia/Urumqi (UTC+08:00)',
          'Irkutsk' => 'Asia/Irkutsk (UTC+09:00)',
          'Osaka' => 'Asia/Tokyo (UTC+09:00)',
          'Sapporo' => 'Asia/Tokyo (UTC+09:00)',
          'Seoul' => 'Asia/Seoul (UTC+09:00)',
          'Tokyo' => 'Asia/Tokyo (UTC+09:00)',
          'Adelaide' => 'Australia/Adelaide (UTC+09:30)',
          'Darwin' => 'Australia/Darwin (UTC+09:30)',
          'Brisbane' => 'Australia/Brisbane (UTC+10:00)',
          'Canberra' => 'Australia/Canberra (UTC+10:00)',
          'Guam' => 'Pacific/Guam (UTC+10:00)',
          'Hobart' => 'Australia/Hobart (UTC+10:00)',
          'Melbourne' => 'Australia/Melbourne (UTC+10:00)',
          'Port Moresby' => 'Pacific/Port_Moresby (UTC+10:00)',
          'Sydney' => 'Australia/Sydney (UTC+10:00)',
          'Yakutsk' => 'Asia/Yakutsk (UTC+10:00)',
          'Vladivostok' => 'Asia/Vladivostok (UTC+11:00)',
          'Auckland' => 'Pacific/Auckland (UTC+12:00)',
          'Fiji' => 'Pacific/Fiji (UTC+12:00)',
          'International Date Line West' => 'Pacific/Kwajalein (UTC+12:00)',
          'Kamchatka' => 'Asia/Kamchatka (UTC+12:00)',
          'Magadan' => 'Asia/Magadan (UTC+12:00)',
          'Marshall Is.' => 'Pacific/Fiji (UTC+12:00)',
          'New Caledonia' => 'Asia/Magadan (UTC+12:00)',
          'Solomon Is.' => 'Asia/Magadan (UTC+12:00)',
          'Wellington' => 'Pacific/Auckland (UTC+12:00)',
          'Nuku\'alofa' => 'Pacific/Tongatap (UTC+13:00)u'
      );
      /**
      * Variables
      */
      $vars = [
        'configuration'  => $configuration,
        'optionUserData' => $optionUserData,
        'countrys'       => $countrys,
        'country_company'=> Country::query()->where('name','=',$configuration->country_company)->first(),
        'status'         => Event::all(),
        'timezones'      => $time_zone,
        'pickupStatus'   => PickupStatus::all(),
        'shipmentStatus'   => ShipmentStatus::all(),
        'bookingStatus'   => BookingStatus::all(),
        'releaseStatus'   => ReleaseStatus::all()
      ];
      $content = $vars;
      /**
      * Show view
      */
      if ( $this->isGET( $request ) ) {
        return view( 'pages.admin.configuration.form', $vars );
      }
      /**
      *
      */
      if ( is_null( $configuration ) ) {
        return $this->doRedirect($configuration, '/admin/configuration')
          ->with('errorMessage', trans('configuration.notFound'));
      }
      /**
      *
      */
      $logo_viejo = $configuration->logo_ics;
      if ( Input::file('logo') != null ) {
        $logo = Input::file('logo');
        $aleatorio = str_random();
        $nombre = $aleatorio.'_'.($logo->getClientOriginalName());
      }
      else {
          $nombre = Input::get('h_logo');
      }
      /**
      * Configuracion de datos a enviar
      */
     $nombre = preg_replace('[\s+]',"", $nombre);
     $nombre = ( Input::file('logo') == null ) ? $logo_viejo : asset('/uploads/logo')."/".$nombre;

     //GUARDANDO ESTATUS DE ALMACEN
     $x = $request->all()['countpack'];
     for ( $i = 1; $i <= $x; $i++ ) {
       if ( (isset( $request->all()['name'.$i]) ) && ( isset( $request->all()['description'.$i]) ) ) {
         $status = Event::find($i);
         $vars = [
           'name' => $request->all()['name'.$i],
           'description' => $request->all()['description'.$i],
           'notification' => '',
           'step' => '0',
           'active' => '1'
         ];
         $status->update($vars);
         $status->save();
       } else {
         $status = Event::find($i);
         $vars = [
           'name' => 'null',
           'description' => 'null',
           'notification' => '',
           'step' => '0',
           'active' => '0'
         ];
         $status->update($vars);
         $status->save();
       }
     }
     $x++;

     if ( $x <= 6 ) {
       for ( $i = $x; $i <= 6; $i++ ) {
         $status = Event::find($i);
         $vars = [
           'name' => 'null',
           'description' => 'null',
           'notification' => '',
           'step' => '0',
           'active' => '0'
         ];
         $status->update($vars);
         $status->save();
       }
     }
     //GUARDANDO ESTATUS DE PICK-UP
     $x = $request->all()['countpackPO'];
     for ( $i = 1; $i <= $x; $i++ ) {
       if ( (isset( $request->all()['namePO'.$i] ) ) && (isset($request->all()['descriptionPO'.$i]))){
         $status = PickupStatus::find($i);
         $vars = [
           'name' => $request->all()['namePO'.$i],
           'description' => $request->all()['descriptionPO'.$i],
           'notification' => '',
           'step' => '0',
           'active' => '1'
         ];
         $status->update($vars);
         $status->save();
       } else {
         $status = PickupStatus::find($i);
         $vars = [
           'name' => 'null',
           'description' => 'null',
           'notification' => '',
           'step' => '0',
           'active' => '0'
         ];
         $status->update($vars);
         $status->save();
       }
     }
     $x++;
     if ( $x <= 6 ) {
       for ( $i = $x; $i <= 6; $i++ ) {
         $status = PickupStatus::find($i);
         $vars = [
           'name' => 'null',
           'description' => 'null',
           'notification' => '',
           'step' => '0',
           'active' => '0'
         ];
         $status->update($vars);
         $status->save();
       }
     }

     if ( Input::hasFile('import_file') ) {
 			 $path = Input::file('import_file')->getRealPath();
       $filename = ( Input::file('import_file')->getClientOriginalName() );
       $ext = ( explode(".", $filename) );
       /**
       *
       */
       if ( ( $ext[1]!='xls' ) && ( $ext[1]!='xlsx' ) ) {
         return view('pages.admin.configuration.form', $content)
         ->with('errorMessage','Asegurese de subir un archivo de Excel con la extension XLS ó XLSX');
       }
       /**
       * carga de archivo de usuarios.
       */
 			$data = Excel::load($path, function( $reader ) {})->get();

 			if ( !empty( $data ) && $data->count() ) {
 				foreach ( $data as $key => $value ) {
 					$insert = [
             'code' => $value->codigo,
             'name' => $value->nombre,
             'last_name' => $value->apellido,
             'dni' => $value->dni,
             'country' => $value->pais,
             'region' => $value->region,
             'city' => $value->ciudad,
             'postal_code' => $value->zip_code,
             'local_phone' => $value->telefono,
             'celular' => $value->telefono_movil,
             'email' => $value->correo,
             'alt_email' => isset( $value->correo_alternativo ) && ( $value->correo_alternativo ) ? $value->correo_alternativo : '',
             'user_type' => HUserType::NATURAL_PERSON,
             'active' => true,
             'sex'=> null,
             'address' => '',
             'password' => '12345678'
           ];
           if ( !empty( $insert ) ) {
             if ( !isset( $insert['email'] ) || ( $insert['email'] == null ) || ( $insert['email']=='') ) {
               $noemail[] = ['name' => $insert['name']];
             } else {
               $test = User::query()->where('email','=',$insert['email'])->first();
               if ( (!$test) && ( $insert['email']!='') ) {
                 $user = User::create( $insert );
                 $success[] =  ['mail' => $insert['email']];
               } else {
                 $err[] = ['mail' => $test->email];
               }
             }
   				}
 				}
         if ( isset( $err) ) {
           $str = '';
           foreach ($err  as $key => $value) {
             $str .= $value['mail'].', ';
           }
           if (isset($success)) {
             $str2 = '';
             foreach ($success  as $key => $value) {
               $str2 .= $value['mail'].', ';
             }
             $msj = 'Los usuarios '.$str2.'se agregaron correctamente.'.' Sin embargo Los usuarios '.$str.' fueron ignorados puesto que ya existe un registro para su Correo electronico.';
             return view('pages.admin.configuration.form', $content)->with('successMessage', trans($msj));
           }else {
             $msj = 'Los usuarios '.$str.' fueron ignorados puesto que ya existe un registro para su Correo electronico.';
             return view('pages.admin.configuration.form', $content)->with('errorMessage', trans($msj));
           }
         }elseif (isset($noemail)) {
           $str = '';
           foreach ($noemail  as $key => $value) {
             $str .= $value['name'].', ';
           }
           if (isset($success)) {
             $str2 = '';
             foreach ($success  as $key => $value) {
               $str2 .= $value['mail'].', ';
             }
             $msj = 'Los usuarios '.$str2.'se agregaron correctamente.'.' Sin embargo Los usuarios '.$str.' fueron ignorados puesto que no se especifico su correo electronico.';
             return view('pages.admin.configuration.form', $content)->with('successMessage', trans($msj));
           }else {
             $msj = 'Los usuarios '.$str.' fueron ignorados puesto que no se especifico su correo electronico.';
             return view('pages.admin.configuration.form', $content)->with('errorMessage', trans($msj));
           }
         }else {
           $str = '';
           foreach ($success  as $key => $value) {
             $str .= $value['mail'].', ';
           }
           $msj = 'Los usuarios '.$str.' fueron guardados, exitosamente';
           return view('pages.admin.configuration.form', $content)->with('successMessage', trans($msj));
         }
 			}
 		} else {
       //return view('pages.admin.configuration.form', $content)->with('errorMessage', trans('No ha seleccionado ningun archivo'));
 		}
    if ($request->all()['language'] == 1) {
      $language = 'es';
    } else {
      $language = 'en';
    }
    /**
    *
    */
    if ( $request->import_rate ) {

       	$rate_path = Input::file('import_rate')->getRealPath();
        $rate_name = Input::file('import_rate')->getClientOriginalName();
        $rate_extension  = ( explode(".", $rate_name) );
        /**
        *
        */
        if ( ( $rate_extension[1] != 'xls' ) && ( $rate_extension[1] != 'xlsx' ) ) {
          return view('pages.admin.configuration.form', $content)
          ->with('errorMessage','Asegurese de subir un archivo de Excel con la extension XLS ó XLSX');
        }
        /**
        *
        */
        $rate_data = Excel::load($rate_path, function ( $reader ) { })->get();
        $nombre_archivo = storage_path() . '/tarifas.php';
        /**
        *
        */
        try {

          if ( $archivo = fopen( $nombre_archivo, "w" ) ) {

            $header_php = '<?php';
            $mensaje = '';
            $message_header_pak = '$fedex_pak = [';
            $message_header_package = '$fedex_packages = [';
            $message_header_env_dhl = '$dhl_envelope = [';
            $message_header_package_dhl = '$dhl_packages = [';
            /**
            * a
            */
            $message_a = "\n '1' => [ \n ";
            $message_a_f = "\n 'A' => [ \n ";
            $message_a_aux = "";
            $message_aa_aux = "";
            $message_aaa_aux = "";
            $message_aaaa_aux = "";
            /**
            * b
            */
            $message_b = "\n '2' => [ \n ";
            $message_b_f = "\n 'B' => [ \n ";
            $message_b_aux = "";
            $message_bb_aux = "";
            $message_bbb_aux = "";
            $message_bbbb_aux = "";
            /**
            * c
            */
            $message_c = "\n '3' => [ \n ";
            $message_c_f = "\n 'C' => [ \n ";
            $message_c_aux = "";
            $message_cc_aux = "";
            $message_ccc_aux = "";
            $message_cccc_aux  = "";
            /**
            * d
            */
            $message_d = "\n '4' => [ \n ";
            $message_d_f = "\n 'D' => [ \n ";
            $message_d_aux = "";
            $message_dd_aux = "";
            $message_ddd_aux = "";
            $message_dddd_aux  = "";
            /**
            * e
            */
            $message_e = "\n '5' => [ \n ";
            $message_e_f = "\n 'E' => [ \n ";
            $message_e_aux = "";
            $message_ee_aux = "";
            $message_eee_aux = "";
            $message_eeee_aux = "";
            /**
            * f
            */
            $message_f = "\n '6' => [ \n ";
            $message_f_f = "\n 'F' => [ \n ";
            $message_f_aux = "";
            $message_ff_aux = "";
            $message_fff_aux = "";
            $message_ffff_aux = "";
            /**
            * g
            */
            $message_g = "\n '7' => [ \n ";
            $message_g_f = "\n 'G' => [ \n ";
            $message_g_aux = "";
            $message_gg_aux = "";
            $message_ggg_aux = "";
            $message_gggg_aux = "";
            /**
            * h
            */
            $message_h = "\n '8' => [ \n ";
            $message_h_f = "\n 'H' => [ \n ";
            $message_h_aux = "";
            $message_hh_aux = "";
            $message_hhh_aux = "";
            $message_hhhh_aux = "";
            /**
            * footer
            */
            $message_footer = "\n ]";

            fwrite($archivo, $header_php . "\n");

            foreach ($rate_data as $key => $value) {
              /**
              * Fedex Envelope
              */
              if ($value->courier == 'Fedex' && $value->type == 'Envelope') {

                $mensaje = $mensaje . '$' . "fedex_envelope = [
                'A' => [
                   'default' => '" . ($value->a) . "'
                 ],
                'B' => [
                   'default' => '" . ($value->b) . "'
                 ],
                'C' => [
                   'default' => '" . ($value->c) . "'
                 ],
                 'D' => [
                   'default' => '" . ($value->d) . "'
                 ],
                 'E' => [
                   'default' => '" . ($value->e) . "'
                 ],
                 'F' => [
                   'default' => '" . ($value->f) . "'
                 ],
                 'G' => [
                   'default' => '" . ($value->g) . "'
                 ],
                 'H' => [
                   'default' => '" . ($value->h) . "'
                 ]
               ];";
                fwrite($archivo, $mensaje . "\n");
              }
              /**
              * Fedex Pak
              */
              if ($value->courier == 'Fedex' && $value->type == 'Pak') {

                if ($value->a) {
                  $message_a_aux = $message_a_aux . "'" . ($value->kgs) . "' => '" . ($value->a) . "', \n";
                }
                /**
                *
                */
                if ($value->b) {
                  $message_b_aux = $message_b_aux . "'" . ($value->kgs) . "' => '" . ($value->b) . "', \n";
                }
                /**
                *
                */
                if ($value->c) {
                  $message_c_aux = $message_c_aux . "'" . ($value->kgs) . "' => '" . ($value->c) . "', \n";
                }
                /**
                *
                */
                if ($value->d) {
                  $message_d_aux = $message_d_aux . "'" . ($value->kgs) . "' => '" . ($value->d) . "', \n";
                }
                /**
                *
                */
                if ($value->e) {
                  $message_e_aux = $message_e_aux . "'" . ($value->kgs) . "' => '" . ($value->e) . "', \n";
                }
                /**
                *
                */
                if ($value->f) {
                  $message_f_aux = $message_f_aux . "'" . ($value->kgs) . "' => '" . ($value->f) . "', \n";
                }
                /**
                *
                */
                if ($value->g) {
                  $message_g_aux = $message_g_aux . "'" . ($value->kgs) . "' => '" . ($value->g) . "', \n";
                }
                /**
                *
                */
                if ($value->h) {
                  $message_h_aux = $message_h_aux . "'" . ($value->kgs) . "' => '" . ($value->h) . "', \n";
                }
              }
              /**
              * Fedex Package
              */
              if ($value->courier == 'Fedex' && $value->type == 'Package') {
                /**
                * 1
                */
                if ($value->a) {
                  $message_aa_aux = $message_aa_aux . "'" . ($value->kgs) . "' => '" . ($value->a) . "', \n";
                }
                /**
                * 2
                */
                if ($value->b) {
                  $message_bb_aux = $message_bb_aux . "'" . ($value->kgs) . "' => '" . ($value->b) . "', \n";
                }
                /**
                * 3
                */
                if ($value->c) {
                  $message_cc_aux = $message_cc_aux . "'" . ($value->kgs) . "' => '" . ($value->c) . "', \n";
                }
                /**
                * 4
                */
                if ($value->d) {
                  $message_dd_aux = $message_dd_aux . "'" . ($value->kgs) . "' => '" . ($value->d) . "', \n";
                }
                /**
                * 5
                */
                if ($value->e) {
                  $message_ee_aux = $message_ee_aux . "'" . ($value->kgs) . "' => '" . ($value->d) . "', \n";
                }
                /**
                * 6
                */
                if ($value->f) {
                  $message_ff_aux = $message_ff_aux . "'" . ($value->kgs) . "' => '" . ($value->f) . "', \n";
                }
                /**
                * 7
                */
                if ($value->g) {
                  $message_gg_aux = $message_gg_aux . "'" . ($value->kgs) . "' => '" . ($value->g) . "', \n";
                }
                /**
                * 8
                */
                if ($value->h) {
                  $message_hh_aux = $message_hh_aux . "'" . ($value->kgs) . "' => '" . ($value->h) . "', \n";
                }
              }
              /**
              * Dhl Envelope
              */
              if ($value->courier == 'Dhl' && $value->type == 'Envelope') {
                /**
                * 1
                */
                if ($value->a) {
                  $message_aaa_aux = $message_aaa_aux . "'" . ($value->kgs) . "' => '" . ($value->a) . "', \n";
                }
                /**
                * 2
                */
                if ($value->b) {
                  $message_bbb_aux = $message_bbb_aux . "'" . ($value->kgs) . "' => '" . ($value->b) . "', \n";
                }
                /**
                * 3
                */
                if ($value->c) {
                  $message_ccc_aux = $message_ccc_aux . "'" . ($value->kgs) . "' => '" . ($value->c) . "', \n";
                }
                /**
                * 4
                */
                if ($value->d) {
                  $message_ddd_aux = $message_ddd_aux . "'" . ($value->kgs) . "' => '" . ($value->d) . "', \n";
                }
                /**
                * 5
                */
                if ($value->e) {
                  $message_eee_aux = $message_eee_aux . "'" . ($value->kgs) . "' => '" . ($value->d) . "', \n";
                }
                /**
                * 6
                */
                if ($value->f) {
                  $message_fff_aux = $message_fff_aux . "'" . ($value->kgs) . "' => '" . ($value->f) . "', \n";
                }
                /**
                * 7
                */
                if ($value->g) {
                  $message_ggg_aux = $message_ggg_aux . "'" . ($value->kgs) . "' => '" . ($value->g) . "', \n";
                }
                /**
                * 8
                */
                if ($value->h) {
                  $message_hhh_aux = $message_hhh_aux . "'" . ($value->kgs) . "' => '" . ($value->h) . "', \n";
                }
              }
              /**
              * Dhl Package
              */
              if ($value->courier == 'Dhl' && $value->type == 'Package') {
                if ($value->a) {
                  $message_aaaa_aux = $message_aaaa_aux . "'" . ($value->kgs) . "' => '" . ($value->a) . "', \n";
                }
                /**
                *
                */
                if ($value->b) {
                  $message_bbbb_aux = $message_bbbb_aux . "'" . ($value->kgs) . "' => '" . ($value->b) . "', \n";
                }
                /**
                *
                */
                if ($value->c) {
                  $message_cccc_aux = $message_cccc_aux . "'" . ($value->kgs) . "' => '" . ($value->c) . "', \n";
                }
                /**
                *
                */
                if ($value->d) {
                  $message_dddd_aux = $message_dddd_aux . "'" . ($value->kgs) . "' => '" . ($value->d) . "', \n";
                }
                /**
                *
                */
                if ($value->e) {
                  $message_eeee_aux = $message_eeee_aux . "'" . ($value->kgs) . "' => '" . ($value->d) . "', \n";
                }
                /**
                *
                */
                if ($value->f) {
                  $message_ffff_aux = $message_ffff_aux . "'" . ($value->kgs) . "' => '" . ($value->f) . "', \n";
                }
                /**
                *
                */
                if ($value->g) {
                  $message_gggg_aux = $message_gggg_aux . "'" . ($value->kgs) . "' => '" . ($value->g) . "', \n";
                }
                /**
                *
                */
                if ($value->h) {
                  $message_hhhh_aux = $message_hhhh_aux . "'" . ($value->kgs) . "' => '" . ($value->h) . "', \n";
                }
              }
            }
            /**
            * Dhl Envelope
            */
            fwrite($archivo, ($message_header_env_dhl . ($message_a . $message_aaa_aux . $message_footer . ',') . ($message_b . $message_bbb_aux . $message_footer . ',') . ($message_c . $message_ccc_aux . $message_footer . ',') . ($message_d . $message_ddd_aux . $message_footer . ',') . ($message_e . $message_eee_aux  . $message_footer . ',') . ($message_f . $message_fff_aux .  $message_footer . ',') . ($message_g . $message_ggg_aux .  $message_footer . ',') . ($message_h . $message_hhh_aux .  $message_footer ) . $message_footer . ';') . "\n");
            /**
            * Dhl Package
            */
            fwrite($archivo, ($message_header_package_dhl . ($message_a . $message_aaaa_aux . $message_footer . ',') . ($message_b . $message_bbbb_aux . $message_footer . ',') . ($message_c . $message_cccc_aux . $message_footer . ',') . ($message_d . $message_dddd_aux . $message_footer . ',') . ($message_e . $message_eeee_aux  . $message_footer . ',') . ($message_f . $message_ffff_aux .  $message_footer . ',') . ($message_g . $message_gggg_aux .  $message_footer . ',') . ($message_h . $message_hhhh_aux .  $message_footer ) . $message_footer . ';') . "\n");
            /**
            * Fedex Pak
            */
            fwrite($archivo, ($message_header_pak . ($message_a_f . $message_a_aux . $message_footer . ',') . ($message_b_f . $message_b_aux . $message_footer . ',') . ($message_c_f . $message_c_aux . $message_footer . ',') . ($message_d_f . $message_d_aux . $message_footer . ',') . ($message_e_f . $message_e_aux  . $message_footer . ',') . ($message_f_f . $message_f_aux .  $message_footer . ',') . ($message_g_f . $message_g_aux .  $message_footer . ',') . ($message_h_f . $message_h_aux .  $message_footer ) . $message_footer . ';') . "\n");
            /**
            * Fedex Package
            */
            fwrite($archivo, ($message_header_package . ($message_a_f . $message_aa_aux . $message_footer . ',') . ($message_b_f . $message_bb_aux . $message_footer . ',') . ($message_c_f . $message_cc_aux . $message_footer . ',') . ($message_d_f . $message_dd_aux . $message_footer . ',') . ($message_e_f . $message_ee_aux  . $message_footer . ',') . ($message_f_f . $message_ff_aux .  $message_footer . ',') . ($message_g_f . $message_gg_aux .  $message_footer . ',') . ($message_h_f . $message_hh_aux .  $message_footer ) . $message_footer . ';') . "\n");
            /**
            *
            */
            fclose( $archivo );
          } else {
            return view('pages.admin.configuration.form', $content)
            ->with('errorMessage', trans('configuration.error_open_path_file'));
          }
        } catch ( Exception $e ) {
            return view('pages.admin.configuration.form', $content)
            ->with('errorMessage', $e->getMessage());
        }
    }
      /**
      *
      */
      $data = [
       'logo_ics' => $nombre,
       'terms_ics' => $request->all()['terms_ics'],
       'header_receipt' => isset($request->all()['header_receipt']) ? $request->all()['header_receipt'] : null,
       'footer_receipt' => $request->all()['footer_receipt'],
       'header_label' => $request->all()['header_label'],
       'footer_label' => $request->all()['footer_label'],
       'header_mail' => $request->all()['header_mail'],
       'footer_mail' => $request->all()['footer_mail'],
       'option_selected_label' => $request->all()['option_selected_label'],
       'name_company' => $request->all()['name_company'],
       'dni_company' => $request->all()['dni_company'],
       'time_zone' => $request->all()['hour_company'],
       'country_company' => $request->all()['country_company'],
       'region_company' => $request->all()['region_company'],
       'city_company' => $request->all()['city_company'],
       'email_company' => $request->all()['email_company'],
       'prefix' => $request->all()['prefix'],
       'num_ini' => $request->all()['num_ini'],
       'language' => $language,
       'notify_xls' => 0 //$request->all()['notify_xls']
      ];
      /**
      *
      */
      $validator = $this->validateData($request);
      if ( !is_null( $validator ) ) {
        if ( $validator->fails() ) {
          return view('pages.admin.configuration.form', $vars)
            ->withErrors( $validator )
            ->with('errorMessage', trans('messages.checkRedFields'));
        }
      }
      /**
      * Se alamacenan los datos
      */
      $configuration->update($data);
      $configuration->save();
      isset($logo) ? $logo->move('uploads/logo', $nombre) : '' ;
      /**
      *
      */
      return $this->doRedirect($request, "/admin/configuration/")->with('successMessage', trans('configuration.saved'));
    }
    /**
     * [items description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function items ( Request $request ) {

      $packageDetail = Event::query()->where('active','=','1')->get();
      $pickup = PickupStatus::query()->where('active','=','1')->get();
      $bookings = BookingStatus::query()->where('active','=','1')->get();
      $shipment = ShipmentStatus::query()->where('active','=','1')->get();
      $release = ReleaseStatus::query()->where('active','=','1')->get();
      /**
      *
      */
      if ( $packageDetail ) {
        return response()->json([
          "message" => 'true',
          "warehouses"   => $packageDetail,
          "pickups"     => $pickup,
          "bookings"    => $bookings,
          "shipments"   => $shipment,
          "releases"    => $release
        ]);
      }
      else {
        return response()->json([
          "message" => 'false'
        ]);
      }
    }
    /**
     * Validar Estructura de campos
     */
    private function validateData(Request $request) {
      return Validator::make($this->clear($request->all()), [
        'email_company' => 'required|email|min:1|max:100',
        'logo'          => 'image|mimes:jpg,png,jpeg|max:1920'
        //'logo'          => 'dimensions:max_width=500, max_height=500'
      ]);
    }

    public function serverTime(Request $request){
      $session = $request->session()->get('key-sesion');
      if ($session) {
        $configuration = Configuration::find(1);
        $timezone = explode(" ", $configuration->time_zone);
        date_default_timezone_set($timezone[0]);

        return response()->json([
          "message" => "true",
          "time"=> date('d/m/Y h:i:s')
        ]);
      }
      return response()->json([
        "message" => "false",
        "time"=> date('d/m/Y h:i:s')
      ]);

    }
}
