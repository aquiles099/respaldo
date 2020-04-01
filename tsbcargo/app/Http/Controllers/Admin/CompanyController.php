<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Company;
use Validator;

/**
 *
 */
class CompanyController extends Controller {

  /**
   *
   */
  public function readDetails(Request $request, $id) {
    $this->checkAuthorization();
    return $this->details($request, $id, true);
  }

  /**
  * Test function for edit (VS)
  */
    public function edit(Request $request, $id)
    {
      $company = Company::find($id);
      $validator = $this->validateData($request);
      /**
      * Use the validator
      */
      if (!is_null($validator)) {
        if ($validator->fails()) {
           return response()->json([
             "message" => "false",
             "alert"   => $validator->messages()
           ]);
        }
      }
      $company->update($request->all());
      $company->save();
      return response()->json([
        "message" => "true"
      ]);
    }

  /**
   *
   */
  public function details(Request $request, $id, $readonly = false) {
    $this->checkAuthorization();
    $company = Company::find($id);
    if(is_null($company)) {
      return $this->doRedirect($request, '/admin/company')
        ->with('errorMessage', trans('company.notFound'));
    }
    $vars = [
      'company' => $company,
      'readonly' => $readonly
    ];
    if($this->isGET($request)) {
      return view('pages.admin.company.view', $vars);
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
      return view('pages.admin.company.create');
    }
    //Guardar la compañia
    $validator = $this->validateData($request);
    if (!is_null($validator)) {
      if ($validator->fails()) {
        return view('pages.admin.company.create')
          ->withErrors($validator)
          ->with('errorMessage', trans('messages.checkRedFields'));
      }
    }
    ////////////////////////////////////////////////////////////////////////////
    $data = $request->all();
    $company = Company::create($data);
    /**
    *
    */
    return $this->doRedirect($request, "/admin/company/")->with('successMessage', trans('company.created', [
      'name' => $company->name,
      'code' => $company->code
    ]));
  }

  /**
   * Listado
   */
  public function index(Request $request) {
    $session = $request->session()->get('key-sesion');
    $this->checkAuthorization();
    $companys = Company::all();
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
      'companys' => $companys
    ];
    return view('pages.admin.company.list', $vars);
  }

  /**
   *
   */
  public function delete(Request $request, $id) {
    $redirect = $this->doRedirect($request, '/admin/company');
    $company = Company::find($id);
    if(is_null($company)) {
      $redirect->with('errorMessage', trans('company.notFound'));
    } else {
      $company->delete();
      $redirect->with('successMessage', trans('company.deleted', [
        'name' => $company->name,
        'code' => $company->code
      ]));
    }
    return $redirect;
  }

  /**
   *
   */
  private function validateData(Request $request) {
    return Validator::make($request->all(), [
      'name'       => 'required|string|min:5|max:100',
      'ruc'        => 'required|string|min:5|max:25',
      'direction'  => 'required|string|min:5|max:255',
      'phone_01'   => 'required|string|min:5|max:25',
      'phone_02'   => 'string|min:5|max:25',
      'email_01'   => 'required|string|min:5|max:50|email',
      'email_02'   => 'string|min:5|max:50|email'
    ]);
  }

}
