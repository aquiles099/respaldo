<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Admin\Country;
use App\Models\Admin\City;
use Validator;
use App\Models\Admin\State;

class StateController extends Controller
{
  /**
  *
  */
  public function index(Request $request){
    $session = $request->session()->get('key-sesion');
    $states  = State::all();
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
      'cities'  => $states
    ];
    /**
    *
    */
    return view('pages.admin.state.list', $vars);
  }
  /**
  *
  */
  public function state(Request $request, $id) {
    $city = State::where('country',$id)->get();
      /**
      *
      */
      return response()->json([
        "message" => $city
      ]);
  }


  public function create(Request $request){
      $session = $request->session()->get('key-sesion');
      $country = Country::orderBy('created_at', 'desc')->get();
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
        'country'  => $country
      ];
      /**
      *
      */
      if($this->isGET($request)) {
        return view('pages.admin.state.create', $vars);
      }
      /**
      *
      */
      $validator = $this->validateData($request);
      if (!is_null($validator)) {
        if ($validator->fails()) {
          return view('pages.admin.state.create',$vars )
            ->withErrors($validator)
            ->with('errorMessage', trans('messages.checkRedFields'));
        }
      }
      /**
      *
      */
      $city = State::create($validator->getData());
      return $this->doRedirect($request, "/admin/state/")->with('successMessage', trans('state.created', [
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
     $city      = State::find($id);
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
     $redirect = $this->doRedirect($request, '/admin/state');
     $city = State::find($id);
     /**
     *
     */
     if(is_null($city)) {
       $redirect->with('errorMessage', trans('state.notFound'));
     } else {
       $city->delete();
       $redirect->with('successMessage', trans('state.deleted', [
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
