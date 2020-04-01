<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\HUserType;
use App\Helpers\HAccess;
use Validator;
use App\Models\Admin\Solicitude;
use App\Models\Admin\Status;
use App\Models\Admin\Contract;
use App\Models\Admin\Test;
use App\Models\Admin\Client;
use App\Models\Admin\Log;
use App\Helpers\HStatus;
use App\Models\Admin\Email;
use App\Models\Admin\User;
use App\Models\Admin\Notifiable;
use \Mail;
use DB;
use Session;

class SolicitudeController extends Controller {
    /**
    *
    */
    public function __construct (Request $request) {
      $this->middleware('requireAccess:' . HAccess::SOLICITUDES);
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
      $user = $request->session()->get('key-sesion')['data'];
      $solicitudes = Solicitude::all();
      /**
      *
      */
      /*if ($request->session()->get('key-sesion')['type'] == HUserType::WRITTER ) {
        return redirect('/');
      } else*/if ($request->session()->get('key-sesion')['type'] == HUserType::SELLER ) {
        $solicitudes = Solicitude::byUser($user->id)->get();
      }
      /**
      *
      */
      $vars = [
        'user'        => $user,
        'solicitudes' => $solicitudes
      ];
      \Log::info('listado de solicitudes visto por: '.$user->email);
      /**
      *
      */
      return view('pages.admin.solicitude.list', $vars);
    }
    /*
    * Borrar Solicitud
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
      /*if ($request->session()->get('key-sesion')['type'] == HUserType::WRITTER ) {
        return redirect('/');
      }*/
      $user = $request->session()->get('key-sesion')['data'];
      /**
      *
      */
      $solicitude = Solicitude::find($id);
      /**
      *
      */
      if(is_null($solicitude)) {
        return $this->doRedirect($request, '/admin/solicitudes')->with('errorMessage', trans('solicitude.notFound'));
      }
      /**
      *
      */
      $solicitude->delete();
      \Log::info('solicitud borrada por: '.$user->email);
      return $this->doRedirect($request, '/admin/solicitudes')->with('successMessage', trans('solicitude.deleted', [
        'code' => $solicitude->code
      ]));
     }
    /**
    * Editar Solicitud
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
      $solicitude = Solicitude::find($id);
      $client     = Client::find($solicitude->client);
      /**
      *
      */
      if (is_null($solicitude)) {
        return $this->doRedirect($request, '/admin/solicitudes')->with('errorMessage', trans('solicitude.notFound'));
      }
      /**
      *
      */
      $status = Status::all();
      $logs   = Log::bySolicitude($solicitude->id)->get();
      /**
      *
      */
      /*if ($request->session()->get('key-sesion')['type'] == HUserType::WRITTER ) {
        return trans('messages.unauthorized');
      } else*/
      if ($request->session()->get('key-sesion')['type'] == HUserType::SELLER ) {
          if ($solicitude->admin != $user->id) {
            return trans('messages.unauthorized');
          }
      }
      
      /**
      *
      */
      if ($this->isGET($request)) {
        if($request->ajax()) {
          return view('pages.admin.solicitude.view', compact('solicitude', 'user', 'status', 'logs'));
        }
        return redirect('/admin/solicitudes');
      }
      /**
      * se almacena la informacion de status en una variable
      */
      $status = $request->all()['status'];
      /**
      * 1) Se verifica si existe el indice[sub]
      * 2) se almacena el contenido del indice[sub]
      * 3) se valida que el indice tenga el patron correcto[url]
      * 4) se actualiza la tabla cliente con el subdominio registrado
      */
      if ($status != HStatus::DENIED) {
        if (isset($request->all()['sub'])) {
          $sub = $request->all()['sub'];
          if (strpos($request->all()['sub'], 'http://')) {
            $sub = substr($sub, 0, 6);
          }
          DB::table('client')->where('id', '=', $client->id)->update(['sub_domain' => $sub]);
        }
      }
      /**
      *
      */
      $solicitude->update($request->all());
      $solicitude->save();
      /**
      * Register Log
      */
      $data_log = [
        'admin'       => $user->id,
        'solicitude'  => $solicitude->id,
        'status'      => $status,
        'description' => trans('log.changestatus').'('.$solicitude->code.')'
      ];
      $this->registerLog($data_log);
      /**
      * Notify to admin
      */
      if ($status == HStatus::APROVED || $status == HStatus::DENIED) {
        /**
        *
        */
        $users = User::byType(HUserType::SELLER)->get();
        $emails = array(env('ICS_MAIL_ADDRESS'));
        $notifiable = Notifiable::all();
        /**
        * 1) se verifican usuarios autorizados para recibir correos
        * 2) Se almacenan las direcciones de correo
        */
        foreach ($users as $key => $value) {
          foreach ($notifiable as $key => $notify) {
            if (($notify->admin == $value->id) && ($notify->status == $status)) {
                array_push($emails, $value->email);
            }
          }
        }
        /**
        * se asigna un valor a la variable estatus para ser utilizada en la vista
        */
        $response = [
          'status' => $status
        ];
        /**
        * Envio de correo con captura de errores
        */
        try {
          Mail::send('emails.response-solicitude', compact('client' , 'solicitude', 'response') , function($mail) use ($solicitude, $client, $status, $emails) {
            $mail->from(env('ICS_MAIL_ADDRESS'));
            $mail->to($client->email, $client->name)
                 ->bcc($emails, env('ICS_MAIL_ADMIN'))
                 ->subject(strtoupper($status == HStatus::APROVED ? trans('messages.aprovedsolicitude') : trans('messages.deniedsolicitude')));
          });
        } catch (Exception $e) {
          return view('errors.solicitude-exception', [
            'error'  => $ex->getMessage(),
            'client' => $client
          ]);
        }
      }
      /**
      *
      */
      \Log::info('solicitud editada por: '.$user->email);
      /**
      * Return Response to client
      */
      return response()->json([
        "message" => true
      ]);
    }
    /**
    * Crear Solicitud de Manera Manual
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
      $user = $request->session()->get('key-sesion');
      $profiles = $this->profilesICS();
      /**
      *
      */
      /*if ($user['type'] == HUserType::WRITTER ) {
        return redirect('/');
      }*/
      /**
      *
      */
      if($this->isGET($request)) {
        return view('pages.admin.solicitude.create', compact('profiles'));
      }
      /**
      *
      */
      $validator = $this->validateData($request);
      if (!is_null($validator)) {
        if ($validator->fails()) {
          return view('pages.admin.solicitude.create', compact('profiles'))
            ->withErrors($validator);
        }
      }
      /**
      * Crear una solicitud y registrar cambios de estatus en log
      */
      $client = Client::create($request->all());
      DB::table('client')->where('id', '=', $client->id)->update(['admin' => $user['data']->id]);
      /**
      *
      */
      $data_solicitude = [
        'client'     => $client->id,
        'subject'    => $request->subject,
        'profile'    => $request->profile,
        'description'=> $request->description
      ];
      /**
      *
      */
      $solicitude = Solicitude::create($data_solicitude);
      DB::table('solicitude')->where('id', '=', $solicitude->id)->update(['admin' => $user['data']->id]);
      /**
      * Se inserta este evento en el log
      */
      $data_log_register = [
        'client'      => $client->id,
        'solicitude'  => $solicitude->id,
        'status'      => HStatus::GENERATED,
        'description' => trans('log.changestatus').'('.$solicitude->code.')'
      ];
      $this->registerLog($data_log_register);
      /**
      *
      */
      $vars = [
        'client'     => $client,
        'solicitude' => $solicitude
      ];
      /**
      *
      */
      if(Session::get('errorMessage') || isset($errorMessage)) {
        return $this->doRedirect($request, '/admin/solicitudes')->with('errorMessage', trans('contact.errormail',[
          'error' => Session::get('errorMessage')
        ]));
      }
      /**
      *
      */
      $solicitude->status = HStatus::FORMSENDED;
      $solicitude->save();
      /**
      * Se inserta este evento en el log
      */
      $data_log_form_send = [
        'client'      => $client->id,
        'solicitude'  => $solicitude->id,
        'status'      => HStatus::FORMSENDED,
        'description' => trans('log.changestatus').'('.$solicitude->code.')'
      ];
      $this->registerLog($data_log_form_send);
      \Log::info('solicitud creada por: '.$user['data']->email);
      return $this->doRedirect($request, '/admin/solicitudes')->with('successMessage', trans('solicitude.created', [
        'code' => $solicitude->code
      ]));
    }
    /**
    * Do Contract Solicitude
    */
    public function test (Request $request, $id) {
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
      $solicitude = Solicitude::find($id);
      /**
      *
      */
      if(is_null($solicitude)) {
        return $this->doRedirect($request, '/admin/solicitudes')->with('errorMessage', trans('solicitude.notFound'));
      }
      /**
      *
      */
      $client = Client::find($solicitude->client);
      /**
      * se valida la solicitud, de tal forma que no se agregue si ya se ha contratado
      */
      $test_solicitude = Test::bySolicitude($solicitude->id)->first();
      if (!is_null($test_solicitude)) {
        return $this->doRedirect($request, '/admin/solicitudes')->with('errorMessage', trans('solicitude.tested',[
          'code' => $solicitude->code
        ]));
      }
      /**
      *
      */
      if ($request->session()->get('key-sesion')['type'] == HUserType::WRITTER ) {
        return redirect('/');
      } elseif ($request->session()->get('key-sesion')['type'] == HUserType::SELLER ) {
        $solicitude = Solicitude::byUser($user->id)->first();
      }
      /**
      *
      */
      $test = Test::create([
        'client'     => $solicitude->client,
        'solicitude' => $solicitude->admin,
        'solicitude' => $solicitude->id
      ]);
      /**
      * Se inserta este evento en el log
      */
      $data_log_register = [
        'admin'       => $solicitude->admin,
        'client'      => $client->id,
        'test'        => $test->id,
        'status'      => HStatus::ACTIVE,
        'description' => trans('log.changestatus').'('.$test->code.')'
      ];
      $this->registerLog($data_log_register);
      \Log::info('solicitud movida a prueba por: '.$user->email);
      /**
      *
      */
      return $this->doRedirect($request, '/admin/tests')->with('successMessage', trans('test.created',[
        'code' => $test->code
      ]));
    }
    /**
    *
    */
    public function mail (Request $request, $id) {
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
      $solicitude = Solicitude::find($id);
      /**
      *
      */
      if(is_null($solicitude)) {
        return $this->doRedirect($request, '/admin/solicitudes')->with('errorMessage', trans('solicitude.notFound'));
      }
      /**
      *
      */
      $client =  Client::find($solicitude->client);
      /**
      *
      */
      if ($request->session()->get('key-sesion')['type'] == HUserType::WRITTER ) {
        return redirect('/');
      } else if ($request->session()->get('key-sesion')['type'] == HUserType::SELLER ) {
        if ($client->admin != $user->user_type) {
          return $this->doRedirect($request, '/admin/tests')->with('errorMessage', trans('test.unauthorized'));
        }
      }
      /**
      *
      */
      $vars = [
        'contact'  => $client,
        'path'     => "admin/solicitudes/{$solicitude->id}/mail",
        'response' => $request->all()
      ];
      /**
      *
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
        \Log::info('correo enviado por: '.$user->email);
        /**
        *
        */
        return $this->doRedirect($request, '/admin/solicitudes')->with('successMessage', trans('contact.sendmail',[
          'name' => $contact->name
        ]));
      } catch(\Exception $ex) {
        return $this->doRedirect($request, '/admin/solicitudes')->with('errorMessage', trans('contact.errormail',[
          'error' => $ex->getMessage()
        ]));
      }
    }
    /**
    *
    */
    public function viewClient (Request $request, $id) {
      /**
      *
      */
      if(is_null($request->session()->get('key-sesion'))) {
        return redirect('login');
      }
      /**
      *
      */
      $solicitude = Solicitude::find($id);
      if (is_null($solicitude)) {
        return redirect('/');
      }
      $user = $request->session()->get('key-sesion')['data'];
      /**
      *
      */
      $client = Client::find($solicitude->client);
      /**
      *
      */
      if ($this->isGet($request)) {
        if($request->ajax()) {
          \Log::info('cliente visualizado desde solicitudes por: '.$user->email);
          return view('pages.admin.client.view', compact('client'));
        }
        return redirect('admin/clients');
      }
    }
    /**
    *
    */
    private function validateData (Request $request) {
        return Validator::make($request->all(), [
          'name'        => 'required|string|min:1|max:100',
          'subject'     => 'required|string|min:5|max:20',
          'email'       => 'required|email|min:5|max:100|unique:client,email',
          'description' => 'required|string|min:5|max:200'
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
