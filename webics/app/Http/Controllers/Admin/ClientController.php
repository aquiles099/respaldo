<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Client;
use App\Models\Admin\Status;
use App\Models\Admin\Country;
use App\Models\Admin\Solicitude;
use App\Models\Admin\Email;
use App\Helpers\HUserType;
use DB;
use Validator;
use \Mail;
use App\Helpers\HStatus;
use App\Helpers\HAccess;

class ClientController extends Controller {
  /**
  *
  */
  public function __construct (Request $request) {
    $this->middleware('requireAccess:' . HAccess::PROSPECTS);
  }
  /**
  * Listado
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
    $clients = Client::all();
    $country = Country::all();
    /**
    *
    */
    if ($request->session()->get('key-sesion')['type'] == HUserType::WRITTER ) {
      return redirect('/');
    } elseif ($request->session()->get('key-sesion')['type'] == HUserType::SELLER ) {
      $clients = Client::byUser($user->id)->get();
    }
    /**
    *
    */
    $vars = [
        'clients' => $clients,
        'countrys' => $country
    ];
    /**
    *
    */
    \Log::info('listado de clientes visto por: '.$user->email);
    /**
    *
    */
    return view('pages.admin.client.list', $vars);
  }
  /**
  * Editar Cliente
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
    $user       = $request->session()->get('key-sesion')['data'];
    $client     = Client::find($id);
    /**
    *
    */
    if (is_null($client)) {
      return $this->doRedirect($request, '/admin/clients')->with('errorMessage', trans('client.notFound'));
    }
    /**
    *
    */
    if ($request->session()->get('key-sesion')['type'] == HUserType::WRITTER ) {
      return redirect('/');
    } else if ($request->session()->get('key-sesion')['type'] == HUserType::SELLER ) {
      if ($client->admin != $user->user_type) {
        return $this->doRedirect($request, '/admin/clients')->with('errorMessage', trans('client.unauthorized'));
      }
    }
    /**
    * 1) Se obtienen paises.
    * 2) Se obtiene la solicitud asociada a este cliente
    */
    $countrys   = Country::all();
    $solicitude = Solicitude::byClient($client->id)->first();
    /**
    *
    */
    if ($this->isGet($request)) {
        return view('pages.admin.client.edit', compact('client','countrys'));
    }
    /**
    *
    */
    $validator = $this->validateData($request, true, ($solicitude ? true : false));
    if (!is_null($validator)) {
      if ($validator->fails()) {
        return view('pages.admin.client.edit', compact('client','countrys'))
          ->withErrors($validator);
      }
   }
    /**
    * Se editan datos de clientes
    */
    $client->update($request->all());
    $client->save();
    DB::table('client')->where('id', '=', $client->id)->update(['admin' => $user->id]);
    /**
    * se modifica el status de la solicitud
    */
    if (!is_null($solicitude) && $solicitude->status < HStatus::FORMRECEIVED) {
      DB::table('solicitude')->where('id', '=', $solicitude->id)->update(['status' => HStatus::FORMRECEIVED]);
      /**
      * Register Log
      */
      $data_log = [
        'admin'       => $user->id,
        'solicitude'  => $solicitude->id,
        'status'      => HStatus::FORMRECEIVED,
        'description' => trans('log.changestatus').'('.$solicitude->code.')'
      ];
      $this->registerLog($data_log);
    }
    /**
    *
    */
    \Log::info('cliente editado por: '.$user->email);
    /**
    *
    */
    return $this->doRedirect($request, '/admin/clients')->with('successMessage', trans('client.updated',[
      'code' => $client->code
    ]));
  }
  /**
  * Crear Cliente
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
    $user     = $request->session()->get('key-sesion')['data'];
    $countrys = Country::all();
    /**
    *
    */
    if ($request->session()->get('key-sesion')['type'] == HUserType::WRITTER ) {
      return redirect('/');
    }
    /**
    *
    */
    if ($this->isGet($request)) {
        return view('pages.admin.client.create', compact('countrys'));
    }
    /**
    *
    */
    $validator = $this->validateData($request);
    if (!is_null($validator)) {
      if ($validator->fails()) {
        return view('pages.admin.client.create', compact('countrys'))
          ->withErrors($validator);
      }
   }
   /**
   *
   */
   $client = Client::create($request->all());
   DB::table('client')->where('id', '=', $client->id)->update(['admin' => $user->id]);
   /**
   *
   */
   \Log::info('cliente creado por: '.$user->email);
   /**
   *
   */
   return $this->doRedirect($request, '/admin/clients')->with('successMessage', trans('client.created',[
     'code' => $client->code
   ]));
  }
  /*
  * Delete Clients
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
     $user = $request->session()->get('key-sesion')['data'];
     /**
     *
     */
     if ($request->session()->get('key-sesion')['type'] == HUserType::WRITTER ) {
       return redirect('/');
     }
     /**
     *
     */
     $client = Client::find($id);
     /**
     *
     */
     if(is_null($client)) {
       return $this->doRedirect($request, '/admin/clients')->with('errorMessage', trans('client.notFound'));
     }
     /**
     *
     */
     $client->delete();
     /**
     *
     */
     \Log::info('cliente borrado por: '.$user->email);
     /**
     *
     */
     return $this->doRedirect($request, '/admin/clients')->with('successMessage', trans('client.deleted', [
       'code' => $client->code
     ]));
    }
  /**
  * Ver en Modal
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
    $user     = $request->session()->get('key-sesion')['data'];
    $countrys = Country::all();
    $client   = Client::find($id);
    /**
    *
    */
    if ($request->session()->get('key-sesion')['type'] == HUserType::WRITTER ) {
      return redirect('/');
    }
    /**
    *
    */
    if (is_null($client)) {
      return $this->doRedirect($request, '/admin/clients')->with('errorMessage', trans('client.notFound'));
    }
    /**
    *
    */
    if ($this->isGet($request)) {
      if($request->ajax()) {
        \Log::info('cliente visualizado por: '.$user->email);
        return view('pages.admin.client.view', compact('client'));
      }
      /**
      *
      */
      return redirect('admin/clients');
    }
  }
  /**
  * Enviar Correo
  */
  public function mail (Request $request,  $id) {
    /**
    *
    */
    if(is_null($request->session()->get('key-sesion'))) {
      return redirect('login');
    }
    /**
    *
    */
    $user     = $request->session()->get('key-sesion')['data'];
    $client   = Client::find($id);
    /**
    *
    */
    if (is_null($client)) {
      return $this->doRedirect($request, '/admin/clients')->with('errorMessage', trans('client.notFound'));
    }
    /**
    *
    */
    if (is_null($client)) {
      return $this->doRedirect($request, '/admin/clients')->with('errorMessage', trans('client.notFound'));
    }
    /**
    *
    */
    if ($request->session()->get('key-sesion')['type'] == HUserType::WRITTER ) {
      return redirect('/');
    } else if ($request->session()->get('key-sesion')['type'] == HUserType::SELLER ) {
      if ($client->admin != $user->user_type) {
        return $this->doRedirect($request, '/admin/clients')->with('errorMessage', trans('client.unauthorized'));
      }
    }
    /**
    *
    */
    $vars = [
      'contact'  => $client,
      'path'     => "admin/clients/{$client->id}/mail",
      'response' => $request->all()
    ];
    /**
    * se utiliza para el envio del correo[implmentado de manera general]
    */
    $contact = $client;
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
      Mail::send('emails.message-contact', $vars, function($mail) use ($contact, $request) {
        $mail->from(env('ICS_MAIL_ADDRESS'));
        $mail->to($contact->email , $contact->name)
             ->bcc(env('ICS_MAIL_ADDRESS'), $contact->name)
             ->subject(strtoupper($request->all()['subject']));
      });
      /**
      * Se almacena la respuesta
      */
      $email = Email::create($request->all());
      /**
      *
      */
     \Log::info('Email Enviado por: '.$user->email);
      /**
      *
      */
      return $this->doRedirect($request, '/admin/clients')->with('successMessage', trans('contact.sendmail',[
        'name' => $contact->name
      ]));
    } catch(\Exception $ex) {
      return $this->doRedirect($request, '/admin/clients')->with('errorMessage', trans('contact.errormail',[
        'error' => $ex->getMessage()
      ]));
    }
  }
  /**
  *
  */
  private function validateData (Request $request, $update = false, $solicitude = false) {
    return Validator::make($request->all(), [
      'name'              => 'required|string|min:1|max:100',
      'email'             => 'required|email|min:5|max:100'.(!$update ? '|unique:client,email' : !$solicitude ? '|unique:client,email' : ''),
      'dni'               => 'required|string|min:5|max:20',
      'country'           => 'not_in:0|required|exists:country,id',
      'region'            => 'required|string|min:5|max:100',
      'city'              => 'required|string|min:5|max:100',
      'postal_code'       => 'required|string|min:|max:100',
      'address'           => 'required|string|min:5|max:100',
      'phone'             => 'required|string|min:5|max:100',
      'webpage'           => 'required|string|min:5|max:100',
      'sub_domain'        => 'max:100',
      'name_manager'      => 'required|string|min:5|max:100',
      'last_name_manager' => 'required|string|min:5|max:100',
      'phone_manager'     => 'required|string|min:5|max:100',
      'email_manager'     => 'required|email|min:5|max:100'.(!$update ? '|unique:client,email_manager' : !$solicitude ? '|unique:client,email_manager' : '')
    ]);
  }
  /**
  *
  */
  private function validateMailData (Request $request) {
      return Validator::make($request->all(), [
        'name'        => 'required|string|min:1|max:100',
        'email'       => 'required|email|min:5|max:100',
        'subject'     => 'required|string|min:5|max:50',
        'message'     => 'required|string|min:5'
      ]);
  }
}
