<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Helpers\HConstants;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Admin\CargoRelease;
use App\Models\Admin\CargoReleaseDetail;
use App\Models\Admin\Configuration;
use App\Models\Admin\User;
use App\Models\Admin\Package;
use App\Models\Admin\Pickup;
use App\Models\Admin\Event;
use App\Models\Admin\Log;
use App\Models\Admin\Attachment;
use App\Models\Admin\Country;
use Input;
use DB;
use Validator;
use Crypt;
use \Mail;

class CargoReleaseController extends Controller {
  /**
  * Initial Process
  */
  public function index(Request $request) {
    $session        = $request->session()->get('key-sesion');
    $cargo_release  = CargoRelease::orderBy('created_at', 'desc')->get();

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
      'cargo_release' => $cargo_release
    ];
    /**
    *
    */
    return view('pages.admin.cargoRelease.list',$vars);
  }
  /**
  *
  */
  public function create(Request $request) {
    $session    = $request->session()->get('key-sesion');
    $users      = User::all();
    $large      = true;
    $warehouse = Package::byBooked(HConstants::RESPONSE_NULL)->get();
    $pickup    = Pickup::byBooked(HConstants::RESPONSE_NULL)->get();
    $countrys   = Country::all();
    $admin      = $request->session()->get('key-sesion')['data'];
    $configuration  = Configuration::find(HConstants::FIRST_CONFIGURATION);

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
      'users'     => $users,
      'warehouse' => $warehouse,
      'pickup'    => $pickup,
      'large'     => $large,
      'countrys' => $countrys
    ];
    /**
    *
    */
    if ($this->isGET($request)) {
      return view('pages.admin.cargoRelease.create', $vars);
    }
    /**
    *
    */
    if($request->all()['finalConsigUser'] == 'adduc') {
        $pais = ($request->all()['clientSelectCountry']);
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
          'country'        => $pais,
          'city'           => $request->all()['cons_city'],
          'password'       => '12345678',
          'user_type'      => 1

        ]);
        /**
        *
        */
        Mail::send('emails.check_email', [
          'host'     => $this->host,
          'user'     => $userCons,
          'configuration' => $configuration,
          'password'      => Crypt::decrypt($userCons->password)
        ],
        function($mail) use ($userCons) {
          $mail->from($this->from);
          $mail->to($userCons->email , "$userCons->user $userCons->name")->subject(trans('messages.activate'));
        });
    }
    $pais= ($request->all()['cons_country']);
    if($request->all()['finalConsigUser']==""){
      $userconsig=null;
    }elseif ($request->all()['finalConsigUser'] == 'adduc') {
      $userconsig= $userCons->id;
      $pais= ($request->all()['clientSelectCountry']);
    }else{
      $userconsig=$request->all()['finalConsigUser'];
    }

    $data = [
      'last_event'          => '1',
      'release_date'        => $request->all()['release_date'],
      'release_time'        => $request->all()['release_time'],
      'user'                => $userconsig,
      'contact_name'        => $request->all()['cons_name'],
      'contact_phone'       => $request->all()['cons_phone'],
      'contact_country'     => $pais,
      'contact_region'      => $request->all()['cons_region'],
      'contact_city'        => $request->all()['cons_city'],
      'contact_address'     => $request->all()['cons_direction'],
      'contact_postal_code' => $request->all()['cons_zipcode'],
      'aditionalInformation'=> $request->all()['aditional_information']
    ];
    /**
    * Se guarda el CargoRelease
    */
    $cargo_release = CargoRelease::create($data);

    $files = Input::file('upload_file');
        mkdir(asset('/uploads/').$cargo_release->code);
        //$files = Request::file('upload_file');
        if ($files[0] != '') {
          foreach($files as $file) {

              $aleatorio      = str_random();
              $nombre         = $aleatorio.'_'.$file->getClientOriginalName();
              $file->move('uploads/'.$cargo_release->code."/", $nombre);

              $data = [
              'shipment'      => null,
              'booking'       => null,
              'warehouse'     => null,
              'pickup'        => null,
              'cargo_release' => $cargo_release->id,
              'transporters'  => null,
              'suppliers'     => null,
              'path'          => asset('/uploads/').$cargo_release->code."/".$nombre,
              'name_path'     => $nombre,
              'operator'      => $admin->id
            ];
            $attachment = Attachment::create($data);
         }
      }
    /**
    * Se inserta la carga asociada al cargo release
    */
    $data_detail = [];
    foreach($request->all() as $value) {
      if(is_string($value)) {
        if(strstr($value, 'wr') || strstr($value, 'pk')) {
            $data_detail = [
              'cargo_release'    => $cargo_release->id,
              'warehouse_receipt'=> (strstr($value, 'wr')) ? substr($value, -1) : null,
              'pickup_order'     => (strstr($value, 'pk')) ? substr($value, -1) : null
            ];
          $cargo_release_detail = CargoReleaseDetail::create($data_detail);
          /**
          * 1) se verifica la existenca de un warehouse en la carga del embarque
          * 2) se edita la columna 'booked' en la tabla 'package'
          */
          if (strstr($value, 'wr')) {
            $package = substr($value, -1);
            $package = Package::find($package);
            $package->booked  = HConstants::EVENT_INITIAL;
            $package->process = $cargo_release->code;
            $package->update();
            $package->save();
          }
          /**
          * 2) se edita la columna 'booked' en la tabla 'pickup_orders'
          */
          if (strstr($value, 'pk')) {
            $pickup = substr($value, -1);
            $pickup = Pickup::find($pickup);
            $pickup->booked  = HConstants::EVENT_INITIAL;
            $pickup->process = $cargo_release->code;
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
    $xml = 'uploads/tmp/attachment_CR.xml';
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
          'shipment'      => null,
          'booking'       => null,
          'warehouse'     => null,
          'pickup'        => null,
          'cargo_release' => $cargo_release->id,
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
    * Se inserta este proceso
    */
    $this->insertLogCargoRelease($cargo_release->id, 1, $request->all()['aditional_information'], null, $session['data']->id);
    /**
    * retorna al listado
    */
    return $this->doRedirect($request, "/admin/cargoRelease/")->with('successMessage', trans('cargoRelease.created', [
      'code' => $cargo_release->code
    ]));

  }
  /**
  *
  */
  public function details(Request $request, $id, $readonly = false) {
    $session              = $request->session()->get('key-sesion');
    $cargoRelease         = CargoRelease::find($id);
    $users                = User::all();
    $large                = true;
    $warehouse            = Package::byEvent(HConstants::EVENT_RECEIVED)->get();
    $pickup               = Pickup::byEvent(HConstants::EVENT_RECEIVED)->get();
    $cargo_release_detail = CargoReleaseDetail::byCargoRelease($id)->get();
    /**
    * se valida la existencia del embarque, si falla se redirige al listado
    */
    if(is_null($cargoRelease)) {
      return $this->doRedirect($request, '/admin/shipments')
        ->with('errorMessage', trans('shipment.notFound'));
    }
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
      'cargoRelease'         => $cargoRelease,
      'users'                => $users,
      'warehouse'            => $warehouse,
      'pickup'               => $pickup,
      'large'                => $large,
      'readonly'             => $readonly,
      'cargo_release_detail' => $cargo_release_detail
    ];
    /**
    *
    */
    if ($this->isGET($request)) {
      return view('pages.admin.cargoRelease.edit', $vars);
    }
    /**
    *
    */
    if($request->all()['finalConsigUser'] == 'adduc') {
        $pais = ($request->all()['clientSelectCountry']);
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
          'country'        => $pais,
          'city'           => $request->all()['cons_city'],
          'password'       => '12345678',
          'user_type'      => 1

        ]);
        /**
        *
        */
        Mail::send('emails.check_email', [
          'host'     => $this->host,
          'user'     => $userCons,
          'configuration' => $configuration,
          'password'      => Crypt::decrypt($userCons->password)
        ],
        function($mail) use ($userCons) {
          $mail->from($this->from);
          $mail->to($userCons->email , "$userCons->user $userCons->name")->subject(trans('messages.activate'));
        });
    }
    $pais= ($request->all()['cons_country']);
    if($request->all()['finalConsigUser']==""){
      $userconsig=null;
    }elseif ($request->all()['finalConsigUser'] == 'adduc') {
      $userconsig= $userCons->id;
      $pais= ($request->all()['clientSelectCountry']);
    }else{
      $userconsig=$request->all()['finalConsigUser'];
    }

    $data = [
      'last_event'          => '1',
      'release_date'        => $request->all()['release_date'],
      'release_time'        => $request->all()['release_time'],
      'user'                => $userconsig,
      'contact_name'        => $request->all()['cons_name'],
      'contact_phone'       => $request->all()['cons_phone'],
      'contact_country'     => $pais,
      'contact_region'      => $request->all()['cons_region'],
      'contact_city'        => $request->all()['cons_city'],
      'contact_address'     => $request->all()['cons_direction'],
      'contact_postal_code' => $request->all()['cons_zipcode'],
      'aditionalInformation'=> $request->all()['aditional_information']
    ];
    /**
    *
    */
    $cargoRelease->update($data);
    $cargoRelease->save();
    /**
    *
    */
    $cargo_release_detail = DB::table('cargo_release_detail')->where('cargo_release','=',$cargoRelease->id)->delete();
    /**
    * 1) se buscan en la tabla 'package' y 'pickup_orders' los registros asociados al embarque actual
    * 2) se editan los paquetes con status 'recebidos en oficina' que no han sido reservados
    */
    $cargo_release_warehouse = Package::byProcessAndEvent(HConstants::EVENT_RECEIVED, $cargoRelease->code)->get();
    foreach ($cargo_release_warehouse as $key => $value) {
      $value->booked  = HConstants::RESPONSE_NULL;
      $value->process = HConstants::RESPONSE_NULL;
      $value->update();
      $value->save();
    }
    /**
    * 3) se crea el embarque con los nuevos warehouse y pickups
    */
    $cargo_release_pickup = Pickup::byProcessAndEvent(HConstants::EVENT_RECEIVED, $cargoRelease->code)->get();
    foreach ($cargo_release_pickup as $key => $value) {
      $value->booked  = HConstants::RESPONSE_NULL;
      $value->process = HConstants::RESPONSE_NULL;
      $value->update();
      $value->save();
    }
    /**
    *
    */
    $data_detail = [];
    foreach($request->all() as $value){
      if(is_string($value)) {
        if(strstr($value, 'wr') || strstr($value, 'pk')) {
          /**
          *
          */
            $data_detail = [
              'cargo_release'    => $cargoRelease->id,
              'warehouse_receipt'=> (strstr($value, 'wr')) ? substr($value, -1) : null,
              'pickup_order'     => (strstr($value, 'pk')) ? substr($value, -1) : null
            ];
          $cargo_release_detail = CargoReleaseDetail::create($data_detail);
          /**
          * 1) se verifica la existenca de un warehouse en la carga del embarque
          * 2) se edita la columna 'booked' en la tabla 'package'
          */
          if (strstr($value, 'wr')) {
            $package = substr($value, -1);
            $package = Package::find($package);
            $package->booked = HConstants::EVENT_INITIAL;
            $package->process = $cargoRelease->code;
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
            $pickup->process = $cargoRelease->code;
            $pickup->update();
            $pickup->save();
          }
        }
      }
    }
    /**
    * Se inserta este proceso
    */
    $this->insertLogCargoRelease($cargoRelease->id, 1, $request->all()['aditional_information'], null, $session['data']->id);
    /**
    * retorna al listado
    */
    return $this->doRedirect($request, "/admin/cargoRelease/")->with('successMessage', trans('cargoRelease.updated', [
      'code' => $cargoRelease->code
    ]));
  }
  /**
  *
  */
  public function readDetails(Request $request, $id) {
    $session = $request->session()->get('key-sesion');
    /**
    *  Se valida que la sesion este activa
    */
    if ($session == null) {
      return redirect('login');
    }
  }
  /**
  *
  */
  public function delete(Request $request, $id) {
    $redirect = $this->doRedirect($request, '/admin/cargoRelease');
    $cargoRelease  = CargoRelease::findOrFail($id);
    /**
    *
    */
    if(is_null($cargoRelease)) {
      $redirect->with('errorMessage', trans('cargoRelease.notFound'));
    }
    else {
      $cargoRelease->delete();
      $redirect->with('successMessage', trans('cargoRelease.deleted', [
        'code' => $cargoRelease->code
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
  public function returnContact(Request $request, $id) {
    $cargo_release = CargoRelease::find($id);
    /**
    *
    */
    $vars = [
      'cargo_release' => $cargo_release
    ];
    /**
    *
    */
    return view('pages.admin.cargoRelease.contact',$vars);
  }
  /**
  *
  */
  public function view(Request $request, $id) {
    $session = $request->session()->get('key-sesion');
    $cargo_release        = CargoRelease::findOrFail($id);
    $event                = Event::query()->where('active','=','1')->get();
    $events_number        = Event::query()->where('active','=','1')->count();
    $cargo_release_detail = CargoReleaseDetail::byCargoRelease($cargo_release->id)->get();
    $event_list           = Log::byCargoRelease($cargo_release->id)->get();
    /**
    *
    */
    $vars = [
      'cargo_release'        => $cargo_release,
      'event'                => $event,
      'events_num'           => $events_number,
      'cargo_release_detail' => $cargo_release_detail,
      'list_event'           => $event_list
    ];
    /**
    *
    */
    if($this->isGET($request))
    {
      return view('pages.admin.cargoRelease.view', $vars);
    }
    /**
    *
    */
    $cargo_release->update(['last_event' => $request->all()['status']]);
    $cargo_release->save();
    /**
    *
    */
    $this->insertLogCargoRelease($cargo_release->id, $request->all()['status'] ,$request->all()['observation'], $cargo_release->getLastEvent['id'], $session['data']->id);

    /**
    *
    */
    return response()->json([
      'message' => true
    ]);
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
    $xml_name = 'uploads/tmp/attachment_CR.xml';
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
