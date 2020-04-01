<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Admin\Transport;
use App\Models\Admin\TransportType;
use Validator;
class TransportTypeController extends Controller
{
  /**
  *
  */
  public function index(Request $request) {
    $session = $request->session()->get('key-sesion');
    $transport_types  = TransportType::orderBy('created_at', 'desc')->get();
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
      'transport_types'  => $transport_types
    ];
    /**
    *
    */
    return view('pages.admin.transportType.list', $vars);
  }
  /**
  *
  */
  public function create(Request $request) {
    $session   = $request->session()->get('key-sesion');
    $transports = Transport::all();
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
      'transports' => $transports
    ];
    /**
    *
    */
    if($this->isGET($request)) {
      return view('pages.admin.transportType.create', $vars);
    }
    /**
    *
    */
    $validator = $this->validateData($request);
    if (!is_null($validator)) {
      if ($validator->fails()) {
        return view('pages.admin.transportType.create', $vars)->withErrors($validator)
         ->with('errorMessage', trans('messages.checkRedFields'));
      }
    }
    /**
    *
    */
    $transport_type = TransportType::create($request->all());
    return $this->doRedirect($request, "/admin/typeTransports")->with('successMessage', trans('transportType.created', [
      'code' => $transport_type->code,
      'name' => $transport_type->name
    ]));
  }
  /**
  * details
  */
  public function details(Request $request, $id, $readonly = false) {
    $transport_type = TransportType::find($id);
    $validator    = $this->validateData($request);
    $transports   = Transport::all();
    /**
    *
    */
    $vars = [
      'transports'     => $transports,
      'readonly'       => $readonly,
      'view'           => true,
      'transport_type' => $transport_type
    ];
    /**
    *
    */
    if($this->isGET($request)) {
      return view('pages.admin.transportType.view', $vars);
    }
    /**
    * Use the validator
    */
    $validator = $this->validateData($request);
    if (!is_null($validator))
    {
      if ($validator->fails())
      {
         return response()->json([
           "message" => "false",
           "alert"   => $validator->messages()
         ]);
      }
    }
    $transport_type->update($request->all());
    $transport_type->save();
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
  /**
  * delete
  */
  public function delete(Request $request, $id) {
    $redirect = $this->doRedirect($request, '/admin/typeTransports');
    $transport_type = TransportType::find($id);
    if(is_null($transport_type)) {
      $redirect->with('errorMessage', trans('route.notFound'));
    } else {
      $transport_type->delete();
      $redirect->with('successMessage', trans('transportType.deleted', [
        'code' => $transport_type->code,
        'name' => $transport_type->name
      ]));
    }
    return $redirect;
  }
  /**
   * Validar Estructura de campos
   */
  private function validateData(Request $request) {
    return Validator::make($this->clear($request->all()), [
      'name'            => 'required|string|min:5|max:20',
      'transport'       => 'required|not_in:0',
      'description'     => 'required|string|min:5|max:100'
    ]);
  }

  public function readjsonservice(Request $request, $service)
  {

   $typeTransports = TransportType::byTransport($service)->get();
   $vars =
   [
    'typeTransports' => $typeTransports
   ];
   /**
   *
   */
   return $vars;
  }
}
