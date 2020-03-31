<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Admin\Transport;
use App\Models\Admin\User;
use App\Models\Admin\Package;
use App\Models\Admin\Pickup;
use App\Models\Admin\Route;
use App\Models\Admin\Vessel;
use App\Models\Admin\TransportType;
use App\Models\Admin\City;
use App\Models\Admin\DetailsTransport;
use App\Models\Admin\Shipment;
use App\Models\Admin\Event;
use App\Models\Admin\Log;
use App\Models\Admin\ShipmentRoute;
use App\Models\Admin\ShipmentDetail;
use App\Models\Admin\Transporters;
use App\Models\Admin\Attachment;
use Input;
use Validator;
use DB;
use App\Helpers\HConstants;

class ShipmentController extends Controller {
  /**
  * Intial Process
  */
  public function index(Request $request) {
    $session   = $request->session()->get('key-sesion');
    $shipments = Shipment::orderBy('created_at', 'desc')->get();
    /**
    *  Se valida que la sesion este activa
    */
    if ($session == null) {
      return redirect('login');
    }
    /**
    *
    */
    $vars = [
      'shipments' => $shipments
    ];
    /**
    *
    */
    return view('pages.admin.shipment.list',$vars);
  }
  /**
  * se modifica un embarque
  */
  public function details(Request $request, $id, $readonly = false) {
    $session         = $request->session()->get('key-sesion');
    /**
    *  Se valida que la sesion este activa
    */
    if ($session == null) {
      return redirect('login');
    }
    /**
    *
    */
    $admin           = $request->session()->get('key-sesion')['data'];
    $shipment        = Shipment::find($id);
    $shipment_route  = ShipmentRoute::byShipment($id)->first();
    $shipment_detail = ShipmentDetail::byShipment($id)->get();
    $transport       = Transport::all();
    $user            = User::all();
    $warehouse       = Package::byEvent(HConstants::EVENT_RECEIVED)->get();
    $pickup          = Pickup::byEvent(HConstants::EVENT_RECEIVED)->get();
    $type            = isset($request->all()['ics_Hd_Type_Shipment']) ? $request->all()['ics_Hd_Type_Shipment'] : null ;
    $count           = $shipment_detail->count();
    /**
    * se valida la existencia del embarque, si falla se redirige al listado
    */
    if(is_null($shipment)) {
      return $this->doRedirect($request, '/admin/shipments')
        ->with('errorMessage', trans('shipment.notFound'));
    }
    /**
    * existen dependiendo el tpo de embarque
    */
    $since_departure        = null;
    $hour_departure         = null;
    $since_arrived          = null;
    $hour_arrived           = null;
    $transporter_shipment   = null;
    $for_aduana             = null;
    $fly_number             = null;
    $vehicle_number         = null;
    $pro_number             = null;
    $tracking_number        = null;
    $driver_name            = null;
    $licence_number         = null;
    $from_city_departure    = null;
    $date_city_departure    = null;
    $hour_city_departure    = null;
    $from_city_arrived      = null;
    $date_city_arrived      = null;
    $hour_city_arrived      = null;
    $pre_transporter        = null;
    $origin_point           = null;
    $origin_pre_transporter = null;
    $dock_terminal          = null;
    $port                   = null;
    $export_transporter     = null;
    $travel_identifier      = null;
    $vessel                 = null;
    $vessel_flag            = null;
    $download_port          = null;
    $deliver_transporter    = null;
    $deliver_city_place     = null;
    $service_type           = null;
    $transport_type         = null;
    $route_type             = null;
    /**
    *
    */
    $vars = [
      'transport'       => $transport,
      'admin'           => $admin,
      'user'            => $user,
      'shipment'        => $shipment,
      'shipment_detail' => $shipment_detail,
      'warehouse'       => $warehouse,
      'pickup'          => $pickup,
      'readonly'        => $readonly
    ];
    /**
    *
    */
    if($this->isGET($request)) {
      return view('pages.admin.shipment.edit',$vars);
    }
    /**
    *
    */
    if($type == 1) {
      /**
      * informacion general
      */
      $since_departure         = ($request->all()['since_departure_maritime'] == "") ? null : $request->all()['since_departure_maritime'] ;
      $hour_departure          = ($request->all()['hour_departure_maritime'] == "") ? null : $request->all()['hour_departure_maritime'] ;
      $since_arrived           = ($request->all()['since_arrived_maritime'] == "") ? null : $request->all()['since_arrived_maritime'] ;
      $hour_arrived            = ($request->all()['hour_arrived_maritime'] == "") ? null : $request->all()['hour_arrived_maritime'] ;
      $transporter_shipment    = ($request->all()['preTransportMaritime_shipment'] == 0) ? null : $request->all()['preTransportMaritime_shipment'] ;
      /**
      * informacion de rutas
      */
      $origin_point           = ($request->all()['originPointMaritime_shipment'] == "") ? null : $request->all()['originPointMaritime_shipment'];
      $origin_pre_transporter = ($request->all()['preTransportPlaceMaritime_shipment'] == 0) ? null : $request->all()['preTransportPlaceMaritime_shipment'];
      $dock_terminal          = ($request->all()['dockMaritime_shipment'] == "") ? null : $request->all()['dockMaritime_shipment'];
      $port                   = ($request->all()['portMaritime_shipment'] == 0) ? null : $request->all()['portMaritime_shipment'];
      $export_transporter     = ($request->all()['carrierExportMaritime_shipment'] == 0) ? null : $request->all()['carrierExportMaritime_shipment'];
      $travel_identifier      = ($request->all()['travelIdentifierMaritime_shipment'] == "") ? null : $request->all()['travelIdentifierMaritime_shipment'];
      $vessel                 = ($request->all()['vesselMaritime_shipment'] == 0) ? null : $request->all()['vesselMaritime_shipment'];
      $vessel_flag            = ($request->all()['vesselFlagMaritime_shipment'] == "") ? null : $request->all()['vesselFlagMaritime_shipment'];
      $download_port          = ($request->all()['downloadPortMaritime_shipment'] == 0) ? null : $request->all()['downloadPortMaritime_shipment'];
      $deliver_transporter    = ($request->all()['carrierDeliverMaritime_shipment'] == 0) ? null : $request->all()['carrierDeliverMaritime_shipment'];
      $deliver_city_place     = ($request->all()['placeDeliverMaritime_shipment'] == 0) ? null :$request->all()['placeDeliverMaritime_shipment'] ;
      $service_type           = ($request->all()['typeServiceMaritime_shipment'] == 0) ? null : $request->all()['typeServiceMaritime_shipment'];
      $transport_type         = ($request->all()['typeTransportMaritime_shipment'] == 0) ? null : $request->all()['typeTransportMaritime_shipment'];
      $route_type             = ($request->all()['typeRouteMaritime_shipment'] == 0) ? null : $request->all()['typeRouteMaritime_shipment'];
    }
    /**
    * aereo
    */
    if($type == 2) {
      /**
      * informacion general
      */
      $transporter_shipment = ($request->all()['carrier_aerial'] == 0) ? null : $request->all()['carrier_aerial'];
      $for_aduana           = ($request->all()['aduana_aerial'] == "") ? null : $request->all()['aduana_aerial'];
      /**
      *
      */
      $fly_number          = ($request->all()['numberTrackingAerial_shipment'] == "") ? null : $request->all()['numberTrackingAerial_shipment'];
      $from_city_departure = ($request->all()['fromAerial_shipment'] == 0) ? null : $request->all()['fromAerial_shipment'];
      $date_city_departure = ($request->all()['departureDateAerial_shipment'] == "") ? null : $request->all()['departureDateAerial_shipment'];
      $hour_city_departure = ($request->all()['hourDepeartureAerial_shipment'] == "") ? null : $request->all()['hourDepeartureAerial_shipment'];
      $from_city_arrived   = ($request->all()['toAerial_shipment'] == 0) ? null : $request->all()['toAerial_shipment'];
      $date_city_arrived   = ($request->all()['arrivedDateAerial_shipment'] == "") ? null : $request->all()['arrivedDateAerial_shipment'];
      $hour_city_arrived   = ($request->all()['hourArrivedAerial_shipment'] == "") ? null : $request->all()['hourArrivedAerial_shipment'];
      $service_type        = ($request->all()['typeServiceAerial_shipment'] == 0) ? null : $request->all()['typeServiceAerial_shipment'];
      $transport_type      = ($request->all()['typeTransportAerial_shipment'] == 0) ? null : $request->all()['typeTransportAerial_shipment'];
      $route_type          = ($request->all()['typeRouteAerial_shipment'] == 0) ? null : $request->all()['typeRouteAerial_shipment'];
    }
    /**
    * terrestre
    */
    if($type == 3) {
      /**
      * informacion general
      */
      $transporter_shipment = ($request->all()['carrierGround_shipment'] == 0) ? null : $request->all()['carrierGround_shipment'];
      /**
      * informcion de rutas
      */
      $vehicle_number      = ($request->all()['numberVehicleGround_shipment'] == "") ? null : $request->all()['numberVehicleGround_shipment'];
      $pro_number          = ($request->all()['numberProGround_shipment'] == "") ? null : $request->all()['numberProGround_shipment'];
      $tracking_number     = ($request->all()['numberTrackingGround_shipment'] == "") ? null : $request->all()['numberTrackingGround_shipment'];
      $driver_name         = ($request->all()['driverVehicleGround_shipment'] == "") ? null : $request->all()['driverVehicleGround_shipment'];
      $licence_number      =  $request->all()['driverLicenceGround_shipment'];
      $from_city_departure = ($request->all()['fromGround_shipment'] == 0 ) ? null : $request->all()['fromGround_shipment'] ;
      $date_city_departure = ($request->all()['fromDateGround_shipment'] == "") ? null : $request->all()['fromDateGround_shipment'] ;
      $hour_city_departure = ($request->all()['fromHourGround_shipment'] == "") ? null : $request->all()['fromHourGround_shipment'] ;
      $from_city_arrived   = ($request->all()['toGround_shipment'] == 0 ) ? null : $request->all()['toGround_shipment'] ;
      $date_city_arrived   = ($request->all()['toDateGround_shipment'] == "") ? null : $request->all()['toDateGround_shipment'] ;
      $hour_city_arrived   = ($request->all()['toHourGround_shipment'] == "") ? null : $request->all()['toHourGround_shipment'] ;
      $service_type        = ($request->all()['typeServiceGround_shipment'] == 0 ) ? null : $request->all()['typeServiceGround_shipment'] ;
      $transport_type      = ($request->all()['typeTransportGround_shipment'] == 0 ) ? null : $request->all()['typeTransportGround_shipment'] ;
      $route_type          = ($request->all()['typeRouteGround_shipment'] == 0 ) ? null : $request->all()['typeRouteGround_shipment'] ;
    }
    /**
    * informacion general
    */
    $data = [
      'name'                  => $request->all()['name_shipment'],
      'operator'              => $request->all()['author_shipment'],
      'number_reservation'    => ($request->all()['reservation_shipment'] == "") ? null : $request->all()['reservation_shipment'] ,
      'number_guide'          => ($request->all()['guide_shipment'] == "") ? null : $request->all()['guide_shipment'],
      'declarate_value'       => $request->all()['declarate_shipment'],
      'realizate_city_place'  => ($request->all()['realizationPlace_shipment'] == "") ? null : $request->all()['realizationPlace_shipment'] ,
      'realizate_city_date'   => ($request->all()['realizationDate_shipment'] == "") ? null : $request->all()['realizationDate_shipment'],
      'realizate_city_hour'   => ($request->all()['realizationHour_shipment'] == "") ? null : $request->all()['realizationHour_shipment'],
      'description'           => ($request->all()['description_shipment'] == "") ? null : $request->all()['description_shipment'] ,
      'transport'             => $type,
      'departure_date_mar'    => $since_departure,
      'departure_hour_mar'    => $hour_departure,
      'arrived_date_mar'      => $since_arrived,
      'arrived_hour_mar'      => $hour_arrived,
      'transporter'           => $transporter_shipment,
      'shipper'               => ($request->all()['shipper_select'] == 0 ) ? null :$request->all()['shipper_select'] ,
      'for_aduana'            => $for_aduana,
      'entity_to_notify'      => ($request->all()['entityToNotify_select'] == 0 ) ? null : $request->all()['entityToNotify_select'],
      'cargo_agent'           => ($request->all()['cargoAgent_select'] == 0 ) ? null     : $request->all()['cargoAgent_select'],
      'consigner'             => ($request->all()['consigneer_select'] == 0 ) ? null     : $request->all()['consigneer_select'],
      'intermediary'          => ($request->all()['intermediate_select'] == 0 ) ? null   : $request->all()['intermediate_select'],
      'destiny_agent'         => ($request->all()['destinyAgent_select'] == 0 ) ? null   : $request->all()['destinyAgent_select']
    ];
    /**
    * Se actualiza el ambarque actual
    */
    $shipment->update($data);
    $shipment->save();
    /**
    * Informacion de ruta
    */
    $data_route = [
      'shipment'               => $shipment->id,
      'service_type'           => $service_type,
      'transport_type'         => $transport_type,
      'route'                  => $route_type,
      'fly_number'             => $fly_number,
      'vehicle_number'         => $vehicle_number,
      'pro_number'             => $pro_number,
      'tracking_number'        => $tracking_number,
      'driver_name'            => $driver_name,
      'licence_number'         => $licence_number,
      'from_city_departure'    => $from_city_departure,
      'date_city_departure'    => $date_city_departure,
      'hour_city_departure'    => $hour_city_departure,
      'from_city_arrived'      => $from_city_arrived,
      'date_city_arrived'      => $date_city_arrived,
      'hour_city_arrived'      => $hour_city_arrived,
      'origin_point'           => $origin_point,
      'pre_transporter'        => $pre_transporter,
      'origin_pre_transporter' => $origin_pre_transporter,
      'dock_terminal'          => $dock_terminal,
      'port'                   => $port,
      'export_transporter'     => $export_transporter,
      'travel_identifier'      => $travel_identifier,
      'vessel'                 => $vessel,
      'vessel_flag'            => $vessel_flag,
      'download_port'          => $download_port,
      'deliver_transporter'    => $deliver_transporter,
      'deliver_city_place'     => $deliver_city_place
    ];
    /**
    *
    */
    $shipment_route->update($data_route);
    $shipment_route->save();
    /**
    * se eliminan los registros asociados al embarque actual
    */
    $shipment_detail = DB::table('shipment_detail')->where('shipment','=',$shipment->id)->delete();
    /**
    * 1) se buscan en la tabla 'package' y 'pickup_orders' los registros asociados al embarque actual
    * 2) se editan los paquetes con status 'recebidos en oficina' que no han sido reservados
    */
    $shipment_warehouse = Package::byProcessAndEvent(HConstants::EVENT_RECEIVED, $shipment->code)->get();
    foreach ($shipment_warehouse as $key => $value) {
      $value->booked    = HConstants::RESPONSE_NULL;
      $value->process = HConstants::RESPONSE_NULL;
      $value->update();
      $value->save();
    }
    /**
    * 3) se crea el embarque con los nuevos warehouse y pickups
    */
    $shipment_pickup = Pickup::byProcessAndEvent(HConstants::EVENT_RECEIVED, $shipment->code)->get();
    foreach ($shipment_pickup as $key => $value) {
      $value->booked    = HConstants::RESPONSE_NULL;
      $value->process = HConstants::RESPONSE_NULL;
      $value->update();
      $value->save();
    }
    /**
    *
    */
    $data_detail = [];
    foreach($request->all() as $value) {
      if(is_string($value)) {
        if(strstr($value, 'wr') || strstr($value, 'pk')) {
            /**
            * se edita el embarque con la nueva carga
            */
            $data_detail = [
              'shipment'  => $shipment->id,
              'pickup'    => (strstr($value, 'pk')) ? substr($value, -1) : null,
              'warehouse' => (strstr($value, 'wr')) ? substr($value, -1) : null
            ];
          $shipment_detail = ShipmentDetail::create($data_detail);
          /**
          * 1) se verifica la existenca de un warehouse en la carga del embarque
          * 2) se edita la columna 'booked' en la tabla 'package'
          */
          if (strstr($value, 'wr')) {
            $package = substr($value, -1);
            $package = Package::find($package);
            $package->booked = HConstants::EVENT_INITIAL;
            $package->process = $shipment->code;
            $package->update();
            $package->save();
          }
          /**
          * 3) se edita la columna 'booked' en la tabla 'pickup'
          */
          if (strstr($value, 'pk')) {
            $pickup = substr($value, -1);
            $pickup = Pickup::find($pickup);
            $pickup->booked = HConstants::EVENT_INITIAL;
            $pickup->process = $shipment->code;
            $pickup->update();
            $pickup->save();
          }
        }
      }
    }
    /**
    *
    */
    return $this->doRedirect($request, "/admin/shipments")->with('successMessage', trans('shipment.updated', [
      'code' => $shipment->code,
      'name' => $shipment->name
    ]));
  }
  /**
  * se crea un embarque
  */
  public function create(Request $request) {
    $session   = $request->session()->get('key-sesion');
    /**
    *  Se valida que la sesion este activa
    */
    if ($session == null) {
      return redirect('login');
    }
    /**
    *
    */
    $admin     = $request->session()->get('key-sesion')['data'];
    $transport = Transport::all();
    $user      = User::all();
    $warehouse = Package::byBooked(HConstants::RESPONSE_NULL)->get();
    $pickup    = Pickup::byBooked(HConstants::RESPONSE_NULL)->get();
    $type      = isset($request->all()['ics_Hd_Type_Shipment']) ? $request->all()['ics_Hd_Type_Shipment'] : null ;
    $count     = isset($request->all()['ics_Hd_Count_Cargo']) ? $request->all()['ics_Hd_Count_Cargo'] : null;
    $admin     = $request->session()->get('key-sesion')['data'];
    /**
    * existen dependiendo el tpo de embarque
    */
    $since_departure        = null;
    $hour_departure         = null;
    $since_arrived          = null;
    $hour_arrived           = null;
    $transporter_shipment   = null;
    $for_aduana             = null;
    $fly_number             = null;
    $vehicle_number         = null;
    $pro_number             = null;
    $tracking_number        = null;
    $driver_name            = null;
    $licence_number         = null;
    $from_city_departure    = null;
    $date_city_departure    = null;
    $hour_city_departure    = null;
    $from_city_arrived      = null;
    $date_city_arrived      = null;
    $hour_city_arrived      = null;
    $pre_transporter        = null;
    $origin_point           = null;
    $origin_pre_transporter = null;
    $dock_terminal          = null;
    $port                   = null;
    $export_transporter     = null;
    $travel_identifier      = null;
    $vessel                 = null;
    $vessel_flag            = null;
    $download_port          = null;
    $deliver_transporter    = null;
    $deliver_city_place     = null;
    $service_type           = null;
    $transport_type         = null;
    $route_type             = null;

    /**
    *
    */
    $vars = [
      'transport'     => $transport,
      'user'          => $user,
      'admin'         => $admin,
      'warehouse'     => $warehouse,
      'pickup'        => $pickup
    ];
    /**
    *
    */
    if($this->isGET($request)) {
      return view('pages.admin.shipment.create',$vars);
    }

    /**
    * se inserta tipo de envio maritimo
    */
    if($type == 1) {
      /**
      * informacion general
      */
      $since_departure       = ($request->all()['since_departure_maritime'] == "") ? null : $request->all()['since_departure_maritime'] ;
      $hour_departure        = ($request->all()['hour_departure_maritime'] == "") ? null : $request->all()['hour_departure_maritime'] ;
      $since_arrived         = ($request->all()['since_arrived_maritime'] == "") ? null : $request->all()['since_arrived_maritime'] ;
      $hour_arrived          = ($request->all()['hour_arrived_maritime'] == "") ? null : $request->all()['hour_arrived_maritime'] ;
      $transporter_shipment  = ($request->all()['preTransportMaritime_shipment'] == 0) ? null : $request->all()['preTransportMaritime_shipment'] ;
      /**
      * informacion de rutas
      */
       $origin_point           = ($request->all()['originPointMaritime_shipment'] == "") ? null : $request->all()['originPointMaritime_shipment'];
       $origin_pre_transporter = ($request->all()['preTransportPlaceMaritime_shipment'] == 0) ? null : $request->all()['preTransportPlaceMaritime_shipment'];
       $dock_terminal          = ($request->all()['dockMaritime_shipment'] == "") ? null : $request->all()['dockMaritime_shipment'];
       $port                   = ($request->all()['portMaritime_shipment'] == 0) ? null : $request->all()['portMaritime_shipment'];
       $export_transporter     = ($request->all()['carrierExportMaritime_shipment'] == 0) ? null : $request->all()['carrierExportMaritime_shipment'];
       $travel_identifier      = ($request->all()['travelIdentifierMaritime_shipment'] == "") ? null : $request->all()['travelIdentifierMaritime_shipment'];
       $vessel                 = ($request->all()['vesselMaritime_shipment'] == 0) ? null : $request->all()['vesselMaritime_shipment'];
       $vessel_flag            = ($request->all()['vesselFlagMaritime_shipment'] == "") ? null : $request->all()['vesselFlagMaritime_shipment'];
       $download_port          = ($request->all()['downloadPortMaritime_shipment'] == 0) ? null : $request->all()['downloadPortMaritime_shipment'];
       $deliver_transporter    = ($request->all()['carrierDeliverMaritime_shipment'] == 0) ? null : $request->all()['carrierDeliverMaritime_shipment'];
       $deliver_city_place     = ($request->all()['placeDeliverMaritime_shipment'] == 0) ? null :$request->all()['placeDeliverMaritime_shipment'] ;
       $service_type           = ($request->all()['typeServiceMaritime_shipment'] == 0) ? null : $request->all()['typeServiceMaritime_shipment'];
       $transport_type         = ($request->all()['typeTransportMaritime_shipment'] == 0) ? null : $request->all()['typeTransportMaritime_shipment'];
       $route_type             = ($request->all()['typeRouteMaritime_shipment'] == 0) ? null : $request->all()['typeRouteMaritime_shipment'];
    }
    /**
    * aereo
    */
    if($type == 2) {
      /**
      *
      */
      $transporter_shipment = ($request->all()['carrier_aerial'] == 0) ? null : $request->all()['carrier_aerial'];
      $for_aduana           = ($request->all()['aduana_aerial'] == "") ? null : $request->all()['aduana_aerial'];
      /**
      *
      */
      $fly_number          = ($request->all()['numberTrackingAerial_shipment'] == "") ? null : $request->all()['numberTrackingAerial_shipment'];
      $from_city_departure = ($request->all()['fromAerial_shipment'] == 0) ? null : $request->all()['fromAerial_shipment'];
      $date_city_departure = ($request->all()['departureDateAerial_shipment'] == "") ? null : $request->all()['departureDateAerial_shipment'];
      $hour_city_departure = ($request->all()['hourDepeartureAerial_shipment'] == "") ? null : $request->all()['hourDepeartureAerial_shipment'];
      $from_city_arrived   = ($request->all()['toAerial_shipment'] == 0) ? null : $request->all()['toAerial_shipment'];
      $date_city_arrived   = ($request->all()['arrivedDateAerial_shipment'] == "") ? null : $request->all()['arrivedDateAerial_shipment'];
      $hour_city_arrived   = ($request->all()['hourArrivedAerial_shipment'] == "") ? null : $request->all()['hourArrivedAerial_shipment'];
      $service_type        = ($request->all()['typeServiceAerial_shipment'] == 0) ? null : $request->all()['typeServiceAerial_shipment'];
      $transport_type      = ($request->all()['typeTransportAerial_shipment'] == 0) ? null : $request->all()['typeTransportAerial_shipment'];
      $route_type          = ($request->all()['typeRouteAerial_shipment'] == 0) ? null : $request->all()['typeRouteAerial_shipment'];
    }
    /**
    * terrestre
    */
    if($type == 3) {
      /**
      *
      */
      $transporter_shipment = ($request->all()['carrierGround_shipment'] == 0) ? null : $request->all()['carrierGround_shipment'];
      /**
      *
      */
      $vehicle_number      = ($request->all()['numberVehicleGround_shipment'] == "") ? null : $request->all()['numberVehicleGround_shipment'];
      $pro_number          = ($request->all()['numberProGround_shipment'] == "") ? null : $request->all()['numberProGround_shipment'];
      $tracking_number     = ($request->all()['numberTrackingGround_shipment'] == "") ? null : $request->all()['numberTrackingGround_shipment'];
      $driver_name         = ($request->all()['driverVehicleGround_shipment'] == "") ? null : $request->all()['driverVehicleGround_shipment'];
      $licence_number      =  $request->all()['driverLicenceGround_shipment'];
      $from_city_departure = ($request->all()['fromGround_shipment'] == 0 ) ? null : $request->all()['fromGround_shipment'] ;
      $date_city_departure = ($request->all()['fromDateGround_shipment'] == "") ? null : $request->all()['fromDateGround_shipment'] ;
      $hour_city_departure = ($request->all()['fromHourGround_shipment'] == "") ? null : $request->all()['fromHourGround_shipment'] ;
      $from_city_arrived   = ($request->all()['toGround_shipment'] == 0 ) ? null : $request->all()['toGround_shipment'] ;
      $date_city_arrived   = ($request->all()['toDateGround_shipment'] == "") ? null : $request->all()['toDateGround_shipment'] ;
      $hour_city_arrived   = ($request->all()['toHourGround_shipment'] == "") ? null : $request->all()['toHourGround_shipment'] ;
      $service_type        = ($request->all()['typeServiceGround_shipment'] == 0 ) ? null : $request->all()['typeServiceGround_shipment'] ;
      $transport_type      = ($request->all()['typeTransportGround_shipment'] == 0 ) ? null : $request->all()['typeTransportGround_shipment'] ;
      $route_type          = ($request->all()['typeRouteGround_shipment'] == 0 ) ? null : $request->all()['typeRouteGround_shipment'] ;
      /**
      *
      */
    }
    /**
    * informacion general
    */
    $data = [
      'name'                  => $request->all()['name_shipment'],
      'operator'              => $request->all()['author_shipment'],
      'number_reservation'    => ($request->all()['reservation_shipment'] == "") ? null : $request->all()['reservation_shipment'] ,
      'number_guide'          => ($request->all()['guide_shipment'] == "") ? null : $request->all()['guide_shipment'],
      'declarate_value'       => $request->all()['declarate_shipment'],
      'realizate_city_place'  => ($request->all()['realizationPlace_shipment'] == "") ? null : $request->all()['realizationPlace_shipment'] ,
      'realizate_city_date'   => ($request->all()['realizationDate_shipment'] == "") ? null : $request->all()['realizationDate_shipment'],
      'realizate_city_hour'   => ($request->all()['realizationHour_shipment'] == "") ? null : $request->all()['realizationHour_shipment'],
      'description'           => ($request->all()['description_shipment'] == "") ? null : $request->all()['description_shipment'] ,
      'transport'             => $type,
      'departure_date_mar'    => $since_departure,
      'departure_hour_mar'    => $hour_departure,
      'arrived_date_mar'      => $since_arrived,
      'arrived_hour_mar'      => $hour_arrived,
      'transporter'           => $transporter_shipment,
      'shipper'               => ($request->all()['shipper_select'] == 0 ) ? null :$request->all()['shipper_select'] ,
      'for_aduana'            => $for_aduana,
      'entity_to_notify'      => ($request->all()['entityToNotify_select'] == 0 ) ? null : $request->all()['entityToNotify_select'],
      'cargo_agent'           => ($request->all()['cargoAgent_select'] == 0 ) ? null     : $request->all()['cargoAgent_select'],
      'consigner'             => ($request->all()['consigneer_select'] == 0 ) ? null     : $request->all()['consigneer_select'],
      'intermediary'          => ($request->all()['intermediate_select'] == 0 ) ? null   : $request->all()['intermediate_select'],
      'destiny_agent'         => ($request->all()['destinyAgent_select'] == 0 ) ? null   : $request->all()['destinyAgent_select']
    ];
    /**
    * Se crea el embarque
    */
    $shipment = Shipment::create($data);
    /**
    *
    */
    $files = Input::file('upload_file');
    /**
    *
    */
    mkdir(asset('/uploads/').$shipment->code);
      if ($files[0] != '') {
        foreach($files as $file) {
            $aleatorio      = str_random();
            $nombre         = $aleatorio.'_'.$file->getClientOriginalName();
            $file->move('uploads/'.$shipment->code."/", $nombre);
            $data = [
            'shipment'      => $shipment->id,
            'booking'       => null,
            'warehouse'     => null,
            'pickup'        => null,
            'cargo_release' => null,
            'transporters'  => null,
            'suppliers'     => null,
            'path'          => asset('/uploads/').$shipment->code."/".$nombre,
            'name_path'     => $nombre,
            'operator'      => $admin->id
          ];
          $attachment = Attachment::create($data);
       }
      }
    /**
    * Informacion de ruta
    */
    $data_route = [
      'shipment'               => $shipment->id,
      'service_type'           => $service_type,
      'transport_type'         => $transport_type,
      'route'                  => $route_type,
      'fly_number'             => $fly_number,
      'vehicle_number'         => $vehicle_number,
      'pro_number'             => $pro_number,
      'tracking_number'        => $tracking_number,
      'driver_name'            => $driver_name,
      'licence_number'         => $licence_number,
      'from_city_departure'    => $from_city_departure,
      'date_city_departure'    => $date_city_departure,
      'hour_city_departure'    => $hour_city_departure,
      'from_city_arrived'      => $from_city_arrived,
      'date_city_arrived'      => $date_city_arrived,
      'hour_city_arrived'      => $hour_city_arrived,
      'origin_point'           => $origin_point,
      'pre_transporter'        => $pre_transporter,
      'origin_pre_transporter' => $origin_pre_transporter,
      'dock_terminal'          => $dock_terminal,
      'port'                   => $port,
      'export_transporter'     => $export_transporter,
      'travel_identifier'      => $travel_identifier,
      'vessel'                 => $vessel,
      'vessel_flag'            => $vessel_flag,
      'download_port'          => $download_port,
      'deliver_transporter'    => $deliver_transporter,
      'deliver_city_place'     => $deliver_city_place
    ];
    /**
    *
    */
    //dd($data_route);
    $shipment_route = ShipmentRoute::create($data_route);
    /**
    *
    */
    $data_detail = [];
    foreach($request->all() as $value){
      if(is_string($value)){
        if(strstr($value, 'wr') || strstr($value, 'pk')) {
          /**
          * se crean los detelles del embarque con los warehouse y los pickup seleccionados
          */
            $data_detail = [
              'shipment'  => $shipment->id,
              'pickup'    => (strstr($value, 'pk')) ? substr($value, -1) : null,
              'warehouse' => (strstr($value, 'wr')) ? substr($value, -1) : null
            ];
          $shipment_detail = ShipmentDetail::create($data_detail);
          /**
          * 1) se verifica la existenca de un warehouse en la carga del embarque
          * 2) se edita la columna 'booked' en la tabla 'package'
          */
          if (strstr($value, 'wr')) {
            $package = substr($value, -1);
            $package = Package::find($package);
            $package->booked  = HConstants::EVENT_INITIAL;
            $package->process = $shipment->code;
            $package->update();
            $package->save();
          }
          /**
          *
          */
          if (strstr($value, 'pk')) {
            $pickup = substr($value, -1);
            $pickup = Pickup::find($pickup);
            $pickup->booked  = HConstants::EVENT_INITIAL;
            $pickup->process = $shipment->code;
            $pickup->update();
            $pickup->save();
          }
        }
      }
    }
    /**
    * Se escribe en la base de datos los datos de los adjuntos relacionados con esta reserva
    * 1) se lee el xml y se agrega el pie del archivo
    * 2) se inserta en la base de datos
    * 3) se borra el archivo
    */
    $xml = 'uploads/tmp/attachment_SH.xml';
    if(file_exists($xml)) {
      /**
      *
      */
      $file = fopen($xml, "a");
      fwrite($file, "</attachment>".PHP_EOL);
      fclose($file);
      $xml_data = simplexml_load_file($xml);
      /**
      *
      */
      foreach ($xml_data as $key => $value) {
        $data = [
          'shipment'      => $shipment->id,
          'booking'       => null,
          'warehouse'     => null,
          'pickup'        => null,
          'cargo_release' => null,
          'path'          => $value->path,
          'name_path'     => $value->name,
          'operator'      => $admin->id
        ];
        $attachment = Attachment::create($data);
      }
      /**
      *
      */
      unlink($xml);
    }
    /**
    *
    */
    return $this->doRedirect($request, "/admin/shipments")->with('successMessage', trans('shipment.created', [
      'code' => $shipment->code,
      'name' => $shipment->name
    ]));
  }
  /**
  * se elimina un embarque
  */
  public function delete(Request $request, $id) {
    $redirect = $this->doRedirect($request, '/admin/shipments');
    $shipment = Shipment::find($id);
    if(is_null($shipment)) {
      $redirect->with('errorMessage', trans('route.notFound'));
    } else {
      $shipment->delete();
      $redirect->with('successMessage', trans('route.deleted', [
        'code' => $shipment->code,
        'name' => $shipment->name
      ]));
    }
    return $redirect;
  }
  /**
  * Retorna complementos del formularo dependiendo el tipo de envio
  */
  public function type(Request $request, $id, $shipment) {

    return response()->json([
    /**
    * llama la vista complementaria para la informacion general del tipo de embarque
    */
    'generalInfo' => asset("admin/shipments/{$id}/loadGeneral/shipment/{$shipment}"),
    /**
    * llama la vista complementaria para las rutas del tipo de embarque
    */
    'routesInfo'  => asset("admin/shipments/{$id}/loadRoutes/shipment/{$shipment}")
    ]);
  }
  /**
  *
  */
  public function view(Request $request, $id) {
    $session        = $request->session()->get('key-sesion');
    $shipmentDetail = ShipmentDetail::byShipment($id)->get();
    $shipment       = Shipment::find($id);
    $event          = Event::query()->where('active','=','1')->get();
    $event_list     = Log::byBooking($shipment->id)->get();
    /**
    *
    */
    $vars = [
    'shipmentDetail'=> $shipmentDetail,
    'shipment'      => $shipment,
    'event'         => $event,
    'event_list'    => $event_list
    ];
    /**
    *
    */
    if($this->isGET($request)) {
    return view('pages.admin.shipment.view', $vars);
    }
    /**
    *
    */
    $shipment->update(['last_event' => $request->all()['status']]);
    $shipment->save();
    /**
    *
    */
    $this->insertLogShipment($shipment->id, $request->all()['status'] , $request->all()['observation'],$shipment->getLastEvent['id'], $session['data']->id);
    /**
    * insertar en el log antes de enviar el response
    */
    return response()->json([
    'message' => true
    ]);
  }
  /**
  * carga los fields complementarios en la vista  'informacion general'
  */
  public function loadGeneral(Request $request, $id, $shipment) {
    $shipment = Shipment::find($shipment);
    /**
    *
    */
    $vars = [
      'route'         => Route::byTransport($id)->get(),
      'vessel'        => Vessel::all(),
      'typeService'   => $this->typeTransport(),
      'typeTransport' => TransportType::byTransport($id)->get(),
      'cities'        => City::all(),
      'ports'         => DetailsTransport::byTransport($id)->get(),
      'transporters'  => Transporters::byTransport($id)->get(),
      'shipment'      => $shipment,
      'shipment_route'=> ($shipment != null ) ? ShipmentRoute::byShipment($shipment->id)->first() : null
    ];
    /**
    *
    */
    if($id == 1) {
      return view('pages.admin.shipment.maritime.general',$vars);
    }
    /**
    *
    */
    if($id == 2) {
      return view('pages.admin.shipment.aerial.general',$vars);
    }
  }
  /**
  *
  */
  public function loadRoutes(Request $request, $id, $shipment) {
    $shipment = Shipment::find($shipment);

    /**
    *
    */
    $vars = [
      'route'         => Route::byTransport($id)->get(),
      'vessel'        => Vessel::all(),
      'typeService'   => $this->typeTransport(),
      'typeTransport' => TransportType::byTransport($id)->get(),
      'cities'        => City::all(),
      'ports'         => DetailsTransport::byTransport($id)->get(),
      'transporters'  => Transporters::byTransport($id)->get(),
      'shipment'      => $shipment,
      'shipment_route'=> ($shipment != null ) ? ShipmentRoute::byShipment($shipment->id)->first() : null
    ];
    /**
    *
    */
    if($id == 1) {
      return view('pages.admin.shipment.maritime.routes', $vars);
    }
    /**
    *
    */
    if($id == 2) {
      return view('pages.admin.shipment.aerial.routes', $vars);
    }
    /**
    *
    */
    if($id == 3) {
      return view('pages.admin.shipment.ground.routes', $vars);
    }
  }
  /**
  *
  */
  public function uploadFile(Request $request) {
    $attachment = $request->file('file');
    $fileName   = str_random().'_'.$attachment->getClientOriginalName();
    $attachment->move('uploads/attachments', $fileName);
   /**
    * creamos un archivo xml para guardar los datos de los adjuntos
    */
    $xml_name = 'uploads/tmp/attachment_SH.xml';
    if(!file_exists($xml_name)) {
      $xml =
    '<?xml version="1.0" encoding="utf-8"?>
      <attachment>
        <attach>
          <name>'.$fileName.'</name>
          <path>'.asset('/uploads/tmp').'/'.$fileName.'</path>
        </attach>';
    } else {
      $xml=
      '<attach>
        <name>'.$fileName.'</name>
        <path>'.asset('/uploads/tmp').'/'.$fileName.'</path>
      </attach>';
    }
    $file = fopen($xml_name, "a");
    fwrite($file, $xml.PHP_EOL);
    fclose($file);
  }
}
