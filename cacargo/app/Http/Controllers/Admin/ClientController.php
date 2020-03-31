<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Client;
use App\Models\Admin\Company;
use Validator;
use \App\Helpers\HUserType;

/**
 *
 */
class ClientController extends Controller {

  /**
  * Test function for edit (VS)
  */
  public function edit(Request $request, $company, $id)
  {
    $client = Client::find($id);
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
    $client->update($request->all());
    $client->save();
    return response()->json([
      "message" => "true"
    ]);
  }

  /**
   * Mostrar formulario con campos en modo readOnly
   */
  public function readDetails(Request $request, $id, $company) {
    return $this->details($request, $id, $company, true);
  }

  /**
   * Detalles y actualizacion de datos
   */
  public function details(Request $request, $company, $id, $readonly = false) {
    $session = $request->session()->get('key-sesion');
    $this->checkAuthorization();
    $client = Client::find($id);
    if(is_null($client) || ($session['type'] !=  HUserType::OPERATOR &&  $client->company != $this->getCompany($company))) {
      return $this->doRedirect($request, '/admin/company/$company/$id')->with('errorMessage', trans('client.notFound'));
    }
    $vars =  [
      'client'   => $client,
      'readonly' => $readonly,
      'company'  => Company::find($company)
    ];
    /*Retornar vista para editar*/
    if($this->isGET($request)) {
      return view('pages.admin.client.view', $vars);
    }
  }

  /**
   * Creacion de clientes
   */
  public function create(Request $request, $company) {
    $session = $request->session()->get('key-sesion');
    $this->checkAuthorization();
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
      'company' => Company::find($company)
    ];
    /**
    * Obtener la vista para crear cliente
    */
    if($this->isGET($request)) {
      return view('pages.admin.client.view', $vars);
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
    /**
    * Send data
    */
   $client = Client::create($request->all());
   return response()->json([
     "message" => "true"
   ]);
  }

  /**
   * Listado de clientes
   */
  public function index(Request $request, $company)
  {

   $clients = Client::byCompany($company)->get();
   $vars =
   [
    'clients' => $clients
   ];
   /**
   *
   */
   if (!is_null($clients))
   {
    return view('pages.admin.client.list', $vars);
   }
   /**
   *
   */
  }


  public function readjsonclient(Request $request, $company)
  {

   $clients = Client::byCompany($company)->get();
   $vars =
   [
    'clients' => $clients
   ];
   /**
   *
   */
   return $vars;
  }

  /**
   * Se borra un cliente
   */
  public function delete(Request $request, $company, $id) {
    $client = Client::find($id);
    if(is_null($client))
    {
      return response()->json([
        "message" => "false",
        "alert"   => "El cliente no se encontro"
      ]);
    }
    else
    {
      $client->delete();
      return response()->json([
        "message" => "true"
      ]);
    }
  }

  /**
   * Validar informacion de campos
   */
  private function validateData(Request $request) {
    return Validator::make($request->all(), [
      'name'       => 'required|string|min:5|max:100',
      'identifier' => 'required|string|min:5|max:100|unique:client,identifier',
      'direction'  => 'required|string|min:5|max:255',
      'phone'      => 'required|string|min:5|max:25',
      'email'      => 'required|string|min:5|max:50|email',
      'company'    => 'unique:company,name'
    ]);
  }

}
