<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\Admin\Package;
use App\Models\Admin\Consolidated;
use App\Models\Admin\PackageConsolidated;
use App\Models\Admin\Log;
use App\Models\Admin\File;
use App\Models\Admin\Event;
use App\Models\Admin\Company;
use App\Models\Admin\Client;
use App\Models\Admin\Detailspackage;
use App\Models\Admin\Configuration;
use Validator;

/**
 *
 */
class ShowPackageController extends Controller {

  protected function insertEvent($idPackage, $idEvent, $observation, $idPreviousEvent = null, $idUser = 4)
  {
    $configuration = Configuration::find(1);
    if ($configuration->time_zone == null) {
      $configuration->time_zone = 'America/Caracas (UTC-04:30)';
      $configuration->save();
    }
    $timezone = explode(" ", $configuration->time_zone);
    date_default_timezone_set($timezone[0]);
    // TODO ENVIAR EL CORREO DE LAS NOTIFICACIONES SI ES QUE EL EVENTO TIENE QUE ENVIAR NOTIFICACIONES.
    $log = Log::create([
      'package' => $idPackage,
      'user' => $idUser,
      'event'=> $idEvent,
      'previous_event'=> $idPreviousEvent,
      'observation' => $observation
    ]);

    $package = Package::find($idPackage);
    $package->update(['last_event' => $idEvent]);
    $package->save();

    return $log;

  }
  /**
   * Creacion
   */
  public function create(Request $request,$id) {
    /**
    *
    */
    $session         = $request->session()->get('key-sesion');
    $package         = Package::find($id);
    $packageLog      = Log::ByPackage($package->id)->get();
    $invoice         = File::query()->where("id_package", "=", $id)->get();
    $detailspackage  = Detailspackage::query()->where('package','=',$id)->get();
    /**
    *
    */
    $event=Event::query()->where('id','>=',$package->last_event)->where('active','=','1')->get();
    $events_number=Event::query()->where('active','=','1')->count();
    /**
    *  Se valida que la sesion este activa
    */
    //dd($event);
    if ($session == null) {
      return redirect('login');
    }
    /**
    *
    */
    $companyclient = "";
    if(isset($package->to_client)) {
      $client          = Client::find($package->to_client);
      $companyclient   = Company::find($client->company);
    }
    /**
    *
    */
    $vars = [
      'package'      => $package,
      'detailspack'  => $detailspackage,
      'packageLog'   => $packageLog,
      'event'        => $event,
      'events_num'   => $events_number,
      'invoice'      => $invoice,
      'companyclient'=> $companyclient

    ];
    /**
    * Se obtiene la vista para ver detalles del paquete
    */
    if($this->isGET($request)) {
      return view('pages.admin.showpackage.view', $vars);
    }
    /**
    * Verificar y validar la Informacion del paquete
    */
    $validator = $this->validateData($request);
    if (!is_null($validator)) {
      if ($validator->fails()) {
          return response()->json([
             "message" => "false",
             "alert"   => $validator->messages()
           ]);
      }
    }
    /**
    * Guardar la informacion del paquete
    */
    $session = $request->session()->get('key-sesion');
    $this->insertEvent($package->id, $request->all()['event'], $request->all()['observation'], $package->getLastEvent['id'], $session['data']->id);
    /**
    *
    */
    if ( !is_null($package->to_user) ) {
      $this->notifyUserStatus($package->to_user, $request->all()['event'], $package->id);
    }
    /**
    *
    */
     return response()->json([
        "message" => "true"
      ]);
    /**
    *
    */
  }

  /**
   *
   */
  private function validateData(Request $request) {
    return Validator::make($this->clear($request->all()), []);
  }

}
