<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Admin\Route;
use App\Models\Admin\Transport;
use App\Models\Admin\Country;
use App\Models\Admin\City;
use Validator;

class RoutesController extends Controller
{
  /**
  * Initial Process
  */
  public function index(Request $request) {
    $session = $request->session()->get('key-sesion');
    $routes  = Route::orderBy('created_at', 'desc')->get();
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
      'routes'  => $routes
    ];
    /**
    *
    */
    return view('pages.admin.route.list', $vars);
  }
  /**
  * create
  */
  public function create(Request $request) {
    $session   = $request->session()->get('key-sesion');
    $transport = Transport::all();
    $country   = Country::all();
    $city      = City::all();
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
      'transport' => $transport,
      'country'   => $country,
      'city'      => $city
    ];
    /**
    *
    */
    if($this->isGET($request))
    {
      return view('pages.admin.route.create', $vars);
    }
    /**
    *
    */
    $validator = $this->validateData($request);
    if (!is_null($validator)) {
      if ($validator->fails()) {
        return view('pages.admin.route.create', $vars)->withErrors($validator)
         ->with('errorMessage', trans('messages.checkRedFields'));
      }
    }
    /**
    *
    */
    $route = Route::create($request->all());
    return $this->doRedirect($request, "/admin/routes")->with('successMessage', trans('route.created', [
      'code' => $route->code,
      'name' => $route->name
    ]));
  }
  /**
  * details
  */
  public function details(Request $request, $id, $readonly = false) {
    $route        = Route::find($id);
    $validator    = $this->validateData($request);
    $transport    = Transport::all();
    $country      = Country::all();
    $origin_city  = City::byCountry($route->origin_country)->get();
    $destiny_city = City::byCountry($route->destiny_country)->get();
    /**
    *
    */
    $vars = [
      'transport'   => $transport,
      'country'     => $country,
      'readonly'    => $readonly,
      'route'       => $route,
      'view'        => true,
      'origin_city' => $origin_city,
      'destiny_city'=> $destiny_city,
    ];
    /**
    *
    */
    if($this->isGET($request)) {
      return view('pages.admin.route.view', $vars);
    }
    /**
    * Use the validator
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
    $route->update($request->all());
    $route->save();
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
    $redirect = $this->doRedirect($request, '/admin/routes');
    $route = Route::find($id);
    if(is_null($route)) {
      $redirect->with('errorMessage', trans('route.notFound'));
    } else {
      $route->delete();
      $redirect->with('successMessage', trans('route.deleted', [
        'code' => $route->code,
        'name' => $route->name
      ]));
    }
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
  private function validateData(Request $request)
  {
    return Validator::make($this->clear($request->all()), [
      'name'            => 'required|string|min:5|max:20',
      'transport'       => 'required|not_in:0',
      'origin_country'  => 'required|not_in:0',
      'origin_city'     => 'required|not_in:0',
      'destiny_country' => 'required|not_in:0',
      'destiny_city'    => 'required|not_in:0',
      'description'     => 'required|string|min:5|max:100'
    ]);
  }
}
