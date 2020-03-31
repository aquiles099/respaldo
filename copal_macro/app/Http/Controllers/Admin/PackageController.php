<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
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
use App\Models\Admin\Prealert;
use App\Models\Admin\Company;
use App\Models\Admin\Promotion;
use App\Models\Admin\FromCourier;
use App\Models\Admin\Category;
use App\Models\Admin\DetailsReceipt;
use App\Models\Admin\Detailspackage;
use App\Models\Admin\Service;
use App\Models\Admin\AddCharge;
use App\Models\Admin\PackageConsolidated;
use App\Models\Admin\Shipment;
use App\Models\Admin\ShipmentDetail;
use App\Models\Admin\File;
use App\Models\Admin\Warehouse;
use App\Models\Admin\Attachment;
use Validator;
use GDText\Box;
use GDText\Color;
use Carbon\Carbon;
use DB;
use Crypt;
use Input;
use \Mail;
use App\Helpers\HConstants;
/**
 *
 */
class PackageController extends Controller {

  /**
   *
   */
  public function readDetails(Request $request, $id)
  {
    return $this->details($request, $id, true);
  }

  /**
   *
   */
  public function details(Request $request, $id, $readonly = false)
  {
    $this->checkAuthorization();
    $package = Package::find($id);

    if(is_null($package))
    {
      return $this->doRedirect($request, '/admin/package')
        ->with('errorMessage', trans('package.notFound'));
    }



    $vars =  [
      'package'       => $package,
      'readonly'      => $readonly,
      'countries'     => Country::all(),
      'company'       => Company::query()->where('id','>',1)->get(),
      'consolidated'  => Consolidated::byStatus(1)->get(),
      'clients'       => Client::all(),
      'promotions'    => Promotion::all(),
      'couriers'      => Courier::byStatus()->get(),
      'users'         => User::byUserType(1)->get(),
      'tax'           => Tax::byStatus(1)->get(),
      'transports'    => Transport::all(),
      'category'      => Category::all(),
      'office'        => Office::all(),
      'service'       => Service::all(),
      'addcharge'     => AddCharge::all()
    ];

    if($this->isGET($request))
    {
      return view('pages.admin.package.edit',$vars);
    }

    //Actualizar el paquete
    /*$validator = $this->validateData($request);
    if (!is_null($validator))
    {
      if ($validator->fails())
      {
        return view('pages.admin.package.edit', $vars)->withErrors($validator)
          ->with('errorMessage', trans('messages.checkRedFields'));
      }
    }*/

    ///GUARDAR EL PAQUETE
    ////////////////////////////////////////////////////////////////////////////
    if($request->all()['from'] == '1') ///vien por persona Natural
    {
      if($request->all()['clientSelect'] == '0') ///no se selecciona cliente de proveniencia
      {
        $clientFrom = Client::create([
          'name'        => $request->all()['name'],
          'direction'   => $request->all()['direction'],
          'phone'       => $request->all()['phone'],
          'email'       => $request->all()['email'],
          'identifier'  => $request->all()['identifier'],
          'company'     => 1 //Siempre se crea cliente para la compañia 1 (MURANO)
        ]);
      }
      //
      if($request->all()['finalDestinationClient'] == '0') ///no se selecciona cliente destino
      {
        $clientTo = Client::create([
          'name'       => $request->all()['destin_name'],
          'direction'  => $request->all()['destin_direction'],
          'phone'      => $request->all()['destin_phone'],
          'email'      => $request->all()['destin_email'],
          'identifier' => $request->all()['destin_identifier'],
          'company'    => 1 //Siempre se crea cliente para la compañia 1 (MURANO)
        ]);
      }
      //
      $packageData = [
        'from_client'        => ($request->all()['clientSelect'] == '0'?$clientFrom->id:$request->all()['clientSelect']),
        'to_client'          => ($request->all()['finalDestinationClient'] == '0'?$clientTo->id:$request->all()['finalDestinationClient']),
        'large'              => $request->all()['large'],
        'width'              => $request->all()['width'],
        'height'             => $request->all()['height'],
        'weight'             => $request->all()['weight'],
        'value'              => $request->all()['value'],
        'volumetricweight'   => $request->all()['volumetricweight'],
        'type'               => $request->all()['type'],
        'category'           => $request->all()['category'],
        'invoice'            => $request->all()['invoice']
      ];
    }
    else if($request->all()['from'] == '2') ///viene por courier
    {
      $packageData = [
        'from_courier'  => $request->all()['courierSelect'],
        'to_user'       => $request->all()['finalDestinationUser'],
        'tracking'      => $request->all()['tracking'],
        'large'         => $request->all()['large'],
        'width'         => $request->all()['width'],
        'height'        => $request->all()['height'],
        'weight'        => $request->all()['weight'],
        'value'         => $request->all()['value'],
        'volumetricweight'   => $request->all()['volumetricweight'],
        'type'          => $request->all()['type'],
        'category'      => $request->all()['category'],
        'invoice'       => $request->all()['invoice']
      ];
    }
    //Emision de Recibos y detalles de recibos
    ////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////

    $package->update($packageData);
    $package->save();

    return view('pages.admin.package.edit', $vars)->with('successMessage', trans('package.updated', [
      'tracking' => $package->tracking,
      'id' => $package->id
    ]));
  }


  /**
   * Creacion
   */
  public function create(Request $request)
  {
    $session = $request->session()->get('key-sesion');
    $this->checkAuthorization();
    $taxs=Tax::byStatus(1)->get();
    $start_at = Carbon::now()->format('Y-m-d'); /********/
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
    $vars = [
      'countries'   => Country::all(),
      'clients'     => Client::all(),
      'promotions'  => Promotion::all(),
      'company'     => Company::query()->where('id','>',1)->get(),
      'consolidated'=> Consolidated::byStatus(1)->get(),
      'couriers'    => Courier::byStatus()->get(),
      'users'       => User::byUserType(1)->get(),
      'tax'         => $taxs,
      'transports'  => Transport::all(),
      'category'    => Category::all(),
      'start_at'    => $start_at
    ];
    if($this->isGET($request))
    {
      return view('pages.admin.package.create', $vars);
    }
    /**
    * Se validan los campos del paquete
    */

    $validator = $this->validateData($request);
    if (!is_null($validator))
    {
      if ($validator->fails())
      {
        return view('pages.admin.package.create', $vars)
          ->withErrors($validator)
          ->with('errorMessage', trans('messages.checkRedFields'));
      }
    }


    /**
    * Esta condicion valida si no se selecciona cliente de proveniencia
    */
    if($request->all()['clientSelect'] == '0')
    {
      $clientFrom = Client::create([
        'name'        => $request->all()['name'],
        'direction'   => $request->all()['direction'],
        'phone'       => $request->all()['phone'],
        'email'       => $request->all()['email'],
        'identifier'  => $request->all()['identifier'],
        'company'     => 1 //Siempre se crea cliente para la compañia 1 (MURANO)
      ]);
    }
    /**
    * Esta condicion valida si no se selecciona un cliente destino
    */
     //
    $packageData = [
      'to_client' => ($request->all()['clientSelect'] == '0'?$clientFrom->id:$request->all()['clientSelect']),

      'large'              => $request->all()['large'],
      'width'              => $request->all()['width'],
      'height'             => $request->all()['height'],
      'weight'             => $request->all()['weight'],
      'value'              => $request->all()['value'],
      'volumetricweight'   => $request->all()['volumetricweight'],
      'type'               => $request->all()['type'],
      'category'           => $request->all()['category'],
      'invoice'            => $request->all()['invoice'],
      'start_at'           => $request->all()['start_at']
    ];



    $package = Package::create($packageData);

     /**
    *Se carga la factura en caso que aplique
    */
    if($request->all()['invoice']!="0"){
      $file           = Input::file('fileinvoice');
      $aleatorio      = str_random();
      $nombre         = $aleatorio.'_'.$file->getClientOriginalName();

      /*
      *Datos de la factura a subir
      */

      $data = [
        "name"           => $nombre,
        "path"           => asset('/uploads')."/".$nombre,
        "id_package"     => $package->id

      ];
      /**
      * Se almacenan los datos del archivo subido
      */
      $file->move('uploads', $nombre);
      $save = File::create($data);
    }

    if(!$request->all()['shipment']=='0')
    {

      $data_detail = [
          'shipment'  => $request->all()['shipment'],
          'warehouse' =>  $package->id
      ];
        $shipment_detail = ShipmentDetail::create($data_detail);
    /*  $consol=
      [
      'package'       =>  $package->id,
      'consolidated'  =>  $request->all()['consolidated'],
      'observation'   =>  $request->all()['observation']
      ];
      PackageConsolidated::create($consol);*/
    }

    $session = $request->session()->get('key-sesion');
    $receipt=$this->setreceipt($package->id,$request->all()['observation'],$request->all()['subtotal'],$request->all()['total']);

    foreach($taxs as $tax){
      $valtax='tax'.$tax->id;
      $receipts=
      [
      'receipt'         =>  $receipt->id,
      'type_cost'       =>  $tax->type,
      'type_attribute'  =>  'I',
      'id_complemento'  =>  $tax->id,
      'value_oring'     =>  $tax->value,
      'value_package'   =>  $request->all()[$valtax]
      ];
      DetailsReceipt::create($receipts);
    }

    $idpro=$request->all()['promotion'];

    if($idpro!="0"){

      $promo= Promotion::find($idpro);
      $promotion=[
        'receipt'         =>  $receipt->id,
        'type_cost'       =>  $promo->type_value,
        'type_attribute'  =>  'P',
        'id_complemento'  =>  $promo->id,
        'value_oring'     =>  $promo->value,
        'value_package'   =>  $request->all()['promotionval']
        ];

        DetailsReceipt::create($promotion);
    }


    $this->insertLog($package->id, 1,$request->all()['observation'],null,$session['data']->id);
    return redirect("/admin/package")->with('successMessage', trans('package.created',
      [
      'tracking' => $package->tracking,
      'id'       => $package->id
    ]));
  }

  /**
   * Creacion de Paquetes por curriers
   */
  public function createcurriers(Request $request) {
    $session       = $request->session()->get('key-sesion');
    $admin         = $request->session()->get('key-sesion')['data'];
    $taxs          = Tax::byStatus(1)->get();
    $taxss         = array();
    $configuration = Configuration::find(HConstants::FIRST_CONFIGURATION);
    /**
    *  Se valida que la sesion este activa
    */
    if ($session == null)
    {
      return redirect('login');
    }


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
      'category'    => Category::all(),
      'start_at'    => Carbon::now()->format('Y-m-d'),
      'office'      => Office::all(),
      'services'    => '',
      'addcharges'  => AddCharge::all(),
      'shipment'    => Shipment::all(),
      'taxxes'      => (isset($request->all()['tax1']) ? $taxss : '')

    ];
  //  dd($vars);
    /**
    *
    */
    if($this->isGET($request))
    {
      return view('pages.admin.packagecurriers.create', $vars);
    }
    /**
    * Se validan los campos del paquete
    */

    /*$validator = $this->validateDatacurriers($request);
        if (!is_null($validator))
     {
      if ($validator->fails())
      {
        return view('pages.admin.packagecurriers.create', $vars)
          ->withErrors($validator)
          ->with('errorMessage', trans('messages.checkRedFields'));
      }
    }*/
    if($request->all()['finalConsigUser'] == 'adduc') ///no se selecciona cliente destino
    {
        $userCons = User::create([
          'name'           => $request->all()['cons_name'],
          'last_name'      => $request->all()['cons_lastname'],
          'dni'            => $request->all()['cons_dni'],
          'local_phone'    => $request->all()['cons_phone'],
          'celular'        => $request->all()['cons_cell'],
          'email'          => $request->all()['cons_email'],
          'postal_code'    => $request->all()['cons_zipcode'],
          'address'        => $request->all()['cons_direction'],
          'region'         => $request->all()['cons_region'],
          'country'        => $request->all()['cons_country'],
          'city'           => $request->all()['cons_city'],
          'password'       => '12345678',
          'user_type'      => 1

        ]);
        /**
        *
        */
        Mail::send('emails.check_email', [
          'host'          => $this->host,
          'link'          => "check/account/op?code={$userCons->remember_token}",
          'user'          => $userCons,
          'configuration' => $configuration,
          'password'      => Crypt::decrypt($userCons->password)
        ],
        function($mail) use ($userCons) {
          $mail->from($this->from);
          $mail->to($userCons->email , "$userCons->user $userCons->name")->subject(trans('messages.activate'));
        });
        /**
        *
        */
        $this->notifyUserStatus($userCons, HConstants::EVENT_RECEIVED, $userCons->id);
    }
    /**
    * esta opcion se ejecuta cuando se agreag un nuevo usuario de destino
    */
    if($request->all()['finalDestinationUser'] == 'addud')  {
        $userDest = User::create([
          'name'           => $request->all()['destin_name'],
          'last_name'      => $request->all()['destin_lastname'],
          'dni'            => $request->all()['destin_dni'],
          'local_phone'    => $request->all()['destin_phone'],
          'celular'        => $request->all()['destin_cell'],
          'email'          => $request->all()['destin_email'],
          'postal_code'    => $request->all()['destin_zipcode'],
          'country'        => $request->all()['destin_country'],
          'region'         => $request->all()['destin_region'],
          'city'           => $request->all()['destin_city'],
          'address'        => $request->all()['destin_direction'],
          'password'       => '12345678',
          'user_type'      => 1

        ]);
        /**
        * Se envia correo electronico
        */
         Mail::send('emails.check_email', [
          'host'          => $this->host,
          'link'          => "check/account/op?code={$userDest->remember_token}",
          'user'          => $userDest,
          'configuration' => $configuration,
          'password' => Crypt::decrypt($userDest->password)
        ],
        function($mail) use ($userDest)
        {
          $mail->from($this->from);
          $mail->to($userDest->email , "$userDest->user $userDest->name")->subject(trans('messages.activate'));
        });
        /**
        *
        */
        $this->notifyUserStatus($userDest, HConstants::EVENT_RECEIVED, $userDest->id);
    }

    /**
    * Se realizan las validaciones del paquete, En esta condicion se valida si el paquete viene de una persona natural
    */
    if($request->all()['finalDestinationUser'] == "") {
       $userdestino = null;
    } elseif ($request->all()['finalDestinationUser'] == 'addud') {
       $userdestino = $userDest->id;
    } else {
       $userdestino = $request->all()['finalDestinationUser'];
    }

    if($request->all()['finalConsigUser']==""){
      $userconsig=null;
    }elseif ($request->all()['finalConsigUser'] == 'adduc') {
      $userconsig= $userCons->id;
    }else{
      $userconsig=$request->all()['finalConsigUser'];
    }
    /**
    *
    */
    $packageData = [
      //  'from_courier'      => $request->all()['courierSelect'],
        'to_user'           => $userdestino,
        'consigner_user'    => $userconsig,
        'tracking'          => $request->all()['tracking'],
        'value'             => $request->all()['value'],
        'type'              => ($request->all()['type'] == "") ? null :$request->all()['type'],
        'details_type'      => ($request->all()['typeservice'] == "") ? null :$request->all()['typeservice'],
        'category'          => ($request->all()['category'] == "") ? null :$request->all()['category'],
        'office'            => ($request->all()['office'] == "") ? null :$request->all()['office'],
        'invoice'           => $request->all()['invoice'],
        'observation'       => $request->all()['observation'],
        'last_event'        => 1,
        'start_at'          => $request->all()['start_at'],
        'subtotal'          => $request->all()['subtotal'],
        'total'          => $request->all()['total']
      ];


    $package = Package::create($packageData);


     $files = Input::file('upload_file');
        mkdir(asset('/uploads/').$package->code);
        //$files = Request::file('upload_file');
        if ($files[0] != '') {
          foreach($files as $file) {

              $aleatorio      = str_random();
              $nombre         = $aleatorio.'_'.$file->getClientOriginalName();
              $file->move('uploads/'.$package->code."/", $nombre);

              $data = [
              'shipment'      => null,
              'booking'       => null,
              'warehouse'     => $package->id,
              'pickup'        => null,
              'cargo_release' => null,
              'transporters'  => null,
              'suppliers'     => null,
              'path'          => asset('/uploads/').$package->code."/".$nombre,
              'name_path'     => $nombre,
              'operator'      => $admin->id
            ];
            $attachment = Attachment::create($data);
         }
      }

    for ($i = 1; $i <= $request->all()['countpack']; $i++) {
      $packagedetailsData=[
        'description'       => $request->all()['description'.$i],
        'large'             => $request->all()['large'.$i],
        'width'             => $request->all()['width'.$i],
        'height'            => $request->all()['height'.$i],
        'weight'            => $request->all()['weight'.$i],
        'volumetricweightm' => $request->all()['volumetricweightm'.$i],
        'volumetricweighta' => $request->all()['volumetricweighta'.$i],
        'pieces'            => $request->all()['pieces'.$i],
        'value'             => $request->all()['valued'.$i],
        'order_service'     => $request->all()['serviceOrder'],
        //'from_courier'      => $request->all()['courierSelect'].$i,
        'courier'           => $request->all()['currier'],
        'addcharge'         => $request->all()['addcharge'],
        'package'           => $package->id
    ];

    $packagedetails=Detailspackage::create($packagedetailsData);
    }


    /**
    *Se carga la factura en caso que aplique
    */
    if($request->all()['invoice']=="1"){
      $file           = Input::file('file');
      $aleatorio      = str_random();
      $nombre         = $aleatorio.'_'.$file->getClientOriginalName();

      /*
      *Datos de la factura a subir
      */

      $data = [
        "name"           => $nombre,
        "path"           => asset('/uploads')."/".$nombre,
        "id_package"     => $package->id,
        "carrier"        => $request->all()['courierSelect'],
        "contentPackage" => "1",
        "pricePackage"   => $request->all()['value']


      ];
      /**
      * Se almacenan los datos del archivo subido
      */
      $file->move('uploads', $nombre);
      $save = File::create($data);
    }


    /**
    *Se agrega el paquete al consolidado en caso de que aplique
    */
    if(!$request->all()['shipment']=='0')
    {

      $data_detail = [
          'shipment'  => $request->all()['shipment'],
          'warehouse' =>  $package->id
      ];
        $shipment_detail = ShipmentDetail::create($data_detail);
    /*  $consol=
      [
      'package'       =>  $package->id,
      'consolidated'  =>  $request->all()['consolidated'],
      'observation'   =>  $request->all()['observation']
      ];
      PackageConsolidated::create($consol);*/
    }

     /**
    *Se agrega el envio al recibo
    */

    $session = $request->session()->get('key-sesion');
    /*dd($package->id,$request->all()['observation'],$request->all()['subtotal'],$request->all()['total']);*/
    $receipt=$this->setreceipt($package->id,$request->all()['observation'],$request->all()['subtotal'],$request->all()['total']);
    //dd($receipt);

   /* foreach($taxs as $tax){
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
    }*/

     $receipts = [
        'receipt'         =>  $receipt->id,
        'type_cost'       =>  0,
        'type_attribute'  =>  'I',
        'id_complemento'  =>  1,
        'value_oring'     =>  $request->all()['taxval'],
        'value_package'   =>  $request->all()['taxre']
      ];
      DetailsReceipt::create($receipts);

      $receipts = [
        'receipt'         =>  $receipt->id,
        'type_cost'       =>  0,
        'type_attribute'  =>  'S',
        'id_complemento'  =>  1,
        'value_oring'     =>  $request->all()['insurance'],
        'value_package'   =>  $request->all()['toinsurance']
      ];
      DetailsReceipt::create($receipts);

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

 /**
      *
      */
      $idpro = $request->all()['promotion'];
      if($idpro != "") {
        $promo= Promotion::find($idpro);
        $promotion = [
            'receipt'         =>  $receipt->id,
            'type_cost'       =>  $promo->type_value,
            'type_attribute'  =>  'P',
            'id_complemento'  =>  $promo->id,
            'value_oring'     =>  $promo->value,
            'value_package'   =>  $request->all()['promotionval']
          ];
          DetailsReceipt::create($promotion);
      }

      $idtype = $request->all()['typeservice'];
      if($idtype != "") {
        $dettype= Service::find($idtype);
        $dettypedata = [
            'receipt'         =>  $receipt->id,
            'type_cost'       =>  0,
            'type_attribute'  =>  'T',
            'id_complemento'  =>  $dettype->id,
            'value_oring'     =>  $dettype->value,
            'value_package'   =>  $request->all()['subtotal']
          ];
          DetailsReceipt::create($dettypedata);
      }

      $idaddcharge = $request->all()['addcharge'];
      if($idaddcharge != "") {
        $detaddcharge= AddCharge::find($idaddcharge);
        $addchargedata = [
            'receipt'         =>  $receipt->id,
            'type_cost'       =>  0,
            'type_attribute'  =>  'A',
            'id_complemento'  =>  $detaddcharge->id,
            'value_oring'     =>  $detaddcharge->value,
            'value_package'   =>  $detaddcharge->value
          ];
          DetailsReceipt::create($addchargedata);
      }

      $warehousedata=[
      'warehouse'   =>  $package->id
    ];
    /**
    *
    */
    $warehouse = Warehouse::create($warehousedata);
    /**
    *
    */
    $this->insertLog($package->id, 1, $request->all()['observation'], HConstants::RESPONSE_NULL, $session['data']->id);
    /**
    * envio de correo
    */
    if ($userdestino != HConstants::RESPONSE_NULL || $userdestino != HConstants::EVENT_CERO ) {
      $this->notifyUserStatus($userdestino, HConstants::EVENT_RECEIVED, $package->id);
    }
    /**
    *
    */
    return redirect("/admin/package")->with('successMessage', trans('package.created', [
      'code' => $package->code,
      'id'   => $package->id
    ]));
  }


  public function currier(Request $request) {
    $packages = Courier::all();
    /**
    *
    */
    return response()->json([
      "message" => $packages
    ]);
  }

  /**
  * Listado de prealertas
  */
  public function prealertList(Request $request) {
    $session = $request->session()->get('key-sesion');
    /**
    *  Se valida que la sesion este activa
    */
    if ($session == null) {
      return redirect('login');
    }
    /**
    *
    */
    $prealerts = Prealert::orderBy('created_at', 'desc')->get();
    /**
    *
    */
    $vars = [
      'prealerts' => $prealerts
    ];

    /**
    *
    */
    return view('pages.admin.package.prealert.list',$vars);
  }
  /**
  *
  */
  public function editpackagecurriers(Request $request, $id) {
    $session = $request->session()->get('key-sesion');
    /**
    *
    */
    if($session == null) {
      return redirect('login');
    }
    /**
    *
    */
    $package   = Package::find($id);
    $detailspackage = Detailspackage::query()->where('package','=',$id)->get();
    /**
    *
    */
    if(is_null($package)) {
      return $this->doRedirect($request, '/admin/package')
        ->with('errorMessage', trans('package.notFound'));
    }
    /**
    *
    */

    $taxs          = Tax::byStatus(1)->get();
    $receipt       = Receipt::ByPackage($id)->first();
    $detailsreceipt = DetailsReceipt::query()->where('receipt','=',$receipt->id)->get();
    $taxss         = array();
    $idaddpromotion = array();
    $insurance     = DB::table('detailsreceipt')->select('id', 'value_oring','name_oring','value_package')->where("type_attribute","=",'S')->where("receipt","=",$receipt->id)->first();
    $configuration = Configuration::find(HConstants::FIRST_CONFIGURATION);
    /**
    *
    */
    $taxdeb= DB::table('detailsreceipt')->select('id', 'value_oring','name_oring','value_package')->where("type_attribute","=",'I')->where("receipt","=",$receipt->id)->first();
    $idtytransport = DB::table('detailsreceipt')->select('id', 'value_oring','name_oring','value_package')->where("type_attribute","=",'T')->where("receipt","=",$receipt->id)->first();
    $idaddcharge = DB::table('detailsreceipt')->select('id', 'value_oring','name_oring','value_package')->where("type_attribute","=",'A')->where("receipt","=",$receipt->id)->first();
    $idaddpromotion = DB::table('detailsreceipt')->select('id', 'value_oring','id_complemento','value_package')->where("type_attribute","=",'P')->where("receipt","=",$receipt->id)->first();

    //dd($package);
    $vars = [
      'package'     =>$package,
      'detailspackage' => $detailspackage[0],
      'countries'   => Country::all(),
      'promotions'  => Promotion::all(),
      'consolidated'=> Consolidated::byStatus(1)->get(),
      'couriers'    => Courier::byStatus()->get(),
      'users'       => User::byUserType(1)->get(),
      'usercons'    => isset($package->consigner_user) ? User::find($package->consigner_user)->first():null,
      'userdestin'  => isset($package->to_user) ? User::find($package->to_user)->first():null,
      'tax'         => $taxs,
      'transports'  => Transport::all(),
      'category'    => Category::all(),
      'start_at'    => Carbon::now()->format('Y-m-d'),
      'office'      => Office::all(),
      'services'    => Service::all(),
      'addcharges'  => AddCharge::all(),
      'insurance'   => $insurance,
      'shipment'    => Shipment::all(),
      'taxxes'      => $taxdeb,
      'idaddcharge' => $idaddcharge,
      'idaddpromotion' => $idaddpromotion,
      'idtytransport' => $idtytransport
    ];


    if($this->isGET($request))
    {
      return view('pages.admin.packagecurriers.edit',$vars);
    }

    //dd((int)$request->all()['addcharge']);
    if($request->all()['finalConsigUser'] == 'adduc') ///no se selecciona cliente destino
    {
        $userCons = User::create([
          'name'           => $request->all()['cons_name'],
          'last_name'      => $request->all()['cons_lastname'],
          'dni'            => $request->all()['cons_dni'],
          'local_phone'    => $request->all()['cons_phone'],
          'celular'        => $request->all()['cons_cell'],
          'email'          => $request->all()['cons_email'],
          'postal_code'    => $request->all()['cons_zipcode'],
          'address'        => $request->all()['cons_direction'],
          'region'         => $request->all()['cons_region'],
          'country'        => $request->all()['cons_country'],
          'city'           => $request->all()['cons_city'],
          'password'       => '12345678',
          'user_type'      => 1

        ]);

        Mail::send('emails.check_email',
        [
          'host'     => $this->host,
          'link'     => "check/account/op?code={$userCons->remember_token}",
          'userName' => $userCons->email,
          'password' => Crypt::decrypt($userCons->password)
        ],
        function($mail) use ($userCons)
        {
          $mail->from($this->from);
          $mail->to($userCons->email , "$userCons->user $userCons->name")->subject(trans('messages.activate'));
        });


    }

    if($request->all()['finalDestinationUser'] == 'addud') ///no se selecciona cliente destino
    {
        $userDest = User::create([
          'name'           => $request->all()['destin_name'],
          'last_name'      => $request->all()['destin_lastname'],
          'dni'            => $request->all()['destin_dni'],
          'local_phone'    => $request->all()['destin_phone'],
          'celular'        => $request->all()['destin_cell'],
          'email'          => $request->all()['destin_email'],
          'postal_code'    => $request->all()['destin_zipcode'],
          'country'        => $request->all()['destin_country'],
          'region'         => $request->all()['destin_region'],
          'city'           => $request->all()['destin_city'],
          'address'        => $request->all()['destin_direction'],
          'password'       => '12345678',
          'user_type'      => 1

        ]);

         Mail::send('emails.check_email',
        [
          'host'     => $this->host,
          'link'     => "check/account/op?code={$userDest->remember_token}",
          'userName' => $userDest->email,
          'password' => Crypt::decrypt($userDest->password)
        ],
        function($mail) use ($userDest)
        {
          $mail->from($this->from);
          $mail->to($userDest->email , "$userDest->user $userDest->name")->subject(trans('messages.activate'));
        });
    }

     if($request->all()['finalDestinationUser']==""){
        $userdestino=null;
      }elseif ($request->all()['finalDestinationUser'] == 'addud') {
        $userdestino=$userDest->id;
      }else{
        $userdestino=$request->all()['finalDestinationUser'];
      }

      if($request->all()['finalConsigUser']==""){
        $userconsig=null;
      }elseif ($request->all()['finalConsigUser'] == 'adduc') {
        $userconsig= $userCons->id;
      }else{
        $userconsig=$request->all()['finalConsigUser'];
      }
      $currier = 0;
      if ($request->currier==null) {
        $currier = 1;
      }else {
        $currier = $request->all()['currier'];
      }
     $packageData = [
        'from_courier'      => $currier,
        'to_user'           => $userdestino,
        'consigner_user'    => $userconsig,
        'tracking'          => $request->all()['tracking'],
        'value'             => $request->all()['value'],
        'type'              => $request->all()['type'] == ''? null: $request->all()['type'],
        'details_type'      => $request->all()['typeservice'] == '' ? null: $request->all()['typeservice'],
        'category'          => $request->all()['category'] == ''? null: $request->all()['category'],
        'office'            => $request->all()['office'] == '' ? null: $request->all()['office'],
        'invoice'           => $request->all()['invoice'],
        'observation'       => $request->all()['observation'],
        'addcharge'         => (int)($request->all()['addcharge']),
        'last_event'        => 1,
        'start_at'          => $request->all()['start_at']
      ];
      //dd($packageData);


    $package->update($packageData);
    $package->save();
    DB::table('detailspackage')->where('package', '=', $id)->delete();

    for ($i = 1; $i <= $request->all()['countpack']; $i++) {
      $packagedetailsData=[
        'description'       => $request->all()['description'.$i],
        'large'             => $request->all()['large'.$i],
        'width'             => $request->all()['width'.$i],
        'height'            => $request->all()['height'.$i],
        'weight'            => $request->all()['weight'.$i],
        'volumetricweightm' => $request->all()['volumetricweightm'.$i],
        'volumetricweighta' => $request->all()['volumetricweighta'.$i],
        'pieces'            => $request->all()['pieces'.$i],
        'value'             => $request->all()['valued'.$i],
        'order_service'     => $request->all()['serviceOrder'],
        'addcharge'         => (int)($request->all()['addcharge']),
        //'from_courier'      => $request->all()['courierSelect'].$i,
        'courier'            => $request->all()['currier'],
        'package'           => $package->id
    ];

    $packagedetails=Detailspackage::create($packagedetailsData);
    }

    if(!$request->all()['shipment']=='0')
    {

      $data_detail = [
          'shipment'  => $request->all()['shipment'],
          'warehouse' =>  $package->id
      ];
        $shipment_detail = ShipmentDetail::create($data_detail);

    }

    $recive = [
      'package'     => $package->id,
      'observation' => $request->all()['observation'],
      'subtotal'    => $request->all()['subtotal'],
      'total'       => $request->all()['total']
    ];
    $receipt->update($recive);
    $receipt->save();

    $detailsreceipt = DetailsReceipt::query()->where('type_attribute','=','I')->where('receipt','=',$receipt->id)->first();
    $receipts = [
       'receipt'         =>  $receipt->id,
       'type_cost'       =>  0,
       'type_attribute'  =>  'I',
       'id_complemento'  =>  1,
       'value_oring'     =>  $request->all()['taxval'],
       'value_package'   =>  $request->all()['taxre']
     ];
     $detailsreceipt->update($receipts);
     $detailsreceipt->save();
     $detailsreceipt = DetailsReceipt::query()->where('type_attribute','=','S')->where('receipt','=',$receipt->id)->first();
     $receipts = [
       'receipt'         =>  $receipt->id,
       'type_cost'       =>  0,
       'type_attribute'  =>  'S',
       'id_complemento'  =>  1,
       'value_oring'     =>  $request->all()['insurance'],
       'value_package'   =>  $request->all()['toinsurance']
     ];
     $detailsreceipt->update($receipts);
     $detailsreceipt->save();

     $detailsreceipt = DetailsReceipt::query()->where('type_attribute','=','P')->where('receipt','=',$receipt->id)->first();
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

       $promo->update($promotion);
       $promo->save();
   }

/**
     *
     */
     $idpro = $request->all()['promotion'];
     if($idpro != "") {
       $promo= Promotion::find($idpro);
       $promotion = [
           'receipt'         =>  $receipt->id,
           'type_cost'       =>  $promo->type_value,
           'type_attribute'  =>  'P',
           'id_complemento'  =>  $promo->id,
           'value_oring'     =>  $promo->value,
           'value_package'   =>  $request->all()['promotionval']
         ];
         $promo->update($promotion);
         $promo->save();
     }
     $detailsreceipt = DetailsReceipt::query()->where('type_attribute','=','T')->where('receipt','=',$receipt->id)->first();
     $idtype = $request->all()['typeservice'];
     if($idtype != "") {
       $dettype= Service::find($idtype);
       $dettypedata = [
           'receipt'         =>  $receipt->id,
           'type_cost'       =>  0,
           'type_attribute'  =>  'T',
           'id_complemento'  =>  $dettype->id,
           'value_oring'     =>  $dettype->value,
           'value_package'   =>  $request->all()['subtotal']
         ];
         $dettype->update($dettypedata);
         $dettype->save();
     }
     $detailsreceipt = DetailsReceipt::query()->where('type_attribute','=','A')->where('receipt','=',$receipt->id)->first();
     $idaddcharge = $request->all()['addcharge'];
     if($idaddcharge != "") {
       $detaddcharge= AddCharge::find($idaddcharge);
       $addchargedata = [
           'receipt'         =>  $receipt->id,
           'type_cost'       =>  0,
           'type_attribute'  =>  'A',
           'id_complemento'  =>  $detaddcharge->id,
           'value_oring'     =>  $detaddcharge->value,
           'value_package'   =>  $detaddcharge->value
         ];
         $detaddcharge->update($addchargedata);
         $detaddcharge->save();
     }
  //dd($receipt);
  return redirect("/admin/package")->with('successMessage', trans('package.updated', [
      'code' => $package->code,
      'id'   => $package->id
    ]));
  }

   /**
   * Listado (se lista de manera descendente)
   */
  public function index(Request $request) {
    $session = $request->session()->get('key-sesion');
    $this->checkAuthorization();
    $this->setCurrentPage($request->query('page'));
    $page = Package::orderBy('created_at', 'desc')->get();
    /**
    *
    */
    $vars = [
      'data'=> $page
    ];
    /**
    *  Se valida que la sesion este activa
    */
    if ($session == null) {
      return redirect('login');
    }
    /**
    *
    */
    return view('pages.admin.package.list', $vars)->with('successMessage', $request->query('search') ? "Realizar el filtrado de la data : {$query['search']}": null);
  }
  /**
  * Listado de envios wr
  */
  public function indexwr(Request $request) {
    $session = $request->session()->get('key-sesion');
    $this->checkAuthorization();
    $this->setCurrentPage($request->query('page'));
    $page = Package::orderBy('created_at', 'desc')->get();
    /**
    *  Se valida que la sesion este activa
    */
    if ($session == null) {
      return redirect('login');
    }
    /**
    *
    */

    return view('pages.admin.package.listwr', [
      'data' => $page
    ])->with('successMessage', $request->query('search') ? "Realizar el filtrado de la data : {$query['search']}": null);
  }

  /**
   *
   */
  public function delete(Request $request, $id) {
    $redirect = redirect("/admin/package");
    $package = Package::find($id);
    /**
    *
    */
    if(is_null($package)) {
      $redirect->with('errorMessage', trans('package.notFound'));
    }
    else {
      $package->delete();
      $redirect->with('successMessage', trans('package.deleted',
        [
        'tracking' => $package->tracking,
        'id' => $package->id
      ]));
    }
    return $redirect;
  }
  /**
   *
   */
  private function validateDatacurriers(Request $request) {
   return Validator::make($this->clear($request->all()), [
      'tracking'             => 'required|string|min:10|max:25',
      'large1'               => 'required|numeric|min:1',
      'width1'               => 'required|numeric|min:1',
      'height1'              => 'required|numeric|min:1',
      'weight1'              => 'required|numeric|min:1',
      'value'                => 'required|numeric|min:1',
      'type'                 => 'required|numeric|min:1',
      'office'               => 'required|numeric|min:1',
      'service'              => 'required|numeric|min:1',
      'category'             => 'required|numeric|min:1',
      'finalConsigUser'      => 'required|numeric|min:1',
      'finalDestinationUser' => 'required|numeric|min:1',
    ]);
  }
  /**
  *
  */
  private function validateData(Request $request) {
    return Validator::make($this->clear($request->all()), [
      'name'              => 'required|string|min:5|max:25',
      'phone'             => 'required|string|min:5|max:25',
      'email'             => 'required|string|min:5|max:50|email',
      'identifier'        => 'required|string|min:5|max:25|unique:client,identifier',
      'direction'         => 'required|string|min:5|max:250',
      'width'             => 'required|numeric|min:1',
      'height'            => 'required|numeric|min:1',
      'weight'            => 'required|numeric|min:1',
      'value'             => 'required|numeric|min:1',
      'type'             => 'required|numeric|min:1',
    ]);
  }
  /**
  *Funcion que trae los detalle de un recibo asociado a un paquete.
  */
  public function detailsreceipt($id) {
    $this->checkAuthorization();
    $package  = Package::find($id);
    $packages = Detailspackage::query()->where("package", "=", $id)->first();
    $resultpackheight = DB::table('detailspackage')->where('package','=',$id)->sum('height');
    $resultpackwidth  = DB::table('detailspackage')->where('package','=',$id)->sum('width');
    $resultpackpieces = DB::table('detailspackage')->where('package','=',$id)->sum('pieces');
    $resultpackweight = DB::table('detailspackage')->where('package','=',$id)->sum('weight');
    $resultpacklarge  = DB::table('detailspackage')->where('package','=',$id)->sum('large');
    $resultpackvol    = DB::table('detailspackage')->where('package','=',$id)->sum('volumetricweight');
    $company = "";
    /**
    *
    */
    if(isset($package->to_client)) {
      $client          = Client::find($package->to_client);
      $company         = Company::find($client->company);
    }
    /**
    *
    */
    $receipt        = Receipt::query()->where("package", "=", $id)->first();
    $detailsreceipt = DB::table('detailsreceipt')
                ->join('tax', 'detailsreceipt.id_complemento', '=', 'tax.id')
                ->select('detailsreceipt.id', 'tax.name', 'detailsreceipt.value_oring','detailsreceipt.value_package')
                ->where("detailsreceipt.type_attribute","=",'I')
                ->where("detailsreceipt.receipt","=",$receipt->id)
                ->get();
    $detailreceiptpro = DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','P')->first();
    /**
    *
    */
    $vars = [
      'package'          => $package,
      'packages'         => $packages,
      'receipt'          => $receipt,
      'detailsreceipt'   => $detailsreceipt,
      'promo'            => $detailreceiptpro,
      'company'          => $company,
      'height'           => $resultpackheight,
      'weight'           => $resultpackweight,
      'pieces'           => $resultpackpieces,
      'volumen'          => $resultpackvol,
      'large'            => $resultpacklarge,
      'width'            => $resultpackwidth
    ];
    /**
    * Se obtiene la vista para ver detalles del recibo
    */
      return view('pages.admin.package.receipt', $vars);
  }

  /**
   *
   */
   public function printer(Request $request, $id) {

     $session = $request->session()->get('key-sesion');
     /**
     *
     */
     /**
     *
     */
     if($session == null) {
       return redirect('login');
     }
     /**
     *
     */
     $package       = Package::find($id);
     /**
     *
     */
     if (is_null($package)) {
       return $this->doRedirect($request, '/admin/package')
         ->with('errorMessage', trans('package.notFound'));
     }
     /**
     *
     */
     $transport     = isset($package->type) ? Transport::find($package->type):'';
     $category      = isset($package->category) ? Category::find($package->category):'';
     $configuration = Configuration::find(1);
     $noFooter      = true;
     /**
     *
     */
     $vars = [
       'noFooter'      => $noFooter,
       'package'       => $package,
       'transport'     => $transport,
       'category'      => $category,
       'configuration' => $configuration
     ];
     /**
     *
     */
     return view('pages.admin.package.print', $vars);

 }

  /**
  *
  */
  public function dashboarDetails(Request $request, $id)
  {
    $dashboardDate = Configuration::all()->last();
    $today =  $dashboardDate->date_dashboard;
    $vars  = [];
    /**
    * Se muesttra en el modal los paquetes recibidos en el dia
    */
    if($id == 1)
    {
      if($this->longDate($today))
      {
        $receivedPackages = Package::query()->where('start_at', '=', $today)->get();
      }
      else
      {
        $receivedPackages = Package::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->get();
      }
      $vars = [
        'packages' => $receivedPackages
      ];
    }
    /**
    * Se muesttra en el modal los paquetes Enviados en el dia
    */
    if($id == 2)
    {
      if($this->longDate($today))
      {
        $sendPackages = Package::query()->where('start_at', '=', $today)->where('last_event', '>', 1)->get();
      }
      else
      {
        $sendPackages = Package::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('last_event', '>', 1)->get();
      }
      $vars = [
        'packages' => $sendPackages
      ];
    }
    /**
    * Se muesttra en el modal los paquetes Enviados en el dia
    */
    if($id == 3)
    {
      if($this->longDate($today))
      {
        $transitPackages  = Package::query()->where([['start_at', '=', $today],['last_event', '>', 2],['last_event', '<', 4]])->get();
      }
      else
      {
        $transitPackages  = Package::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('last_event', '>', 2)->where('last_event', '<', 4)->get();
      }
      $vars = [
        'packages' => $transitPackages
      ];
    }
    /**
    * Se muesttra en el modal los paquetes Enviados en el dia
    */
    if($id == 4)
    {
      if($this->longDate($today))
      {
        $arribedPackage  = Package::query()->where('start_at', '=', $today)->where('last_event', '=', 4)->get();
      }
      else
      {
        $arribedPackage  = Package::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('last_event', '=', 4)->get();
      }
      $vars = [
        'packages' => $arribedPackage
      ];
    }
    /**
    * Se muesttra en el modal los paquetes sin factura recibidos en el dia el metodo longDate valida si se selecciono un dia especifico o un mes
    */
    if($id == 5)
    {
      if($this->longDate($today))
      {
        $noInvoicePackage  = Package::query()->where([['start_at', '=', $today],['invoice', '=', 0]])->get();
      }
      else
      {
        $noInvoicePackage  = Package::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('invoice', '=', 0)->get();
      }
      $vars = [
        'packages' => $noInvoicePackage
      ];
    }
    /**
    * Se muesttra en el modal los paquetes entregados al cliente en el dia el metodo longDate valida si se selecciono un dia especifico o un mes
    */
    if($id == 6)
    {
      if($this->longDate($today))
      {
        $deliveredPackage  = Package::query()->where([['start_at', '=', $today],['last_event', '=', 5]])->get();
      }
      else
      {
        $deliveredPackage  = Package::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('last_event', '=', 5)->get();
      }
      $vars = [
        'packages' => $deliveredPackage
      ];
    }
    return view('sections.detailsOnDashboard', $vars);
  }

    /**
    *
    */
    public function items(Request $request, $id)
    {
      $packageDetail      = Detailspackage::bypackage($id)->get();
      $packageDetailCount = Detailspackage::bypackage($id)->count();
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




    public function uploadile (Request $request, $id)
    {
      $session       = $request->session()->get('key-sesion');
      $package = Package::find($id);

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
       $vars = [
      'package'     =>$package

    ];

      /**
      *
      */
      if($this->isGET($request))
      {
        return view('pages.admin.package.uploadfilepackage', $vars);
      }
      /**
      * Use the validator
      */
      /*if (!is_null($validator))
      {
        if ($validator->fails())
        {
           return response()->json([
             "message" => "false",
             "alert"   => $validator->messages()
           ]);
        }
      }*/


    /**
    *Se carga la factura en caso que aplique
    */


      $file           = Input::file('fileinvoice');
      $aleatorio      = str_random();
      $nombre         = $aleatorio.'_'.$file->getClientOriginalName();

      /*
      *Datos de la factura a subir
      */

      $data = [
        "name"           => $nombre,
        "path"           => asset('/uploads')."/".$nombre,
        "id_package"     => $package->id,
        "carrier"        => $package->from_courier,
        "contentPackage" => "1",
        "pricePackage"   => '0'


      ];
      /**
      * Se almacenan los datos del archivo subido
      */
      $file->move('uploads', $nombre);
      $save = File::create($data);

      $package->invoice = true;
      $package->save();

      /**
      *
      */
      return response()->json([
        "message" => "true"
      ]);
    }
}
