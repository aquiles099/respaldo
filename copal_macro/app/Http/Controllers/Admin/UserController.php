<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\User;
use App\Models\Admin\Company;
use App\Models\Admin\Configuration;
use Validator;
use App\Helpers\HUserType;
use App\Helpers\HConstants;
use App\Models\Admin\Event;
use Mail;
use Crypt;
/**
 *
 */
class UserController extends Controller {
  /**
  * Metodo para crear usuarios ICS desde modal
  */
  public function viewNew (Request $request) {
    $session = $request->session()->get('key-sesion');
    $this->checkAuthorization();
    $countrys = $this->countrys();
    $company = Company::find(1);

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
      'company'  => $company,
      'countrys' => $countrys
    ];
    /**
    * se retorna vista si la peticion es GET
    */
    if($this->isGET($request)) {
      return view('pages.admin.user.view',$vars);
    }
    /**
    * Se valida y alamacena si la petcion es !GET
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
    $data = $request->all();
    $data['user_type'] = HUserType::NATURAL_PERSON; /** change from RESELLER to NATURAL_PERSON**/
    $data['active'] = true;
    $user = User::create($data);
    /**
    *
    */
    return response()->json([
      "message" => "true"
    ]);
  }
  /**
  * Modo edicion
  */
  public function viewEdit(Request $request, $id) {
    return $this->view($request, $id, false);
  }
  /**
  * Modo solo lectura
  */
  public function view(Request $request, $id, $readonly = true) {
    $this->checkAuthorization();
    $user = User::find($id);
    $countrys = $this->countrys();
    $company = Company::find(1);
    /**
    * Vars on the view
    */
    $vars = [
      'user'     => $user,
      'readonly' => $readonly,
      'company'  => $company,
      'countrys' => $countrys
    ];
    /**
    *
    */
    if($this->isGET($request)) {
      return view('pages.admin.user.view',$vars);
    }
    /**
    *
    */
    $validator = $this->validateData($request, true, $id);
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
    $user->update($request->all());
    $user->save();
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
    $this->checkAuthorization();
    $user = User::find($id);
    $countrys = $this->countrys();
    /**
    *
    */
    if(is_null($user)) {
      return $this->doRedirect($request, '/admin/users')
        ->with('errorMessage', trans('user.notFound'));
    }
    /**
    *
    */
    $vars = [
      'companies' => Company::all(),
      'user'      => $user,
      'readonly'  => $readonly,
      'countrys'  => $countrys
    ];
    /**
    *
    */
    if($this->isGET($request)) {
      return view('pages.admin.user.edit', $vars);
    }
    /**
    *
    */
    $validator = $this->validateData($request, true, $id);
    if (!is_null($validator)) {
      if ($validator->fails()) {
        return view('pages.admin.user.edit', $vars)->withErrors($validator)
         ->with('errorMessage', trans('messages.checkRedFields'));
      }
    }
    //Actualizar la compañia
    $user->update($request->all());
    $user->save();
    return view('pages.admin.user.edit', $vars)->with('successMessage', trans('user.updated', [
      'name' => $user->name,
      'code' => $user->code
    ]));
  }
  /**
   * Creacion
   */
  public function create(Request $request) {
    $session  = $request->session()->get('key-sesion');
    $countrys = $this->countrys();
    $events   = Event::all();
    $configuration = Configuration::find(HConstants::FIRST_CONFIGURATION);
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
      'companies' => Company::all(),
      'countrys'  => $countrys
    ];

    if($this->isGET($request)) {
      return view('pages.admin.user.create', $vars);
    }
    /**
    *
    */
    $validator = $this->validateData($request);
    if (!is_null($validator)) {
      if ($validator->fails()) {
        return view('pages.admin.user.create', $vars)
          ->withErrors($validator)
          ->with('errorMessage', trans('messages.checkRedFields'));
      }
    }
    /**
    *
    */
    $data = $request->all();
    $data['user_type'] = HUserType::NATURAL_PERSON;
    $data['active'] = true;
    $data['company'] = $this->muranoId;
    $user = User::create($data);
    /**
    * se insertan notificaciones por defecto
    */
    foreach($events as $key => $event) {
      $this->insertUserNotifications($user->id, $event->id);
    }
    /**
    * Se envia el correo
    */
    Mail::send('emails.check_email', [
      'host'          => $this->host,
      'link'          => "check/account?code={$user->remember_token}",
      'user'          => $user,
      'configuration' => $configuration,
      'password'      => Crypt::decrypt($user->password)
    ],
    function($mail) use ($user) {
      $mail->from($this->from);
      $mail->to($user->email , "$user->name $user->lastname")
        ->subject(trans('messages.activate'));
    });
    /**
    *
    */
    return $this->doRedirect($request, "/admin/users")->with('successMessage', trans('user.created', [
      'name' => $user->name,
      'code' => $user->code
    ]));
  }
  /**
   * Listado
   */
  public function index(Request $request) {
    $session = $request->session()->get('key-sesion');
    $this->checkAuthorization();
    $users = User::all();
    /**
    *  Se valida que la sesion este activa
    */
    if ($session == null) {
      return redirect('login');
    }
    /**
    * Se listan los usuarios existentes
    */
    $vars = [
      'users' => $users
    ];
    /**
    * Se retorna la vista de usuarios
    */
    return view('pages.admin.user.list',$vars);
  }
  /**
  *
  */
  public function listAjax(Request $request) {
    $session  = $request->session()->get('key-sesion');
    $users = User::byUserType(1)->get();
    /**
    * se valida session
    */
    if ($session == null) {
      return redirect('/');
    }
    /**
    * Vars on the view
    */
    $vars = [
      'users' => $users
    ];
    /**
    * Show view
    */
    return view('pages.admin.user.listAjax', $vars);

  }

  /**
  * On modal
  */
  public function deleteAjax(Request $request, $id) {
    $user = User::find($id);
    if(is_null($user)) {
      return response()->json([
        "message" => "false",
        "alert"   => "El usuario no se encontro"
      ]);
    }
    else {
      $user->delete();
      return response()->json([
        "message" => "true"
      ]);
    }
  }

  /**
   *
   */
  public function delete(Request $request, $id) {
    $redirect = $this->doRedirect($request, '/admin/users');
    $user = User::find($id);
    if(is_null($user)) {
      $redirect->with('errorMessage', trans('user.notFound'));
    } else {
      $user->delete();
      $redirect->with('successMessage', trans('user.deleted', [
        'name' => $user->name,
        'code' => $user->code
      ]));
    }
    return $redirect;
  }
  /**
   *
   */
  private function validateData(Request $request, $update = false, $id = null) {
    return Validator::make($request->all(), [
      'name'        => 'required|string|min:5|max:100',
      'last_name'   => 'required|string|min:5|max:100',
      'dni'         => 'required|numeric',
      'email'       => 'required|string|min:5|max:50|email|unique:user,email' . (is_null($id) ? '' : ",$id"),
      'password'    => 'required|string|min:5|max:25|confirmed',
      'password'    => ($update ? '' : 'required|') . 'string|min:5|max:25|confirmed'
    ]);
  }
}
