<?php

namespace App\Http\Controllers\Admin\Security;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Security\Access;
use Validator;
use App\Helpers\HUserType;
/**
 *
 */
class AccessController extends Controller {
  const EDIT_PATH   = '/admin/security/access/%d';
  const EDIT_VIEW   = 'pages.admin.security.access.edit';
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
    $access  = Access::find($id);
    $accesss = Access::all();

    if(is_null($access)) {
      return $this->doRedirect($request, "admin/security/access")
        ->with('errorMessage', trans('access.notFound'));
    }
    /**
    *
    */
    $vars = [
      'access'   => $access,
      'readonly' => $readonly,
      'accesss'  => $accesss
    ];
    /**
    *
    */
    if($this->isGET($request)) {
      return  view('pages.admin.security.access.edit', $vars);
    }
    /**
    * Use the validator
    */
    $validator = $this->validateData($request);
    if (!is_null($validator)) {
      if ($validator->fails()) {
      return view('pages.admin.security.access.edit', $vars)->withErrors($validator)
            ->with('errorMessage', trans('messages.checkRedFields'));
      }
    }
    /**
    *
    */
    $access->update($validator->getData());
    $access->save();
    /**
    *
    */
    return $this->doRedirect($request, "/admin/security/access")->with('successMessage', trans('access.created', [
      'name' => $access->name,
      'code' => $access->id
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
    if($this->isGET($request)) {
      return view('pages.admin.security.access.create');
    }
    /**
    *
    */
    $validator = $this->validateData($request);
    if (!is_null($validator) && $validator->fails()) {
      return view('pages.admin.security.access.create')
        ->withErrors($validator)->with('errorMessage', trans('messages.checkRedFields'));
    }
    /**
    *
    */
    $access = Access::create($request->all());
    return $this->doRedirect($request, "admin/security/access")->with('successMessage', trans('access.created', [
      'name' => $access->name,
      'code' => $access->code
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
    $redirect = $this->doRedirect($request, '/admin/security/access');
    $access = Access::find($id);
    /**
    *
    */
    if(is_null($access)) {
      $redirect->with('errorMessage', trans('access.notFound'));
    } else {
      $access->delete();
      $redirect->with('successMessage', trans('access.deleted', [
        'name' => $access->name,
        'code' => $access->code
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
  private function validateData(Request $request, $access = null) {
    return Validator::make($this->clear($request->all()), [
      'name' => 'required|string|min:3|max:100|unique:access,name'. ($access == null ? '' : (',' . $access->id))
    ]);
  }

}
