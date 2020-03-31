<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\HConstants;
use Input;
use App\Models\Admin\Configuration;
use App\Models\Admin\Status;
use App\Models\Admin\Event;
use Validator;

class ConfigurationController extends Controller {
    //
    public function index(Request $request) {
      $session        = $request->session()->get('key-sesion');
      $configuration  = Configuration::find(HConstants::FIRST_CONFIGURATION); /** Siempre deberia ser una sola configuracion **/
      $optionUserData = $this->optionUserData();
      $countrys       = $this->countrys();
      /**
      * se valida session
      */
      if ($session == null) {
        return redirect('/');
      }
      /**
      * Variables
      */
      $vars = [
        'configuration'  => $configuration,
        'optionUserData' => $optionUserData,
        'countrys'       => $countrys,
        'status'         => Event::all()
      ];
    //  dd($vars);
      /**
      * Show view
      */
      if($this->isGET($request)) {
        return view('pages.admin.configuration.form',$vars);
      }
      /**
      *
      */
      if(is_null($configuration)) {
        return $this->doRedirect($configuration, '/admin/configuration')
          ->with('errorMessage', trans('configuration.notFound'));
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
      * Configuracion de datos a enviar
      */
     $nombre = preg_replace('[\s+]',"", $nombre);
     $nombre = (Input::file('logo') == null) ? asset('/uploads/logo/favicon.png') : asset('/uploads/logo')."/".$nombre;

     //dd($request->all()['countpack']);
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
     if ($x < 6) {
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
         $status->save();
       }
     }
    // dd($status);

     //$status=Status::create($status);

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
       'region_company'        => $request->all()['region_company'],
       'city_company'          => $request->all()['city_company'],
       'email_company'         => $request->all()['email_company'],
     ];
     /**
     *
     */
    // dd($nombre);
      $validator = $this->validateData($request);
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
     /**
     *
     */
     return $this->doRedirect($request, "/admin/configuration/")->with('successMessage', trans('configuration.saved'));
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
          "alert"   => $packageDetail
        ]);
      }
      else
      {
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
}
