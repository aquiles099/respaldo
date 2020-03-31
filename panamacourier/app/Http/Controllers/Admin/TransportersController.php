<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Admin\Transport;
use App\Models\Admin\Transporters;
use App\Models\Admin\User;
use App\Models\Admin\Package;
use App\Models\Admin\Pickup;
use App\Models\Admin\Route;
use App\Models\Admin\Vessel;
use App\Models\Admin\Country;
use App\Models\Admin\City;
use App\Models\Admin\Attachment;
use Input;
use App\Helpers\HUserType;

class TransportersController extends Controller
{
 /**
  *
  */
  public function __construct () {
    $this->middleware('admin:' . HUserType::OPERATOR);
  }
  /**
  * Intial Process
  */
  public function index(Request $request) {
    $session       = $request->session()->get('key-sesion');
    $transporters  = Transporters::orderBy('created_at', 'desc')->get();


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
      'transporters' => $transporters
    ];
    /**
    *
    */
    return view('pages.admin.transporters.list',$vars);
  }
  /**
  *
  */
  public function create(Request $request) {
    $session   = $request->session()->get('key-sesion');
    $admin     =  $request->session()->get('key-sesion')['data'];
    $transport = Transport::all();
    $user      = User::all();
    $warehouse = Package::all();
    $pickup    = Pickup::all();
    $country   = Country::all();
    $city      = City::all();
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
      'transport' => $transport,
      'country'   => $country,
      'city'      => $city
    ];



    /**
    *
    */
    /**
    *
    */
    if($this->isGET($request))
    {
      return view('pages.admin.transporters.create',$vars);
    }
    /**
    *
    */
    $transporters = Transporters::create($request->all());

    $files = Input::file('upload_file');
    mkdir(asset('/uploads/').$transporters->code);
    //$files = Request::file('upload_file');
    if ($files[0] != '') {
      foreach($files as $file) {

          $aleatorio      = str_random();
          $nombre         = $aleatorio.'_'.$file->getClientOriginalName();
          $file->move('uploads/'.$transporters->code."/", $nombre);

          $data = [
          'shipment'      => null,
          'booking'       => null,
          'warehouse'     => null,
          'pickup'        => null,
          'cargo_release' => null,
          'transporters'  => $transporters->id,
          'suppliers'     => null,
          'path'          => asset('/uploads/').$transporters->code."/".$nombre,
          'name_path'     => $nombre,
          'operator'      => $admin->id
        ];
        $attachment = Attachment::create($data);
     }
  }





    return $this->doRedirect($request, "/admin/transporters/")->with('successMessage', trans('service.created', [
    	'code'           => $transporters->code,
      	'name'         => $transporters->name,

    ]));
  }


    /**
    * delete
    */
    public function delete(Request $request, $id) {
      $redirect = $this->doRedirect($request, '/admin/transporters');
      $transporters = Transporters::find($id);
      if(is_null($transporters)) {
        $redirect->with('errorMessage', trans('transporters.notFound'));
      } else {
        $transporters->delete();
        $redirect->with('successMessage', trans('transporters.deleted', [
          'code' => $transporters->code,
          'name' => $transporters->name
        ]));
      }
      return $redirect;
    }


    /**
  * details
  */
  public function details(Request $request, $id, $readonly = false) {


    $transporters    = Transporters::find($id);
    $country         = $this->countrys();
    $transport       = Transport::all();

    /**
    *
    */
    $vars = [
      'transporters' => $transporters,
      'transport' => $transport,
      'countrys'  => $country,
      'readonly'    => $readonly,
    ];
    /**
    *
    */
    //dd($vars);
    if($this->isGET($request)) {
      return view('pages.admin.transporters.view', $vars);
    }
    /**
    * Use the validator
    */
    /*$validator = $this->validateData($request);
    if (!is_null($validator))
    {
      if ($validator->fails())
      {
         return response()->json([
           "message" => "false",
           "alert"   => $validator->messages()
         ]);
      }
    }*/

    $transporter = [
      'name' => $request->all()['name'],
      'identification' => $request->all()['identification'],
      'phone' => $request->all()['phone'],
      'email' => $request->all()['email'],
      'web' => $request->all()['web'],
      'account_number' => $request->all()['account_number'],
      'name_contac' => $request->all()['name_contac'],
      'lastname_contac' => $request->all()['lastname_contac'],
      'exportation' => $request->all()['exportation'],
      'divition' => $request->all()['divition'],
      'address_street' => $request->all()['address_street'],
      'address_country' => $request->all()['address_country'],
      'address_city' => $request->all()['address_city'],
      'address_state' => $request->all()['address_state'],
      'address_code' => $request->all()['address_code'],
      'address_port' => $request->all()['address_port'],
      'note' => $request->all()['note'],
      'payments_term_terms' => $request->all()['payments_term_terms'],
      'payments_term_pays' => $request->all()['payments_term_pays'],
      'payments_term_coin' => $request->all()['payments_term_coin'],
      'payments_term_bill' => $request->all()['payments_term_bill'],
      'numberfmc' => $request->all()['numberfmc'],
      'numberscac' => $request->all()['numberscac'],
      'numberiata' => $request->all()['numberiata'],
      'codeair' => $request->all()['codeair'],
      'numbercodeair' => $request->all()['numbercodeair'],
      'guidenumber' => $request->all()['guidenumber'],
      'billing_address_street' => $request->all()['billing_address_street'],
      'billing_address_country' => $request->all()['billing_address_country'],
      'billing_address_city' => $request->all()['billing_address_city'],
      'billing_address_state' => $request->all()['billing_address_state'],
      'billing_address_code' => $request->all()['billing_address_code'],
      'billing_address_port' => $request->all()['billing_address_port']
    ];

    $transporters->update($transporter);
    $transporters->save();
    return response()->json([
      "message" => "true"
    ]);
  }
  /**
  *read Details
  */
  public function readDetails(Request $request, $id) {
    return $this->details($request, $id, true);
  }
}
