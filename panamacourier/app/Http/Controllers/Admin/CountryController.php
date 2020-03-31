<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Country;
use Validator;
use App\Helpers\HUserType;
/**
 *
 */
class CountryController extends Controller {
  /**
  *
  */
  public function __construct () {
    $this->middleware('admin:' . HUserType::OPERATOR);
  }
  /**
   *
   */
  public function readDetails(Request $request, $id) {
    return $this->details($request, $id, true);
  }
  /**
  * Test function for edit (VS)
  */
    public function edit(Request $request, $id)
    {
      $country = Country::find($id);
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
      $country->update($request->all());
      $country->save();
      return response()->json([
        "message" => "true"
      ]);
    }

  /**
   *
   */
  public function details(Request $request, $id, $readonly = false) {
    $this->checkAuthorization();
    $country = Country::find($id);
    if(is_null($country)) {
      return $this->doRedirect($country, '/admin/country')
        ->with('errorMessage', trans('country.notFound'));
    }
    $vars = [
      'country' => $country,
      'readonly' => $readonly
    ];
    if($this->isGET($request)) {
      return view('pages.admin.country.view', $vars);
    }
  }

  /**
   * Creacion
   */
  public function create(Request $request) {
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
    if($this->isGET($request)) {
      return view('pages.admin.country.create');
    }
    //Guardar el pais
    $validator = $this->validateData($request);
    if (!is_null($validator)) {
      if ($validator->fails()) {
        return view('pages.admin.country.create')
          ->withErrors($validator)
          ->with('errorMessage', trans('messages.checkRedFields'));
      }
    }
    ////////////////////////////////////////////////////////////////////////////
    $country = Country::create($validator->getData());
    return $this->doRedirect($request, "/admin/country/")->with('successMessage', trans('country.created', [
      'name' => $country->name,
      'code' => $country->id
    ]));
  }

  /**
   * Listado
   */
  public function index(Request $request) {
    $session = $request->session()->get('key-sesion');
    $this->checkAuthorization();
    $countrys = Country::orderBy('created_at', 'desc')->get();
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
      'countrys' => $countrys
    ];
    /**
    *
    */
    return view('pages.admin.country.list', $vars);
  }

  /**
   *
   */
  public function delete(Request $request, $id) {
    $redirect = $this->doRedirect($request, '/admin/country');
    $country = Country::find($id);
    if(is_null($country)) {
      $redirect->with('errorMessage', trans('country.notFound'));
    } else {
      $country->delete();
      $redirect->with('successMessage', trans('country.deleted', [
        'name' => $country->name,
        'code' => $country->id
      ]));
    }
    return $redirect;
  }

  /**
   *
   */
  private function validateData(Request $request) {
    return Validator::make($this->clear($request->all()), [
      'name'       => 'required|string|min:3|max:100|unique:country,name'
    ]);
  }
  /**
  *
  */
  public function getList (Request $request) {
    $countries = Country::all();
    return response()->json([
      "response" => $countries
    ]);
  }

}
