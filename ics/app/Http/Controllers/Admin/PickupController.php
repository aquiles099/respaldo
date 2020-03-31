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

class PickupController extends Controller {

  protected function insertPickup($idPickup, $idEvent, $observation, $idPreviousEvent = null, $idUser = 4) {
    $configuration = Configuration::find(1);
    if ($configuration->time_zone == null) {
      $configuration->time_zone = 'America/Caracas (UTC-04:30)';
      $configuration->save();
    }
    $timezone = explode(" ", $configuration->time_zone);
    date_default_timezone_set($timezone[0]);

    // TODO ENVIAR EL CORREO DE LAS NOTIFICACIONES SI ES QUE EL EVENTO TIENE QUE ENVIAR NOTIFICACIONES.
    $log = Log::create([
      'pickup' => $idPickup,
      'user' => $idUser,
      'event'=> $idEvent,
      'previous_event'=> $idPreviousEvent,
      'observation' => $observation
    ]);

    $package = Pickup::find($idPickup);
    $package->update(['last_event' => $idEvent]);
    $package->save();

    return $log;

  }
    public function index (Request $request) {
      $session = $request->session()->get('key-sesion');
      $pickup = Pickup::all();
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
          'pickup' => $pickup
      ];
      /**
      *
      */

      return view('pages.admin.pickup.list',$vars);
    }
    /**
    *
    */
    public function create (Request $request) {
      $session = $request->session()->get('key-sesion');
      $admin     =  $request->session()->get('key-sesion')['data'];
      $this->checkAuthorization();
      $start_at = Carbon::now()->format('Y-m-d');
      $validator = $this->validateData($request);
      $taxs=Tax::byStatus(1)->get();
      $taxss=array();
      /**
      *  Se valida que la sesion este activa
      */
      if ($session == null) {
        return redirect('login');
      }
      /**
      *
      */
      foreach($taxs as $tax){
      $valtax='tax'.$tax->id;
      if($valtax==isset($request->all()[$valtax])){
        array_push($taxss, array(
            'name'        =>$valtax,
            'value'       => $request->all()[$valtax],
            'value_oring' => $tax->id)

           );
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
          'taxxes'      =>(isset($request->all()['tax1']) ? $taxss : '')
      ];
      /**
      *
      */
      if($this->isGET($request)) {
        return view('pages.admin.pickup.create',$vars);
      }

        if($request->all()['exporter'] == '0') ///no se selecciona cliente destino
        {
            $userCons = null;

        }
        if($request->all()['consigner'] == '') ///no se selecciona cliente destino
        {
            $userDest = null;
        }

     $pickupData = [
        'from_courier'      => isset($request->all()['courierSelect']) ? $request->all()['courierSelect'] : null,
        'promotion'         => null,
        'observation'       => null,
        'insurance'         => null,
        'volumetricweightm'   => null,
        'volumetricweighta'   => null,
        'costservice'   => null,
        'costinsurance'   => null,
        'aditionalcost'   => null,
        'subtotal'   => null,
        'total'   => null,
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
        'consigner_user'         => (($request->all()['exporter'] == '0')||(!isset($request->all()['exporter'])))? $userCons:$request->all()['exporter'],
        'addcharge'         => ($request->all()['addcharge'] == "") ? 0 :$request->all()['addcharge'],
        'invoice'           => (($request->all()['invoiced1'] == '')||(!isset($request->all()['invoiced1'])))? '' :$request->all()['invoiced1'],
        'last_event'        => 1,
        'notes'   => (!isset($request->all()['notes'])||($request->all()['notes']=='')) ? null : $request->all()['notes'],

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
      //dd($pickupData);
    $pickup = Pickup::create($pickupData);


    $files = Input::file('upload_file');
        mkdir(asset('/uploads/').$pickup->code);
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

    for ($i = 1; $i <= $request->all()['countpack']; $i++) {
      $pickupdetailsData=[
        'description'       => $request->all()['description'.$i],
        //'typepickup'        => $request->all()['typepickup'.$i],
        'numberparts'       => $request->all()['numberparts'.$i],
        'pieces'            => $request->all()['pieces'.$i],
        'large'             => $request->all()['large'.$i],
        'width'             => $request->all()['width'.$i],
        'height'            => $request->all()['height'.$i],
        'weight'            => $request->all()['weight'.$i],
        'volumetricweight'  => $request->all()['volumetricweightm'.$i],
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
  //  $receipt=$this->setreceiptpickup($pickup->id,$request->all()['observation'],$request->all()['subtotal'],$request->all()['total']);
    /**
    *
    */
  /*  foreach($taxs as $tax){
      $valtax='tax'.$tax->id;
      if($valtax==isset($request->all()[$valtax])){
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

    $idpro=$request->all()['promotion'];

    if($idpro!=""){
      $promo= Promotion::find($idpro);
      $promotion=[
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
    $idserv = $request->all()['type'];
    if($idserv!=""){
      $service= Service::find($idserv);
      $serviceData=[
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

    $idcharge=$request->all()['addcharge'];
    if($idcharge!=""){
      $addcharge= AddCharge::find($idcharge);
      $addchargeData=[
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

    $idins=$request->all()['insurance'];
    if($idins!=""){
      $insuranceData=[
        'receipt'         =>  $receipt->id,
        'type_cost'       =>  1,
        'type_attribute'  =>  'IN',
        'id_complemento'  =>  1,
        'name_oring'      =>  "Seguro",
        'value_oring'     =>  $request->all()['insurance'],
        'value_package'   =>  $request->all()['toinsurance']
        ];

        DetailsReceipt::create($insuranceData);
    }

    $idtrans=$request->all()['type'];
    if($idtrans!=""){
      $addtransport=Transport::find($idtrans);
      $transportData=[
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
      //$this->notifyUserPickup($request->all()['consigner'], HConstants::EVENT_RECEIVED, $pickup->id);
    }
    /**
    *
    */
  //  $this->insertLogPickup($pickup->id, 1,$request->all()['note'],null,$session['data']->id);
    return redirect("/admin/pickup")->with('successMessage', trans('package.created', [
      'tracking' => $pickup->tracking,
      'code' => $pickup->code
    ]));
    /**
    *
    */
    }
  /**
   *
   */
  private function validateDatacurriers(Request $request) {
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
    *
    */
    public function details (Request $request, $id, $readonly = false) {
      $session    = $request->session()->get('key-sesion');
      $admin     =  $request->session()->get('key-sesion')['data'];
      $this->checkAuthorization();
      $pickup     = Pickup::find($id);
      $edit       = true;
      $attachment = Attachment::query()->where('pickup','=',$id)->get();

      /**
      *
      */
      if ($session == null)
      {
        return redirect('login');
      }
      /**
      *
      */
      if (is_null($pickup))
      {
        return $this->doRedirect($pickup, '/admin/typepickup')
                    ->with('errorMessage', trans('typepickup.notFound'));
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
        'taxxes'      =>(isset($request->all()['tax1']) ? $taxss : ''),
        'readonly'    => $readonly
      ];
    //  dd($vars);
      /**
       * Se obtiene la vista para editar
       */
      if($this->isGET($request)) {
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
        'volumetricweightm'   => $request->all()['volumetricweightm1'],
        'volumetricweighta'   => $request->all()['volumetricweighta1'],
        'costservice'   => null,
        'costinsurance'   => null,
        'aditionalcost'   => null,
        'subtotal'   => null,
        'total'   => null,
        'tax'               => null,
        'pro'               => null,
        'value'             => null,
        'type'              => null,
        'details_type'      => null,
        'category'          => null,
        'office'            => null,
        'typeservice'       => null,
        'start_at'          => null,

        'to_user'           => (($request->all()['consigner'] == '')||(!isset($request->all()['consigner']))) ? null :$request->all()['consigner'],
        'consigner_user'         => (($request->all()['exporter'] == '0')||(!isset($request->all()['exporter'])))? null:$request->all()['exporter'],
        'addcharge'         => ($request->all()['addcharge'] == "") ? 0 :$request->all()['addcharge'],
        'invoice'           => (($request->all()['invoiced1'] == '')||(!isset($request->all()['invoiced1'])))? '' :$request->all()['invoiced1'],
        'last_event'        => 1,
        'notes'   => (!isset($request->all()['notes'])||($request->all()['notes']=='')) ? null : $request->all()['notes'],

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
      $pickup->update($pickupData);
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
      DB::table('details_pickup_order')->where('pickup', '=', $id)->delete();
      for ($i = 1; $i <= $request->all()['countpack']; $i++) {
        $pickupdetailsData=[
          'description'       => $request->all()['description'.$i],
          //'typepickup'        => isset($request->all()['typepickup'.$i]) ? $request->all()['typepickup'.$i] : null,
          'numberparts'       => isset($request->all()['numberparts'.$i]) ? $request->all()['numberparts'.$i] : "",
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
        //  'po'                => $request->all()['po'.$i],
          'pickup'            => $pickup->id
      ];
      /**
      *
      */
    //dd($pickupdetailsData);
      $pickupdetails=DetailsPickup::create($pickupdetailsData);
    }
    /**
    *
    */
    return redirect("/admin/pickup")->with('successMessage', trans('package.created', [
       'name' => $pickup->name,
       'code' => $pickup->code
    ]));
    }

    /**
    *
    */
    public function readDetails (Request $request, $id)
    {
      $session = $request->session()->get('key-sesion');
      /**
      *  Se valida que la sesion este activa
      */
      if ($session == null)
      {
        return redirect('login');
      }
      /**
      *
      */
      return $this->details($request, $id, true);
    }

    /**
    * retorna tipo de pikcup modo json
    */
    public function type(Request $request) {
      $type = TypePickup::all();
      /**
      *
      */
      return response()->json([
        "message" => $type
      ]);
    }

    /**
    * retorna numero de partes modo json
    */
    public function numberparts(Request $request)
    {
      $numberparts = NumberParts::all();
      /**
      *
      */
      return response()->json([
        "message" => $numberparts
      ]);
    }

    /**
     *
     */
    public function delete(Request $request, $id)
    {
      $redirect = $this->doRedirect($request, '/admin/typepickup');
      $tipepickup = Pickup::find($id);
      /**
      *
      */
      if(is_null($tipepickup))
      {
        $redirect->with('errorMessage', trans('typepickup.notFound'));
      }
      else
      {
        $tipepickup->delete();
        return redirect('admin/pickup')->with('successMessage', trans('typepickup.deleted',
        [
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
  *
  */
  private function validateData(Request $request)
  {
    return Validator::make($this->clear($request->all()),
    [
      'name'         => 'required|string|min:3|max:100|unique:typepickup,name',
      'description'  => 'required|string|min:3|max:100|unique:typepickup,description'
    ]);
  }

  public function items(Request $request, $id)
  {
    $pickupDetail       = DetailsPickup::bypickup($id)->get();
    $pickupDetailCount = DetailsPickup::bypickup($id)->count();
    /**
    *
    */
    if($pickupDetail)
    {
      return response()->json([
        "message" => 'true',
        "alert"   => $pickupDetail
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
  *
  */
  public function showpickup(Request $request,$id) {
      $session         = $request->session()->get('key-sesion');
      $pickup          = Pickup::find($id);
      $packageLog      = Log::ByPickup($pickup->id)->get();
      $invoice         = File::query()->where("id_package", "=", $id)->get();
      $detailspackage  = DetailsPickup::query()->where('pickup','=',$id)->get();
      $event = PickupStatus::query()->where('active','=','1')->get();
      $events_number = PickupStatus::query()->where('active','=','1')->count();
      $attachment = Attachment::query()->where('pickup','=',$id)->get();
      /**
      *  Se valida que la sesion este activa
      */
      if ($session == null) {
        return redirect('login');
      }
      /**
      *
      */
      $companyclient = "";
      if(isset($pickup->to_client)){
        $client          = Client::find($pickup->to_client);
        $companyclient   = Company::find($client->company);
      }
      /**
      *
      */
      $vars = [
        'package'      => $pickup,
        'attachments'   => $attachment,
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
  *
  */
public function addwr(Request $request,$id) {
  /**
  *Construyendo el json para agregarlo al wr
  */
    $pickupdata=[
      'pickup'   =>  $id
    ];
  Warehouse::create($pickupdata);

  return response()->json([
        "message" => "true"
  ]);
}

}
