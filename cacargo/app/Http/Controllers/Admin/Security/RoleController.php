<?php

namespace App\Http\Controllers\Admin\Security;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Security\Access;
use App\Models\Admin\Security\Role;
use Validator;
use DB;

/**
 *
 */
class RoleController extends Controller {
  const LIST_PATH = '/admin/security/role';
  const EDIT_PATH = '/admin/security/role/%d';
  const EDIT_VIEW = 'pages.admin.security.role.edit';
  const CREATE_VIEW = 'pages.admin.security.role.create';
  const LIST_VIEW = 'pages.admin.security.role.list';

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
    $role = Role::find($id);
    $session = $request->session()->get('key-sesion');
    if ($session == null)
    {
      return redirect('login');
    }
    if(is_null($role)) {
      return $this->doRedirect($request, self::LIST_PATH)
        ->with('errorMessage', trans('role.notFound'));
    }
    ////////////////////////////////////////////////////////////////////////////
    $view = view(self::EDIT_VIEW, [
      'role' => $role,
      'readonly' => $readonly,
      'access' => Access::all()
    ]);
    ////////////////////////////////////////////////////////////////////////////
    if($this->isGET($request)) {
      return  $view;
    }
    $validator = $this->validateData($request, $id);
    if (!is_null($validator) && $validator->fails()) {
      return $view->withErrors($validator)->with('errorMessage', trans('messages.checkRedFields'));
    }


    $data = $request->all();
    $role->update($data);
    DB::table('role_access')->where('role', '=', $role->id)->delete();
    $role->access()->attach($data['access']);
    $role->save();
    return $view->with('successMessage', trans('role.updated', [
      'name' => $role->name,
      'code' => $role->id
    ]));
  }

  /**
   * Creacion
   */
  public function create(Request $request) {
    $this->checkAuthorization();
    $session = $request->session()->get('key-sesion');
    if ($session == null)
    {
      return redirect('login');
    }
    $view = view(self::CREATE_VIEW, [
      'access' => Access::all()
    ]);
    if($this->isGET($request)) {
      return $view;
    }
    $validator = $this->validateData($request);
    if (!is_null($validator) && $validator->fails()) {
      return $view->withErrors($validator)->with('errorMessage', trans('messages.checkRedFields'));
    }
    $data = $request->all();
    $role = Role::create($data);
    $role->access()->attach($data['access']);
    return $this->doRedirect($request, sprintf(self::EDIT_PATH, $role->id))->with('successMessage', trans('role.created', [
      'name' => $role->name,
      'code' => $role->id
    ]));
  }

  /**
   * Listado
   */
  public function index(Request $request) {
    $this->checkAuthorization();
    $session = $request->session()->get('key-sesion');
    $roles = Role::orderBy('created_at', 'desc')->get();
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
      'roles' => $roles
    ];
    /**
    *
    */
    return view('pages.admin.security.role.list', $vars);;
  }

  /**
   *
   */
  public function delete(Request $request, $id) {
    $redirect = $this->doRedirect($request, self::LIST_PATH);
    $role = Role::find($id);
    if(is_null($role)) {
      $redirect->with('errorMessage', trans('role.notFound'));
    } else {
      $role->delete();
      $redirect->with('successMessage', trans('role.deleted', [
        'name' => $role->name
      ]));
    }
    return $redirect;
  }

  /**
   *
   */
  private function validateData(Request $request, $id = null) {
    return Validator::make($this->clear($request->all()), [
      'name'     => 'required|string|min:3|max:100|unique:role,name'.($id == null ? '' : ",$id,id"),
      'access'   => 'required|array',
      'access.*' => 'required|integer|exists:access,id',
    ]);
  }

}
