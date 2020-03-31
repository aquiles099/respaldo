<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Admin\AddCharge;
use Validator;
use DB;

class AddChargesController extends Controller
{
       /**
  * Test function for edit (VS)
  */
    public function edit(Request $request, $id)
    {
      $addcharge = AddCharge::find($id);
    //  dd($office);
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
    $addcharge = AddCharge::find($id);

    if(is_null($addcharge))
    {
      return $this->doRedirect($request, '/admin/addcharge')
        ->with('errorMessage', trans('office.notFound'));
    }
    $vars =  [
      'addcharge' => $service,
      'readonly' => $readonly
      
    ];

    if($this->isGET($request))
    {
      return view('pages.admin.addcharge.view',$vars);
    }
    
  }

  /**
   * Creacion
   */
  public function create(Request $request)
  {
    $session = $request->session()->get('key-sesion');
    $this->checkAuthorization();
    /**
    *  Se valida que la sesion este activa
    */
    if ($session == null) {
      return redirect('login');
    }
    /**
    *
    */
   
    if($this->isGET($request)) {
      return view('pages.admin.addcharge.create');
    }
    //Guardar la compañia
    $validator = $this->validateData($request);
    if (!is_null($validator)) {
      if ($validator->fails()) {
        return view('pages.admin.addcharge.create')
          ->withErrors($validator)
          ->with('errorMessage', trans('messages.checkRedFields'));
      }
    }
    ////////////////////////////////////////////////////////////////////////////
    $addcharge = AddCharge::create($request->all());
    return $this->doRedirect($request, "/admin/addcharge/")->with('successMessage', trans('addcharge.created', [
      'name' => $addcharge->name,
      'descripcion' => $addcharge->descripcion
    ]));
  }

  /**
   * Listado
   */
  public function index(Request $request)
  {
    $session = $request->session()->get('key-sesion');
    $this->checkAuthorization();
    $addcharge = AddCharge::all();
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
      'addcharges' => $addcharge
    ];
    /**
    *
    */
    return view('pages.admin.addcharge.list', $vars);
  }

  /**
   *
   */
  public function delete(Request $request, $id)
  {
    $redirect = $this->doRedirect($request, '/admin/office');
    $office = Office::find($id);
    if(is_null($office)) {
      $redirect->with('errorMessage', trans('office.notFound'));
    } else {
      $office->delete();
      $redirect->with('successMessage', trans('office.deleted', [
        'name' => $office->name,
        'code' => $office->code
      ]));
    }
    return $redirect;
  }

  /**
   *
   */
  private function validateData(Request $request) {
    return Validator::make($this->clear($request->all()), [
      'name'         => 'required|string|min:5|max:100',
      'description'  => 'required|string|min:5|max:255',
      'value'        => 'required|string|min:2|max:25'

    ]);
  }
}
