<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Session;
use \App\Helpers\HUserType;
use App\Models\Admin\Package;
use App\Models\Admin\Configuration;
use App\Models\Admin\Event;
use App\Models\Admin\Office;
use App\Models\Admin\Prealert;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Helpers\HConstants;
/**
 *
 */
class MainController extends Controller {

  /**
   *
   */
  public function index(Request $request) {
    $session              = $request->session()->get('key-sesion');
    $dashboardDate        = Configuration::all()->last();
    $configuration_header = Configuration::find(HConstants::FIRST_CONFIGURATION);
    /**
    * modifica la fecha en que se visualizan los paquetes en el dashboard
    */
    if($session == null ) {
      $dashboardDate->date_dashboard = Carbon::now()->format('Y-m-d');
      $dashboardDate->save();
    }
    /**
    *
    */
    $today = $dashboardDate->date_dashboard;
    /**
    * se valida que la fecha contenga dia, mes y año para saber si se esta buscando por mes o un dia especfico
    */
    if ($this->longDate($today)) {
      $today = $dashboardDate->date_dashboard;
      /**
      *  top panels
      */
      $receivedPackages = Package::query()->where('start_at', '=', $today)->count();                                                  /*Paquetes recibidos en el dia actual hoy*/
      $sendPackages     = Package::query()->where('start_at', '=', $today)->where('last_event', '>', HConstants::EVENT_RECEIVED)->count();                     /*Paquetes enviados en el dia actual*/
      $transitPackages  = Package::query()->where([['start_at', '=', $today],['last_event', '>', HConstants::EVENT_PROCESED],['last_event', '<', HConstants::EVENT_ARRIVED]])->count();/*Paquetes enviados en el dia actual*/
      $arribedPackage   = Package::query()->where('start_at', '=', $today)->where('last_event', '=', HConstants::EVENT_ARRIVED)->count();                     /*Paquetes recibidos en destino en el dia actual*/
      $delivered        = Package::query()->where([['start_at', '=', $today],['last_event', '=', HConstants::EVENT_AVAILABLE]])->count();                       /*Paquetes entregados en el dia actual*/
      $noInvoice        = Package::query()->where([['start_at', '=', $today],['invoice', '=', HConstants::EVENT_CERO]])->count();                          /*Paquetes sn factura en el dia actual*/
      $today_prealerts  = Prealert::byDateArrived($today)->count();
      /**
      * small charts (left)
      */
      $mar  = DB::table('package')->join('transport', 'package.type', '=', 'transport.id')->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('english','=','maritime')->count();
      $air  = DB::table('package')->join('transport', 'package.type', '=', 'transport.id')->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('english','=','aerial')->count();
      /**
      * small charts (right)
      */
      $invoicePackages   = Package::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('invoice', '=', 1)->count(); /*Muestra en la grafca izquierda los Paquetes del mes CON factura*/
      $noInvoicePackages = Package::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('invoice', '=', 0)->count(); /*Muestra en la grafca izquierda los Paquetes del mes SIN factura*/

      /**
      * Code Office
      */
      $pOffice = Office::query()->where('id', '=', 1)->get();
      $mOffice = Office::query()->where('id', '=', 2)->get();
      /**
      * vars on the view
      */
    }elseif ($today==null) {
      $today = Carbon::now()->format('Y-m-d');
      /**
      *  top panels
      */
      $receivedPackages = Package::query()->where('start_at', '<=', $today)->count();                                                  /*Paquetes recibidos en el dia actual hoy*/
      $sendPackages     = Package::query()->where('start_at', '<=', $today)->where('last_event', '>', HConstants::EVENT_RECEIVED)->count();                     /*Paquetes enviados en el dia actual*/
      $transitPackages  = Package::query()->where([['start_at', '<=', $today],['last_event', '>', HConstants::EVENT_PROCESED],['last_event', '<', HConstants::EVENT_ARRIVED]])->count();/*Paquetes enviados en el dia actual*/
      $arribedPackage   = Package::query()->where('start_at', '<=', $today)->where('last_event', '=', HConstants::EVENT_ARRIVED)->count();                     /*Paquetes recibidos en destino en el dia actual*/
      $delivered        = Package::query()->where([['start_at', '<=', $today],['last_event', '=', HConstants::EVENT_AVAILABLE]])->count();                       /*Paquetes entregados en el dia actual*/
      $noInvoice        = Package::query()->where([['start_at', '<=', $today],['invoice', '=', HConstants::EVENT_CERO]])->count();                          /*Paquetes sn factura en el dia actual*/
      $today_prealerts  = Prealert::byDateArrived($today)->count();
      /**
      * small charts (left)
      */
      $mar  = DB::table('package')->join('transport', 'package.type', '=', 'transport.id')->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('english','=','maritime')->count();
      $air  = DB::table('package')->join('transport', 'package.type', '=', 'transport.id')->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('english','=','aerial')->count();
      /**
      * small charts (right)
      */
      $invoicePackages   = Package::query()->whereMonth('start_at', '<=', Carbon::parse($today)->format('m'))->where('invoice', '=', 1)->count(); /*Muestra en la grafca izquierda los Paquetes del mes CON factura*/
      $noInvoicePackages = Package::query()->whereMonth('start_at', '<=', Carbon::parse($today)->format('m'))->where('invoice', '=', 0)->count(); /*Muestra en la grafca izquierda los Paquetes del mes SIN factura*/

      /**
      * Code Office
      */
      $pOffice = Office::query()->where('id', '=', 1)->get();
      $mOffice = Office::query()->where('id', '=', 2)->get();

      $today = null;
    }
    else {
      $today = Carbon::parse($dashboardDate->date_dashboard)->format('Y-m-d');
      /**
      * top panels
      */
      $receivedPackages = Package::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->count();                                                  /*Paquetes recibidos en el dia actual hoy*/
      $sendPackages     = Package::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('last_event', '>', HConstants::EVENT_RECEIVED)->count();                     /*Paquetes enviados en el dia actual*/
      $transitPackages  = Package::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('last_event', '>', HConstants::EVENT_PROCESED)->where('last_event', '<', HConstants::EVENT_ARRIVED)->count();/*Paquetes enviados en el dia actual*/
      $arribedPackage   = Package::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('last_event', '=', HConstants::EVENT_ARRIVED)->count();                     /*Paquetes recibidos en destino en el dia actual*/
      $delivered        = package::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('last_event', '=', HConstants::EVENT_AVAILABLE)->count();                       /*Paquetes entregados en el dia actual*/
      $noInvoice        = package::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('invoice', '=', HConstants::EVENT_CERO)->count();                          /*Paquetes sn factura en el dia actual*/
      $today_prealerts  = Prealert::query()->whereMonth('date_arrived', '=', Carbon::parse($today)->format('m'))->count();
      /**
      * small charts (left)
      */
      $mar  = DB::table('package')->join('transport', 'package.type', '=', 'transport.id')->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('english','=','maritime')->count();
      $air  = DB::table('package')->join('transport', 'package.type', '=', 'transport.id')->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('english','=','aerial')->count();
      /**
      * small charts (right)
      */
      $invoicePackages   = Package::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('invoice', '=', 1)->count(); /*Muestra en la grafca izquierda los Paquetes del mes CON factura*/
      $noInvoicePackages = Package::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('invoice', '=', 0)->count(); /*Muestra en la grafca izquierda los Paquetes del mes SIN factura*/

      /**
      * Code Office
      */
      $pOffice = Office::query()->where('id', '=', 1)->get();
      $mOffice = Office::query()->where('id', '=', 2)->get();
      /**
      * se modifica formato de fecha para mostrar en vista, no afecta los datos
      */
      $today = Carbon::parse($dashboardDate->date_dashboard)->format('Y-m');
    }
    /**
    *
    */
    if($session == null) {
      return redirect('login');
    }
    /**
    *
    */
    $allPackages = Package::count();
    switch ($session['type']) {
      case HUserType::OPERATOR :

      $vars = [
        'events_num'       => Event::query()->where('active','=',1)->count(),
        'events'           => Event::all(),
        'allPackage'       => $allPackages,
        'todayPackage'     => $receivedPackages,
        'sendPackages'     => $sendPackages,
        'transitPackages'  => $transitPackages,
        'mar'              => $mar,
        'air'              => $air,
        'invoicePackages'  => $invoicePackages,
        'noInvoicePackages'=> $noInvoicePackages,
        'arribedPackage'   => $arribedPackage,
        'pOffice'          => $pOffice,
        'mOffice'          => $mOffice,
        'delivered'        => $delivered,
        'noInvoice'        => $noInvoice,
        'today'            => $today,
        'today_prealerts'  => $today_prealerts,
        'configuration_header' => $configuration_header
      ];
      /**
      * show view
      */
      return view('pages.page', $vars);
      /**
      * Si es un usuario registrado por la pagina se asigna otra ruta
      */
      default : return redirect('account');
    }
  }
 /**
 * View package on DashBoard-Configuration
 */
  public function dateSelect (Request $request, $sw, $value) {
    $configDateDashboard = Configuration::all()->last();
    /**
    * Se modifica la fecha segun lo que indique el usuario
    */
    if($sw == 1 && is_numeric($value)) /** Se verifica si es un numero para ejecutar dia de ayer u hoy **/
    {
      /*
      * Se establece la fecha actual (el dia de hoy)
      */
      if($value == 1) {
        $configDateDashboard->date_dashboard = Carbon::now()->format('Y-m-d');
      }
      /*
      * Se establece la fecha del dia de ayer
      */
      if($value == 2) {
        $configDateDashboard->date_dashboard = date_format(new Carbon('yesterday'), 'Y-m-d');
      }
      /**
       * Todos los paquetes
       */
      if($value == 5)
      {
        $configDateDashboard->date_dashboard = null;
      }
    }
    /**
    * Se modifica la fecha segun lo que indique el usuario para este caso es un dia  especifico o un mes especifico
    */
    else {
      /**
      * Se modifica la fecha segun lo que indique el usuario para este caso es un dia especifico
      */
      if($sw == 3) {
        $configDateDashboard->date_dashboard = Carbon::parse($value)->format('Y-m'); /** Se establece la fecha para un dia especifico **/
      }
      /**
      * Se modifica la fecha segun lo que indique el usuario para este caso es un dia especifico
      */
      if($sw == 4) {
        $configDateDashboard->date_dashboard = Carbon::parse($value)->format('Y-m-d'); /** Se establece la fecha para un dia especifico **/
      }

    }
    /**
    *
    */
    $configDateDashboard->save();
    /**
    *
    */
    return response()->json([
      "message" => "true",
      "data"    => $value
    ]);
  }
}
