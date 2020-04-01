<?php

namespace App\Http\Controllers\Admin;
use App\Models\Admin\Incidence;
use App\Models\Admin\Configuration;
use Illuminate\Http\Request;
use Input;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class IncidenceController extends Controller
{
    public function create(Request $request) {
      $session = $request->session()->get('key-sesion');
      $configuration = Configuration::find(1);

      if($this->isGET($request)) {
        return view('pages.admin.incidence.create');
      }

      if (Input::file('screen') != null) {
        $logo          = Input::file('screen');
        $aleatorio     = str_random();
        $nombre        = $aleatorio.'_'.($logo->getClientOriginalName());
      }
      else {
          $nombre = Input::get('screen');
      }
      //dd($request);
      /**
      * Configuracion de datos a enviar
      */
     $nombre = preg_replace('[\s+]',"", $nombre);

      $screen = ($nombre == null) ? null : asset('/uploads/incidence')."/".$nombre;

      $vars =  [
        'type' => $request->all()['option_selected_label'],
        'subject' => $request->all()['incidence_subject'],
        'description' => $request->all()['incidence_description'],
        'email' => $configuration->email_company,
        'image' => $screen,
        'peril' => 'macro'
      ];
      $incidence = Incidence::create($vars);
      isset($logo) ? $logo->move('uploads/incidence', $nombre) : '' ;
      return $this->doRedirect($request, "/admin/incidence/new");
    }
}
