<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\HConstants;
use App\Helpers\HUserType;
use Input;
use App\Models\Admin\Configuration;
use App\Models\Admin\Country;
use App\Models\Admin\Event;
use App\Models\Admin\User;
use Excel;
use Validator;

class ConfigurationController extends Controller {
    //
    public function index(Request $request) {
      $session        = $request->session()->get('key-sesion');
      /**
      * se valida session
      */
      if ($session == null) {
        return redirect('/');
      }
      /**
      *
      */
      $configuration  = Configuration::find(HConstants::FIRST_CONFIGURATION); /** Siempre deberia ser una sola configuracion **/
      $optionUserData = $this->optionUserData();
      $countrys       = $this->countrys();
      /**
      *
      */
      if(is_null($configuration)) {
        return $this->doRedirect($configuration, '/admin/configuration')
          ->with('errorMessage', trans('configuration.notFound'));
      }
      /**
      * Variables
      */
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
        'timezones'      => $time_zone
      ];
      $content = $vars;
      /*$vars = [
        'configuration'  => $configuration,
        'optionUserData' => $optionUserData,
        'countrys'       => $countrys
      ];*/
      /**
      * Show view
      */
      if($this->isGET($request)) {
        return view('pages.admin.configuration.form',$vars);
      }
      /**
      *
      */
      if (Input::file('logo') != null) {
        $logo          = Input::file('logo');
        $aleatorio     = str_random();
        $nombre        = $aleatorio.'_'.($logo->getClientOriginalName());
      }
      else {
        $nombre = Input::get('h_logo');
      }

      /**
      *  se obtiene el nombre del archivo
      */
      if (Input::file('logo') !=null) {
        $nombre = preg_replace('[\s+]',"", $nombre);
        //$nombre = "favicon.png";
        $nombre = (Input::file('logo') == null) ? $nombre : asset('/uploads/logo')."/".$nombre;
      }
     /**
     * Configuracion de datos a enviar
     */
     if ($request->all()['language'] == 1) {
       $language = 'es';
     }else {
       $language = 'en';
     }
     $data = [
       'logo_ics'              => $nombre,
       'terms_ics'             => $request->all()['terms_ics'],
       'header_receipt'        => $request->all()['header_receipt'],
       'footer_receipt'        => $request->all()['footer_receipt'],
       'header_label'          => $request->all()['header_label'],
       'footer_label'          => $request->all()['footer_label'],
       'header_mail'           => $request->all()['header_mail'],
       'footer_mail'           => $request->all()['footer_mail'],
       'option_selected_label' => $request->all()['option_selected_label'],
       'name_company'          => $request->all()['name_company'],
       'dni_company'           => $request->all()['dni_company'],
       'country_company'       => $request->all()['country_company'],
       'time_zone'             => $request->all()['hour_company'],
       'region_company'        => $request->all()['region_company'],
       'city_company'          => $request->all()['city_company'],
       'email_company'         => $request->all()['email_company'],
       'web_site_company'      => $request->all()['web_site_company'],
       'language'              => $language
     ];
     /**
     *
     */
      /*$validator = $this->validateData($request);
      if (!is_null($validator)){
        if ($validator->fails()) {
          return view('pages.admin.configuration.form', $vars)->withErrors($validator)
            ->with('errorMessage', trans('messages.checkRedFields'));
        }
      }
     /**
     * Se alamacenan los datos
     */

     $configuration->update($data);
     $configuration->save();
     isset($logo) ? $logo->move('uploads/logo', $nombre) : '' ;
     if(Input::hasFile('import_file')){
 			$path = Input::file('import_file')->getRealPath();
       $filename = (Input::file('import_file')->getClientOriginalName());
       $ext = (explode(".", $filename));
       if(($ext[1]!='xls')&&($ext[1]!='xlsx')){
         return view('pages.admin.configuration.form', $content)->with('errorMessage','Asegurese de subir un archivo de Excel con la extension XLS ó XLSX');
       }
 			$data = Excel::load($path, function($reader) {
 			})->get();
 			if(!empty($data) && $data->count()){
 				foreach ($data as $key => $value) {
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
             'alt_email' => isset($value->correo_alternativo)&&($value->correo_alternativo) ? $value->correo_alternativo : '',
             'user_type' => HUserType::NATURAL_PERSON,
             'active'    => true,
             'sex' => null,
             'address' => '',
             'password' => '12345678'
           ];
           if(!empty($insert)){
             if (!isset($insert['email'])||($insert['email']==null)||($insert['email']=='')) {
               $noemail[] = ['name' => $insert['name']];
             }else {
               $test = User::query()->where('email','=',$insert['email'])->first();
               if((!$test)&&($insert['email']!='')){
                 $user = User::create($insert);
                 $success[] =  ['mail' => $insert['email']];
               }else {
                 $err[] = ['mail' => $test->email];
               }
             }
   				}
 				}
         if (isset($err)) {
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
 		}else {
       //return view('pages.admin.configuration.form', $content)->with('errorMessage', trans('No ha seleccionado ningun archivo'));
 		}
     /**
     *
     */

     //GUARDANDO ESTATUS DE ALMACEN
     $x = $request->all()['countpack'];
     for ($i = 1; $i <= $x; $i++) {
       if ((isset($request->all()['name'.$i]))&&(isset($request->all()['description'.$i]))){
         $status = Event::find($i);
         $vars=[
           'name'           => $request->all()['name'.$i],
           'description'    => $request->all()['description'.$i],
           'notification'    => '',
           'step' => '0',
           'active'         => '1'
         ];
         $status->update($vars);
         $status->save();
       }else {
         $status = Event::find($i);
         $vars=[
           'name'           => 'null',
           'description'    => 'null',
           'notification'    => '',
           'step' => '0',
           'active'         => '0'
         ];
         $status->update($vars);
         $status->save();
       }
     }
     $x++;

     if ($x <= 6) {
       for ($i = $x; $i <= 6; $i++) {
         $status = Event::find($i);
         $vars=[
           'name'           => 'null',
           'description'    => 'null',
           'notification'    => '',
           'step' => '0',
           'active'         => '0'
         ];
         $status->update($vars);
         $status->name = null;
         $status->active = 0;
         $status->save();
       }
     }
     /**
      *
      */
     return $this->doRedirect($request, "/admin/configuration/")->with('successMessage', trans('configuration.saved'));
    }
    /**
     * Validar Estructura de campos
     */
    private function validateData(Request $request) {
      return Validator::make($this->clear($request->all()), [
        'email_company' => 'required|email|min:1|max:100',
        'logo'          => 'image|mimes:jpg,jpeg,png|max:1920'
        //'logo'          => 'dimensions:max_width=500, max_height=500'
      ]);
    }

    public function items(Request $request)
    {
      //dd("si");
    //  $packageDetail = Status::
      $packageDetail = Event::query()->where('active','=','1')->get();
      /**
      *
      */
      if($packageDetail)
      {
        return response()->json([
          "message" => 'true',
          "warehouses"   => $packageDetail
        ]);
      }
      else
      {
        return response()->json([
          "message" => 'false'
        ]);
      }
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
