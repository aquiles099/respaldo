<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Country;
use App\Models\Admin\Office;
use Validator;

/**
 *
 */
class OfficeController extends Controller {

  /**
  * Test function for edit (VS)
  */
    public function edit(Request $request, $id)
    {
      $office = Office::find($id);
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
    $office = Office::find($id);

    if(is_null($office))
    {
      return $this->doRedirect($request, '/admin/office')
        ->with('errorMessage', trans('office.notFound'));
    }
    $vars =  [
      'office' => $office,
      'readonly' => $readonly,
      'countries' => Country::all()
    ];

    if($this->isGET($request))
    {
      return view('pages.admin.office.view',$vars);
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
    $vars = [
      'countries' => Country::all()
    ];
    if($this->isGET($request)) {
      return view('pages.admin.office.create', $vars);
    }
    //Guardar la compañia
    $validator = $this->validateData($request);
    if (!is_null($validator)) {
      if ($validator->fails()) {
        return view('pages.admin.office.create', $vars)
          ->withErrors($validator)
          ->with('errorMessage', trans('messages.checkRedFields'));
      }
    }
    ////////////////////////////////////////////////////////////////////////////
    $office = Office::create($request->all());
    return $this->doRedirect($request, "/admin/office/")->with('successMessage', trans('office.created', [
      'name' => $office->name,
      'code' => $office->code
    ]));
  }

  /**
   * Listado
   */
  public function index(Request $request)
  {
    $session = $request->session()->get('key-sesion');
    $this->checkAuthorization();
    $oficces = Office::orderBy('created_at', 'desc')->get();
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
      'offices' => $oficces
    ];
    /**
    *
    */
    return view('pages.admin.office.list', $vars);
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
      'name'       => 'required|string|min:5|max:100',
      'direction'  => 'required|string|min:5|max:255',
      'phone'      => 'required|string|min:5|max:25',
      'country'    => 'exists:country,id'
    ]);
  }

}
