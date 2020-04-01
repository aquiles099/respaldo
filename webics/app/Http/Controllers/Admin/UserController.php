<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Client;
use App\Models\Admin\User;
use App\Models\Admin\UserType;
use App\Models\Admin\Solicitude;
use App\Models\Admin\Notice;
use App\Models\Admin\Contract;
use App\Models\Admin\Status;
use App\Models\Admin\Log;
use App\Models\Admin\Notifiable;
use App\Helpers\HUserType;
use App\Helpers\HAccess;
use DB;
use Session;
use Validator;
use App\Models\Admin\UserAccess;
use App\Models\Admin\ItemMenu;

class UserController extends Controller {
    /**
    *
    */
    public function __construct (Request $request) {
      $this->middleware('requireAccess:' . HAccess::USERS);
    }
    /**
    * User List
    */
    public function index (Request $request) {
      /**
      *
      */
      if(is_null($request->session()->get('key-sesion'))) {
        return redirect('login');
      }
      $user  = $request->session()->get('key-sesion')['data'];
      /**
      *
      */
      if (!($request->session()->get('key-sesion')['type'] == HUserType::MASTER) ) {
        return redirect('/');
      }
      /**
      *
      */
      $users = User::all();
      /**
      *
      */
      $vars = [
        'users' => $users
      ];
      /**
      *
      */
      \Log::info('listado de usuarios vistos por: '.$user->email);
      return view('pages.admin.user.list', $vars);
  	}
    /*
    * Delete Users
    */
    public function delete (Request $request,$id) {
      /**
      *
      */
      if(is_null($request->session()->get('key-sesion'))) {
        return redirect('login');
      }
      /**
      *
      */
      if ($request->session()->get('key-sesion')['type'] == HUserType::WRITTER ) {
        return redirect('/');
      }
      /**
      *
      */
      $user = User::find($id);
      /**
      *
      */
      if(is_null($user)) {
        $this->doRedirect($request, '/admin/users')->with('errorMessage', trans('user.notFound'));
      }
      /**
      *
      */
      $user->delete();
      $this->doRedirect($request, '/admin/users')->with('successMessage', trans('user.deleted', [
        'code' => $user->code
      ]));
      \Log::info('usuario borrado por '.$request->session()->get('key-sesion')['data']->email);
      /**
      *
      */
      return $this->doRedirect($request, '/admin/users');
     }
    /**
    * Create User
    */
    public function create (Request $request) {
      /**
      *
      */
      if(is_null($request->session()->get('key-sesion'))) {
        return redirect('login');
      }
      /**
      *
      */
      if (!($request->session()->get('key-sesion')['type'] == HUserType::MASTER) ) {
        return redirect('/');
      }
      $types = UserType::all();
      /**
      *
      */
      if ($this->isGET($request)) {
        return view('pages.admin.user.create', compact('types'));
      }
      /**
      *
      */
      $validator = $this->validateData($request);
      if (!is_null($validator)) {
        if ($validator->fails()) {
          return view('pages.admin.user.create',compact('types'))
            ->withErrors($validator);
        }
      }
      /**
      *
      */
      if(Session::get('errorMessage') || isset($errorMessage)) {
        return $this->doRedirect($request, '/admin/users')->with('errorMessage', trans('contact.errormail',[
          'error' => Session::get('errorMessage')
        ]));
      }
      /**
      *
      */
      $user = User::create($request->all());
      \Log::info('usuario creado por '.$request->session()->get('key-sesion')['data']->email);
      /**
      *
      */
      return $this->doRedirect($request, '/admin/users')->with('successMessage', trans('user.created',[
        'code' => $user->code
      ]));
    }
    /**
    *
    */
    public function edit (Request $request, $id) {
      /**
      *
      */
      if(is_null($request->session()->get('key-sesion'))) {
        return redirect('login');
      }
      /**
      *
      */
      if (!($request->session()->get('key-sesion')['type'] == HUserType::MASTER) ) {
        return redirect('/');
      }
      $types = UserType::all();
      $user = User::find($id);
      /**
      *
      */
      if(is_null($user)) {
        return $this->doRedirect($request, '/admin/users')->with('errorMessage', trans('user.notFound'));
      }
      /**
      *
      */
      if ($this->isGET($request)) {
        return view('pages.admin.user.edit', compact('types', 'user'));
      }
      /**
      *
      */
      $validator = $this->validateData($request, true, $user->id);
      if (!is_null($validator)) {
        if ($validator->fails()) {
          return view('pages.admin.user.edit', compact('types', 'user'))
            ->withErrors($validator);
        }
      }
      /**
      *
      */
      $user->update($request->all());
      $user->save();
      \Log::info('usuario editado por '.$request->session()->get('key-sesion')['data']->email);
      /**
      *
      */
      return $this->doRedirect($request, '/admin/users')->with('successMessage', trans('user.updated', [
        'code' => $user->code
      ]));
    }
    /**
    *
    */
    public function view (Request $request, $id) {
      /**
      *
      */
      if(is_null($request->session()->get('key-sesion'))) {
        return redirect('login');
      }
      /**
      *
      */
      if (!($request->session()->get('key-sesion')['type'] == HUserType::MASTER) ) {
        return redirect('/');
      }
      /**
      *
      */
      $user        = User::find($id);
      $solicitudes = Solicitude::byUser($user->id)->get();
      $clients     = Client::byUser($user->id)->get();
      $notices     = Notice::byUser($user->id)->get();
      $logs        = Log::byUser($user->id)->get();
      $contracts   = Contract::bySolicitude($user->id)->get();
      /**
      *
      */
      if ($this->isGET($request)) {
        if($request->ajax()) {
          \Log::info('usuario visualizado por '.$request->session()->get('key-sesion')['data']->email);
          return view('pages.admin.user.view', compact('user', 'solicitudes', 'clients', 'notices', 'logs', 'contracts'));
        }
        return redirect('admin/users');
      }
    }
    /**
    * Se prueba la validacion de la session desde el middleware
    */
    public function notifiable (Request $request, $id) {
      $user = User::find($id);
      $notifiable = Notifiable::byUser($user->id)->get();
      $status = Status::all();
      /**
      *
      */
      if ($this->isGET($request)) {
        return view('pages.admin.user.notifiable', compact('notifiable', 'status', 'user'));
      }
      /**
      *
      */
      $notifiable = Notifiable::byUser($user->id)->delete();
      /**
      *
      */
      foreach ($request->all() as $key => $value) {
        if (!is_null($value)) {
          Notifiable::create([
            'status' => $value,
            'admin'  => $user->id
          ]);
        }
      }
      /**
      *
      */
      return $this->doRedirect($request, "/admin/users/{$user->id}/notifiable")->with('successMessage', trans('user.updatednotifiable', [
        'code' => $user->code,
        'name' => $user->name
      ]));
    }
    /**
    *
    */
    public function access (Request $request, User $user) {

      if(is_null($user)) {
        return $this->doRedirect($request, '/admin/users')->with('errorMessage', trans('user.notFound'));
      }
      /**
      *
      */
      $items = ItemMenu::all();
      $accesses = UserAccess::byUser($user->id)->get();
      /**
      *
      */
      if ($this->isGET($request)) {
        return view('pages.admin.user.access', compact('user', 'items', 'accesses'));
      }
      /**
      *
      */
      UserAccess::byUser($user->id)->delete();
      foreach ($request->all() as $key => $value) {
        if (!is_null($value)) {
          UserAccess::create([
            'user' => $user->id,
            'item' => $value
          ]);
        }
      }
      /**
      *
      */
      return $this->doRedirect($request, "/admin/users/{$user->id}/access")->with('successMessage', trans('user.updatedaccess', [
        'code' => $user->code,
        'name' => $user->name
      ]));
    }
    /**
    *Solicitud por usuario
    */

  public function solicitude(Request $request, User $user)
    {
      if(is_null($user)) {
        return $this->doRedirect($request, '/admin/users')->with('errorMessage', trans('user.notFound'));
      }
      $userdata=User::where('id','=',$user->id)->get();
      $data = Solicitude::where('status','<>',11)
                        ->where('status','<>',12)
                        ->get();
      /**
      *
      */
      if($this->isGet($request)) {
        if($request->ajax()) {
            return view('pages.admin.user.listSolicitude', compact('data','userdata','user'));
        }
      }
      foreach ($request->all() as $key => $value) {
        if (!is_null($value)) {
          Solicitude::where('id','=',$value)
                    ->update(['admin' => $user->id,]);
          }
        }
      return $this->doRedirect($request, "/admin/users")->with('successMessage', trans('user.solicitudeCorrect'));
      }

    /**
    * Validate Data
    */
    private function validateData (Request $request, $update = false, $id=null) {
        return Validator::make($request->all(), [
          'name'      => 'required|string|min:5|max:100',
          'phone'     => 'required|string|min:5|max:20',
          'email'     => 'required|email|min:5|max:100|unique:user,email' . (is_null($id) ? '' : ",$id"),
          'user_type' => 'required',
          'password'  => (!isset($update) ? 'required|confirmed|string|min:3|max:8' : ''),
          'password_confirmation' => (!isset($update) ? 'required|' : '')
        ]);
    }
}
