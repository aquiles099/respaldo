<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Country;
use App\Models\Admin\Tax;
use Validator;

/**
 *
 */
class TaxController extends Controller {

  public function view(Request $request, $id)
  {
    $tax = Tax::find($id);

    /**
    *
    */
    $vars = [
      'tax'      => $tax,
      'readonly' => true,
      'country'  => Country::all()
    ];
    /**
    *
    */
    return view('pages.admin.tax.view', $vars);
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
    $tax = Tax::find($id);
    /**
    *
    */
    if(is_null($tax))
    {
      return $this->doRedirect($request, '/admin/tax')
        ->with('errorMessage', trans('tax.notFound'));
    }
    /**
    *
    */
    $vars = [
      'tax'      => $tax,
      'readonly' => $readonly,
      'country'  => Country::all()
    ];
    /**
    *
    */
    if($this->isGET($request))
    {
      return view('pages.admin.tax.view', $vars);
    }
    /**
    *
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
    $tax->update($request->all());
    $tax->save();
    return response()->json([
      "message" => "true"
    ]);
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
    if ($session == null)
    {
      return redirect('login');
    }
    /**
    *
    */
    $vars = [
      'country' => Country::all()
    ];
    if($this->isGET($request)) {
      return view('pages.admin.tax.create', $vars);
    }
    //dd($request->input('value'));
    //Guardar el impuesto
    $validator = $this->validateData($request);
    if (!is_null($validator)) {
      if ($validator->fails()) {
        return view('pages.admin.tax.create', $vars)
          ->withErrors($validator)
          ->with('errorMessage', trans('messages.checkRedFields'));
      }
    }
    ////////////////////////////////////////////////////////////////////////////
    $tax = Tax::create($request->all());
    return $this->doRedirect($request, "/admin/tax/{$tax->id}")->with('successMessage', trans('tax.created', [
      'name' => $tax->name,
      'code' => $tax->id
    ]));
  }

  /**
   * Listado
   */
  public function index(Request $request)
  {
    $session = $request->session()->get('key-sesion');
    $this->checkAuthorization();
    $taxes = Tax::orderBy('created_at', 'desc')->get();
    /**
    *  Se valida que la sesion este activa
    */
    if ($session == null)
    {
      return redirect('login');
    }
    $vars = [
      'taxes' => $taxes
    ];
    /**
    *
    */
    return view('pages.admin.tax.list',$vars);
  }

  /**
   *
   */
  public function delete(Request $request, $id)
  {
    $redirect = $this->doRedirect($request, '/admin/tax');
    $tax = Tax::find($id);
    if(is_null($tax)) {
      $redirect->with('errorMessage', trans('tax.notFound'));
    } else {
      $tax->delete();
      $redirect->with('successMessage', trans('tax.deleted', [
        'name' => $tax->name,
        'code' => $tax->id
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
      'value'      => 'required|numeric|min:1',
      'country'    => 'exists:country,id'
    ]);
  }

}
