<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Email;
use App\Helpers\HUserType;
use DB;
use Validator;
use \Mail;
use App\Helpers\HStatus;
use App\Helpers\HAccess;

class EmailController extends Controller {
  /**
  *
  */
  public function __construct (Request $request) {
    $this->middleware('requireAccess:' . HAccess::MAILS);
  }
  /**
  *
  */
  public function index (Request $request) {
    /**
    *
    */
    if(is_null($request->session()->get('key-sesion'))) {
      return redirect('login');
    }
    /**
    *
    */
    $user    = $request->session()->get('key-sesion')['data'];
    $mails   = Email::all();

    /**
    *
    */
    if ($request->session()->get('key-sesion')['type'] == HUserType::SELLER || $request->session()->get('key-sesion')['type'] == HUserType::WRITTER) {
      $mails = Email::byUser($user->id)->get();
    }
    /**
    *
    */
    \Log::info('listado de correos enviados visto por: '.$user->email);
    /**
    *
    */
    return view('pages.admin.mail.list', compact('user', 'mails'));
  }
  /**
  *
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
    $user    = $request->session()->get('key-sesion')['data'];
    /**
    *
    */
    $vars = [
      'path'     => "admin/mails/new",
      'response' => $request->all()
    ];
    /**
    *
    */
    if($this->isGet($request)) {
        return view('pages.admin.mail', $vars);
    }
    /**
    *
    */
    $validator = $this->validateMailData($request);
    if (!is_null($validator)) {
      if ($validator->fails()) {
        return view('pages.admin.mail', $vars)
          ->withErrors($validator);
      }
    }
    /**
    *
    */
    try {
      Mail::send('emails.message-contact', $vars, function($mail) use ($request) {
        $mail->from(env('ICS_MAIL_ADDRESS'));
        $mail->to($request->all()['email'], $request->all()['name'])
             ->bcc(env('ICS_MAIL_ADDRESS'), $request->all()['name'])
             ->subject(strtoupper($request->all()['subject']));
      });
      /**
      * Se almacena la respuesta
      */
      $email = Email::create($request->all());
      /**
      *
      */
      \Log::info('correo enviado por: '.$user->email);
      /**
      *
      */
      return $this->doRedirect($request, '/admin/mails')->with('successMessage', trans('contact.sendmail',[
        'name' => $request->all()['name']
      ]));
    } catch(\Exception $ex) {
      return $this->doRedirect($request, '/admin/mails')->with('errorMessage', trans('contact.errormail',[
        'error' => $ex->getMessage()
      ]));
    }
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
    $mail = Email::find($id);
    /**
    *
    */
    if (is_null($mail)) {
      return redirect('/admin/mails');
    }
    /**
    *
    */
    $user = $request->session()->get('key-sesion')['data'];
    /**
    *
    */
    if ($request->ajax()) {
        \Log::info('correo visualizado por: '.$user->email);
        return view('pages.admin.mail.edit', compact('mail'));
    }
    /**
    *
    */
    return redirect('/admin/mails/');
  }
  /**
  *
  */
  public function delete (Request $request, $id) {
    /**
    *
    */
    if(is_null($request->session()->get('key-sesion'))) {
      return redirect('login');
    }
    /**
    *
    */
    if ($request->session()->get('key-sesion')['type'] == HUserType::SELLER || $request->session()->get('key-sesion')['type'] == HUserType::WRITTER) {
      return $this->doRedirect($request, '/admin/mails')->with('errorMessage', trans('client.unauthorized'));
    }
    /**
    *
    */
    $user = $request->session()->get('key-sesion')['data'];
    /**
    *
    */
    $mail = Email::find($id);
    /**
    *
    */
    if(is_null($mail)) {
      return $this->doRedirect($request, '/admin/mails')->with('errorMessage', trans('mail.notFound'));
    }
    /**
    *
    */
    $mail->delete();
    \Log::info('correo borrado por: '.$user->email);
    /**
    *
    */
    return $this->doRedirect($request, '/admin/mails')->with('successMessage', trans('mail.deleted', [
      'email' => $mail->email
    ]));
  }
  /**
  *
  */
  private function validateMailData (Request $request) {
      return Validator::make($request->all(), [
        'name'        => 'required|string|min:5|max:100',
        'email'       => 'required|email|min:5|max:100',
        'subject'     => 'required|string|min:5|max:50',
        'message'     => 'required|string|min:5'
      ]);
  }
}
