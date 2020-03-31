<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Admin\Service;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Admin\Transport;
use Validator;

class ServicesController extends Controller
{
     /**
  * Test function for edit (VS)
  */
    public function edit(Request $request, $id)
    {
      $service = Service::find($id);
      $validator = $this->validateData($request);
      /**
      * Use the validator
      */
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
      $office->update($request->all());
      $office->save();
      return response()->json([
        "message" => "true"
      ]);
    }


  /**
   *
   */
  public function readDetails(Request $request, $id) {
    return $this->details($request, $id, true);
  }

  /**
   *
   */
  public function details(Request $request, $id, $readonly = false)
  {
    $this->checkAuthorization();
    $service = Service::find($id);
    /**
    *
    */
    if(is_null($service))
    {
      return $this->doRedirect($request, '/admin/service')
        ->with('errorMessage', trans('service.notFound'));
    }
    /**
    *
    */
    $vars =  [
      'service'  => $service,
      'readonly' => $readonly
    ];
    /**
    *
    */
    if($this->isGET($request))
    {
      return view('pages.admin.service.view',$vars);
    }
    /**
    *
    */
    $validator = $this->validateData($request);
    if (!is_null($validator)) {
      if ($validator->fails()) {
         return response()->json([
           "message" => "false",
           "alert"   => $validator->messages()
         ]);
      }
    }
    /**
    *
    */
    $service->update($request->all());
    $service->save();
    return response()->json([
      "message" => "true"
    ]);
  }

  /**
   * Creacion
   */
  public function create(Request $request)
  {
    $session = $request->session()->get('key-sesion');
    $this->checkAuthorization();
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
      'transports'     => $transports,
    
    ];

    
    if($this->isGET($request)) {
      return view('pages.admin.service.create', $vars );
    }
    //Guardar el servicio
    $validator = $this->validateData($request);
    if (!is_null($validator)) {
      if ($validator->fails()) {
        return view('pages.admin.service.create')
          ->withErrors($validator)
          ->with('errorMessage', trans('messages.checkRedFields'));
      }
    }
    ////////////////////////////////////////////////////////////////////////////
    $service = Service::create($request->all());
    return $this->doRedirect($request, "/admin/service/")->with('successMessage', trans('service.created', [
      'name'  => $service->name,
      'code'  => $service->code
    ]));
  }

  /**
   * Listado
   */
  public function index(Request $request)
  {
    $session = $request->session()->get('key-sesion');
    $this->checkAuthorization();
    $service = Service::orderBy('created_at', 'desc')->get();
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
      'services' => $service
    ];
    /**
    *
    */
    return view('pages.admin.service.list', $vars);
  }

  /**
   *
   */
  public function delete(Request $request, $id)
  {
    $redirect = $this->doRedirect($request, '/admin/service');
    $service = Service::find($id);
    /**
    *
    */
    if(is_null($service)) {
      $redirect->with('errorMessage', trans('service.notFound'));
    } else {
      $service->delete();
      $redirect->with('successMessage', trans('service.deleted', [
        'name' => $service->name,
        'code' => $service->code
      ]));
    }
    /**
    *
    */
    return $redirect;
  }

  public function readjsonservice(Request $request, $service)
  {

   $service = Service::byTransport($service)->get();
   $vars =
   [
    'service' => $service
   ];
   /**
   *
   */
   return $vars;
  }

  /**
   *
   */
  private function validateData(Request $request) {
    return Validator::make($this->clear($request->all()), [
      'name'         => 'required|string|min:5|max:100',
      'description'  => 'required|string|min:5|max:255',
      'value'        => 'required|string|min:2|max:25',
    ]);
  }
}
