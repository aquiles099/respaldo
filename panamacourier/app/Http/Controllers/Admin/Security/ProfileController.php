<?php

namespace App\Http\Controllers\Admin\Security;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Security\Role;
use App\Models\Admin\Security\Profile;
use Validator;
use App\Helpers\HUserType;
/**
 *
 */
class ProfileController extends Controller {
  const EDIT_PATH = '/admin/security/profile/%d';
  const EDIT_VIEW = 'pages.admin.security.profile.edit';
  const CREATE_VIEW = 'pages.admin.security.profile.create';
  /**
  *
  */
  public function __construct () {
    $this->middleware('admin:' . HUserType::OPERATOR);
  }
  /**
   *
   */
  public function readDetails(Request $request, $id) {
    $this->checkAuthorization();
    return $this->details($request, $id, true);
  }
  /**
   *
   */
  public function details(Request $request, $id, $readonly = false) {
    $this->checkAuthorization();
    $profile = Profile::find($id);
    if(is_null($profile)) {
      return $this->doRedirect($request, '/admin/security/profile')
        ->with('errorMessage', trans('profile.notFound'));
    }
    /**
    *
    */
    $vars = [
      'profile'  => $profile,
      'readonly' => $readonly,
      'roles'    => Role::all()
    ];
    /**
    *
    */
    if($this->isGET($request)) {
      return  view('pages.admin.security.profile.edit', $vars);
    }
    /**
    *
    */
    $validator = $this->validateData($request, $id);
    if (!is_null($validator) && $validator->fails()) {
      return view('pages.admin.security.profile.edit', $vars)
      ->withErrors($validator)->with('errorMessage', trans('messages.checkRedFields'));
    }
    /**
    *
    */
    $data = $request->all();
    $profile->update($data);
    $profile->roles()->attach($data['roles']);
    $profile->save();
    /**
    *
    */
    return $this->doRedirect($request, "/admin/security/profile")->with('successMessage', trans('profile.updated',[
      'name' => $profile->name,
      'code' => $profile->id
    ]));
  }
  /**
   * Creacion
   */
  public function create(Request $request) {
    $this->checkAuthorization();
    /**
    *
    */
    $view = view(self::CREATE_VIEW, [
      'roles' => Role::all()
    ]);
    /**
    *
    */
    if($this->isGET($request)) {
      return $view;
    }
    /**
    *
    */
    $validator = $this->validateData($request);
    if (!is_null($validator) && $validator->fails()) {
      return $view->withErrors($validator)->with('errorMessage', trans('messages.checkRedFields'));
    }
    /**
    *
    */
    $data = $request->all();
    $profile = Profile::create($data);
    $profile->roles()->attach($data['roles']);
    /**
    *
    */
    return $this->doRedirect($request, sprintf(self::EDIT_PATH, $profile->id))->with('successMessage', trans('profile.created', [
      'name' => $profile->name,
      'code' => $profile->id
    ]));
  }
  /**
   * Listado
   */
  public function index(Request $request) {
    $this->checkAuthorization();
    $session = $request->session()->get('key-sesion');
    $profiles = Profile::orderBy('created_at', 'desc')->get();
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
    $vars =[
      'profiles' => $profiles
    ];
    /**
    *
    */
    return view('pages.admin.security.profile.list', $vars);
  }
  /**
   *
   */
  public function delete(Request $request, $id) {
    $redirect = $this->doRedirect($request, '/admin/security/profile');
    $profile = Profile::find($id);
    if(is_null($profile)) {
      $redirect->with('errorMessage', trans('profile.notFound'));
    } else {
      $profile->delete();
      $redirect->with('successMessage', trans('profile.deleted', [
        'name' => $profile->name
      ]));
    }
    return $redirect;
  }
  /**
   *
   */
  private function validateData(Request $request, $id = null) {
    return Validator::make($this->clear($request->all()), [
      'name'    => 'required|string|min:3|max:100|unique:profile,name'.($id == null ? '' : ",$id,id"),
      'roles'   => 'required|array',
      'roles.*' => 'required|integer|exists:role,id',
    ]);
  }
}
