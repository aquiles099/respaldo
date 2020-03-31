<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Admin\Client;
use App\Models\Admin\Courier;
use App\Models\Admin\Consolidated;
use App\Models\Admin\Tax;
use App\Models\Admin\Receipt;
use App\Models\Admin\User;
use App\Models\Admin\Country;
use App\Models\Admin\Office;
use App\Models\Admin\Configuration;
use App\Models\Admin\Packages\Transport;
use App\Models\Admin\Package;
use App\Models\Admin\Company;
use App\Models\Admin\Promotion;
use App\Models\Admin\Transporters;
use App\Models\Admin\FromCourier;
use App\Models\Admin\Category;
use App\Models\Admin\Suppliers;
use App\Models\Admin\DetailsReceipt;
use App\Models\Admin\Detailspackage;
use App\Models\Admin\DetailsPickup;
use App\Models\Admin\Service;
use App\Models\Admin\AddCharge;
use App\Models\Admin\PackageConsolidated;
use App\Models\Admin\File;
use App\Models\Admin\Pickup;
use App\Models\Admin\PickupStatus;
use App\Models\Admin\TypePickup;
use App\Models\Admin\NumberParts;
use App\Models\Admin\Log;
use App\Models\Admin\Event;
use App\Models\Admin\Warehouse;
use App\Models\Admin\Attachment;
use Input;
use Carbon\Carbon;
use Validator;
use DB;
use App\Helpers\HConstants;
use App\Helpers\HUserType;
use Cookie;

class PickupController extends Controller {
    /**
     * [__construct description]
     */
    public function __construct () {
      $this->middleware('admin:' . HUserType::OPERATOR);
    }
    /**
     * [insertPickup description]
     * @param  [type]  $idPickup        [description]
     * @param  [type]  $idEvent         [description]
     * @param  [type]  $observation     [description]
     * @param  [type]  $idPreviousEvent [description]
     * @param  integer $idUser          [description]
     * @return [type]                   [description]
     */
    protected function insertPickup($idPickup, $idEvent, $observation, $idPreviousEvent = null, $idUser = 4) {

      $configuration = Configuration::find(1);
      /**
      *
      */
      if ($configuration->time_zone == null) {
        $configuration->time_zone = 'America/Caracas (UTC-04:30)';
        $configuration->save();
      }
      /**
      *
      */
      $timezone = explode(" ", $configuration->time_zone);
      date_default_timezone_set($timezone[0]);
      /**
      *
      */
      $log = Log::create([
        'pickup' => $idPickup,
        'user' => $idUser,
        'event'=> $idEvent,
        'previous_event'=> $idPreviousEvent,
        'observation' => $observation
      ]);
      /**
      *
      */
      $package = Pickup::find($idPickup);
      $package->update(['last_event' => $idEvent]);
      $package->save();
      return $log;
    }
    /**
     * [index description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function index (Request $request) {
      $session = $request->session()->get('key-sesion');
      $pickup = Pickup::all();
      /**
      *  Se valida que la sesion este activa
      */
      if ( $session == null ) {
        return redirect('login');
      }
      /**
      *
      */
      $vars = [
        'pickup' => $pickup
      ];
      /**
      *
      */
      return view('pages.admin.pickup.list', $vars);
    }
    /**
     * [create description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function create ( Request $request ) {
      $session = $request->session()->get('key-sesion');
      $admin   =  $request->session()->get('key-sesion')['data'];
      $start_at = Carbon::now()->format('Y-m-d');
      $validator = $this->validateData($request);
      $taxs = Tax::byStatus(1)->get();
      $taxss = array();
      /**
      *  Se valida que la sesion este activa
      */
      if ( $session == null ) {
        return redirect('login');
      }
      /**
      *
      */
      foreach ( $taxs as $key => $tax ) {
        $valtax='tax'.$tax->id;
        if ($valtax==isset($request->all()[$valtax])) {
          array_push($taxss, array('name' => $valtax, 'value' => $request->all()[$valtax], 'value_oring' => $tax->id) );
        }
      }
      /**
      *
      */
      $vars = [
        'countries'   => Country::all(),
        'promotions'  => Promotion::all(),
        'consolidated'=> Consolidated::byStatus(1)->get(),
        'couriers'    => Courier::byStatus()->get(),
        'users'       => User::byUserType(1)->get(),
        'tax'         => $taxs,
        'transports'  => Transport::all(),
        'suppliers'   => Suppliers::all(),
        'transporters'=> Transporters::all(),
        'category'    => Category::all(),
        'start_at'    => Carbon::now()->format('Y-m-d'),
        'office'      => Office::all(),
        'services'    => '',
        'addcharges'  => AddCharge::all(),
        'typepickup'  => TypePickup::all(),
        'numberparts' => NumberParts::all(),
        'taxxes'      => (isset($request->all()['tax1']) ? $taxss : '')
      ];
      /**
      *
      */
      if ( $this->isGET($request) ) {
        return view('pages.admin.pickup.create', $vars);
      }
      /**
      *
      */
      if( $request->all()['exporter'] == '0' ) {
        $userCons = null;
      }
      /**
      *
      */
      if ( $request->all()['consigner'] == '' ) {
        $userDest = null;
      }
      /**
      *
      */
      $pickupData = [
        'from_courier'      => isset($request->all()['courierSelect']) ? $request->all()['courierSelect'] : null,
        'promotion'         => null,
        'observation'       => null,
        'insurance'         => null,
        'volumetricweightm' => null,
        'volumetricweighta' => null,
        'costservice'       => null,
        'costinsurance'     => null,
        'aditionalcost'     => null,
        'subtotal'          => null,
        'total'             => null,
        'tax'               => null,
        'pro'               => null,
        'value'             => null,
        'type'              => null,
        'details_type'      => null,
        'category'          => null,
        'office'            => null,
        'typeservice'       => null,
        'start_at'          => null,
        'to_user'           => (($request->all()['consigner'] == '')||(!isset($request->all()['consigner']))) ? $userDest :$request->all()['consigner'],
        'consigner_user'    => (($request->all()['exporter'] == '0')||(!isset($request->all()['exporter'])))? $userCons:$request->all()['exporter'],
        'addcharge'         => ($request->all()['addcharge'] == "") ? 0 :$request->all()['addcharge'],
        'invoice'           => (($request->all()['invoiced1'] == '')||(!isset($request->all()['invoiced1'])))? '' :$request->all()['invoiced1'],
        'last_event'        => 1,
        'notes'             => (!isset($request->all()['notes'])||($request->all()['notes']=='')) ? null : $request->all()['notes'],
        'country_shipper'   => (!isset($request->all()['cons_country'])||($request->all()['cons_country']=='')) ? null : $request->all()['cons_country'],
        'region_shipper'    => (!isset($request->all()['cons_region'])||($request->all()['cons_region']=='')) ? null : $request->all()['cons_region'],
        'city_shipper'      => (!isset($request->all()['cons_city'])||($request->all()['cons_city']=='')) ? null : $request->all()['cons_city'],
        'address_shipper'   => (!isset($request->all()['cons_direction'])||($request->all()['cons_direction']=='')) ? null : $request->all()['cons_direction'],
        'location_shipper'  => (!isset($request->all()['consigner_dir'])||($request->all()['exporter_dir']=='')) ? '0' : $request->all()['exporter_dir'],
        'country_consig'    => (!isset($request->all()['destin_country'])||($request->all()['destin_country']=='')) ? null : $request->all()['destin_country'],
        'region_consig'     => (!isset($request->all()['destin_region'])||($request->all()['destin_region']=='')) ? null : $request->all()['destin_region'],
        'city_consig'       => (!isset($request->all()['destin_city'])||($request->all()['destin_city']=='')) ? null : $request->all()['destin_city'],
        'address_consig'    => (!isset($request->all()['destin_direction'])||($request->all()['destin_direction']=='')) ? null : $request->all()['destin_direction'],
        'location_consig'   => (!isset($request->all()['exporter_dir'])||($request->all()['exporter_dir']=='')) ? '0' : $request->all()['exporter_dir'],
        'provider'          => (!isset($request->all()['supplier'])||($request->all()['supplier']=='')) ? '0' : $request->all()['supplier'],
        'po_number'         => (!isset($request->all()['purchase_order'])||($request->all()['purchase_order']=='')) ? null : $request->all()['purchase_order'],
        'transporter'       => (!isset($request->all()['transporter'])||($request->all()['transporter']=='')) ? '0' : $request->all()['transporter'],
        'trans_tracking'    => (!isset($request->all()['tracking_transporter'])||($request->all()['tracking_transporter']=='')) ? null : $request->all()['tracking_transporter'],
        'pickup_number'     => (!isset($request->all()['pickup_number'])||($request->all()['pickup_number']=='')) ? null : $request->all()['pickup_number'],
        'pickup_date'       => $request->all()['pickup_date'].' '.$request->all()['pickup_hour'],
        'deliver_date'      => $request->all()['deliver_date'].' '.$request->all()['deliver_hour']
      ];
      /**
      *
      */
      $pickup = Pickup::create($pickupData);
      $files = Input::file('upload_file');
      mkdir( asset('/uploads/') . $pickup->code );
      /**
      *
      */
      if ($files[0] != '') {
        foreach ($files as $file) {
          $aleatorio      = str_random();
          $nombre         = $aleatorio.'_'.$file->getClientOriginalName();
          $file->move('uploads/'.$pickup->code."/", $nombre);
          /**
          *
          */
          $data = [
          'shipment'      => null,
          'booking'       => null,
          'warehouse'     => null,
          'pickup'        => $pickup->id,
          'cargo_release' => null,
          'transporters'  => null,
          'suppliers'     => null,
          'path'          => asset('/uploads/').'/'.$pickup->code."/".$nombre,
          'name_path'     => $nombre,
          'operator'      => $admin->id
          ];
          /**
          *
          */
          $attachment = Attachment::create($data);
        }
      }
      /**
      *
      */
      for ($i = 1; $i <= $request->all()['countpack']; $i++) {
        $pickupdetailsData = [
          'description'       => $request->all()['description'.$i],
          'numberparts'       => $request->all()['numberparts'.$i],
          'pieces'            => $request->all()['pieces'.$i],
          'large'             => $request->all()['large'.$i],
          'width'             => $request->all()['width'.$i],
          'height'            => $request->all()['height'.$i],
          'weight'            => $request->all()['weight'.$i],
          'volumetricweightm'  => $request->all()['volumetricweightm'.$i],
          'volumetricweighta'  => $request->all()['volumetricweighta'.$i],
          'value'             => $request->all()['valued'.$i],
          'invoice'           => $request->all()['invoiced'.$i],
          'tracking'          => $request->all()['tracking'.$i],
          //'po'                => $request->all()['po'.$i],
          'pickup'            => $pickup->id
        ];
        $pickupdetails=DetailsPickup::create($pickupdetailsData);
      }
      /*
      Se carga la factura en caso que aplique

      if($request->all()['invoice']=="1"){
      $file           = Input::file('file');
      $aleatorio      = str_random();
      $nombre         = $aleatorio.'_'.$file->getClientOriginalName();
      /*
      * Datos de la factura a subir
      *
      $data = [
      "name"           => $nombre,
      "path"           => asset('/uploads')."/".$nombre,
      "id_package"     => $pikcup->id,
      "carrier"        => $request->all()['courierSelect'],
      "contentPackage" => "1",
      "pricePackage"   => $request->all()['value']
      ];*/
      /*
      * Se almacenan los datos del archivo subido
      *
      $file->move('uploads', $nombre);
      $save = File::create($data);
      }
      /**
      *Se agrega el paquete al consolidado en caso de que aplique
      */
      /*if(!$request->all()['consolidated']=='') {
      $consol = [
      'package'       =>  $pikcup->id,
      'consolidated'  =>  $request->all()['consolidated'],
      'observation'   =>  $request->all()['observation']
      ];

      }
      /**
      * Se agrega el envio al recibo
      */
      $session = $request->session()->get('key-sesion');
      /********************************************************/
      /*    CALCULAR AQUI TOTAL Y SUBTOTAL DE LOS PICKUP      */
      /********************************************************/

      $receipt = $this->setreceiptpickup($pickup->id, isset($request->all()['observation']) ? $request->all()['observation'] : null , isset($request->all()['subtotal']) ? $request->all()['subtotal'] : '0' , isset($request->all()['total']) ? $request->all()['total'] : '0' );
      /**
      *
      */
      foreach ($taxs as $tax) {
        $valtax = 'tax' . $tax->id;
        if ($valtax==isset($request->all()[$valtax])) {
          $receipts = [
            'receipt'         =>  $receipt->id,
            'type_cost'       =>  $tax->type,
            'type_attribute'  =>  'I',
            'id_complemento'  =>  $tax->id,
            'name_oring'      =>  $tax->name,
            'value_oring'     =>  $tax->value,
            'value_package'   =>  $request->all()[$valtax]
          ];
          DetailsReceipt::create($receipts);
        }
      }

      /* $idpro = $request->all()['promotion'];

      if ($idpro != "") {
      $promo= Promotion::find($idpro);
      $promotion = [
      'receipt'         =>  $receipt->id,
      'type_cost'       =>  $promo->type_value,
      'type_attribute'  =>  'P',
      'id_complemento'  =>  $promo->id,
      'name_oring'      =>  $promo->name,
      'value_oring'     =>  $promo->value,
      'value_package'   =>  $request->all()['promotionval']
      ];
      DetailsReceipt::create($promotion);
      }
      */
      /* $idserv = $request->all()['type'];
      if ($idserv != "") {
      $service= Service::find($idserv);
      $serviceData = [
      'receipt'         =>  $receipt->id,
      'type_cost'       =>  1,
      'type_attribute'  =>  'S',
      'id_complemento'  =>  $service->id,
      'name_oring'      =>  $service->name,
      'value_oring'     =>  $service->value,
      'value_package'   =>  $service->value
      ];
      DetailsReceipt::create($serviceData);
      }
      */
      /**
      *
      */
      if ($request->all()['addcharge']) {
        $addcharge= AddCharge::find($idcharge);
        $addchargeData = [
        'receipt'         =>  $receipt->id,
        'type_cost'       =>  1,
        'type_attribute'  =>  'A',
        'id_complemento'  =>  $addcharge->id,
        'name_oring'      =>  $addcharge->name,
        'value_oring'     =>  $addcharge->value,
        'value_package'   =>  $addcharge->value
        ];
        DetailsReceipt::create($addchargeData);
      }
      /**
      *
      */
      /*if ($request->all()['insurance']) {
      $insuranceData = [
      'receipt'         =>  $receipt->id,
      'type_cost'       =>  1,
      'type_attribute'  =>  'IN',
      'id_complemento'  =>  1,
      'name_oring'      =>  "Seguro",
      'value_oring'     =>  $request->all()['insurance'],
      'value_package'   =>  $request->all()['toinsurance']
      ];
      DetailsReceipt::create($insuranceData);
      } */
      /**
      *
      */
      /*$idtrans  =$request->all()['type'];
      if ( $idtrans != "") {
      $addtransport=Transport::find($idtrans);
      $transportData = [
      'receipt'         =>  $receipt->id,
      'type_cost'       =>  1,
      'type_attribute'  =>  'T',
      'id_complemento'  =>  1,
      'name_oring'      =>  $addtransport->spanish,
      'value_oring'     =>  $addtransport->price,
      'value_package'   =>  $addtransport->price
      ];
      DetailsReceipt::create($transportData);
      }*/
      /**
      * se notifica al usuario
      */
      if ($request->all()['consigner'] != HConstants::RESPONSE_NULL) {
        $this->notifyUserPickup($request->all()['consigner'], HConstants::EVENT_RECEIVED, $pickup->id);
      }
      /**
      *
      */
      $this->insertLogPickup($pickup->id, 1,isset($request->all()['note']) ? $request->all()['note'] : null ,null,$session['data']->id);
      return redirect("/admin/pickup")->with('successMessage', trans('package.created', [
        'tracking' => $pickup->tracking,
        'code' => $pickup->code
      ]));
    }
    /**
     * [validateDatacurriers description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    private function validateDatacurriers ( Request $request ) {
     return Validator::make($this->clear($request->all()), [
        'large1'               => 'required|string|min:1',
        'width1'               => 'required|string|min:1',
        'height1'              => 'required|string|min:1',
        'weight1'              => 'required|string|min:1',
        'value'                => 'required|string|min:1',
        'type'                 => 'required|string|min:1',
        'office'               => 'required|string|min:1',
        'service'              => 'required|string|min:1',
        'category'             => 'required|string|min:1',
        'finalConsigUser'      => 'required|string|min:1',
        'finalDestinationUser' => 'required|string|min:1',

      ]);
    }
    /**
     * [details description]
     * @param  Request $request  [description]
     * @param  [type]  $id       [description]
     * @param  boolean $readonly [description]
     * @return [type]            [description]
     */
    public function details (Request $request, $id, $readonly = false) {

      $session    = $request->session()->get('key-sesion');
      $admin      =  $request->session()->get('key-sesion')['data'];
      $pickup     = Pickup::find($id);
      $edit       = true;
      $attachment = Attachment::query()->where('pickup','=',$id)->get();
      /**
      *
      */
      if ( $session == null ) {
        return redirect('login');
      }
      /**
      *
      */
      if ( is_null($pickup) ) {
        return $this->doRedirect($pickup, '/admin/typepickup')->with('errorMessage', trans('typepickup.notFound'));
      }
      /**
      *
      */
      $vars = [
        'pickup'      => $pickup,
        'attachments' => $attachment,
        'edit'        => $edit,
        'numberparts' => NumberParts::all(),
        'users'       => User::byUserType(1)->get(),
        'usercons'    => isset($pickup->consigner_user) ? User::find($pickup->consigner_user)->first():null,
        'userdestin'  => isset($pickup->to_user) ? User::find($pickup->to_user)->first():null,
        'couriers'    => Courier::byStatus()->get(),
        'typepickup'  => TypePickup::all(),
        'transports'  => Transport::all(),
        'office'      => Office::all(),
        'consolidated'=> Consolidated::byStatus(1)->get(),
        'services'    => Service::all(),
        'category'    => Category::all(),
        'start_at'    => Carbon::now()->format('Y-m-d'),
        'addcharges'  => AddCharge::all(),
        'countries'   => Country::all(),
        'promotions'  => Promotion::all(),
        'suppliers'   => Suppliers::all(),
        'transporters'=> Transporters::all(),
        'taxxes'      => (isset($request->all()['tax1']) ? $taxss : ''),
        'readonly'    => $readonly,
        'cookie'      => Cookie::get('storage_data')
      ];
      /**
      * Se obtiene la vista para editar
      */
      if ( $this->isGET($request) ) {
        return view('pages.admin.pickup.edit', $vars);
      }
      /**
      *
      */
      $pickupData = [
        'from_courier'      => isset($request->all()['courierSelect']) ? $request->all()['courierSelect'] : null,
        'promotion'         => null,
        'observation'       => null,
        'insurance'         => null,
        'volumetricweightm' => $request->all()['volumetricweightm1'],
        'volumetricweighta' => $request->all()['volumetricweighta1'],
        'costservice'       => null,
        'costinsurance'     => null,
        'aditionalcost'     => null,
        'subtotal'          => null,
        'total'             => null,
        'tax'               => null,
        'pro'               => null,
        'value'             => null,
        'details_type'      => null,
        'category'          => null,
        'office'            => null,
        'typeservice'       => null,
        'start_at'          => null,
        'to_user'           => (($request->all()['consigner'] == '')||(!isset($request->all()['consigner']))) ? null :$request->all()['consigner'],
        'consigner_user'    => (($request->all()['exporter'] == '0')||(!isset($request->all()['exporter'])))? null:$request->all()['exporter'],
        'addcharge'         => ($request->all()['addcharge'] == "") ? 0 :$request->all()['addcharge'],
        'invoice'           => (($request->all()['invoiced1'] == '')||(!isset($request->all()['invoiced1'])))? '' :$request->all()['invoiced1'],
        'last_event'        => 1,
        'notes'             => (!isset($request->all()['notes'])||($request->all()['notes']=='')) ? null : $request->all()['notes'],
        'country_shipper'   => (!isset($request->all()['cons_country'])||($request->all()['cons_country']=='')) ? null : $request->all()['cons_country'],
        'region_shipper'    => (!isset($request->all()['cons_region'])||($request->all()['cons_region']=='')) ? null : $request->all()['cons_region'],
        'city_shipper'      => (!isset($request->all()['cons_city'])||($request->all()['cons_city']=='')) ? null : $request->all()['cons_city'],
        'address_shipper'   => (!isset($request->all()['cons_direction'])||($request->all()['cons_direction']=='')) ? null : $request->all()['cons_direction'],
        'location_shipper'  => (!isset($request->all()['consigner_dir'])||($request->all()['exporter_dir']=='')) ? '0' : $request->all()['exporter_dir'],
        'country_consig'    => (!isset($request->all()['destin_country'])||($request->all()['destin_country']=='')) ? null : $request->all()['destin_country'],
        'region_consig'     => (!isset($request->all()['destin_region'])||($request->all()['destin_region']=='')) ? null : $request->all()['destin_region'],
        'city_consig'       => (!isset($request->all()['destin_city'])||($request->all()['destin_city']=='')) ? null : $request->all()['destin_city'],
        'address_consig'    => (!isset($request->all()['destin_direction'])||($request->all()['destin_direction']=='')) ? null : $request->all()['destin_direction'],
        'location_consig'   => (!isset($request->all()['exporter_dir'])||($request->all()['exporter_dir']=='')) ? '0' : $request->all()['exporter_dir'],
        'provider'          => (!isset($request->all()['supplier'])||($request->all()['supplier']=='')) ? '0' : $request->all()['supplier'],
        'po_number'         => (!isset($request->all()['purchase_order'])||($request->all()['purchase_order']=='')) ? null : $request->all()['purchase_order'],
        'transporter'       => (!isset($request->all()['transporter'])||($request->all()['transporter']=='')) ? '0' : $request->all()['transporter'],
        'trans_tracking'    => (!isset($request->all()['tracking_transporter'])||($request->all()['tracking_transporter']=='')) ? null : $request->all()['tracking_transporter'],
        'pickup_number'     => (!isset($request->all()['pickup_number'])||($request->all()['pickup_number']=='')) ? null : $request->all()['pickup_number'],
        'pickup_date'       => $request->all()['pickup_date'].' '.$request->all()['pickup_hour'],
        'deliver_date'      => $request->all()['deliver_date'].' '.$request->all()['deliver_hour'],
        'destin_phone'      => (!isset($request->all()['destin_phone'])||($request->all()['destin_phone']=='')) ? null : $request->all()['destin_phone'],
        'shipper_phone'     => (!isset($request->all()['cons_phone'])||($request->all()['cons_phone']=='')) ? null : $request->all()['cons_phone'],
        'type_destin'       => (!isset($request->all()['type_destin'])||($request->all()['type_destin']=='')) ? 1 : $request->all()['type_destin'],
        'destin_name'       => (!isset($request->all()['destin_name'])||($request->all()['destin_name']=='')) ? null : $request->all()['destin_name']
      ];
      /**
      *
      */
      /**
      *
      */
        $country_id = $pickupData['country_consig'];
        $pickup_weight = $request->all()['weight1'];
        $pickup_type = (isset($request->all()['typepickup1']) && ($request->all()['typepickup1'] != 0) ? $request->all()['typepickup1'] : 1);
        $calculable = [
          'country' => $country_id,
          'weight'  => $pickup_weight,
          'type' => $pickup_type
        ];
        $temp = 0.0;
        for ($i = 1; $i <= $request->all()['countpack']; $i++){
          $n = $request->all()['weight'.$i] * 1.0;
          $aux = (string) number_format($n,1,'.','');
          $decimal = substr( ($aux), strpos( $aux, "." ));

          $decimal = ($decimal*1);
          if($decimal > 0.5){
            $n -= $decimal;
            $decimal = 0;
            $n++;
          }else
          if(($decimal <= 0.5) && ($decimal != 0)){
            $n -= $decimal;
            $n += ($n + 0.5);
          }

          $weight_rounded = number_format($n,1,'.','');
          $calculable['type'] = (isset($request->all()['typepickup1']) && ($request->all()['typepickup1'] != 0) ? $request->all()['typepickup1'] : 1);
          $calculable['weight'] = ($weight_rounded > 0.0) ? $weight_rounded : 0.5;
          $temp += $this->getPricePickup($calculable);
          if ($temp == 0) {
            $recogida = TypePickup::find($pickup_type);
            $pais = Country::find($country_id);
            return view('pages.admin.pickup.edit', $vars)->with('errorMessage','El tipo de recogida '.strtoupper($recogida->name).' no está disponible en '.strtoupper($pais->name).'. Verifique estos datos para continuar.');
          }
        }
        $chargeValue = ($pickupData['addcharge'] != 0) ? AddCharge::find($pickupData['addcharge']) : false;
        if($chargeValue){
          $price = $temp + $chargeValue['value'];
        }else {
          $price = $temp;
        }
        $pickup->update($pickupData);
        $pickup->details_type = $pickup_type *1;
        $pickup->price = $price;
        $pickup->save();

        $files = Input::file('upload_file');
          mkdir(asset('/uploads/').$pickup->code,0777,true);
          //$files = Request::file('upload_file');
          if ($files[0] != '') {
            foreach($files as $file) {

                $aleatorio      = str_random();
                $nombre         = $aleatorio.'_'.$file->getClientOriginalName();
                $file->move('uploads/'.$pickup->code."/", $nombre);

                $data = [
                'shipment'      => null,
                'booking'       => null,
                'warehouse'     => null,
                'pickup'        => $pickup->id,
                'cargo_release' => null,
                'transporters'  => null,
                'suppliers'     => null,
                'path'          => asset('/uploads/').'/'.$pickup->code."/".$nombre,
                'name_path'     => $nombre,
                'operator'      => $admin->id
              ];
              $attachment = Attachment::create($data);
           }
        }
      DB::table('detailspackage')->where('package', '=', $id)->delete();
      /**
      *
      */
      //$pickupdetails = DetailsPickup::query()->where('pickup','=',$id)->get();
      $trackings = [];
      DB::table('details_pickup_order')->where('pickup', '=', $id)->delete();
      for ($i = 1; $i <= $request->all()['countpack']; $i++) {
        $calculable = [
          'country' => $country_id,
          'weight'  => $weight_rounded,
          'type' => $pickup_type
        ];

        $n = $request->all()['weight'.$i] * 1.0;
        $aux = (string) number_format($n,1,'.','');
        $decimal = substr( ($aux), strpos( $aux, "." ));

        $decimal = ($decimal * 1);
        if ($decimal > 0.5) {
          $n -= $decimal;
          $decimal = 0;
          $n++;
        } else if (($decimal <= 0.5) && ($decimal != 0)) {
          $n -= $decimal;
          $n += ($n + 0.5);
        }

        $weight_rounded = number_format($n, 1, '.', '');
        $calculable['weight'] = $weight_rounded;
        $pickupdetailsData = [
          'description' => $request->all()['description'.$i],
          'type' => isset($request->all()['typepickup'.$i]) ? $request->all()['typepickup'.$i] : null,
          'numberparts' => isset($request->all()['numberparts'.$i]) ? $request->all()['numberparts'.$i] : "",
          'pieces' => $request->all()['pieces'.$i],
          'large' => $request->all()['large'.$i],
          'width' => $request->all()['width'.$i],
          'height' => $request->all()['height'.$i],
          'weight' => $request->all()['weight'.$i],
          'volumetricweightm' => $request->all()['volumetricweightm'.$i],
          'volumetricweighta' => $request->all()['volumetricweighta'.$i],
          'value' => $request->all()['valued'.$i],
          'invoice' => $request->all()['invoiced'.$i],
          'tracking' => $request->all()['tracking'.$i],
        //  'po'                => $request->all()['po'.$i],
          'pickup' => $pickup->id,
          'price' => $this->getPricePickup($calculable)
        ];

          array_push($trackings,$pickupdetailsData);
      /**
      *
      */
        $pickupdetails=DetailsPickup::create($pickupdetailsData);
      }
      $this->notifyUserTrackings($request->all()['consigner'], HConstants::EVENT_RECEIVED, $pickup->id, $trackings);
      /**
      *
      */
      return redirect("/admin/pickup")->with('successMessage', trans('package.updated', [
         'name' => $pickup->name,
         'code' => $pickup->code
      ]));
    }
    /**
     * [readDetails description]
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function readDetails (Request $request, $id) {
      $session = $request->session()->get('key-sesion');
      /**
      *  Se valida que la sesion este activa
      */
      if ( $session == null ) {
        return redirect('login');
      }
      /**
      *
      */
      return $this->details($request, $id, true);
    }
    /**
     * [type description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function type ( Request $request ) {
      $type = TypePickup::all();
      /**
      *
      */
      return response()->json([
        "message" => $type
      ]);
    }
    /**
     * [typeselected description]
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function typeselected ( Request $request, $id ) {
      $type = DetailsPickup::query()->where('pickup','=',$id)->get();
      /**
      *
      */
      return response()->json([
        "message" => $type
      ]);
    }
    /**
     * [numberparts description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function numberparts(Request $request) {
      $numberparts = NumberParts::all();
      /**
      *
      */
      return response()->json([
        "message" => $numberparts
      ]);
    }
    /**
     * [delete description]
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function delete ( Request $request, $id ) {
      $redirect = $this->doRedirect($request, '/admin/typepickup');
      $tipepickup = Pickup::find($id);
      /**
      *
      */
      if ( is_null($tipepickup) ) {
        $redirect->with('errorMessage', trans('typepickup.notFound'));
      } else {
        $tipepickup->delete();
        return redirect('admin/pickup')->with('successMessage', trans('typepickup.deleted', [
          'name' => $tipepickup->name,
          'code' => $tipepickup->code
        ]));
      }
      /**
      *
      */
      return $redirect;
    }
    /**
     * [validateData description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    private function validateData( Request $request ) {
      return Validator::make($this->clear($request->all()), [
        'name'         => 'required|string|min:3|max:100|unique:typepickup,name',
        'description'  => 'required|string|min:3|max:100|unique:typepickup,description'
      ]);
    }
    /**
     * [items description]
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function items ( Request $request, $id ) {
      $pickupDetail       = DetailsPickup::bypickup($id)->get();
      $pickupDetailCount = DetailsPickup::bypickup($id)->count();
      /**
      *
      */
      if ( $pickupDetail ) {
        return response()->json([
          "message" => 'true',
          "alert"   => $pickupDetail
        ]);
      } else {
        return response()->json([
          "message" => 'false'
        ]);
      }
    }
    /**
     * [showpickup description]
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function showpickup ( Request $request, $id ) {
      $session = $request->session()->get('key-sesion');
      $pickup = Pickup::find($id);
      $packageLog = Log::ByPickup($pickup->id)->get();
      $invoice  = File::query()->where("id_package", "=", $id)->get();
      $detailspackage  = DetailsPickup::query()->where('pickup','=',$id)->get();
      $event = PickupStatus::query()->where('active','=','1')->get();
      $events_number = PickupStatus::query()->where('active','=','1')->count();
      $attachment = Attachment::query()->where('pickup','=',$id)->get();
      /**
      *  Se valida que la sesion este activa
      */
      if ( $session == null ) {
        return redirect('login');
      }
      /**
      *
      */
      $companyclient = "";
      if ( isset($pickup->to_client) ) {
        $client          = Client::find($pickup->to_client);
        $companyclient   = Company::find($client->company);
      }
      /**
      *
      */
      $vars = [
        'package' => $pickup,
        'country_consig' => Country::find($pickup->country_consig)->name,
        'attachments' => $attachment,
        'detailspack'=> $detailspackage,
        'packageLog' => $packageLog,
        'event' => $event,
        'events_num' => $events_number,
        'invoice' => $invoice,
        'companyclient' => $companyclient
      ];
      /**
      * Se obtiene la vista para ver detalles del paquete
      */
      if ( $this->isGET($request) ) {
        return view('pages.admin.pickup.view', $vars);
      }
      /**
      * Guardar la informacion del paquete
      */
      $session = $request->session()->get('key-sesion');
      $this->insertPickup($pickup->id, $request->all()['event'], $request->all()['observation'], null, $session['data']->id);
      /**
      *
      */
      if ( !is_null($pickup->to_user) ) {
        //$this->notifyUserPickup($pickup->to_user, $request->all()['event'], $pickup->id);
      }
      /**
      *
      */
      return response()->json([
      "message" => "true"
      ]);
    }
    /**
     * [addwr description]
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function addwr(Request $request,$id) {
      $pickupdata = [
        'pickup'   =>  $id
      ];
      Warehouse::create( $pickupdata );
      return response()->json([
        "message" => "true"
      ]);
    }
    /**
     * [getPrice description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getPrice ( Request $request ) {

      $type = $request->all()['type_package'];
      $weight = $request->all()['weight'];
      $n = $weight;
      $aux = (string) $n;
      $decimal = substr( $aux, strpos( $aux, "." ));
      $decimal = ($decimal*1);

      if ( $decimal > 0.5 ) {
        $n -= $decimal;
        $decimal = 0;
        $n++;
      } else if ( $decimal <= 0.5 ) {
        $n -= $decimal;
        $n += ($n + 0.5);
      }

      $weight = number_format($n, 1 ,'.', '');

      if ( $weight == 0.0 ) {
        $weight = 0.5;
      }

      $country = $request->all()['country'];
      $country = Country::find($country);
      /**
       * DHL SOBRE
       */
      if ( $type == '1' ) {
        $dhl_envelope = $this->getPriceAray( $type );
        $price = $dhl_envelope[$country->dhl_zone][$weight];
        return response()->json([
          "price" => $price
        ]);
      }
      /**
       * DHL PAQUETE
       */      
      if ( $type == '2' ) {
        $dhl_packages = $this->getPriceAray( $type );
        $price = ( $dhl_packages[$country->dhl_zone][$weight] );
        return response()->json([
          "price" => $price
        ]);
      }
      /**
       * FEDEX
       */
      if ( $type == '3' ) {
        $fedex_envelope = $this->getPriceAray( $type );
        $price = ( $fedex_envelope[$country->fedex_zone]['default'] );
        return response()->json([
          "price" => $price
        ]);
      }
      /**
       * FEDEX
       */
      if ( $type == '4' ) {
        $fedex_pak = $this->getPriceAray( $type );
        $price = ( $fedex_pak[$country->fedex_zone][$weight] );
        return response()->json([
          "price" => $price
        ]);
      }
      /**
       * FEDEX
       */      
      if ( $type == '5' ) {
        $fedex_packages = $this->getPriceAray( $type );
        $price = ( $fedex_packages[$country->fedex_zone][$weight] );
        return response()->json([
          "price" => $price
        ]);
      }
    }
    /**
     * [getPricePickup description]
     * @param  [type] $array [description]
     * @return [type]        [description]
     */
    public function getPricePickup ( $array ) {
      $type = $array['type'];
      $weight = number_format($array['weight'], 1,'.', '');
      $country = $array['country'];
      $country = Country::find($country);
      /**
      *
      */
      if ( $country == null ) {
        return 0;
      }
      /**
      *
      */
      if ( $weight <= 0.0 ) {
        $weight = '0.5';
      }
      /**
      *
      */
      if ( $type == '1') {
        if ( $weight > 2.0 ) {
          $weight = '2.0';
        }
        /**
        *
        */
        if ( ($country->dhl_zone == 0) ) {
          return 0.1;
        }
        /**
        *
        */
        $dhl_envelope = $this->getPriceAray($type);
        $price = ($country->dhl_zone !='') ? $dhl_envelope[$country->dhl_zone][$weight] : 0;
        return $price;
      }
      /**
      *
      */
      if ( $type == '2' ) {
        if ( $weight > 20.0 ) {
          $weight = '20.0';
        }
        /**
        *
        */
        if ( $country->dhl_zone == 0 ) {
          return 0.1;
        }
        /**
        *
        */
        $dhl_packages = $this->getPriceAray($type);
        $price = ($country->dhl_zone != '') ?  ($dhl_packages[$country->dhl_zone][$weight]) : 0;
        return $price;
      }
      /**
      *
      */
      if ( $type == '3' ) {
        if ( $country->fedex_zone == 0 ) {
          return 0.1;
         }
        $fedex_envelope = $this->getPriceAray($type);
        $price = (($country->fedex_zone!='')) ? ($fedex_envelope[$country->fedex_zone]['default']) : 0;
        return $price;
      }
      /**
      *
      */
      if ( $type == '4' ) {
        if ( $weight > 2.5 ) {
          $weight = '2.5';
        }
        /**
        *
        */
        if ( $country->fedex_zone == 0 ) {
          return 0.1;
        }
        /**
        *
        */
        $fedex_pak = $this->getPriceAray($type);
        $price = ($country->fedex_zone != '') ? ($fedex_pak[$country->fedex_zone][$weight]) : 0;
        return $price;
      }
      /**
      *
      */
      if ( $type == '5' ) {
        if ( $weight > 70.5 ) {
          $weight = '70.5';
        }
        /**
        *
        */
        if ( $country->fedex_zone == 0 ) {
          return 0.1;
        }
        /**
        *
        */
        $fedex_packages = $this->getPriceAray($type);
        $price = ($country->fedex_zone != '') ? ($fedex_packages[$country->fedex_zone][$weight]) : 0;
        return $price;
      }
    }
    /**
     * [getPriceAray description]
     * @param  [type] $type [description]
     * @return [type]       [description]
     */
    public function getPriceAray ( $type ) {

      $dhl_envelope = [
        '1'=> ['0.5' => '20.66','1.0' => '39.90','1.5' => '58.26','2.0' => '76.62'],
        '2'=> ['0.5' => '37.95','1.0' => '48.24','1.5' => '72.84','2.0' => '97.44'],
        '3'=> ['0.5' => '38.19','1.0' => '49.29','1.5' => '72.57','2.0' => '95.85'],
        '4'=> ['0.5' => '54.99','1.0' => '70.23','1.5' => '101.22','2.0' => '132.21'],
        '5'=> ['0.5' => '55.68','1.0' => '70.92','1.5' => '101.94','2.0' => '132.96'],
        '6'=> ['0.5' => '56.79','1.0' => '72.03','1.5' => '102.03','2.0' => '132.03'],
        '7'=> ['0.5' => '75.48','1.0' => '96.27','1.5' => '137.67','2.0' => '179.07']
      ];

      $dhl_packages = [
        '1'=> [
          '0.5' => '55.68',
          '1.0' => '63.60',
          '1.5' => '71.73',
          '2.0' => '79.86',
          '2.5' => '87.99',
          '3.0' => '94.20',
          '3.5' => '100.41',
          '4.0' => '106.62',
          '4.5' => '112.83',
          '5.0' => '119.04',
          '5.5' => '125.25',
          '6.0' => '131.46',
          '6.5' => '137.67',
          '7.0' => '143.88',
          '7.5' => '150.09',
          '8.0' => '156.30',
          '8.5' => '162.51',
          '9.0' => '168.72',
          '9.5' => '174.93',
          '10.0' => '181.14',
          '10.5' => '186.14',
          '11.0' => '191.64',
          '11.5' => '196.89',
          '12.0' => '202.14',
          '12.5' => '207.39',
          '13.0' => '212.64',
          '13.5' => '217.89',
          '14.0' => '223.14',
          '14.5' => '228.39',
          '15.0' => '233.64',
          '15.5' => '238.89',
          '16.0' => '244.14',
          '16.5' => '249.39',
          '17.0' => '254.64',
          '17.5' => '259.89',
          '18.0' => '265.14',
          '18.5' => '270.39',
          '19.0' => '275.64',
          '19.5' => '280.89',
          '20.0'=> '286.14'
        ],
        '2'=> [
          '0.5' => '63.96',
          '1.0' => '75.36',
          '1.5' => '87.03',
          '2.0' => '98.70',
          '2.5' => '110.37',
          '3.0' => '117.90',
          '3.5' => '125.43',
          '4.0' => '132.96',
          '4.5' => '140.49',
          '5.0' => '148.02',
          '5.5' => '155.55',
          '6.0' => '163.08',
          '6.5' => '170.61',
          '7.0' => '178.14',
          '7.5' => '185.67',
          '8.0' => '193.20',
          '8.5' => '200.73',
          '9.0' => '208.26',
          '9.5' => '215.79',
          '10.0' => '223.32',
          '10.5' => '227.73',
          '11.0' => '232.14',
          '11.5' => '236.55',
          '12.0' => '240.96',
          '12.5' => '245.37',
          '13.0' => '249.78',
          '14.0' => '254.19',
          '14.5' => '258.60',
          '15.0' => '263.01',
          '15.5' => '267.42',
          '16.0' => '271.83',
          '16.5' => '276.24',
          '17.0' => '280.65',
          '17.5' => '289.47',
          '18.0' => '293.88',
          '18.5' => '298.29',
          '19.0' => '302.70',
          '19.5' => '307.11',
          '20.0'=> '311.52'
        ],
        '3'=> [
          '0.5' => '65.52',
          '1.0' => '76.47',
          '1.5' => '87.96',
          '2.0' => '99.45',
          '2.5' => '110.94',
          '3.0' => '119.64',
          '3.5' => '128.34',
          '4.0' => '137.04',
          '4.5' => '145.74',
          '5.0' => '154.44',
          '5.5' => '162.72',
          '6.0' => '171.00',
          '6.5' => '179.28',
          '7.0' => '187.56',
          '7.5' => '195.84',
          '8.0' => '204.12',
          '8.5' => '212.40',
          '9.0' => '220.68',
          '9.5' => '228.96',
          '10.0' => '237.24',
          '10.5' => '241.89',
          '11.0' => '246.54',
          '11.5' => '251.19',
          '12.0' => '255.84',
          '12.5' => '260.49',
          '13.0' => '265.14',
          '13.5' => '269.79',
          '14.0' => '274.44',
          '14.5' => '279.09',
          '15.0' => '283.74',
          '15.5' => '288.39',
          '16.0' => '293.04',
          '16.5' => '297.69',
          '17.0' => '302.34',
          '17.5' => '306.99',
          '18.0' => '311.64',
          '18.5' => '316.29',
          '19.0' => '320.94',
          '19.5' => '325.59',
          '20.0'=> '330.59'
        ],
        '4'=> [
          '0.5' => '91.20',
          '1.0' => '104.91',
          '1.5' => '118.95',
          '2.0' => '132.99',
          '2.5' => '147.03',
          '3.0' => '159.09',
          '3.5' => '171.15',
          '4.0' => '183.21',
          '4.5' => '195.27',
          '5.0' => '207.33',
          '5.5' => '218.85',
          '6.0' => '230.37',
          '6.5' => '241.89',
          '7.0' => '253.41',
          '7.5' => '264.93',
          '8.0' => '276.45',
          '8.5' => '287.97',
          '9.0' => '299.49',
          '9.5' => '311.01',
          '10.0' => '322.53',
          '10.5' => '328.77',
          '11.0' => '335.01',
          '11.5' => '341.25',
          '12.0' => '347.49',
          '12.5' => '353.73',
          '13.0' => '359.97',
          '13.5' => '366.21',
          '14.0' => '372.45',
          '14.5' => '378.69',
          '15.0' => '384.93',
          '15.5' => '391.17',
          '16.0' => '397.41',
          '16.5' => '403.65',
          '17.0' => '409.89',
          '17.5' => '416.13',
          '18.0' => '422.37',
          '18.5' => '428.61',
          '19.0' => '434.85',
          '19.5' => '441.09',
          '20.0'=> '447.33'
        ],
        '5'=> [
          '0.5' => '90.45',
          '1.0' => '104.07',
          '1.5' => '118.05',
          '2.0' => '132.03',
          '2.5' => '146.01',
          '3.0' => '158.01',
          '3.5' => '170.01',
          '4.0' => '182.01',
          '4.5' => '194.01',
          '5.0' => '206.01',
          '5.5' => '217.50',
          '6.0' => '228.99',
          '6.5' => '240.48',
          '7.0' => '251.97',
          '7.5' => '263.46',
          '8.0' => '274.95',
          '8.5' => '286.44',
          '9.0' => '297.93',
          '9.5' => '309.42',
          '10.0' => '320.91',
          '10.5' => '327.18',
          '11.0' => '333.72',
          '11.5' => '339.72',
          '12.0' => '345.99',
          '12.5' => '352.26',
          '13.0' => '358.53',
          '13.5' => '364.80',
          '14.0' => '371.07',
          '14.5' => '377.34',
          '15.0' => '383.61',
          '15.5' => '389.88',
          '16.0' => '396.15',
          '16.5' => '402.42',
          '17.0' => '408.69',
          '17.5' => '414.96',
          '18.0' => '421.23',
          '18.5' => '427.50',
          '19.0' => '433.77',
          '19.5' => '440.04',
          '20.0'=> '446.31'
        ],
        '6'=> [
          '0.5' => '89.46',
          '1.0' => '102.69',
          '1.5' => '116.34',
          '2.0' => '129.99',
          '2.5' => '143.64',
          '3.0' => '155.31',
          '3.5' => '166.98',
          '4.0' => '178.65',
          '4.5' => '190.32',
          '5.0' => '201.99',
          '5.5' => '213.12',
          '6.0' => '224.25',
          '6.5' => '235.38',
          '7.0' => '246.51',
          '7.5' => '257.64',
          '8.0' => '268.77',
          '8.5' => '279.90',
          '9.0' => '291.03',
          '9.5' => '302.16',
          '10.0' => '313.29',
          '10.5' => '322.38',
          '11.0' => '331.47',
          '11.5' => '340.56',
          '12.0' => '349.65',
          '12.5' => '358.74',
          '13.0' => '367.83',
          '13.5' => '376.92',
          '14.0' => '386.01',
          '14.5' => '395.10',
          '15.0' => '404.19',
          '15.5' => '413.28',
          '16.0' => '422.37',
          '16.5' => '431.46',
          '17.0' => '440.55',
          '17.5' => '449.64',
          '18.0' => '458.73',
          '18.5' => '467.82',
          '19.0' => '476.91',
          '19.5' => '486.00',
          '20.0'=> '495.09'
        ],
        '7'=> [
          '0.5' => '140.55',
          '1.0' => '160.59',
          '1.5' => '181.20',
          '2.0' => '201.81',
          '2.5' => '222.42',
          '3.0' => '240.42',
          '3.5' => '258.42',
          '4.0' => '276.42',
          '4.5' => '294.42',
          '5.0' => '312.42',
          '5.5' => '329.55',
          '6.0' => '346.68',
          '6.5' => '363.81',
          '7.0' => '380.94',
          '7.5' => '398.07',
          '8.0' => '415.20',
          '8.5' => '432.33',
          '9.0' => '449.46',
          '9.5' => '466.59',
          '10.0' => '483.72',
          '10.5' => '498.30',
          '11.0' => '512.88',
          '11.5' => '527.46',
          '12.0' => '542.04',
          '12.5' => '556.62',
          '13.0' => '571.20',
          '13.5' => '585.78',
          '14.0' => '600.36',
          '14.5' => '614.94',
          '15.0' => '629.52',
          '15.5' => '644.10',
          '16.0' => '658.68',
          '16.5' => '673.26',
          '17.0' => '687.84',
          '17.5' => '702.42',
          '18.0' => '717.00',
          '18.5' => '731.58',
          '19.0' => '746.16',
          '19.5' => '760.74',
          '20.0'=> '775.32'
        ]
      ];

      $fedex_envelope = [
        'A'=> [
          'default' => '28.80'
        ],
        'B'=> [
          'default' => '28.98'
        ],
        'C'=> [
          'default' => '34.14'
        ],
        'D'=> [
          'default' => '37.68'
        ],
        'E'=> [
          'default' => '38.70'
        ],
        'F'=> [
          'default' => '43.32'
        ],
        'G'=> [
          'default' => '49.38'
        ],
        'H'=> [
          'default' => '52.14'
        ]
      ];

      $fedex_pak = [
        'A'=> [
          '0.5' => '29.94',
          '1.0' => '34.08',
          '1.5' => '39.48',
          '2.0' => '44.88',
          '2.5' => '50.28'
        ],
        'B'=> [
          '0.5' => '31.20',
          '1.0' => '37.26',
          '1.5' => '43.08',
          '2.0' => '48.90',
          '2.5' => '54.72'
        ],
        'C'=> [
          '0.5' => '36.54',
          '1.0' => '45.90',
          '1.5' => '53.58',
          '2.0' => '61.26',
          '2.5' => '68.94'
        ],
        'D'=> [
          '0.5' => '39.12',
          '1.0' => '48.42',
          '1.5' => '56.82',
          '2.0' => '65.22',
          '2.5' => '73.62'
        ],
        'E'=> [
          '0.5' => '41.40',
          '1.0' => '50.34',
          '1.5' => '57.90',
          '2.0' => '65.46',
          '2.5' => '73.02'
        ],
        'F'=> [
          '0.5' => '45.42',
          '1.0' => '55.14',
          '1.5' => '64.92',
          '2.0' => '74.70',
          '2.5' => '84.48'
        ],
        'G'=> [
          '0.5' => '50.94',
          '1.0' => '61.50',
          '1.5' => '73.02',
          '2.0' => '84.54',
          '2.5' => '96.06'
        ],
        'H'=> [
          '0.5' => '54.72',
          '1.0' => '67.38',
          '1.5' => '81.00',
          '2.0' => '94.62',
          '2.5' => '108.24'
        ]
      ];

      $fedex_packages = [
        'A'=> [
          '0.5' => '54.96',
          '1.0' => '62.16',
          '1.5' => '69.36',
          '2.0' => '76.56',
          '2.5' => '83.76',
          '3.0' => '88.20',
          '3.5' => '92.64',
          '4.0' => '97.08',
          '4.5' => '101.52',
          '5.0' => '105.96',
          '5.5' => '111.96',
          '6.0' => '117.96',
          '6.5' => '123.96',
          '7.0' => '129.96',
          '7.5' => '135.96',
          '8.0' => '141.96',
          '8.5' => '147.96',
          '9.0' => '153.96',
          '9.5' => '159.96',
          '10.0' => '165.96',
          '10.5' => '169.86',
          '11.0' => '173.76',
          '11.5' => '177.66',
          '12.0' => '181.56',
          '12.5' => '185.46',
          '13.0' => '189.36',
          '13.5' => '193.26',
          '14.0' => '197.16',
          '14.5' => '201.06',
          '15.0' => '204.96',
          '15.5' => '208.86',
          '16.0' => '212.76',
          '16.5' => '216.66',
          '17.0' => '220.56',
          '17.5' => '224.46',
          '18.0' => '228.36',
          '18.5' => '229.32',
          '19.0' => '229.32',
          '19.5' => '229.32',
          '20.0' => '229.32',
          '20.5' => '229.32',
          '21.0' => '229.32',
          '21.5' => '240.24',
          '22.0' => '240.24',
          '22.5' => '251.16',
          '23.0' => '251.16',
          '23.5' => '262.08',
          '24.0' => '262.08',
          '24.5' => '273.00',
          '25.0' => '273.00',
          '25.5' => '283.92',
          '26.0' => '283.92',
          '26.5' => '294.84',
          '27.0' => '294.84',
          '27.5' => '305.76',
          '28.0' => '305.76',
          '28.5' => '316.68',
          '29.0' => '316.68',
          '29.5' => '327.60',
          '30.0' => '327.60',
          '30.5' => '338.52',
          '31.0' => '338.52',
          '31.5' => '349.44',
          '32.0' => '349.44',
          '32.5' => '360.36',
          '33.0' => '360.36',
          '33.5' => '371.28',
          '34.0' => '371.28',
          '34.5' => '382.20',
          '35.0' => '382.20',
          '35.5' => '393.12',
          '36.0' => '393.12',
          '36.5' => '404.04',
          '37.0' => '404.04',
          '37.5' => '414.96',
          '38.0' => '414.96',
          '38.5' => '425.88',
          '39.0' => '425.88',
          '39.5' => '436.80',
          '40.0' => '436.80',
          '40.5' => '447.72',
          '41.0' => '447.72',
          '41.5' => '458.64',
          '42.0' => '458.64',
          '42.5' => '461.70',
          '43.0' => '461.70',
          '43.5' => '461.70',
          '44.0' => '461.70',
          '44.5' => '461.70',
          '45.0' => '461.70',
          '45.5' => '471.96',
          '46.0' => '471.96',
          '46.5' => '482.22',
          '47.0' => '482.22',
          '47.5' => '492.48',
          '48.0' => '492.48',
          '48.5' => '502.74',
          '49.0' => '502.74',
          '49.5' => '513.00',
          '50.0' => '513.00',
          '50.5' => '523.26',
          '51.0' => '523.26',
          '51.5' => '533.52',
          '52.0' => '533.52',
          '52.5' => '543.78',
          '53.0' => '543.78',
          '53.5' => '545.28',
          '54.0' => '545.28',
          '54.5' => '545.28',
          '55.0' => '545.28',
          '55.5' => '545.28',
          '56.0' => '545.28',
          '56.5' => '545.28',
          '57.0' => '545.28',
          '57.5' => '545.28',
          '58.0' => '545.28',
          '58.5' => '545.28',
          '59.0' => '545.28',
          '59.5' => '545.28',
          '60.0' => '545.28',
          '60.5' => '545.28',
          '61.0' => '545.28',
          '61.5' => '545.28',
          '62.0' => '545.28',
          '62.5' => '545.28',
          '63.0' => '545.28',
          '63.5' => '545.28',
          '64.0' => '545.28',
          '64.5' => '545.28',
          '65.0' => '545.28',
          '65.5' => '545.28',
          '66.0' => '545.28',
          '66.5' => '545.28',
          '67.0' => '545.28',
          '67.5' => '545.28',
          '68.0' => '545.28',
          '68.5' => '545.28',
          '69.0' => '545.28',
          '69.5' => '545.28',
          '70.0' => '545.28',
          '70.5' => '545.28'
        ],
        'B'=> [
          '0.5' => '57.42',
          '1.0' => '64.26',
          '1.5' => '71.10',
          '2.0' => '77.94',
          '2.5' => '84.78',
          '3.0' => '90.54',
          '3.5' => '96.30',
          '4.0' => '102.06',
          '4.5' => '107.82',
          '5.0' => '113.58',
          '5.5' => '119.22',
          '6.0' => '124.86',
          '6.5' => '130.60',
          '7.0' => '136.14',
          '7.5' => '141.76',
          '8.0' => '147.42',
          '8.5' => '153.06',
          '9.0' => '156.70',
          '9.5' => '164.34',
          '10.0' => '169.98',
          '10.5' => '174.42',
          '11.0' => '178.86',
          '11.5' => '183.30',
          '12.0' => '187.74',
          '12.5' => '192.18',
          '13.0' => '196.62',
          '13.5' => '201.06',
          '14.0' => '205.50',
          '14.5' => '209.94',
          '15.0' => '214.36',
          '15.5' => '218.62',
          '16.0' => '223.26',
          '16.5' => '227.70',
          '17.0' => '232.14',
          '17.5' => '236.58',
          '18.0' => '241.02',
          '18.5' => '245.48',
          '19.0' => '245.70',
          '19.5' => '245.70',
          '20.0' => '245.70',
          '20.5' => '245.70',
          '21.0' => '245.70',
          '21.5' => '257.40',
          '22.0' => '257.40',
          '22.5' => '269.10',
          '23.0' => '269.10',
          '23.5' => '280.80',
          '24.0' => '280.80',
          '24.5' => '292.50',
          '25.0' => '292.50',
          '25.5' => '304.20',
          '26.0' => '304.20',
          '26.5' => '315.90',
          '27.0' => '315.90',
          '27.5' => '327.60',
          '28.0' => '327.60',
          '28.5' => '339.30',
          '29.0' => '339.30',
          '29.5' => '351.00',
          '30.0' => '351.00',
          '30.5' => '362.70',
          '31.0' => '362.70',
          '31.5' => '374.40',
          '32.0' => '374.40',
          '32.5' => '306.10',
          '33.0' => '386.10',
          '33.5' => '397.80',
          '34.0' => '397.80',
          '34.5' => '409.50',
          '35.0' => '409.50',
          '35.5' => '413.10',
          '36.0' => '413.10',
          '36.5' => '413.10',
          '37.0' => '413.10',
          '37.5' => '413.10',
          '38.0' => '413.10',
          '38.5' => '413.10',
          '39.0' => '413.10',
          '39.5' => '413.10',
          '40.0' => '413.10',
          '40.5' => '413.10',
          '41.0' => '413.10',
          '41.5' => '413.10',
          '42.0' => '413.10',
          '42.5' => '413.10',
          '43.0' => '413.10',
          '43.5' => '413.10',
          '44.0' => '413.10',
          '44.5' => '413.10',
          '45.0' => '413.10',
          '45.5' => '422.28',
          '46.0' => '422.28',
          '46.5' => '431.46',
          '47.0' => '431.46',
          '47.5' => '440.64',
          '48.0' => '440.64',
          '48.5' => '449.82',
          '49.0' => '449.82',
          '49.5' => '459.00',
          '50.0' => '459.00',
          '50.5' => '468.18',
          '51.0' => '468.18',
          '51.5' => '477.36',
          '52.0' => '477.36',
          '52.5' => '486.54',
          '53.0' => '433.54',
          '53.5' => '495.72',
          '54.0' => '495.72',
          '54.5' => '504.90',
          '55.0' => '504.90',
          '55.5' => '514.08',
          '56.0' => '514.08',
          '56.5' => '523.26',
          '57.0' => '523.26',
          '57.5' => '532.44',
          '58.0' => '532.44',
          '58.5' => '532.50',
          '59.0' => '532.50',
          '59.5' => '532.50',
          '60.0' => '532.50',
          '60.5' => '532.50',
          '61.0' => '532.50',
          '61.5' => '532.50',
          '62.0' => '532.50',
          '62.5' => '532.50',
          '63.0' => '532.50',
          '63.5' => '532.50',
          '64.0' => '532.50',
          '64.5' => '532.50',
          '65.0' => '532.50',
          '65.5' => '532.50',
          '66.0' => '532.50',
          '66.5' => '532.50',
          '67.0' => '532.50',
          '67.5' => '532.50',
          '68.0' => '532.50',
          '68.5' => '532.50',
          '69.0' => '532.50',
          '69.5' => '532.50',
          '70.0' => '532.50',
          '70.5' => '532.50'
        ],
        'C'=> [
          '0.5' => '61.56',
          '1.0' => '71.70',
          '1.5' => '81.84',
          '2.0' => '91.98',
          '2.5' => '102.12',
          '3.0' => '109.38',
          '3.5' => '116.64',
          '4.0' => '123.90',
          '4.5' => '131.16',
          '5.0' => '138.42',
          '5.5' => '145.74',
          '6.0' => '153.06',
          '6.5' => '160.38',
          '7.0' => '167.70',
          '7.5' => '175.02',
          '8.0' => '182.34',
          '8.5' => '189.68',
          '9.0' => '196.98',
          '9.5' => '204.30',
          '10.0' => '211.62',
          '10.5' => '215.04',
          '11.0' => '218.46',
          '11.5' => '221.88',
          '12.0' => '225.30',
          '12.5' => '228.72',
          '13.0' => '232.14',
          '13.5' => '235.56',
          '14.0' => '238.98',
          '14.5' => '242.40',
          '15.0' => '245.82',
          '15.5' => '249.24',
          '16.0' => '252.66',
          '16.5' => '256.08',
          '17.0' => '259.50',
          '17.5' => '262.92',
          '18.0' => '266.34',
          '18.5' => '269.76',
          '19.0' => '273.18',
          '19.5' => '276.60',
          '20.0' => '278.46',
          '20.5' => '278.46',
          '21.0' => '278.46',
          '21.5' => '291.72',
          '22.0' => '291.72',
          '22.5' => '304.98',
          '23.0' => '304.98',
          '23.5' => '318.24',
          '24.0' => '318.24',
          '24.5' => '331.50',
          '25.0' => '331.50',
          '25.5' => '344.76',
          '26.0' => '344.76',
          '26.5' => '358.02',
          '27.0' => '358.02',
          '27.5' => '371.28',
          '28.0' => '371.28',
          '28.5' => '384.54',
          '29.0' => '384.54',
          '29.5' => '397.00',
          '30.0' => '397.80',
          '30.5' => '411.03',
          '31.0' => '411.06',
          '31.5' => '423.90',
          '32.0' => '423.90',
          '32.5' => '423.90',
          '33.0' => '423.90',
          '33.5' => '423.90',
          '34.0' => '423.90',
          '34.5' => '423.90',
          '35.0' => '423.90',
          '35.5' => '423.90',
          '36.0' => '423.90',
          '36.5' => '423.90',
          '37.0' => '423.90',
          '37.5' => '423.90',
          '38.0' => '423.90',
          '38.5' => '423.90',
          '39.0' => '423.90',
          '39.5' => '423.90',
          '40.0' => '423.90',
          '40.5' => '423.90',
          '41.0' => '423.90',
          '41.5' => '423.90',
          '42.0' => '423.90',
          '42.5' => '423.90',
          '43.0' => '423.90',
          '43.5' => '423.90',
          '44.0' => '423.90',
          '44.5' => '423.90',
          '45.0' => '423.90',
          '45.5' => '433.32',
          '46.0' => '433.32',
          '46.5' => '442.74',
          '47.0' => '442.74',
          '47.5' => '452.16',
          '48.0' => '452.16',
          '48.5' => '461.58',
          '49.0' => '461.58',
          '49.5' => '471.00',
          '50.0' => '471.00',
          '50.5' => '460.42',
          '51.0' => '480.42',
          '51.5' => '489.84',
          '52.0' => '489.64',
          '52.5' => '499.26',
          '53.0' => '499.28',
          '53.5' => '503.68',
          '54.0' => '500.69',
          '54.5' => '510.10',
          '55.0' => '519.10',
          '55.5' => '527.52',
          '56.0' => '527.52',
          '56.5' => '536.94',
          '57.0' => '536.94',
          '57.5' => '546.36',
          '58.0' => '546.35',
          '58.5' => '555.73',
          '59.0' => '555.73',
          '59.5' => '595.20',
          '60.0' => '595.20',
          '60.5' => '574.92',
          '61.0' => '574.62',
          '61.5' => '504.04',
          '62.0' => '594.04',
          '62.5' => '593.46',
          '63.0' => '593.46',
          '63.5' => '602.88',
          '64.0' => '602.86',
          '64.5' => '612.30',
          '65.0' => '612.30',
          '65.5' => '621.72',
          '66.0' => '621.72',
          '66.5' => '631.14',
          '67.0' => '631.14',
          '67.5' => '634.74',
          '68.0' => '634.74',
          '68.5' => '634.74',
          '69.0' => '634.74',
          '69.5' => '634.74',
          '70.0' => '834.74',
          '70.5' => '634.74'
        ],
        'D'=> [
          '0.5' => '65.52',
          '1.0' => '75.84',
          '1.5' => '88.16',
          '2.0' => '96.48',
          '2.5' => '106.80',
          '3.0' => '113.82',
          '3.5' => '120.34',
          '4.0' => '127.86',
          '4.5' => '134.86',
          '5.0' => '141.90',
          '5.5' => '148.02',
          '6.0' => '154.14',
          '6.5' => '160.26',
          '7.0' => '166.38',
          '7.5' => '172.50',
          '8.0' => '178.62',
          '8.5' => '184.74',
          '9.0' => '190.86',
          '9.5' => '196.98',
          '10.0' => '203.10',
          '10.5' => '207.36',
          '11.0' => '211.62',
          '11.5' => '215.88',
          '12.0' => '220.14',
          '12.5' => '224.40',
          '13.0' => '228.66',
          '13.5' => '232.92',
          '14.0' => '237.18',
          '14.5' => '241.44',
          '15.0' => '245.70',
          '15.5' => '249.95',
          '16.0' => '254.22',
          '16.5' => '258.48',
          '17.0' => '262.74',
          '17.5' => '267.00',
          '18.0' => '268.38',
          '18.5' => '268.38',
          '19.0' => '268.38',
          '19.5' => '268.38',
          '20.0' => '268.38',
          '20.5' => '268.38',
          '21.0' => '268.38',
          '21.5' => '281.16',
          '22.0' => '261.16',
          '22.5' => '293.94',
          '23.0' => '293.94',
          '23.5' => '306.72',
          '24.0' => '306.72',
          '24.5' => '319.50',
          '25.0' => '319.50',
          '25.5' => '332.28',
          '26.0' => '332.28',
          '26.5' => '345.06',
          '27.0' => '345.06',
          '27.5' => '357.84',
          '28.0' => '357.84',
          '28.5' => '370.62',
          '29.0' => '370.62',
          '29.5' => '333.40',
          '30.0' => '333.40',
          '30.5' => '396.18',
          '31.0' => '396.13',
          '31.5' => '403.95',
          '32.0' => '403.93',
          '32.5' => '421.74',
          '33.0' => '421.74',
          '33.5' => '429.30',
          '34.0' => '429.30',
          '34.5' => '429.30',
          '35.0' => '429.30',
          '35.5' => '429.30',
          '36.0' => '429.30',
          '36.5' => '429.30',
          '37.0' => '429.30',
          '37.5' => '429.30',
          '38.0' => '429.30',
          '38.5' => '429.30',
          '39.0' => '429.30',
          '39.5' => '429.30',
          '40.0' => '429.30',
          '40.5' => '429.30',
          '41.0' => '429.30',
          '41.5' => '429.30',
          '42.0' => '429.30',
          '42.5' => '429.30',
          '43.0' => '429.30',
          '43.5' => '429.30',
          '44.0' => '429.30',
          '44.5' => '429.30',
          '45.0' => '429.30',
          '45.5' => '433.34',
          '46.0' => '438.84',
          '46.5' => '448.38',
          '47.0' => '443.33',
          '47.5' => '457.92',
          '48.0' => '457.92',
          '48.5' => '467.46',
          '49.0' => '467.46',
          '49.5' => '477.00',
          '50.0' => '477.00',
          '50.5' => '486.54',
          '51.0' => '486.54',
          '51.5' => '495.08',
          '52.0' => '496.08',
          '52.5' => '505.62',
          '53.0' => '505.32',
          '53.5' => '515.16',
          '54.0' => '515.16',
          '54.5' => '524.70',
          '55.0' => '524.70',
          '55.5' => '534.24',
          '56.0' => '534.24',
          '56.5' => '543.73',
          '57.0' => '543.73',
          '57.5' => '553.32',
          '58.0' => '553.32',
          '58.5' => '562.33',
          '59.0' => '532.36',
          '59.5' => '572.40',
          '60.0' => '572.40',
          '60.5' => '581.94',
          '61.0' => '581.94',
          '61.5' => '591.48',
          '62.0' => '591.48',
          '62.5' => '600.66',
          '63.0' => '600.66',
          '63.5' => '600.66',
          '64.0' => '600.66',
          '64.5' => '600.66',
          '65.0' => '600.66',
          '65.5' => '600.66',
          '66.0' => '600.66',
          '66.5' => '600.66',
          '67.0' => '600.66',
          '67.5' => '600.66',
          '68.0' => '600.66',
          '68.5' => '600.66',
          '69.0' => '600.66',
          '69.5' => '600.66',
          '70.0' => '600.66',
          '70.5' => '600.66'
        ],
        'E'=> [
          '0.5' => '66.84',
          '1.0' => '76.16',
          '1.5' => '89.52',
          '2.0' => '100.86',
          '2.5' => '112.20',
          '3.0' => '116.65',
          '3.5' => '125.16',
          '4.0' => '131.64',
          '4.5' => '136.12',
          '5.0' => '144.66',
          '5.5' => '151.80',
          '6.0' => '159.00',
          '6.5' => '166.20',
          '7.0' => '173.40',
          '7.5' => '160.60',
          '8.0' => '107.60',
          '8.5' => '195.00',
          '9.0' => '202.20',
          '9.5' => '209.40',
          '10.0' => '216.60',
          '10.5' => '220.74',
          '11.0' => '224.88',
          '11.5' => '229.02',
          '12.0' => '233.16',
          '12.5' => '237.30',
          '13.0' => '241.44',
          '13.5' => '245.56',
          '14.0' => '249.72',
          '14.5' => '253.66',
          '15.0' => '262.14',
          '15.5' => '266.28',
          '16.0' => '270.42',
          '16.5' => '274.56',
          '17.0' => '278.70',
          '17.5' => '282.84',
          '18.0' => '284.76',
          '18.5' => '284.76',
          '19.0' => '284.76',
          '19.5' => '284.76',
          '20.0' => '284.76',
          '20.5' => '298.32',
          '21.0' => '298.32',
          '21.5' => '311.88',
          '22.0' => '311.88',
          '22.5' => '325.44',
          '23.0' => '325.44',
          '23.5' => '339.00',
          '24.0' => '339.00',
          '24.5' => '352.56',
          '25.0' => '352.56',
          '25.5' => '356.12',
          '26.0' => '366.12',
          '26.5' => '379.68',
          '27.0' => '379.68',
          '27.5' => '393.24',
          '28.0' => '393.24',
          '28.5' => '406.00',
          '29.0' => '400.00',
          '29.5' => '420.36',
          '30.0' => '420.36',
          '30.5' => '433.92',
          '31.0' => '433.92',
          '31.5' => '447.40',
          '32.0' => '447.43',
          '32.5' => '459.00',
          '33.0' => '409.00',
          '33.5' => '459.00',
          '34.0' => '459.00',
          '34.5' => '459.00',
          '35.0' => '459.00',
          '35.5' => '459.00',
          '36.0' => '459.00',
          '36.5' => '459.00',
          '37.0' => '459.00',
          '37.5' => '459.00',
          '38.0' => '459.00',
          '38.5' => '459.00',
          '39.0' => '459.00',
          '39.5' => '459.00',
          '40.0' => '459.00',
          '40.5' => '459.00',
          '41.0' => '459.00',
          '41.5' => '459.00',
          '42.0' => '459.00',
          '42.5' => '459.00',
          '43.0' => '469.20',
          '43.5' => '469.20',
          '44.0' => '479.40',
          '44.5' => '479.40',
          '45.0' => '489.60',
          '45.5' => '489.60',
          '46.0' => '499.80',
          '46.5' => '499.80',
          '47.0' => '510.00',
          '47.5' => '510.00',
          '48.0' => '520.20',
          '48.5' => '520.20',
          '49.0' => '530.40',
          '49.5' => '530.40',
          '50.0' => '540.60',
          '50.5' => '540.60',
          '51.0' => '550.80',
          '51.5' => '550.80',
          '52.0' => '561.00',
          '52.5' => '561.00',
          '53.0' => '571.20',
          '53.5' => '571.20',
          '54.0' => '581.40',
          '54.5' => '581.40',
          '55.0' => '591.60',
          '55.5' => '591.60',
          '56.0' => '601.80',
          '56.5' => '601.80',
          '57.0' => '612.00',
          '57.5' => '612.00',
          '58.0' => '622.20',
          '58.5' => '622.20',
          '59.0' => '632.40',
          '59.5' => '532.40',
          '60.0' => '642.60',
          '60.5' => '642.60',
          '61.0' => '652.80',
          '61.5' => '652.80',
          '62.0' => '656.04',
          '62.5' => '656.04',
          '63.0' => '656.04',
          '63.5' => '656.04',
          '64.0' => '656.04',
          '64.5' => '656.04',
          '65.0' => '656.04',
          '65.5' => '656.04',
          '66.0' => '656.04',
          '66.5' => '656.04',
          '67.0' => '656.04',
          '67.5' => '656.04',
          '68.0' => '656.04',
          '68.5' => '656.04',
          '69.0' => '656.04',
          '69.5' => '656.04',
          '70.0' => '656.04',
          '70.5' => '656.04'
        ],
        'F'=> [
          '0.5' => '72.60',
          '1.0' => '84.96',
          '1.5' => '97.32',
          '2.0' => '109.68',
          '2.5' => '122.04',
          '3.0' => '133.80',
          '3.5' => '145.56',
          '4.0' => '157.32',
          '4.5' => '169.08',
          '5.0' => '180.84',
          '5.5' => '189.78',
          '6.0' => '198.72',
          '6.5' => '207.66',
          '7.0' => '216.60',
          '7.5' => '225.54',
          '8.0' => '234.48',
          '8.5' => '243.42',
          '9.0' => '252.35',
          '9.5' => '261.30',
          '10.0' => '270.24',
          '10.5' => '275.70',
          '11.0' => '281.16',
          '11.5' => '286.62',
          '12.0' => '292.08',
          '12.5' => '297.54',
          '13.0' => '303.00',
          '13.5' => '308.46',
          '14.0' => '313.92',
          '14.5' => '319.38',
          '15.0' => '324.84',
          '15.5' => '330.30',
          '16.0' => '335.76',
          '16.5' => '341.22',
          '17.0' => '346.68',
          '17.5' => '352.14',
          '18.0' => '357.60',
          '18.5' => '360.36',
          '19.0' => '360.36',
          '19.5' => '360.36',
          '20.0' => '360.36',
          '20.5' => '360.36',
          '21.0' => '360.36',
          '21.5' => '377.52',
          '22.0' => '377.52',
          '22.5' => '394.68',
          '23.0' => '394.68',
          '23.5' => '411.84',
          '24.0' => '411.84',
          '24.5' => '429.00',
          '25.0' => '429.00',
          '25.5' => '446.16',
          '26.0' => '446.16',
          '26.5' => '463.32',
          '27.0' => '463.32',
          '27.5' => '480.48',
          '28.0' => '480.48',
          '28.5' => '497.64',
          '29.0' => '497.64',
          '29.5' => '514.00',
          '30.0' => '514.80',
          '30.5' => '531.96',
          '31.0' => '531.96',
          '31.5' => '549.12',
          '32.0' => '549.12',
          '32.5' => '566.28',
          '33.0' => '566.28',
          '33.5' => '583.44',
          '34.0' => '583.44',
          '34.5' => '600.60',
          '35.0' => '600.60',
          '35.5' => '604.80',
          '36.0' => '604.80',
          '36.5' => '604.80',
          '37.0' => '604.80',
          '37.5' => '604.80',
          '38.0' => '604.80',
          '38.5' => '604.80',
          '39.0' => '604.80',
          '39.5' => '604.80',
          '40.0' => '604.80',
          '40.5' => '604.80',
          '41.0' => '604.80',
          '41.5' => '604.80',
          '42.0' => '604.80',
          '42.5' => '604.80',
          '43.0' => '604.80',
          '43.5' => '604.80',
          '44.0' => '604.80',
          '44.5' => '604.80',
          '45.0' => '618.24',
          '45.5' => '618.24',
          '46.0' => '631.68',
          '46.5' => '631.68',
          '47.0' => '645.12',
          '47.5' => '645.12',
          '48.0' => '658.56',
          '48.5' => '658.56',
          '49.0' => '672.00',
          '49.5' => '672.00',
          '50.0' => '535.44',
          '50.5' => '685.44',
          '51.0' => '698.88',
          '51.5' => '698.88',
          '52.0' => '712.32',
          '52.5' => '712.32',
          '53.0' => '739.20',
          '53.5' => '739.20',
          '54.0' => '752.64',
          '54.5' => '752.64',
          '55.0' => '766.08',
          '55.5' => '766.08',
          '56.0' => '779.52',
          '56.5' => '779.52',
          '57.0' => '792.96',
          '57.5' => '792.96',
          '58.0' => '806.40',
          '58.5' => '806.40',
          '59.0' => '817.92',
          '59.5' => '817.92',
          '60.0' => '817.92',
          '60.5' => '817.92',
          '61.0' => '817.92',
          '61.5' => '817.92',
          '62.0' => '817.92',
          '62.5' => '817.92',
          '63.0' => '817.92',
          '63.5' => '817.92',
          '64.0' => '817.92',
          '64.5' => '817.92',
          '65.0' => '817.92',
          '65.5' => '817.92',
          '66.0' => '817.92',
          '66.5' => '817.92',
          '67.0' => '817.92',
          '67.5' => '817.92',
          '68.0' => '817.92',
          '68.5' => '817.92',
          '69.0' => '817.92',
          '69.5' => '817.92',
          '70.0' => '817.92',
          '70.5' => '817.92'
        ],
        'G'=> [
          '0.5' => '79.92',
          '1.0' => '90.42',
          '1.5' => '100.92',
          '2.0' => '111.42',
          '2.5' => '121.92',
          '3.0' => '131.20',
          '3.5' => '140.64',
          '4.0' => '150.00',
          '4.5' => '159.36',
          '5.0' => '168.72',
          '5.5' => '177.00',
          '6.0' => '185.28',
          '6.5' => '193.56',
          '7.0' => '201.04',
          '7.5' => '210.12',
          '8.0' => '218.40',
          '8.5' => '226.68',
          '9.0' => '234.96',
          '9.5' => '251.52',
          '10.0' => '257.70',
          '10.5' => '263.88',
          '11.0' => '270.06',
          '11.5' => '276.21',
          '12.0' => '282.42',
          '12.5' => '288.60',
          '13.0' => '294.78',
          '13.5' => '300.96',
          '14.0' => '307.14',
          '14.5' => '313.32',
          '15.0' => '319.50',
          '15.5' => '325.68',
          '16.0' => '331.86',
          '16.5' => '333.90',
          '17.0' => '333.90',
          '17.5' => '333.90',
          '18.0' => '333.90',
          '18.5' => '333.90',
          '19.0' => '333.90',
          '19.5' => '333.90',
          '20.0' => '333.90',
          '20.5' => '349.80',
          '21.0' => '349.80',
          '21.5' => '365.70',
          '22.0' => '365.70',
          '22.5' => '381.60',
          '23.0' => '381.60',
          '23.5' => '397.50',
          '24.0' => '397.50',
          '24.5' => '413.40',
          '25.0' => '413.40',
          '25.5' => '429.30',
          '26.0' => '429.30',
          '26.5' => '445.20',
          '27.0' => '445.20',
          '27.5' => '461.10',
          '28.0' => '461.10',
          '28.5' => '477.00',
          '29.0' => '477.00',
          '29.5' => '492.90',
          '30.0' => '492.90',
          '30.5' => '508.80',
          '31.0' => '503.80',
          '31.5' => '524.70',
          '32.0' => '524.70',
          '32.5' => '540.60',
          '33.0' => '540.60',
          '33.5' => '556.50',
          '34.0' => '556.50',
          '34.5' => '572.40',
          '35.0' => '572.40',
          '35.5' => '583.20',
          '36.0' => '583.20',
          '36.5' => '583.20',
          '37.0' => '583.20',
          '37.5' => '583.20',
          '38.0' => '583.20',
          '38.5' => '583.20',
          '39.0' => '583.20',
          '39.5' => '583.20',
          '40.0' => '583.20',
          '40.5' => '583.20',
          '41.0' => '583.20',
          '41.5' => '583.20',
          '42.0' => '583.20',
          '42.5' => '583.20',
          '43.0' => '583.20',
          '43.5' => '583.20',
          '44.0' => '583.20',
          '44.5' => '596.16',
          '45.0' => '596.16',
          '45.5' => '609.12',
          '46.0' => '609.12',
          '46.5' => '622.08',
          '47.0' => '622.08',
          '47.5' => '635.04',
          '48.0' => '635.04',
          '48.5' => '648.00',
          '49.0' => '648.00',
          '49.5' => '660.96',
          '50.0' => '660.96',
          '50.5' => '673.92',
          '51.0' => '673.92',
          '51.5' => '686.88',
          '52.0' => '686.88',
          '52.5' => '699.84',
          '53.0' => '699.84',
          '53.5' => '712.80',
          '54.0' => '712.80',
          '54.5' => '725.76',
          '55.0' => '725.76',
          '55.5' => '738.72',
          '56.0' => '738.72',
          '56.5' => '751.68',
          '57.0' => '751.68',
          '57.5' => '764.64',
          '58.0' => '764.64',
          '58.5' => '777.60',
          '59.0' => '777.60',
          '59.5' => '790.56',
          '60.0' => '790.56',
          '60.5' => '803.52',
          '61.0' => '803.52',
          '61.5' => '816.48',
          '62.0' => '816.48',
          '62.5' => '829.44',
          '63.0' => '829.44',
          '63.5' => '839.22',
          '64.0' => '839.22',
          '64.5' => '839.22',
          '65.0' => '839.22',
          '65.5' => '839.22',
          '66.0' => '839.22',
          '66.5' => '839.22',
          '67.0' => '839.22',
          '67.5' => '839.22',
          '68.0' => '839.22',
          '68.5' => '839.22',
          '69.0' => '839.22',
          '69.5' => '839.22',
          '70.0' => '839.22',
          '70.5' => '839.22'
        ],
        'H'=> [
          '0.5' => '90.06',
          '1.0' => '102.12',
          '1.5' => '114.13',
          '2.0' => '126.24',
          '2.5' => '138.30',
          '3.0' => '149.10',
          '3.5' => '159.90',
          '4.0' => '170.10',
          '4.5' => '131.50',
          '5.0' => '192.30',
          '5.5' => '203.82',
          '6.0' => '215.34',
          '6.5' => '226.86',
          '7.0' => '238.38',
          '7.5' => '249.90',
          '8.0' => '261.42',
          '8.5' => '272.94',
          '9.0' => '284.46',
          '9.5' => '295.98',
          '10.0' => '307.50',
          '10.5' => '315.36',
          '11.0' => '323.22',
          '11.5' => '331.08',
          '12.0' => '339.94',
          '12.5' => '346.80',
          '13.0' => '354.66',
          '13.5' => '362.52',
          '14.0' => '370.38',
          '14.5' => '378.24',
          '15.0' => '386.10',
          '15.5' => '393.96',
          '16.0' => '401.82',
          '16.5' => '409.68',
          '17.0' => '417.54',
          '17.5' => '425.40',
          '18.0' => '433.26',
          '18.5' => '439.74',
          '19.0' => '439.74',
          '19.5' => '439.74',
          '20.0' => '439.74',
          '20.5' => '460.68',
          '21.0' => '460.68',
          '21.5' => '481.62',
          '22.0' => '481.62',
          '22.5' => '502.56',
          '23.0' => '502.56',
          '23.5' => '523.50',
          '24.0' => '523.50',
          '24.5' => '544.44',
          '25.0' => '544.44',
          '25.5' => '565.38',
          '26.0' => '565.38',
          '26.5' => '585.32',
          '27.0' => '586.32',
          '27.5' => '607.26',
          '28.0' => '607.26',
          '28.5' => '628.20',
          '29.0' => '628.20',
          '29.5' => '649.14',
          '30.0' => '549.14',
          '30.5' => '670.08',
          '31.0' => '670.08',
          '31.5' => '691.02',
          '32.0' => '691.02',
          '32.5' => '711.96',
          '33.0' => '711.96',
          '33.5' => '732.90',
          '34.0' => '732.90',
          '34.5' => '753.84',
          '35.0' => '753.84',
          '35.5' => '774.78',
          '36.0' => '774.78',
          '36.5' => '795.72',
          '37.0' => '795.72',
          '37.5' => '816.66',
          '38.0' => '816.66',
          '38.5' => '837.60',
          '39.0' => '837.60',
          '39.5' => '858.54',
          '40.0' => '858.54',
          '40.5' => '874.80',
          '41.0' => '874.80',
          '41.5' => '874.80',
          '42.0' => '874.80',
          '42.5' => '874.80',
          '43.0' => '874.80',
          '43.5' => '874.80',
          '44.0' => '874.80',
          '44.5' => '894.24',
          '45.0' => '894.24',
          '45.5' => '913.68',
          '46.0' => '913.68',
          '46.5' => '933.12',
          '47.0' => '933.12',
          '47.5' => '952.56',
          '48.0' => '952.56',
          '48.5' => '972.00',
          '49.0' => '972.00',
          '49.5' => '991.44',
          '50.0' => '991.44',
          '50.5' => '1010.88',
          '51.0' => '1010.88',
          '51.5' => '1030.32',
          '52.0' => '1030.32',
          '52.5' => '1049.76',
          '53.0' => '1049.76',
          '53.5' => '1069.20',
          '54.0' => '1069.20',
          '54.5' => '1088.64',
          '55.0' => '1088.64',
          '55.5' => '1108.08',
          '56.0' => '1108.08',
          '56.5' => '1127.52',
          '57.0' => '1127.52',
          '57.5' => '1137.42',
          '58.0' => '1137.42',
          '58.5' => '1137.42',
          '59.0' => '1137.42',
          '59.5' => '1137.42',
          '60.0' => '1137.42',
          '60.5' => '1137.42',
          '61.0' => '1137.42',
          '61.5' => '1137.42',
          '62.0' => '1137.42',
          '62.5' => '1137.42',
          '63.0' => '1137.42',
          '63.5' => '1137.42',
          '64.0' => '1137.42',
          '64.5' => '1137.42',
          '65.0' => '1137.42',
          '65.5' => '1137.42',
          '66.0' => '1137.42',
          '66.5' => '1137.42',
          '67.0' => '1137.42',
          '67.5' => '1137.42',
          '68.0' => '1137.42',
          '68.5' => '1137.42',
          '69.0' => '1137.42',
          '69.5' => '1137.42',
          '70.0' => '1137.42',
          '70.5' => '1137.42'
        ]
      ];
      /**
       * Tipos de paquetes
       * 1 =
       */
      if ( $type == '1' ) {
        return $dhl_envelope;
      }
      if ( $type == '2' ) {
        return $dhl_packages;
      }
      if ( $type == '3' ) {
        return $fedex_envelope;
      }
      if ( $type == '4' ) {
        return $fedex_pak;
      }
      if ( $type == '5' ) {
        return $fedex_packages;
      }
    }
}
