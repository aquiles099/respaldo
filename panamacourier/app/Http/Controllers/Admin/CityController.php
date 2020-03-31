<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Admin\Country;
use App\Models\Admin\City;
use App\Models\Admin\State;
use Validator;
use App\Helpers\HUserType;

class CityController extends Controller
{
  /**
  *
  */
  public function __construct () {
    $this->middleware('admin:' . HUserType::OPERATOR);
  }
  /**
  *
  */
  public function index(Request $request){
    $session = $request->session()->get('key-sesion');
    $cities  = City::all();
    $states = State::all();
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
      'states'  => $states,
      'cities'  => $cities
    ];
    /**
    *
    */
    return view('pages.admin.city.list', $vars);
  }
  /**
  *
  */
  public function create(Request $request){
      $session = $request->session()->get('key-sesion');
      $country = Country::orderBy('created_at', 'desc')->get();
      $state = State::orderBy('created_at', 'desc')->get();
      /**
      *
      */
      if ($session == null)
      {
        return redirect('login');
      }
      /**
      *
      */
      $vars = [
        'state'    => $state,
        'country'  => $country
      ];
      /**
      *
      */
      if($this->isGET($request)) {
        return view('pages.admin.city.create', $vars);
      }
      /**
      *
      */
      $validator = $this->validateData($request);
      if (!is_null($validator)) {
        if ($validator->fails()) {
          return view('pages.admin.city.create',$vars )
            ->withErrors($validator)
            ->with('errorMessage', trans('messages.checkRedFields'));
        }
      }
      /**
      *
      */
      $city = City::create($validator->getData());
      return $this->doRedirect($request, "/admin/cities/")->with('successMessage', trans('city.created', [
        'name' => $city->name,
        'code' => $city->code
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
     $city      = City::find($id);
     $validator = $this->validateData($request);
     $country   = Country::all();
     /**
     *
     */
     $vars = [
       'country'     => $country,
       'readonly'    => $readonly,
       'city'        => $city,
       'view'        => true,
     ];
     /**
     *
     */
     if($this->isGET($request)) {
       return view('pages.admin.city.view', $vars);
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
     $city ->update($request->all());
     $city ->save();
     return response()->json([
       "message" => "true"
     ]);
   }
   /**
   *
   */
   public function delete(Request $request, $id) {
     $redirect = $this->doRedirect($request, '/admin/cities');
     $city = City::find($id);
     /**
     *
     */
     if(is_null($city)) {
       $redirect->with('errorMessage', trans('vessel.notFound'));
     } else {
       $city->delete();
       $redirect->with('successMessage', trans('vessel.deleted', [
         'code' => $city->code,
         'name' => $city->name
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
  private function validateData(Request $request) {
    return Validator::make($this->clear($request->all()), [
      'name'        => 'required|string|min:3|max:100|unique:city,name',
      'country'     => 'required|not_in:0|unique:country,name',
      'description' => 'required|string|min:3|max:100',
    ]);
  }
}
