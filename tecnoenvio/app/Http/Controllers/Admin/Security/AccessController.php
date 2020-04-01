<?php

namespace App\Http\Controllers\Admin\Security;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Security\Access;
use Validator;

/**
 *
 */
class AccessController extends Controller {
  const LIST_PATH = '/admin/security/access';
  const EDIT_PATH = '/admin/security/access/%d';
  const EDIT_VIEW = 'pages.admin.security.access.edit';
  const CREATE_VIEW = 'pages.admin.security.access.create';
  const LIST_VIEW = 'pages.admin.security.access.list';

  /**
   *
   */
  public function readDetails(Request $request, $id) {
    $session = $request->session()->get('key-sesion');
    if ($session == null)
    {
      return redirect('login');
    }
    return $this->details($request, $id, true);
  }

  /**
   *
   */
  public function details(Request $request, $id, $readonly = false) {
    $this->checkAuthorization();
    $access = Access::find($id);
    $session = $request->session()->get('key-sesion');
    if ($session == null)
    {
      return redirect('login');
    }
    if(is_null($access)) {
      return $this->doRedirect($request, self::LIST_PATH)
        ->with('errorMessage', trans('access.notFound'));
    }
    ////////////////////////////////////////////////////////////////////////////
    $view = view(self::EDIT_VIEW, [
      'access' => $access,
      'readonly' => $readonly
    ]);
    ////////////////////////////////////////////////////////////////////////////
    if($this->isGET($request)) {
      return  $view;
    }
    $validator = $this->validateData($request, $access);
    if (!is_null($validator) && $validator->fails()) {
      return $view->withErrors($validator)->with('errorMessage', trans('messages.checkRedFields'));
    }
    $access->update($validator->getData());
    $access->save();
    return $view->with('successMessage', trans('access.updated', [
      'name' => $access->name,
      'code' => $access->id
    ]));
  }

  /**
   * Creacion
   */
  public function create(Request $request) {
    $this->checkAuthorization();
    $view = view(self::CREATE_VIEW);
    $session = $request->session()->get('key-sesion');
    if ($session == null)
    {
      return redirect('login');
    }
    if($this->isGET($request)) {
      return $view;
    }
    $validator = $this->validateData($request);
    if (!is_null($validator) && $validator->fails()) {
      return $view->withErrors($validator)->with('errorMessage', trans('messages.checkRedFields'));
    }
    $access = Access::create($request->all());
    return $this->doRedirect($request, sprintf(self::EDIT_PATH, $access->id))->with('successMessage', trans('access.created', [
      'name' => $access->name,
      'code' => $access->id
    ]));
  }

  /**
   * Listado
   */
  public function index(Request $request) {
    $this->checkAuthorization();
    $session = $request->session()->get('key-sesion');
    $accesss = Access::orderBy('created_at', 'desc')->get();
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
      'accesss' => $accesss
    ];
    /**
    *
    */
    return view('pages.admin.security.access.list', $vars);
  }

  /**
   *
   */
  public function delete(Request $request, $id) {
    $redirect = $this->doRedirect($request, self::LIST_PATH);
    $access = Access::find($id);
    if(is_null($access)) {
      $redirect->with('errorMessage', trans('access.notFound'));
    } else {
      $access->delete();
      $redirect->with('successMessage', trans('access.deleted', [
        'name' => $access->name
      ]));
    }
    return $redirect;
  }

  /**
   *
   */
  private function validateData(Request $request, $access = null) {
    return Validator::make($this->clear($request->all()), [
      'name' => 'required|string|min:3|max:100|unique:access,name'. ($access == null ? '' : (',' . $access->id))
    ]);
  }

}
