<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Operator;
use App\Models\Admin\Security\Profile;
use Validator;
use App\Helpers\HUserType;
use \Mail;
use Crypt;
use App\Models\Admin\Configuration;
use App\Helpers\HConstants;
use App\Models\Admin\Event;
/**
 *
 */
class OperatorController extends Controller {
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
    $operator = Operator::find($id);
    /**
    *
    */
    if(is_null($operator)) {
      return $this->doRedirect($request, '/admin/operators')
        ->with('errorMessage', trans('user.notFound'));
    }
    /**
    *
    */
    $vars = [
      'profiles' => Profile::all(),
      'operator' => $operator,
      'readonly' => $readonly
    ];
    /**
    *
    */
    if($this->isGET($request)) {
       return view('pages.admin.operator.view', $vars);
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
    * Editar un operator
    */
    $operator->update($request->all());
    $operator->save();
    return response()->json([
      "message" => "true"
    ]);
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
    $profiles = Profile::all();
    $configuration = Configuration::find(HConstants::FIRST_CONFIGURATION);   
    /**
    *
    */
    $vars = [
      'profiles' => $profiles
    ];
    /**
    *
    */
    if($this->isGET($request)) {
      return view('pages.admin.operator.create', $vars);
    }
    /**
    *
    */
    $validator = $this->validateData($request);
    if (!is_null($validator)) {
      if ($validator->fails()) {
        return view('pages.admin.operator.create', $vars)
          ->withErrors($validator)
          ->with('errorMessage', trans('messages.checkRedFields'));
        }
      }
    $operator = Operator::create($request->all());
      /**
      * Mail Send
      */
      Mail::send('emails.check_email', [
        'host'     => $this->host,
        'link'     => "check/account/op?code={$operator->remember_token}",
        'user'     => $operator,
        'configuration' => $configuration,
        'password' => Crypt::decrypt($operator->password)
      ],
      function($mail) use ($operator) {
        $mail->from($this->from);
        $mail->to($operator->email , "$operator->user $operator->name")->subject(trans('messages.activate'));
      });
      /**
      * Return View
      */
      return $this->doRedirect($request, "/admin/operators")->with('successMessage', trans('operator.created', [
        'name' => $operator->name,
        'code' => $operator->code
      ]));
    }
  /**
   * Listado
   */
  public function index(Request $request) {
    $session = $request->session()->get('key-sesion');
    $this->checkAuthorization();
    $operators = Operator::all();
    /**
    *  Se valida que la sesion este activa
    */
    if ($session == null) {
      return redirect('login');
    }
    /**
    * Se listan los operadores existentes
    */
    $vars =[
      'operators' => $operators
    ];
    /**
    * Se retorna la vista de operadores
    */
    return view('pages.admin.operator.list', $vars);
  }
  /**
   *
   */
  public function delete(Request $request, $id) {
    $redirect = $this->doRedirect($request, '/admin/operators');
    $operator = Operator::find($id);
    /**
    *
    */
    if(is_null($operator)) {
      $redirect->with('errorMessage', trans('operator.notFound'));
    }
    else {
      $operator->delete();
      $redirect->with('successMessage', trans('operator.deleted', [
        'name' => $operator->name,
        'code' => $operator->code
      ]));
    }
    return $redirect;
  }
  /**
   *
   */
  private function validateData(Request $request, $update = false, $id = null) {
    return Validator::make($request->all(), [
      'username'   => 'required|string|min:5|max:15|unique:operator,username' . (is_null($id) ? '' : ",$id"),
      'name'       => 'required|string|min:5|max:100',
      'lastname'   => 'required|string|min:5|max:100',
      'email'      => 'required|string|min:5|max:50|email|unique:operator,email' . (is_null($id) ? '' : ",$id"),
      'password'   => 'required|string|min:5|max:25|confirmed',
      'password'   => ($update ? '' : 'required|') . 'string|min:5|max:25|confirmed'
    ]);
  }

}
