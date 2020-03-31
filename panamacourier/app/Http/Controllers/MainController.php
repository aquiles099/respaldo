<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Session;
use \App\Helpers\HUserType;
use App\Models\Admin\Package;
use App\Models\Admin\Configuration;
use App\Models\Admin\Office;
use App\Models\Admin\Booking;
use App\Models\Admin\Pickup;
use App\Models\Admin\Shipment;
use App\Models\Admin\CargoRelease;
use App\Models\Admin\Event;
use App\Models\Admin\PickupStatus;
use App\Models\Admin\ShipmentStatus;
use App\Models\Admin\ReleaseStatus;
use App\Models\Admin\BookingStatus;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Alert;
/**
 *
 */
class MainController extends Controller {

  public function __construct () {

  }
  /**
   *
   */
  public function index ( Request $request ) {

    $session = $request->session()->get('key-sesion');
    $dashboardDate = Configuration::all()->last();

    /**
    * modifica la fecha en que se visualizan los paquetes en el dashboard
    */

    if ( $session == null ) {
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
      $packages         = Package::all();
      $receivedPackages = Package::query()->where('start_at', '=', $today)->count();                                                  /*Paquetes recibidos en el dia actual hoy*/
      $sendPackages     = Package::query()->where('start_at', '=', $today)->where('last_event', '>', 1)->count();                     /*Paquetes enviados en el dia actual*/
      $transitPackages  = Package::query()->where([['start_at', '=', $today],['last_event', '>', 2],['last_event', '<', 4]])->count();/*Paquetes enviados en el dia actual*/
      $arribedPackage   = Package::query()->where('start_at', '=', $today)->where('last_event', '=', 4)->count();                     /*Paquetes recibidos en destino en el dia actual*/
      $delivered        = Package::query()->where([['start_at', '=', $today],['last_event', '=', 5]])->count();                       /*Paquetes entregados en el dia actual*/
      $laststatus       = Package::query()->where([['start_at', '=', $today],['last_event', '=', 6]])->count();
      $noInvoice        = Package::query()->where([['start_at', '=', $today],['invoice', '=', 0]])->count();                          /*Paquetes sn factura en el dia actual*/
      /**
      * bookings
      */
      $bookings          = Booking::all();
      $receivedBookings  = Booking::query()->where('start_at', '=', $today)->count();                                                  /*Paquetes recibidos en el dia actual hoy*/
      $sendBookings      = Booking::query()->where('start_at', '=', $today)->where('last_event', '>', 1)->count();                     /*Paquetes enviados en el dia actual*/
      $transitBookings   = Booking::query()->where([['start_at', '=', $today],['last_event', '>', 2],['last_event', '<', 4]])->count();/*Paquetes enviados en el dia actual*/
      $arribedBookings   = Booking::query()->where('start_at', '=', $today)->where('last_event', '=', 4)->count();                     /*Paquetes recibidos en destino en el dia actual*/
      $deliveredBookings = Booking::query()->where([['start_at', '=', $today],['last_event', '=', 5]])->count();                       /*Paquetes entregados en el dia actual*/
      /**
      * Pickup
      */
      $pickups = Pickup::all();
      $receivedPickups = Pickup::query()->where('start_at', '=', $today)->count();
      $sendPickups    = Pickup::query()->where('start_at', '=', $today)->where('last_event', '>', 1)->count();
      $transitPickups = Pickup::query()->where([['start_at', '=', $today],['last_event', '>', 2],['last_event', '<', 4]])->count();
      $arribedPickups = Pickup::query()->where('start_at', '=', $today)->where('last_event', '=', 4)->count();
      $noInvoicePickups = Pickup::query()->where([['start_at', '=', $today],['invoice', '=', 0]])->count();
      $deliveredPickups = Pickup::query()->where([['start_at', '=', $today],['last_event', '=', 5]])->count();
      /**
      * Embarque
      */
      $shipments = Shipment::all();
      $receivedShipments = Shipment::query()->where('start_at', '=', $today)->count();
      $sendShipments    = Shipment::query()->where('start_at', '=', $today)->where('last_event', '>', 1)->count();
      $transitShipments = Shipment::query()->where([['start_at', '=', $today],['last_event', '>', 2],['last_event', '<', 4]])->count();
      $arribedShipments = Shipment::query()->where('start_at', '=', $today)->where('last_event', '=', 4)->count();
      //$noInvoiceShipments = Shipment::query()->where([['start_at', '=', $today],['invoice', '=', 0]])->count();
      $deliveredShipments = Shipment::query()->where([['start_at', '=', $today],['last_event', '=', 5]])->count();
      /**
      * Liberacion
      */
      $releases = CargoRelease::all();
      $receivedReleases  = CargoRelease::query()->where('start_at', '=', $today)->count();
      $sendReleases      = CargoRelease::query()->where('start_at', '=', $today)->where('last_event', '>', 1)->count();
      $transitReleases   = CargoRelease::query()->where([['start_at', '=', $today],['last_event', '>', 2],['last_event', '<', 4]])->count();
      $arribedReleases   = CargoRelease::query()->where('start_at', '=', $today)->where('last_event', '=', 4)->count();
      //$noInvoiceShipments = Shipment::query()->where([['start_at', '=', $today],['invoice', '=', 0]])->count();
      $deliveredReleases = CargoRelease::query()->where([['start_at', '=', $today],['last_event', '=', 5]])->count();
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
    } elseif ($today == null) {
      $today = Carbon::now()->format('Y-m-d');      /**
      *  top panels
      */
      $packages         = Package::all();
      $receivedPackages = Package::query()->where('start_at', '<=', $today)->count();                                                  /*Paquetes recibidos en el dia actual hoy*/
      $sendPackages     = Package::query()->where('start_at', '<=', $today)->where('last_event', '>', 1)->count();                     /*Paquetes enviados en el dia actual*/
      $transitPackages  = Package::query()->where([['start_at', '<=', $today],['last_event', '>', 2],['last_event', '<', 4]])->count();/*Paquetes enviados en el dia actual*/
      $arribedPackage   = Package::query()->where('start_at', '<=', $today)->where('last_event', '=', 4)->count();                     /*Paquetes recibidos en destino en el dia actual*/
      $delivered        = Package::query()->where([['start_at', '<=', $today],['last_event', '=', 5]])->count();                       /*Paquetes entregados en el dia actual*/
      $laststatus       = Package::query()->where([['start_at', '<=', $today],['last_event', '=', 6]])->count();
      $noInvoice        = Package::query()->where([['start_at', '<=', $today],['invoice', '=', 0]])->count();                          /*Paquetes sn factura en el dia actual*/
      /**
      * bookings
      */
      $bookings          = Booking::all();
      $receivedBookings  = Booking::query()->where('start_at', '<=', $today)->count();                                                  /*Paquetes recibidos en el dia actual hoy*/
      $sendBookings      = Booking::query()->where('start_at', '<=', $today)->where('last_event', '>', 1)->count();                     /*Paquetes enviados en el dia actual*/
      $transitBookings   = Booking::query()->where([['start_at', '<=', $today],['last_event', '>', 2],['last_event', '<', 4]])->count();/*Paquetes enviados en el dia actual*/
      $arribedBookings   = Booking::query()->where('start_at', '<=', $today)->where('last_event', '=', 4)->count();                     /*Paquetes recibidos en destino en el dia actual*/
      $deliveredBookings = Booking::query()->where([['start_at', '<=', $today],['last_event', '=', 5]])->count();                       /*Paquetes entregados en el dia actual*/
      /**
      * Pickup
      */
      $pickups = Pickup::all();
      $receivedPickups = Pickup::query()->where('start_at', '<=', $today)->count();
      $sendPickups    = Pickup::query()->where('start_at', '<=', $today)->where('last_event', '>', 1)->count();
      $transitPickups = Pickup::query()->where([['start_at', '<=', $today],['last_event', '>', 2],['last_event', '<', 4]])->count();
      $arribedPickups = Pickup::query()->where('start_at', '<=', $today)->where('last_event', '=', 4)->count();
      $noInvoicePickups = Pickup::query()->where([['start_at', '<=', $today],['invoice', '=', 0]])->count();
      $deliveredPickups = Pickup::query()->where([['start_at', '<=', $today],['last_event', '=', 5]])->count();
      /**
      * Embarque
      */
      $shipments = Shipment::all();
      $receivedShipments = Shipment::query()->where('start_at', '<=', $today)->count();
      $sendShipments    = Shipment::query()->where('start_at', '<=', $today)->where('last_event', '>', 1)->count();
      $transitShipments = Shipment::query()->where([['start_at', '<=', $today],['last_event', '>', 2],['last_event', '<', 4]])->count();
      $arribedShipments = Shipment::query()->where('start_at', '<=', $today)->where('last_event', '=', 4)->count();
      //$noInvoiceShipments = Shipment::query()->where([['start_at', '<=', $today],['invoice', '=', 0]])->count();
      $deliveredShipments = Shipment::query()->where([['start_at', '<=', $today],['last_event', '=', 5]])->count();
      /**
      * Liberacion
      */
      $releases = CargoRelease::all();
      $receivedReleases  = CargoRelease::query()->where('start_at', '<=', $today)->count();
      $sendReleases      = CargoRelease::query()->where('start_at', '<=', $today)->where('last_event', '>', 1)->count();
      $transitReleases   = CargoRelease::query()->where([['start_at', '<=', $today],['last_event', '>', 2],['last_event', '<', 4]])->count();
      $arribedReleases   = CargoRelease::query()->where('start_at', '<=', $today)->where('last_event', '=', 4)->count();
      //$noInvoiceShipments = Shipment::query()->where([['start_at', '<=', $today],['invoice', '=', 0]])->count();
      $deliveredReleases = CargoRelease::query()->where([['start_at', '<=', $today],['last_event', '=', 5]])->count();
      /**
      * small charts (left)
      */
      $mar  = DB::table('package')->join('transport', 'package.type', '=', 'transport.id')->whereMonth('start_at', '<=', Carbon::parse($today)->format('m'))->where('english','=','maritime')->count();
      $air  = DB::table('package')->join('transport', 'package.type', '=', 'transport.id')->whereMonth('start_at', '<=', Carbon::parse($today)->format('m'))->where('english','=','aerial')->count();
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
      /**
      * vars on the view
      */
      $today = null;
    }
    else {
      $today = Carbon::parse($dashboardDate->date_dashboard)->format('Y-m-d');

      /**
      * top panels
      */
      $receivedPackages = Package::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->count();                                                  /*Paquetes recibidos en el dia actual hoy*/
      $sendPackages     = Package::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('last_event', '>', 1)->count();                     /*Paquetes enviados en el dia actual*/
      $transitPackages  = Package::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('last_event', '>', 2)->where('last_event', '<', 4)->count();/*Paquetes enviados en el dia actual*/
      $arribedPackage   = Package::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('last_event', '=', 4)->count();                     /*Paquetes recibidos en destino en el dia actual*/
      $delivered        = package::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('last_event', '=', 5)->count();                       /*Paquetes entregados en el dia actual*/
      $laststatus        = package::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('last_event', '=', 6)->count();                       /*Paquetes entregados en el dia actual*/
      $noInvoice        = package::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('invoice', '=', 0)->count();
      $packages         = Package::all();
      /**
      * bookings
      */
      $bookings          = Booking::all();
      $receivedBookings  = Booking::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->count();                                                    /*Paquetes recibidos en el dia actual hoy*/
      $sendBookings      = Booking::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('last_event', '>', 1)->count();                     /*Paquetes enviados en el dia actual*/
      $transitBookings   = Booking::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('last_event', '>', 2)->where('last_event', '<', 4)->count();/*Paquetes enviados en el dia actual*/
      $arribedBookings   = Booking::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('last_event', '=', 4)->count();                     /*Paquetes recibidos en destino en el dia actual*/
      $deliveredBookings = Booking::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('last_event', '=', 5)->count();                       /*Paquetes entregados en el dia actual*/
      /**
      * Pickup
      */
      $pickups = Pickup::all();
      $receivedPickups  = Pickup::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->count();                                                  /*Paquetes recibidos en el dia actual hoy*/
      $sendPickups      = Pickup::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('last_event', '>', 1)->count();                     /*Paquetes enviados en el dia actual*/
      $transitPickups   = Pickup::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('last_event', '>', 2)->where('last_event', '<', 4)->count();/*Paquetes enviados en el dia actual*/
      $arribedPickups   = Pickup::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('last_event', '=', 4)->count();                     /*Paquetes recibidos en destino en el dia actual*/
      $deliveredPickups = Pickup::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('last_event', '=', 5)->count();                       /*Paquetes entregados en el dia actual*/
      $noInvoicePickups = package::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('invoice', '=', 0)->count();
      /**
      * Embarque
      */
      $shipments = Shipment::all();
      $receivedShipments  = Pickup::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->count();                                                  /*Paquetes recibidos en el dia actual hoy*/
      $sendShipments      = Pickup::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('last_event', '>', 1)->count();                     /*Paquetes enviados en el dia actual*/
      $transitShipments   = Pickup::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('last_event', '>', 2)->where('last_event', '<', 4)->count();/*Paquetes enviados en el dia actual*/
      $arribedShipments   = Pickup::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('last_event', '=', 4)->count();                     /*Paquetes recibidos en destino en el dia actual*/
      $deliveredShipments = Pickup::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('last_event', '=', 5)->count();                       /*Paquetes entregados en el dia actual*/
      //$noInvoiceShipments = package::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('invoice', '=', 0)->count();
      /**
      * Liberacion
      */
      $releases = CargoRelease::all();                    /*Paquetes sn factura en el dia actual*/
      $receivedReleases  = Pickup::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->count();                                                  /*Paquetes recibidos en el dia actual hoy*/
      $sendReleases      = Pickup::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('last_event', '>', 1)->count();                     /*Paquetes enviados en el dia actual*/
      $transitReleases   = Pickup::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('last_event', '>', 2)->where('last_event', '<', 4)->count();/*Paquetes enviados en el dia actual*/
      $arribedReleases   = Pickup::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('last_event', '=', 4)->count();                     /*Paquetes recibidos en destino en el dia actual*/
      $deliveredReleases = Pickup::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('last_event', '=', 5)->count();                       /*Paquetes entregados en el dia actual*/
      //$noInvoiceShipments = package::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('invoice', '=', 0)->count();
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
    if ($session == null) {
      return redirect('login');
    }
    /**
    *
    */
    $laststatus = Package::query()->where('last_event', '=', 6)->count();
    /**
    * se verifica si hay pickups por atender para notificar al admnistrador
    */
    if (Pickup::byPrice(null)->count() > 0 && $session['type'] == HUserType::OPERATOR) {
      Session::put('errorMessage', Pickup::byPrice(null)->count());
    }
    /**
    *
    */
    switch ($session['type']) {
      case HUserType::OPERATOR :
      $status = Event::query()->where('active','=','1')->get();
      $events_number = 0;
      /**
      *
      */
      foreach ($status as $key => $value) {
        $events_number+=1;
      }
      /**
      *
      */
      $vars = [
        'todayPackage'     => $receivedPackages,
        'sendPackages'     => $sendPackages,
        'transitPackages'  => $transitPackages,
        'laststatus'       => $laststatus,
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
        'packages'         => $packages,
        /**
        * Recogidas
        */
        'pickups'          => $pickups,
        'receivedPickups'  => $receivedPickups,
        'sendPickups'      => $sendPickups,
        'transitPickups'   => $transitPickups,
        'arribedPickups'   => $arribedPickups,
        'noInvoicePickups' => $noInvoicePickups,
        'deliveredPickups' => $deliveredPickups,
        //'noInvoiceShipments' => $noInvoiceShipments,
        'deliveredReleases'  => $deliveredReleases,
        'status'             => $status,
        'events_number'      => $events_number,
        'pickupStatus'       => PickupStatus::query()->where('active','=','1')->get(),
        'shipmentStatus'     => ShipmentStatus::query()->where('active','=','1')->get(),
        'bookingStatus'      => BookingStatus::query()->where('active','=','1')->get(),
        'releaseStatus'      => ReleaseStatus::query()->where('active','=','1')->get(),
        'pickupStatus_number'       => PickupStatus::query()->where('active','=','1')->count(),
        'shipmentStatus_number'     => ShipmentStatus::query()->where('active','=','1')->count(),
        'bookingStatus_number'      => BookingStatus::query()->where('active','=','1')->count(),
        'releaseStatus_number'      => ReleaseStatus::query()->where('active','=','1')->count()
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
      if($value == 1)
      {
        $configDateDashboard->date_dashboard = Carbon::now()->format('Y-m-d');
      }
      /*
      * Se establece la fecha del dia de ayer
      */
      if($value == 2)
      {
        $configDateDashboard->date_dashboard = date_format(new Carbon('yesterday'), 'Y-m-d');
      }
      /*
      * Se establece la fecha del dia de ayer
      */
      if($value == 5)
      {
        $configDateDashboard->date_dashboard = null;
      }
    }
    /**
    * Se modifica la fecha segun lo que indique el usuario para este caso es un dia  especifico o un mes especifico
    */
    else
    {
      /**
      * Se modifica la fecha segun lo que indique el usuario para este caso es un dia especifico
      */
      if($sw == 3)
      {
        $configDateDashboard->date_dashboard = Carbon::parse($value)->format('Y-m'); /** Se establece la fecha para un dia especifico **/
      }
      /**
      * Se modifica la fecha segun lo que indique el usuario para este caso es un dia especifico
      */
      if($sw == 4)
      {
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
    return response()->json(
    [
      "message" => "true",
      "data"    => $value
    ]);
  }
}
