<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Admin\User;
use App\Helpers\HUserType;
use \Mail;

class LoginController extends Controller {
    /**
    * Muestra el formulario para login
    */
    public function index(Request $request) {
      if (is_null($request->session()->get('key-sesion'))) {
        return view('main.login');
      }
      /**
      *
      */
     return redirect('/');
    }
    /**
    * Procesa los datos de login
    */
    public function login (Request $request) {

      $validator = Validator::make($request->all(), [
       'email'    => 'required|email|min:5|max:40|exists:user,email',
       'password' => 'required|string|min:5|max:9'
      ]);
      /**
      *
      */
      if (!is_null($validator)) {
        if ($validator->fails()) {
            return view('main.login')
              ->withErrors($validator);
        }
      }
      /**
      *
      */
      $email    = $request->all()['email'];
      $password = $request->all()['password'];
      $user     = User::byEmail($email)->first();
      /**
      * se verifca la contraseña y se asigna la data del adminstrador
      */
      if ($user->checkPassword($password)) {

        switch ($user->user_type) {
          case  HUserType::MASTER:
            $request->session()->put('key-sesion', [
                'type' => HUserType::MASTER,
                'data' => $user
            ]);
            break;
          case  HUserType::SELLER:
            $request->session()->put('key-sesion', [
                'type' => HUserType::SELLER,
                'data' => $user
            ]);
            break;
          case  HUserType::WRITTER:
            $request->session()->put('key-sesion', [
                'type' => HUserType::WRITTER,
                'data' => $user
            ]);
           break;
        }
        \Log::info('sesion iniciada por: '.$user->email);
        return redirect('/');
      }
      return view('main.login')->with('errorMessage', trans('messages.invalidData'));
    }
    /**
    * Procesa el cierre de sesion
    */
    public function logout(Request $request) {
      $user = $request->session()->get('key-sesion')['data'];
      /**
      *
      */
      if (!is_null($user)) {
        \Log::info($user->email.' ha cerrado sesion');
      }
      /**
      *
      */
      $request->session()->put('key-sesion', null);
      return redirect('/login');
    }
    /**
    * Procesa el cambio de contraseña
    */
    public function recoverPassword (Request $request) {
      if (!is_null($request->session()->get('key-sesion'))) {
        return redirect('/');
      }
      if ($this->isGet($request)) {
        return view('main.recoverpass');
      }
      /**
      *
      */
      $validator = $this->validateRecover($request);
      if (!is_null($validator)) {
        if ($validator->fails()) {
          return view('main.recoverpass')->withErrors($validator);

        }
      }
      /**
      *
      */
      $user = User::byEmail($request->email)->first();
      /**
      *
      */
      try {
        Mail::send('emails.recover-password', compact('user'), function($mail) use ($user) {
          $mail->from(env('ICS_MAIL_ADDRESS'));
          $mail->to($user->email, $user->name)
               ->bcc(env('ICS_MAIL_ADDRESS'), env('ICS_MAIL_ADMIN'))
               ->subject(strtoupper(trans('messages.recoverpass')));
        });
        /**
        *
        */
        return $this->doRedirect($request, '/login')->with('successMessage', trans('messages.sendDataMail',[
          'mail' => $user->email
        ]));
      } catch(\Exception $ex) {
        return $this->doRedirect($request, '/recover-password')->with('errorMessage', trans('contact.errormail',[
          'error' => $ex->getMessage()
        ]));
      }

    }
    /**
    *
    */
    private function validateRecover (Request $request) {
        return Validator::make($request->all(), [
          'email' => 'required|email|exists:user,email',
        ]);
      }

}
