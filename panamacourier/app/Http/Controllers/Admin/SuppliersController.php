<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Admin\Suppliers;
use App\Models\Admin\User;
use App\Models\Admin\Attachment;
use App\Models\Admin\Country;
use App\Models\Admin\City;
use Input;
use App\Helpers\HUserType;


class SuppliersController extends Controller
{
  /**
  *
  */
  public function __construct () {
    $this->middleware('admin:' . HUserType::OPERATOR);
  }
   /**
   * Listado
   */
  public function index(Request $request) {
    $session = $request->session()->get('key-sesion');
    $this->checkAuthorization();
    $suppliers = Suppliers::orderBy('created_at', 'desc')->get();
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
      'suppliers' => $suppliers
    ];
    /**
    *
    */
    return view('pages.admin.suppliers.list', $vars);
  }
  /**
   * Creacion
   */
  public function create(Request $request) {
    $session = $request->session()->get('key-sesion');
    $admin     =  $request->session()->get('key-sesion')['data'];
    $this->checkAuthorization();
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
         'country'  => $country,
         'city'     => $city
    ];
    /**
    *
    */
    if($this->isGET($request)) {
      return view('pages.admin.suppliers.create',$vars);
    }
    //Guardar el servicio
    /*$validator = $this->validateData($request);
    if (!is_null($validator)) {
      if ($validator->fails()) {
        return view('pages.admin.suppliers.create')
          ->withErrors($validator)
          ->with('errorMessage', trans('messages.checkRedFields'));
      }
    }*/
    ////////////////////////////////////////////////////////////////////////////
    $suppliers = Suppliers::create($request->all());

    $files = Input::file('upload_file');
    mkdir(asset('/uploads/').$suppliers->code);
    //$files = Request::file('upload_file');
    if ($files[0] != '') {
      foreach($files as $file) {

          $aleatorio      = str_random();
          $nombre         = $aleatorio.'_'.$file->getClientOriginalName();
          $file->move('uploads/'.$suppliers->code."/", $nombre);

          $data = [
          'shipment'      => null,
          'booking'       => null,
          'warehouse'     => null,
          'pickup'        => null,
          'cargo_release' => null,
          'transporters'  => null,
          'suppliers'     => $suppliers->id,
          'path'          => asset('/uploads/').'/'.$suppliers->code."/".$nombre,
          'name_path'     => $nombre,
          'operator'      => $admin->id
        ];
        $attachment = Attachment::create($data);
     }
   }
    return $this->doRedirect($request, "/admin/suppliers/")->with('successMessage', trans('suppliers.created', [
      'code' => $suppliers->code,
      'name'=> $suppliers->name,

    ]));
  }
  /**
  * delete
  */
  public function delete(Request $request, $id) {
    $redirect = $this->doRedirect($request, '/admin/suppliers');
    $supplier = Suppliers::find($id);
    if(is_null($supplier)) {
      $redirect->with('errorMessage', trans('supplier.notFound'));
    } else {
      $supplier->delete();
      $redirect->with('successMessage', trans('suppliers.deleted', [
        'code' => $supplier->code,
        'name' => $supplier->name
      ]));
    }
    return $redirect;
  }

   /**
  * details
  */
  public function details(Request $request, $id, $readonly = false) {
    $country       = $this->countrys();
    $suppliers    = Suppliers::find($id);
    $attachment = Attachment::query()->where('suppliers','=',$id)->get();

    /**
    *
    */
    $vars = [
      'supliers' => $suppliers,
      'countrys'  => $country,
      'attachments' => $attachment,
      'readonly'  => $readonly
    ];
    /**
    *
    */
    if($this->isGET($request)) {
      return view('pages.admin.suppliers.view', $vars);
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
    $suppliers->update($request->all());
    $suppliers->address_country = $request->all()['address_country'];
    $suppliers->save();
    return response()->json([
      "message" => "true"
    ]);
  }
  /*
  *
  */
  public function getAttachment(){
    $attachment = Attachment::all();
    if (isset($attachment)) {
      return response()->json([
        "attachment" => $attachment,
        "message" => "true"
      ]);
    }
    return response()->json([
      "attachment" => null,
      "message" => "false"
    ]);
  }

  /**
  *read Details
  */
  public function readDetails(Request $request, $id) {
    return $this->details( $request, $id, true);
  }

}
