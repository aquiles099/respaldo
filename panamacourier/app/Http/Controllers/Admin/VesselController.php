<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Admin\Country;
use App\Models\Admin\Vessel;
use App\Models\Admin\City;
use Validator;

class VesselController extends Controller
{
  /**
  *
  */
  public function index(Request $request) {
    $session = $request->session()->get('key-sesion');
    $vessels  = Vessel::orderBy('created_at', 'desc')->get();
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
      'vessels'  => $vessels
    ];
    /**
    *
    */
    return view('pages.admin.vessel.list', $vars);
  }
  /**
  *
  */
  public function create(Request $request) {
    $session = $request->session()->get('key-sesion');
    $country = Country::all();
    $city = City::all();
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
      'city'   => $city,
      'country' => $country
    ];
    /**
    *
    */
    if($this->isGET($request))
    {
      return view('pages.admin.vessel.create', $vars);
    }
    /**
    *
    */
    $validator = $this->validateData($request);
    if (!is_null($validator)) {
      if ($validator->fails()) {
        return view('pages.admin.vessel.create', $vars)->withErrors($validator)
         ->with('errorMessage', trans('messages.checkRedFields'));
      }
    }
    /**
    *
    */
    $vessel = Vessel::create($request->all());
    return $this->doRedirect($request, "/admin/vessels")->with('successMessage', trans('vessel.created', [
      'code' => $vessel->code,
      'name' => $vessel->name
    ]));
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
  public function details(Request $request, $id, $readonly = false) {
    $vessel    = Vessel::find($id);
    $validator = $this->validateData($request);
    $country   = Country::all();
    $city      = City::byCountry($vessel->country)->get();
    /**
    *
    */
    $vars = [
      'country'     => $country,
      'readonly'    => $readonly,
      'vessel'      => $vessel,
      'city'        => $city,
      'view'        => true,
    ];
    /**
    *
    */
    if($this->isGET($request)) {
      return view('pages.admin.vessel.view', $vars);
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
    $vessel->update($request->all());
    $vessel->save();
    return response()->json([
      "message" => "true"
    ]);
  }
  /**
  *
  */
  public function delete(Request $request, $id) {
    $redirect = $this->doRedirect($request, '/admin/vessels');
    $vessel = Vessel::find($id);
    /**
    *
    */
    if(is_null($vessel)) {
      $redirect->with('errorMessage', trans('vessel.notFound'));
    } else {
      $vessel->delete();
      $redirect->with('successMessage', trans('vessel.deleted', [
        'code' => $vessel->code,
        'name' => $vessel->name
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
  public function city(Request $request, $id) {
    $city = City::byCountry($id)->get();
      /**
      *
      */
      return response()->json([
        "message" => $city
      ]);
  }
  /**
   * Validar Estructura de campos
   */
  private function validateData(Request $request) {
    return Validator::make($this->clear($request->all()), [
      'name'        => 'required|string|min:5|max:20',
      'flag'        => 'required|string|min:5|max:50',
      'country'     => 'required|not_in:0',
      'city'        => 'required|not_in:0',
    ]);
  }
}
