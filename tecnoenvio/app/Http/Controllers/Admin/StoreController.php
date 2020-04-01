<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Admin\Store;
use Validator;
class StoreController extends Controller {
  /**
  * Proceso Inicial
  */
  public function index(Request $request) {
    $session = $request->session()->get('key-sesion');
    $stores = Store::orderBy('created_at', 'desc')->get();
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
      'stores' => $stores
    ];
    /**
    *
    */
    return view('pages.admin.store.list', $vars);
  }
  /**
  * Crear una tienda
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
    $vars = [

    ];
    /**
    *
    */
    if($this->isGET($request)) {
      return view('pages.admin.store.create', $vars);
    }
    /**
    * se valida el request
    */
    $validator = $this->validateData($request);
    if (!is_null($validator)) {
      if ($validator->fails()) {
        return view('pages.admin.store.create', $vars)
          ->withErrors($validator)
          ->with('errorMessage', trans('messages.checkRedFields'));
      }
    }
    /**
     *
     */
     $store = Store::create($request->all());
     return $this->doRedirect($request, "/admin/store")->with('successMessage', trans('store.created', [
       'name' => $store->name,
       'code' => $store->code
     ]));
  }
  /**
  * editar tienda
  */
  public function details(Request $request, $id, $readonly = false) {
    $this->checkAuthorization();
    $store = Store::find($id);
    /**
    *
    */
    if(is_null($store)) {
      return $this->doRedirect($store, '/admin/store')
        ->with('errorMessage', trans('store.notFound'));
    }
    /**
    *
    */
    $vars = [
      'store'    => $store,
      'readonly' => $readonly
    ];
    /**
    *
    */
    if($this->isGET($request)) {
      return view('pages.admin.store.view', $vars);
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
    $store->update($request->all());
    $store->save();
    return response()->json([
      "message" => "true"
    ]);
  }
  /**
  * Proceso Inicial
  */
  public function readDetails(Request $request, $id) {
    return $this->details($request, $id, true);
  }
  /**
  * Proceso Inicial
  */
  public function delete(Request $request, $id) {

    $redirect = $this->doRedirect($request, '/admin/store');
    $store = Store::find($id);
    /**
    *
    */
    if(is_null($store)) {
      $redirect->with('errorMessage', trans('store.notFound'));
    } else {
      $store->delete();
      $redirect->with('successMessage', trans('store.deleted', [
        'name' =>  $store->name,
        'code' =>  $store->code
      ]));
    }
    return $redirect;
  }
  /**
   * Validar Estructura de campos
   */
  private function validateData(Request $request) {
    return Validator::make($this->clear($request->all()), [
      'name'        => 'required|string|min:5|max:100',
      'description' => 'required|string|min:5|max:100'
    ]);
  }
}
