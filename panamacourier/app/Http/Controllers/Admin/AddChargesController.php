<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Admin\AddCharge;
use Validator;
use DB;
use App\Helpers\HUserType;

class AddChargesController extends Controller {
    /**
    *
    */
    public function __construct () {
      $this->middleware('admin:' . HUserType::OPERATOR);
    }
    /**
    * Test function for edit (VS)
    */
    public function edit(Request $request, $id) {
      $addcharge = AddCharge::find($id);
    //  dd($office);
      /*$validator = $this->validateData($request);
      /**
      * Use the validator
      */
     /* if (!is_null($validator))
      {
        if ($validator->fails())
        {
           return response()->json([
             "message" => "false",
             "alert"   => $validator->messages()
           ]);
        }
      }*/
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
  public function details(Request $request, $id, $readonly = false) {
    $addcharge = AddCharge::find($id);
    $session = $request->session()->get('key-sesion');
    /**
    *
    */
    if (is_null($session)) {
      return redirect('/login');
    }
    /**
    *
    */
    if(is_null($addcharge)) {
      return $this->doRedirect($request, '/admin/addcharge')
        ->with('errorMessage', trans('office.notFound'));
    }
    /**
    *
    */
    $vars =  [
      'addcharge' => $addcharge,
      'readonly'  => $readonly
    ];
    /**
    *
    */
    if($this->isGET($request)) {
      return view('pages.admin.addcharge.edit',$vars);
    }
    /**
    *
    */
    $validator = $this->validateData($request);
    if (!is_null($validator)) {
      if ($validator->fails()) {
        return view('pages.admin.addcharge.edit', $vars)->withErrors($validator)
         ->with('errorMessage', trans('messages.checkRedFields'));
        }
    }
    /**
    *
    */
    $addcharge->update($request->all());
    $addcharge->save();
    return $this->doRedirect($request, '/admin/addcharge')
      ->with('successMessage', trans('addcharge.updated',[
        'name' => $addcharge->name,
        'code' => $addcharge->code
      ]));
  }

  /**
   * Creacion
   */
  public function create(Request $request) {
    $session = $request->session()->get('key-sesion');
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
    /*$validator = $this->validateData($request);
    if (!is_null($validator)) {
      if ($validator->fails()) {
        return view('pages.admin.addcharge.create')
          ->withErrors($validator)
          ->with('errorMessage', trans('messages.checkRedFields'));
      }
    }*/
    /**
    *
    */
    $addcharge = AddCharge::create($request->all());
    return $this->doRedirect($request, "/admin/addcharge/")->with('successMessage', trans('addcharge.created', [
      'name' => $addcharge->name,
      'code' => $addcharge->code
    ]));
  }
  /**
   * Listado
   */
  public function index(Request $request) {
    $session = $request->session()->get('key-sesion');
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
  public function delete(Request $request, $id) {
    $redirect = $this->doRedirect($request, '/admin/addcharge');
    $charge = AddCharge::find($id);
    /**
    *
    */
    if(is_null($charge)) {
      $redirect->with('errorMessage', trans('addcharge.notFound'));
    } else {
      $charge->delete();
      $redirect->with('successMessage', trans('addcharge.deleted', [
        'name' => $charge->name,
        'code' => $charge->code
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
      'name'         => 'required|string|min:5|max:100',
      'description'  => 'required|string|min:5|max:255',
      'value'        => 'required|numeric|min:1|max:25'
    ]);
  }
}
