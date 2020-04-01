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
use App\Models\Admin\Configuration;
use App\Models\Admin\Packages\Transport;
use App\Models\Admin\Package;
use App\Models\Admin\Company;
use App\Models\Admin\Promotion;
use App\Models\Admin\Prealert;
use App\Models\Admin\FromCourier;
use App\Models\Admin\Category;
use App\Models\Admin\DetailsReceipt;
use App\Models\Admin\PackageConsolidated;
use App\Models\Admin\TransportType;
use App\Models\Admin\AddCharge;
use App\Models\Admin\File;
use App\Models\Admin\Office;
use Validator;
use GDText\Box;
use GDText\Color;
use Carbon\Carbon;
use DB;
use Input;
use App\Helpers\HConstants;

/**
 *
 */
class PackageController extends Controller {

  /**
   *
   */
  public function readDetails(Request $request, $id) {
    return $this->details($request, $id, true);
  }
  /**
   *
   */
  public function details(Request $request, $id, $readonly = false) {
    $this->checkAuthorization();
    $package = Package::find($id);
    $start_at = Carbon::now()->format('Y-m-d');
    $receipt       = Receipt::query()->where('package','=',$id)->first();
    $taxs=Tax::byStatus(1)->get();

    if(is_null($package)) {
      return $this->doRedirect($request, '/admin/package')
        ->with('errorMessage', trans('package.notFound'));
    }

    if(isset($receipt)){
      $tax  = DB::table('detailsreceipt')
                        ->join('tax', 'detailsreceipt.id_complemento', '=', 'tax.id')
                        ->select('tax.id', 'tax.name', 'detailsreceipt.value_oring as value','detailsreceipt.value_package as valuep')
                        ->where("detailsreceipt.type_attribute","=",'I')
                        ->where("detailsreceipt.receipt","=",$receipt->id)
                        ->get();

       $promotion = DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','P')->first();

       $typetranspor = DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','T')->first();



       $insurance = DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','S')->first();

       $detailreceiptadd = DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','A')->first();
    } else {
      $tax=Tax::byStatus(1)->get();
    }
    /**
    *
    */
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
      'office'        => Office::all(),
      'tytransport'   => TransportType::all(),
      'idtytransport' => TransportType::find($package->dettype),
      'tax'           => $tax,
      'transports'    => Transport::all(),
      'addcharge'   => AddCharge::all(),
      'category'      => Category::all(),
      'addcharge'     => AddCharge::all(),
      'idaddcharge'   => $detailreceiptadd,
      'receipt'       => $receipt ,
      'promotion'     => isset($promotion) ? $promotion: '',
      'insurance'     => isset($insurance) ? $insurance: '',
      'start_at'      => $start_at
    ];
    /**
    *
    */
    if($this->isGET($request)) {
      return view('pages.admin.package.edit',$vars);
    }

     if($request->all()['clientSelect']==""){
        $userdestino=null;
      }else{
        $userdestino=$request->all()['clientSelect'];
      }

      $packageData = [
        'to_client' => $userdestino,
        'large'              => ($request->all()['large']== "") ? null :$request->all()['large'],
        'width'              => ($request->all()['width']== "") ? null :$request->all()['width'],
        'height'             => ($request->all()['height']== "") ? null :$request->all()['height'],
        'weight'             => ($request->all()['weight']== "") ? null :$request->all()['weight'],
        'value'              => ($request->all()['value']== "") ? null :$request->all()['value'],
        'volumetricweightm'  => ($request->all()['volumetricweightm']== "") ? null :$request->all()['volumetricweightm'],
        'volumetricweighta'  => ($request->all()['volumetricweighta']== "") ? null :$request->all()['volumetricweighta'],
        'type'               => ($request->all()['type']== "") ? null :$request->all()['type'],
        'dettype'            => ($request->all()['typeservice']== "") ? null :$request->all()['typeservice'],
        'category'           => ($request->all()['category']== "") ? null :$request->all()['category'],
        'office'             => ($request->all()['office'] == "") ? null :$request->all()['office'],
        'invoice'            => ($request->all()['invoice']== "") ? null :$request->all()['invoice'],
        'start_at'           => ($request->all()['start_at']== "") ? null :$request->all()['start_at'],
        'consolidated'       => ($request->all()['consolidated']== "") ? null : $request->all()['consolidated']
      ];



    $package->update($packageData);
    $package->save();

    $receipt       = Receipt::query()->where('package','=',$id)->first();
    $receiptt=$this->updatereceipt($receipt->id,'',$request->all()['subtotal'],$request->all()['total']);
      if(isset($receipt)){
        DB::table('detailsreceipt')->where('receipt', '=', $receipt->id)->delete();
      }

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

    if(!$request->all()['consolidated']=='')
    {
      $consol=
      [
      'package'       =>  $package->id,
      'consolidated'  =>  $request->all()['consolidated'],
      'observation'   =>  $request->all()['observation']
      ];
      PackageConsolidated::create($consol);
    }

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
        'value_package'   =>  $request->all()['costinsu']
      ];
      DetailsReceipt::create($receipts);


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
        $dettype= TransportType::find($idtype);
        $dettypedata = [
            'receipt'         =>  $receipt->id,
            'type_cost'       =>  0,
            'type_attribute'  =>  'T',
            'id_complemento'  =>  $dettype->id,
            'value_oring'     =>  $dettype->price,
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
      return redirect("/admin/package")->with('successMessage', trans('package.editp',
      [
      'tracking' => $package->tracking,
      'id'       => $package->id
    ]));
  }
  /*
  *Subiendo factura
  */

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
  //dd(Input::file('fileinvoice'));

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

  /**
   * Creacion
   */
  public function create(Request $request) {
    $session = $request->session()->get('key-sesion');
    $this->checkAuthorization();
    $taxs=Tax::byStatus(1)->get();
    $start_at = Carbon::now()->format('Y-m-d'); /********/
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
      'countries'   => Country::all(),
      'clients'     => Client::all(),
      'promotions'  => Promotion::all(),
      'company'     => Company::query()->where('id','>',1)->get(),
      'consolidated'=> Consolidated::byStatus(1)->get(),
      'couriers'    => Courier::byStatus()->get(),
      'users'       => User::byUserType(1)->get(),
      'tax'         => $taxs,
      'transports'  => Transport::all(),
      'office'      => Office::all(),
      'tytransport' => '',
      'category'    => Category::all(),
      'addcharge'   => AddCharge::all(),
      'start_at'    => $start_at
    ];
    /**
    *
    */
    if($this->isGET($request)) {
      return view('pages.admin.package.create', $vars);
    }
    /**
    * Se validan los campos del paquete
    */

    /*$validator = $this->validateData($request);
    if (!is_null($validator))
    {
      if ($validator->fails())
      {
        return view('pages.admin.package.create', $vars)
          ->withErrors($validator)
          ->with('errorMessage', trans('messages.checkRedFields'));
      }
    }*/

    //dd($request->all());
    /**
    * Esta condicion valida si no se selecciona cliente de proveniencia
    */
    if($request->all()['clientSelect'] == 'add') {
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

    if($request->all()['clientSelect']==""){
      $userdestino=null;
    }else{
      $userdestino=$request->all()['clientSelect'];
    }

    $packageData = [
      'to_client' => $userdestino,
      'large'              => ($request->all()['large']== "") ? null :$request->all()['large'],
      'width'              => ($request->all()['width']== "") ? null :$request->all()['width'],
      'height'             => ($request->all()['height']== "") ? null :$request->all()['height'],
      'weight'             => ($request->all()['weight']== "") ? null :$request->all()['weight'],
      'value'              => ($request->all()['value']== "") ? null :$request->all()['value'],
      'volumetricweightm'  => ($request->all()['volumetricweightm']== "") ? null :$request->all()['volumetricweightm'],
      'volumetricweighta'  => ($request->all()['volumetricweighta']== "") ? null :$request->all()['volumetricweighta'],
      'type'               => ($request->all()['type']== "") ? null :$request->all()['type'],
      'dettype'            => ($request->all()['typeservice']== "") ? null :$request->all()['typeservice'],
      'category'           => ($request->all()['category']== "") ? null :$request->all()['category'],
      'office'             => ($request->all()['office'] == "") ? null :$request->all()['office'],
      'invoice'            => ($request->all()['invoice']== "") ? null :$request->all()['invoice'],
      'start_at'           => ($request->all()['start_at']== "") ? null :$request->all()['start_at'],
      'consolidated'       => ($request->all()['consolidated']== "") ? null : $request->all()['consolidated']
    ];

    //dd($packageData);



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

    if(!$request->all()['consolidated']=='')
    {
      $consol=
      [
      'package'       =>  $package->id,
      'consolidated'  =>  $request->all()['consolidated'],
      'observation'   =>  $request->all()['observation']
      ];
      PackageConsolidated::create($consol);
    }

      $receipt=$this->setreceipt($package->id,$request->all()['observation'],$request->all()['subtotal'],$request->all()['total']);

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
        'value_package'   =>  $request->all()['costinsu']
      ];
      DetailsReceipt::create($receipts);


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
      $dettype= TransportType::find($idtype);
      $dettypedata = [
          'receipt'         =>  $receipt->id,
          'type_cost'       =>  0,
          'type_attribute'  =>  'T',
          'id_complemento'  =>  $dettype->id,
          'value_oring'     =>  $dettype->price,
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


    $this->insertLog($package->id, 1,$request->all()['observation'],null,$session['data']->id);
    return redirect("/admin/package")->with('successMessage', trans('package.created',
      [
      'tracking' => $package->tracking,
      'id'       => $package->id
    ]));
  }
  /**
  *
  */
  public function verify(Request $request) {
    $order_service = $request->all()['servicerOrder'];
    $prealert = Prealert::byOrderService($order_service)->first();
    $user='';
    if($prealert!=null){
      $user     = User::find($prealert->user);
    }

    $courier  = Courier::all();
    /**
    *
    */
    if (is_null($prealert)) {
      return response()->json([
        'message' => 'false'
      ]);
    } else {
      return response()->json([
        'message' => true,
        'data'    => $prealert,
        'courier' => $courier,
        'user'    => $user
      ]);
    }
  }
  /**
   * Creacion de Paquetes por curriers
   */
  public function createcurriers(Request $request) {
    $session = $request->session()->get('key-sesion');
    $taxs=Tax::byStatus(1)->get();
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
      'countries'   => Country::all(),
      'promotions'  => Promotion::all(),
      'consolidated'=> Consolidated::byStatus(1)->get(),
      'couriers'    => Courier::byStatus()->get(),
      'users'       => User::byUserType(1)->get(),
      'tax'         => $taxs,
      'transports'  => Transport::all(),
      'tytransport' => '',
      'office'      => Office::all(),
      'category'    => Category::all(),
      'addcharge'   => AddCharge::all(),
      'start_at'    => Carbon::now()->format('Y-m-d')
    ];


    /**
    *
    */
    if($this->isGET($request)) {
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
    if($request->all()['finalDestinationUser']==""){
      $userdestino=null;
    }else{
      $userdestino=$request->all()['finalDestinationUser'];
    }
    if($request->all()['courierSelect']==""){
      $courier=null;
    }else{
      $courier=$request->all()['courierSelect'];
    }
    /**
    * Se realizan las validaciones del paquete, En esta condicion se valida si el paquete viene de una persona natural
    */

    $packageData = [
        'from_courier'      => $courier,
        'to_user'           => $userdestino,
        'tracking'          => ($request->all()['tracking']== "") ? null :$request->all()['tracking'],
        'order_service'     => ($request->all()['service_order']== "") ? null :$request->all()['service_order'],
        'large'             => ($request->all()['large']== "") ? null :$request->all()['large'],
        'width'             => ($request->all()['width']== "") ? null :$request->all()['width'],
        'height'            => ($request->all()['height']== "") ? null :$request->all()['height'],
        'weight'            => ($request->all()['weight']== "") ? null :$request->all()['weight'],
        'value'             => ($request->all()['value']== "") ? null :$request->all()['value'],
        'volumetricweightm' => ($request->all()['volumetricweightm']== "") ? null :$request->all()['volumetricweightm'],
        'volumetricweighta' => ($request->all()['volumetricweighta']== "") ? null :$request->all()['volumetricweighta'],
        'type'              => ($request->all()['type']== "") ? null :$request->all()['type'],
        'dettype'           => ($request->all()['typeservice']== "") ? null :$request->all()['typeservice'],
        'category'          => ($request->all()['category']== "") ? null :$request->all()['category'],
        'office'            => ($request->all()['office'] == "") ? null :$request->all()['office'],
        'invoice'           => ($request->all()['invoice']== "") ? null :$request->all()['invoice'],
        'start_at'          => ($request->all()['start_at']== "") ? null :$request->all()['start_at'],
        'consolidated'      => ($request->all()['consolidated']== "") ? null : $request->all()['consolidated']
      ];
    $package = Package::create($packageData);

    $prealert=Prealert::byOrderService($request->all()['service_order'])->first();


    if($prealert != null){

      $prealert->update([
        'package' => $package->id,
        'complete'=>'1'
      ]);
      $prealert->save();
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
    if(!$request->all()['consolidated']=='')
    {
      $consol=
      [
      'package'       =>  $package->id,
      'consolidated'  =>  $request->all()['consolidated'],
      'observation'   =>  $request->all()['observation']
      ];
      PackageConsolidated::create($consol);
    }

    $session = $request->session()->get('key-sesion');
    $receipt=$this->setreceipt($package->id,$request->all()['observation'],$request->all()['subtotal'],$request->all()['total']);

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
        'value_package'   =>  $request->all()['costinsu']
      ];
      DetailsReceipt::create($receipts);


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
      $dettype= TransportType::find($idtype);
      $dettypedata = [
          'receipt'         =>  $receipt->id,
          'type_cost'       =>  0,
          'type_attribute'  =>  'T',
          'id_complemento'  =>  $dettype->id,
          'value_oring'     =>  $dettype->price,
          'value_package'   =>  $request->all()['subtotal']
        ];
        DetailsReceipt::create($dettypedata);
    }

    $idaddcharge = $request->all()['addcharge'];
    if($idaddcharge != "") {
      $detaddcharge= AddCharge::find($idtype);
      $addchargedata = [
          'receipt'         =>  $receipt->id,
          'type_cost'       =>  0,
          'type_attribute'  =>  'A',
          'id_complemento'  =>  isset($detaddcharge) ? $detaddcharge->id : '',
          'value_oring'     =>  isset($detaddcharge)?$detaddcharge->value: '',
          'value_package'   =>  isset($detaddcharge)?$detaddcharge->value: ''
        ];
        DetailsReceipt::create($addchargedata);
    }


    /**
    *
    */
    $this->insertLog($package->id, 1,$request->all()['observation'],null,$session['data']->id);
    $this->notifyUserStatus($userdestino, HConstants::EVENT_RECEIVED, $package->id);
    /**
    *
    */
    return redirect("/admin/package")->with('successMessage', trans('package.created', [
      'tracking' => $package->tracking,
      'id' => $package->id
    ]));
  }
  /**
  *
  */
  public function detailscurriers(Request $request, $id, $readonly = false) {
    $session   = $request->session()->get('key-sesion');
    $this->checkAuthorization();
    $package = Package::find($id);
    $start_at = Carbon::now()->format('Y-m-d'); /********/
    $receipt       = Receipt::query()->where('package','=',$id)->first();
    $taxs=Tax::byStatus(1)->get();

    if ($session == null)
    {
      return redirect('login');
    }
    if(isset($receipt)){
      $tax  = DB::table('detailsreceipt')
                        ->join('tax', 'detailsreceipt.id_complemento', '=', 'tax.id')
                        ->select('tax.id', 'tax.name', 'detailsreceipt.value_oring as value','detailsreceipt.value_package as valuep')
                        ->where("detailsreceipt.type_attribute","=",'I')
                        ->where("detailsreceipt.receipt","=",$receipt->id)
                        ->first();
       $promotion = DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','P')->first();

       $typetranspor = DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','T')->first();



       $insurance = DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','S')->first();

       $detailreceiptadd = DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','A')->first();
    }else{
      $tax=Tax::byStatus(1)->get();
    }

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
      'tytransport'   => TransportType::all(),
      'idtytransport' => TransportType::find($package->dettype),
      'office'        => Office::all(),
      'tax'           => $tax,
      'transports'    => Transport::all(),
      'category'      => Category::all(),
      'addcharge'     => AddCharge::all(),
      'idaddcharge'   => $detailreceiptadd,
      'receipt'       => $receipt,
      'promotion'     => isset($promotion) ? $promotion: '',
      'insurance'     => isset($insurance) ? $insurance: '',
      'start_at'      => $start_at
    ];
    //dd($vars);


    if($this->isGET($request))
    {
      return view('pages.admin.packagecurriers.edit',$vars);
    }




    if($request->all()['finalDestinationUser']==""){
      $userdestino=null;
    }else{
      $userdestino=$request->all()['finalDestinationUser'];
    }

    if($request->all()['courierSelect']==""){
      $courier=null;
    }else{
      $courier=$request->all()['courierSelect'];
    }



    /**
    * Se realizan las validaciones del paquete, En esta condicion se valida si el paquete viene de una persona natural
    */
    $packageData = [
        'from_courier'      => $courier,
        'to_user'           => $userdestino,
        'tracking'          => ($request->all()['tracking']== "") ? null :$request->all()['tracking'],
        'order_service'     => ($request->all()['service_order']== "") ? null :$request->all()['service_order'],
        'large'             => ($request->all()['large']== "") ? null :$request->all()['large'],
        'width'             => ($request->all()['width']== "") ? null :$request->all()['width'],
        'height'            => ($request->all()['height']== "") ? null :$request->all()['height'],
        'weight'            => ($request->all()['weight']== "") ? null :$request->all()['weight'],
        'value'             => ($request->all()['value']== "") ? null :$request->all()['value'],
        'volumetricweightm' => ($request->all()['volumetricweightm']== "") ? null :$request->all()['volumetricweightm'],
        'volumetricweighta' => ($request->all()['volumetricweighta']== "") ? null :$request->all()['volumetricweighta'],
        'type'              => ($request->all()['type']== "") ? null :$request->all()['type'],
        'dettype'           => ($request->all()['typeservice']== "") ? null :$request->all()['typeservice'],
        'category'          => ($request->all()['category']== "") ? null :$request->all()['category'],
        'office'            => ($request->all()['office'] == "") ? null :$request->all()['office'],
        'invoice'           => ($request->all()['invoice']== "") ? null :$request->all()['invoice'],
        'start_at'          => ($request->all()['start_at']== "") ? null :$request->all()['start_at'],
        'consolidated'      => ($request->all()['consolidated']== "") ? null : $request->all()['consolidated']
      ];

    //Emision de Recibos y detalles de recibos
    ////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////

    $package->update($packageData);
    $package->save();



     $receipt       = Receipt::query()->where('package','=',$id)->first();
     $receiptt=$this->updatereceipt($receipt->id,'',$request->all()['subtotal'],$request->all()['total']);
      if(isset($receipt)){
        DB::table('detailsreceipt')->where('receipt', '=', $receipt->id)->delete();
      }

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

      if(!$request->all()['consolidated']=='')
      {
        $consol=
        [
        'package'       =>  $package->id,
        'consolidated'  =>  $request->all()['consolidated'],
        'observation'   =>  $request->all()['observation']
        ];
        PackageConsolidated::create($consol);
      }

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
        'value_package'   =>  $request->all()['costinsu']
      ];
      DetailsReceipt::create($receipts);

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
      $dettype= TransportType::find($idtype);
      $dettypedata = [
          'receipt'         =>  $receipt->id,
          'type_cost'       =>  0,
          'type_attribute'  =>  'T',
          'id_complemento'  =>  $dettype->id,
          'value_oring'     =>  $dettype->price,
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

      return redirect("/admin/package")->with('successMessage', trans('package.editp',
      [
      'tracking' => $package->tracking,
      'id'       => $package->id
    ]));


  }
   /**
   * Listado (se lista de manera descendente)
   */
  public function index(Request $request) {
    $session = $request->session()->get('key-sesion');
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
    return view('pages.admin.package.list', [
      'data' => $page
    ])->with('successMessage', $request->query('search') ? "Realizar el filtrado de la data : {$query['search']}": null);
  }
  /**
   *
   */
  public function delete(Request $request, $id) {
    $redirect = redirect("/admin/package");
    $package = Package::find($id);
    if(is_null($package)) {
      $redirect->with('errorMessage', trans('package.notFound'));
    }
    else {
      $package->delete();
      $redirect->with('successMessage', trans('package.deleted', [
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
      'tracking'          => 'required|string|min:10|max:25',
      'large'             => 'required|numeric|min:1',
      'width'             => 'required|numeric|min:1',
      'height'            => 'required|numeric|min:1',
      'weight'            => 'required|numeric|min:1',
      'value'             => 'required|numeric|min:1',
      'type'              => 'required|numeric|min:1',
    ]);
  }
  /**
  *
  */
  private function validateData(Request $request) {
    if($request->all()['clientSelect'] == '0') ///no se selecciona cliente
    {

      {
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
    }
    else ///se selecciona cliente de proveniencia
    {
      return Validator::make($this->clear($request->all()), [
        'large'             => 'required|numeric|min:1',
        'width'             => 'required|numeric|min:1',
        'height'            => 'required|numeric|min:1',
        'weight'            => 'required|numeric|min:1',
        'value'             => 'required|numeric|min:1',
        'type'             => 'required|numeric|min:1',
      ]);
    }
  }
  /**
  *Funcion que trae los detalle de un recibo asociado a un paquete.
  */
  public function detailsreceipt($id){
    $this->checkAuthorization();
    $package         = Package::find($id);
    $company="";
    if(isset($package->to_client)){
    $client          = Client::find($package->to_client);
    $company         = Company::find($client->company);
    }
    $receipt         = Receipt::query()->where("package", "=", $id)->first();
    $detailsreceipt  = DB::table('detailsreceipt')
                ->join('tax', 'detailsreceipt.id_complemento', '=', 'tax.id')
                ->select('detailsreceipt.id', 'tax.name', 'detailsreceipt.value_oring','detailsreceipt.value_package')
                ->where("detailsreceipt.type_attribute","=",'I')
                ->where("detailsreceipt.receipt","=",$receipt->id)
                ->get();

    //Detalle de las Promociones
    $detailreceiptpro = DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','P')->first();
    //Detalle del Seguro
    $insurance = DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','S')->first();
    //Detalle de Cargos Adicionales
    $detailreceiptadd = DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','A')->first();

    //Detalle por tipo de servicio
    $detailtype = DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','T')->first();
    $vars = [
      'package'          => $package,
      'receipt'          => $receipt,
      'detailsreceipt'   => $detailsreceipt,
      'promo'            => $detailreceiptpro,
      'addcharge'        => $detailreceiptadd,
      'insurance'        => $insurance,
      'detailtype'       => $detailtype,
      'company'          => $company
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
    return view('pages.admin.package.label.print', $vars);

  }
  /**
  *
  */
  public function dashboarDetails(Request $request, $id) {
    $dashboardDate = Configuration::all()->last();
    $today =  $dashboardDate->date_dashboard;
    $vars  = [];
    /**
    * Se muesttra en el modal los paquetes recibidos en el dia
    */
    if($id == 1) {
      if($this->longDate($today)) {
        $receivedPackages = Package::query()->where('start_at', '=', $today)->get();
      }
      else {
        $receivedPackages = Package::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->get();
      }
      $vars = [
        'packages' => $receivedPackages
      ];
    }
    /**
    * Se muesttra en el modal los paquetes Enviados en el dia
    */
    if($id == 2) {
      if($this->longDate($today)) {
        $sendPackages = Package::query()->where('start_at', '=', $today)->where('last_event', '>', 1)->get();
      }
      else {
        $sendPackages = Package::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('last_event', '>', 1)->get();
      }
      $vars = [
        'packages' => $sendPackages
      ];
    }
    /**
    * Se muesttra en el modal los paquetes Enviados en el dia
    */
    if($id == 3) {
      if($this->longDate($today)) {
        $transitPackages  = Package::query()->where([['start_at', '=', $today],['last_event', '>', 2],['last_event', '<', 4]])->get();
      }
      else {
        $transitPackages  = Package::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('last_event', '>', 2)->where('last_event', '<', 4)->get();
      }
      $vars = [
        'packages' => $transitPackages
      ];
    }
    /**
    * Se muesttra en el modal los paquetes Enviados en el dia
    */
    if($id == 4) {
      if($this->longDate($today)) {
        $arribedPackage  = Package::query()->where('start_at', '=', $today)->where('last_event', '=', 4)->get();
      }
      else {
        $arribedPackage  = Package::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('last_event', '=', 4)->get();
      }
      $vars = [
        'packages' => $arribedPackage
      ];
    }
    /**
    * Se muesttra en el modal los paquetes sin factura recibidos en el dia el metodo longDate valida si se selecciono un dia especifico o un mes
    */
    if($id == 5) {
      if($this->longDate($today)) {
        $noInvoicePackage  = Package::query()->where([['start_at', '=', $today],['invoice', '=', 0]])->get();
      }
      else {
        $noInvoicePackage  = Package::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('invoice', '=', 0)->get();
      }
      $vars = [
        'packages' => $noInvoicePackage
      ];
    }
    /**
    * Se muesttra en el modal los paquetes entregados al cliente en el dia el metodo longDate valida si se selecciono un dia especifico o un mes
    */
    if($id == 6) {
      if($this->longDate($today)) {
        $deliveredPackage  = Package::query()->where([['start_at', '=', $today],['last_event', '=', 5]])->get();
      }
      else {
        $deliveredPackage  = Package::query()->whereMonth('start_at', '=', Carbon::parse($today)->format('m'))->where('last_event', '=', 5)->get();
      }
      $vars = [
        'packages' => $deliveredPackage
      ];
    }
    return view('sections.detailsOnDashboard', $vars);
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
  * eliminar una prealerta
  */
  public function prealertDelete(Request $request, $id) {
    $redirect = $this->doRedirect($request, "/admin/package/prealert");
    $prealert = Prealert::find($id);
    /**
    *
    */
    if(is_null($prealert)) {
      $redirect->with('errorMessage', trans('prealert.notFound'));
    } else {
      $prealert->delete();
      $redirect->with('successMessage', trans('prealert.deleted', [
        'code'    => $prealert->code,
        'package' => $prealert->getPackage == null ? trans('prealert.unknown') : $prealert->getPackage->code
      ]));
    }
    return $redirect;
  }

}
