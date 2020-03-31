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
use App\Models\Admin\FromCourier;
use App\Models\Admin\Category;
use App\Models\Admin\DetailsReceipt;
use App\Models\Admin\Detailspackage;
use App\Models\Admin\DetailsPickup;
use App\Models\Admin\Service;
use App\Models\Admin\AddCharge;
use App\Models\Admin\PackageConsolidated;
use App\Models\Admin\File;
use App\Models\Admin\Pickup;
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
      /**
      *
      */
      if($request->all()['finalConsigUser'] == '0') ///no se selecciona cliente destino
       {
        $userCons = User::create([
          'name'           => $request->all()['cons_name'],
          'celular'        => $request->all()['cons_phone'],
          'email'          => $request->all()['cons_email'],
          'postal_code'    => $request->all()['cons_zipcode'],
          'pais'           => $request->all()['cons_country'],
          'region'         => $request->all()['cons_region'],
          'address'        => $request->all()['cons_direction']

        ]);
    }
    if($request->all()['finalDestinationUser'] == '0') ///no se selecciona cliente destino
    {
        $userDest = User::create([
          'name'           => $request->all()['destin_name'],
          'celular'        => $request->all()['destin_phone'],
          'email'          => $request->all()['destin_email'],
          'postal_code'    => $request->all()['destin_zipcode'],
          'pais'           => $request->all()['destin_country'],
          'region'         => $request->all()['destin_region'],
          'address'        => $request->all()['destin_direction']

        ]);
    }
     $pickupData = [
        'from_courier'      => $request->all()['courierSelect'],
        'to_user'           => ($request->all()['finalDestinationUser'] == ''? null :$request->all()['finalDestinationUser']),
        'consigner_user'    => ($request->all()['finalConsigUser'] == ''? null :$request->all()['finalConsigUser']),
        'value'             => $request->all()['value'],
        'type'              => ($request->all()['type'] == "") ? null :$request->all()['type'],
        'details_type'      => ($request->all()['dettype'] == "") ? null :$request->all()['dettype'],
        'category'          => ($request->all()['category'] == "") ? null :$request->all()['category'],
        'office'            => ($request->all()['office'] == "") ? null :$request->all()['office'],
        'typeservice'       => ($request->all()['typeservice'] == "") ? null :$request->all()['typeservice'],
        'addcharge'         => ($request->all()['addcharge'] == "") ? null :$request->all()['addcharge'],
        'promotion'         => ($request->all()['promotion'] == "") ? null :$request->all()['promotion'],
        'invoice'           => $request->all()['invoice'],
        'observation'       => $request->all()['observation'],
        'last_event'        => 1,
        'insurance'         => $request->all()['insurance'],
        'volumetricweightm'   => $request->all()['volre'],
        'volumetricweighta'   => $request->all()['volre'],
        'costservice'   => $request->all()['costservice'],
        'costinsurance'   => $request->all()['toinsurance'],
        'aditionalcost'   => $request->all()['costadd'],
        'subtotal'   => $request->all()['subtotal'],
        'total'   => $request->all()['total'],
        'tax'               => $request->all()['taxval'],
        'pro'               => $request->all()['promotionval'],
        'start_at'          => $request->all()['start_at']
      ];
    //  dd($pickupData);
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
              'path'          => asset('/uploads/').$pickup->code."/".$nombre,
              'name_path'     => $nombre,
              'operator'      => $admin->id
            ];
            $attachment = Attachment::create($data);
         }
      }

    for ($i = 1; $i <= $request->all()['countpack']; $i++) {
      $pickupdetailsData=[
        'description'       => $request->all()['description'.$i],
        'typepickup'        => $request->all()['typepickup'.$i],
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
        'po'                => $request->all()['po'.$i],
        'pickup'            => $pickup->id
    ];

      $pickupdetails=DetailsPickup::create($pickupdetailsData);
    }
    /**
    *Se carga la factura en caso que aplique
    */
    if($request->all()['invoice']=="1"){
      $file           = Input::file('file');
      $aleatorio      = str_random();
      $nombre         = $aleatorio.'_'.$file->getClientOriginalName();
      /**
      * Datos de la factura a subir
      */
      $data = [
        "name"           => $nombre,
        "path"           => asset('/uploads')."/".$nombre,
        "id_package"     => $pikcup->id,
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
    if(!$request->all()['consolidated']=='') {
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
    $receipt=$this->setreceiptpickup($pickup->id,$request->all()['observation'],$request->all()['subtotal'],$request->all()['total']);
    /**
    *
    */
    foreach($taxs as $tax){
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
    }
    /**
    * se notifica al usuario
    */
    if ($request->all()['finalDestinationUser'] != HConstants::RESPONSE_NULL) {
      $this->notifyUserPickup($request->all()['finalDestinationUser'], HConstants::EVENT_RECEIVED, $pickup->id);
    }
    /**
    *
    */
    $this->insertLogPickup($pickup->id, 1,$request->all()['observation'],null,$session['data']->id);
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
      $pickup     = Pickup::find($id);
      $edit       = true;
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
        //  dd($pickup);
      $vars = [
        'pickup'      => $pickup,
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
    //  dd($request->all());

      $pickupData = [
          'from_courier'      => $request->all()['courierSelect'],
          'to_user'           => ($request->all()['finalDestinationUser'] == ''? null :$request->all()['finalDestinationUser']),
          'consigner_user'    => ($request->all()['finalConsigUser'] == ''? null :$request->all()['finalConsigUser']),
          'value'             => $request->all()['value'],
          'type'              => ($request->all()['type'] == "") ? null :$request->all()['type'],
          'details_type'      => ($request->all()['dettype'] == "") ? null :$request->all()['dettype'],
          'category'          => ($request->all()['category'] == "") ? null :$request->all()['category'],
          'office'            => ($request->all()['office'] == "") ? null :$request->all()['office'],
          'typeservice'       => ($request->all()['typeservice'] == "") ? null :$request->all()['typeservice'],
          'addcharge'         => ($request->all()['addcharge'] == "") ? null :$request->all()['addcharge'],
          'promotion'         => ($request->all()['promotion'] == "") ? null :$request->all()['promotion'],
          'invoice'           => $request->all()['invoice'],
          'observation'       => $request->all()['observation'],
          'last_event'        => 1,
          'insurance'         => $request->all()['insurance'],
          'volumetricweightm'  => $request->all()['volre'],
          'volumetricweighta'  => $request->all()['volre'],
          'costservice'       => $request->all()['costservice'],
          'costinsurance'     => $request->all()['toinsurance'],
          'aditionalcost'     => $request->all()['costadd'],
          'subtotal'          => $request->all()['subtotal'],
          'total'             => $request->all()['total'],
          'tax'               => $request->all()['taxval'],
          'pro'               => $request->all()['promotionval'],
          'start_at'          => $request->all()['start_at']
        ];
        /**
        *
        */
      $pickup->update($pickupData);
      $pickup->save();
      DB::table('detailspackage')->where('package', '=', $id)->delete();
      /**
      *
      */
      for ($i = 1; $i <= $request->all()['countpack']; $i++) {
        $pickupdetailsData=[
          'description'       => $request->all()['description'.$i],
          'typepickup'        => $request->all()['typepickup'.$i],
          'numberparts'       => isset($request->all()['numberparts'.$i]) ? $request->all()['numberparts'.$i] : "",
          'pieces'            => $request->all()['pieces'.$i],
          'large'             => $request->all()['large'.$i],
          'width'             => $request->all()['width'.$i],
          'height'            => $request->all()['height'.$i],
          'weight'            => $request->all()['weight'.$i],
          'volumetricweight'  => $request->all()['volumetricweightm'.$i],
          'value'             => $request->all()['valued'.$i],
          'invoice'           => $request->all()['invoiced'.$i],
          'tracking'          => $request->all()['tracking'.$i],
          'po'                => $request->all()['po'.$i],
          'pickup'            => $pickup->id
      ];
      /**
      *
      */
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
      $tipepickup = TypePickup::find($id);
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
        $redirect->with('successMessage', trans('typepickup.deleted',
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
      $event = Event::query()->where('active','=','1')->get();
      $events_number = Event::query()->where('active','=','1')->count();
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
      $this->insertLogPickup($pickup->id, $request->all()['event'], $request->all()['observation'], null, $session['data']->id);
      /**
      *
      */
      if ( !is_null($pickup->to_user) ) {
        $this->notifyUserPickup($pickup->to_user, $request->all()['event'], $pickup->id);
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
