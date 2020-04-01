<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\HUserType;
use Validator;
use App\Models\Admin\Solicitude;
use App\Models\Admin\Client;
use App\Models\Admin\Notice;
use App\Models\Admin\Country;
use App\Models\Admin\Contract;
use App\Models\Admin\User;
use App\Models\Admin\Test;
use App\Models\Admin\Contact;
use App\Models\Admin\Payment;
use App\Models\Admin\Price;
use App\Models\Admin\Notifiable;
use App\Models\Admin\Billing;
use App\Helpers\HStatus;
use Session;
use \Mail;
use Carbon\Carbon;
use DB;
use App\Helpers\HPayment;
use App\Helpers\HProfileType;
use Crypt;

class MainController extends Controller {
  /**
  * retorna el dashboard
  */
  public function index (Request $request) {
    $user = $request->session()->get('key-sesion')['data'];
    /**
    *
    */
    switch ($request->session()->get('key-sesion')['type']) {
    /**  case HUserType::WRITTER:
        return redirect('admin/notices');
        break;
    **/
      case HUserType::MASTER:

        $clients     = Client::all();
        $solicitudes = Solicitude::all();
        $contracts   = Contract::all();
        $notices     = Notice::all();
        $users       = User::all();
        /**
        * Administrador Master
        */
        $vars = [
          'clients'    => $clients,
          'solicitudes'=> $solicitudes,
          'user'       => $user,
          'contracts'  => $contracts,
          'notices'    => $notices,
          'users'      => $users
        ];
        /**
        *
        */
        return view('pages.admin.dashboard', $vars);
        break;
        case HUserType::SELLER:
        $clients     = Client::byUser($user->id)->get();
        $solicitudes = Solicitude::byUser($user->id)->get();
          /**
          * Administrador Vendedor
          */
          $vars = [
            'clients'     => $clients,
            'solicitudes' => $solicitudes,
            'user'        => $user
          ];
          /**
          *
          */
          return view('pages.admin.dashboard', $vars);
          break;
      default:
        return view('main.dashboard');
    }
  }
  /**
  * Procesar una solicitud
  */
  public function solicitude (Request $request) {
    /**
    *
    */
    if (!(is_null($request->session()->get('key-sesion')))) {
      return redirect('login');
    }
    /**
    *
    */
    $profiles = $this->profilesICS();
    /**
    *
    */
    if ($this->isGET($request)) {
        return view('main.contact', compact('profiles'));
    }
    /**
    *
    */
    $validator = $this->validateSolicitudeData($request);
    if (!is_null($validator)) {
      if ($validator->fails()) {
        return view('main.contact', compact('profiles'))
          ->withErrors($validator);
      }
    }
    /**
    * Crear una solicitud y registrar cambios de estatus en log
    */
    $client = Client::create($request->all());
    /**
    *
    */
    $data_solicitude = [
      'client'     => $client->id,
      'subject'    => $request->all()['subject'],
      'profile'    => $request->all()['profile'],
      'description'=> $request->all()['description']
    ];
    /**
    *
    */
    $solicitude = Solicitude::create($data_solicitude);
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
        return view('errors.solicitude-exception', [
          'error'  => Session::get('errorMessage'),
          'client' => $client
        ]);
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
    /**
    *
    */
    return view('main.notify-admin', $vars);
  }
  /**
  *
  */
  public function changePassword (Request $request) {
    $user = $request->session()->get('key-sesion')['data'];

    if($this->isGET($request)){
      return view('pages.admin.user.pass',compact('user'));
    }

    $validator=$this->validateSolicitudePass($request);

    if (!is_null($validator)) {
      if ($validator->fails()) {
        return view('pages.admin.user.pass')->withErrors($validator);
      }
    }

    if(decrypt($user->password) == $request->input('current')){

      $user->password=$request->input('pass');
      $user->save();

      try {
        Mail::send('emails.change-password', compact('user'), function($mail) use ($user) {
          $mail->from(env('ICS_MAIL_ADDRESS'));
          $mail->to($user->email, $user->name)
               ->bcc(env('ICS_MAIL_ADDRESS'), env('ICS_MAIL_ADMIN'))
               ->subject(strtoupper(trans('messages.changepassword')));
        });
        \Log::info('El Usuario '.$user->name.' ha cambiado su contraseña');
        return redirect('/change-password')->with('successMessage', trans('messages.passwordIschange'));
      }catch(\Exception $ex) {
        return redirect('/change-password')->with('errorMessage', trans('messages.error'));
      }


    }else{
      return redirect('/change-password')->with('errorMessage', trans('messages.passnomatch'));
    }

  }
  /**
  * Todas las noticias
  */
  public function news (Request $request) {
    $notices = Notice::byPublished(1)->get();
    /**
    *
    */
    if ($this->isGET($request)) {
        return view('main.news', compact('notices'));
    }
  }
  /**
  * Terminos y condicones
  */
  public function terms (Request $request) {
    return view('main.terms');
  }
  /**
  * Politicas de Privacidad
  */
  public function privacy (Request $request) {
    return view('main.privacy');
  }
  /**
  * Preguntas Frecuentes
  */
  public function faq (Request $request) {
    return view('main.faq');
  }
  /**
  * Retorna una noticia
  */
  public function showNew (Request $request, $notice) {
    $notice = Notice::bySlug($notice)->first();
    /**
    *
    */
    if (is_null($notice) || ((!is_null($notice)) && ($notice->published != true))) {
      return redirect('news');
    }
    /**
    *
    */
    return view('main.news-detail', compact('notice'));
  }
  /**
  * retorna la vista 'nosotros'
  */
  public function us (Request $request) {
      return view('main.us');
  }
  /**
  * Procesa un contacto realizado a través del formulario ubicado en el pie de la pagina
  */
  public function contact (Request $request) {
    /**
    *
    */
    if ($this->isGET($request)) {
        return redirect('/');
    }
    /**
    *
    */
    $validator = $this->validateContactData($request);
    if (!is_null($validator)) {
      if ($validator->fails()) {
        return view('main.dashboard')
          ->withErrors($validator);
      }
    }
    /**
    *
    */
    $contact = Contact::create($request->all());
    /**
    *
    */
    if(Session::get('errorMessage') || isset($errorMessage)) {
        return view('errors.solicitude-exception', [
          'error'   => Session::get('errorMessage'),
          'contact' => $contact
        ]);
    }
    /**
    *
    */
    $vars = [
      'contact' => $contact
    ];
    /**
    *
    */
    return view('main.notify-contact', $vars);
  }
  /**
  * Retorna la vista 'demo'
  */
  public function demo (Request $request) {
      return view('main.demo');
  }
  /**
  * Retorna la vista 'precios'
  */
  public function prices (Request $request) {
    $prices = Price::all();
    return view('main.prices', compact('prices'));
  }
  /**
  * Verificar Codigo enviado por correo al cliente
  */
  public function check (Request $request) {
    $request->session()->put('key-sesion', null);
    $code = $request->query('p');
    if (is_null($code)) {
      return redirect('/solicitude')->with('errorMessage', trans('messages.invalid_code'));
    } else {
      $client = Client::byRememberToken($code)->first();
      if (is_null($client)) {
        return redirect('/solicitude')->with('errorMessage', trans('messages.invalid_client'));
      } else {
        return redirect("/check-data/{$client->slug}");
      }
    }
  }
  /**
  * Mostrar Formulario que el cliente debe cargar
  */
  public function checkData (Request $request, $client) {
    $client = Client::bySlug($client)->first();
    /**
    *
    */
    if (is_null($client)) {
      return redirect('/solicitude')->with('errorMessage', trans('messages.invalid_client'));
    } else if (!is_null($client->dni)) {
      return redirect('/');
    }
    /**
    *
    */
    $countrys = Country::all();
    /**
    *
    */
    if ($this->isGET($request)) {
        return view('main.check-data', compact('client', 'countrys'));
    }
    /**
    *
    */
    $validator = $this->validateClientData($request, $client->id);
    if (!is_null($validator)) {
      if ($validator->fails()) {
        return view('main.check-data',  compact('client', 'countrys'))
          ->withErrors($validator);
      }
    }
    /**
    * PRUEBA [ACTUALIZACION DE STATUS DE SOLICTUD A 'FORMULARIO RECIBIDO']
    */
    $solicitude = Solicitude::byClient($client->id)->first();
    DB::table('solicitude')->where('id', '=', $solicitude->id)->update(['status' => HStatus::FORMRECEIVED]);
    /**
    *
    */
    $client->update($request->all());
    $client->save();
    /**
    * Register Log
    */
    $data_log = [
      'solicitude'  => $solicitude->id,
      'status'      => HStatus::FORMRECEIVED,
      'description' => trans('log.changestatus').'('.$solicitude->code.')'
    ];
    $this->registerLog($data_log);
    /**
    *
    */
    $users = User::byType(HUserType::SELLER)->get();
    $emails = array(env('ICS_MAIL_ADDRESS'));
    $notifiable = Notifiable::all();
    /**
    *
    */
    foreach ($users as $key => $value) {
      foreach ($notifiable as $key => $notify) {
        if (($notify->admin == $value->id) && ($notify->status == $solicitude->status)) {
            array_push($emails, $value->email);
        }
      }
    }
    /**
    *
    */
    try {
      Mail::send('emails.process-solicitude', compact('client' , 'solicitude') , function($mail) use ($solicitude, $client, $emails) {
        $mail->from(env('ICS_MAIL_ADDRESS'));
        $mail->to($client->email , $client->name)
             ->bcc($emails, $client->name)
             ->subject(strtoupper(trans('messages.formreceived')));
      });
      /**
      *
      */
      return view('main.notify-admin', compact('client'));
    } catch (Exception $e) {
      return view('errors.solicitude-exception', [
        'error'  => $ex->getMessage(),
        'client' => $client
      ]);
    }
  }
  /**
  * Redirige al subdominio de un cliente
  */
  public function subDomain (Request $request) {
    $request->session()->put('key-sesion', null);
    $code = $request->query('p');
    if (is_null($code)) {
      return redirect('/solicitude')->with('errorMessage', trans('messages.invalid_code'));
    } else {
      $client = Client::byRememberToken($code)->first();
      if (is_null($client)) {
        return redirect('/solicitude')->with('errorMessage', trans('messages.invalid_client'));
      } else {
        return redirect("$client->sub_domain");
      }
    }
  }
  /**
  * buscar cliente para el pago
  */
  public function searchClientFromPayment (Request $request, $url) {
    $request->session()->put('key-sesion', null);
    $client = Client::bySubDomain($url)->first();
    /**
    *
    */
    if (is_null($client)) {
      \Log::info('se ha intentado acceder al modulo de pago desde: '.$url);
      return redirect('/');
    }
    /**
    *
    */
   \Log::info('accediendo al modulo de pago desde: '.$url);
    return redirect("/payment?p=$client->remember_token");
  }
  /**
  * procesar pago
  */
  public function payment (Request $request) {
    $request->session()->put('key-sesion', null);
    $code = $request->query('p');
    /**
    *
    */
    if (is_null($code)) {
      return redirect('/solicitude')->with('errorMessage', trans('messages.invalid_code'));
    } else {
      $client = Client::byRememberToken($code)->first();
      if (is_null($client)) {
        return redirect('/solicitude')->with('errorMessage', trans('messages.invalid_client'));
      } else {
        $time = Price::all();
        $solicitude = Solicitude::byClient($client->id)->first();
        $test = Test::bySolicitude($solicitude->id)->first();
        $contract = Contract::bySolicitude($solicitude->id)->first();
        $billing = Billing::bySolicitude($solicitude->id)->first();
        $date = Carbon::now();
        /**
        * Se establecen precios dependiendo la version del software que solicito el cliente
        */
        switch ($solicitude->profile) {
          case HProfileType::BASIC:
            $time = Price::byType(HProfileType::BASIC)->get();
          break;
          /**
          *
          */
          case HProfileType::PROFESSIONAL:
            $time = Price::byType(HProfileType::PROFESSIONAL)->get();
          break;
        }
        /**
        *
        */
        if ($this->isGET($request)) {
          return view('main.payment', compact('client', 'time', 'solicitude', 'contract', 'billing'));
        }
        /**
        * Se valida si el cliente ralizo un pago y este no se ha registrado [debe recibir una respuesta]
        */
        if (is_null($contract) && !is_null($billing)) {
          return view('main.payment', compact('client', 'solicitude', 'time', 'billing'))->with('errorMessage', trans('payment.processinitial'));
        }
        /**
        *
        */
        $validator = $this->validatePaymentData($request, is_null($contract) ? $request->total : $billing->debt , is_null($contract));
        if (!is_null($validator)) {
          if ($validator->fails()) {
            return view('main.payment', compact('client', 'solicitude', 'time', 'billing'))->withErrors($validator);
          }
        }
        /**
        * 1) se verifica si el cliente ya posee un contrato para registrar un nuevo recibo o factura [receipt || billing]
        * 2) si el cliente posee un contrato activo, se extrae el recibo o factura asociada a ese contrato y se editan las columnas 'deuda' y 'proximo pago' [debt && next_pay]
        */
        if (is_null($contract)) {
          $data_billing = [
              'solicitude' => $solicitude->id,
              'total'      => $request->total,
              'debt'       => substract($request->total, $request->amount)
          ];
          $billing = Billing::create($data_billing);
        } else {
            $billing = Billing::bySolicitude($solicitude->id)->first();
            DB::table('billing')->where('id', '=', $billing->id)->update(['debt' => substract($billing->debt, $request->amount),'next_pay' => isZero($billing->debt) ? $contract->cut_off_date : $date->addMonth()]);
        }
        /**
        * se almacena el pago relacionado con un recibo
        */
        $payment = Payment::create($request->all());
        DB::table('payment')->where('id', '=', $payment->id)->update(['solicitude' => $solicitude->id , 'concept' => trans('payment.paytest').' '.$test->code, 'billing' => $billing->id]);
        /**
        * Se inserta este evento en el log
        */
        $data_log_register = [
          'client'      => $client->id,
          'solicitude'  => $solicitude->id,
          'status'      => HPayment::HOLD,
          'payment'     => $payment->id,
          'description' => trans('payment.hold')."(".$payment->code.")"
        ];
        $this->registerLog($data_log_register);
        /**
        * se realiza el envio de correo al cliente que registro el pago
        */
        try {
          Mail::send('emails.payment.payment-received', compact('client', 'solicitude', 'payment') , function($mail) use ($client) {
            $mail->from(env('ICS_MAIL_ADDRESS'));
            $mail->to($client->email , $client->name)
                 ->bcc(env('ICS_MAIL_ADDRESS'), $client->name)
                 ->subject(strtoupper(trans('messages.paymentreceived')));
          });
        } catch(\Exception $ex) {
            return view('errors.solicitude-exception', [
              'error'  => Session::get('errorMessage'),
              'client' => $client
            ]);
        }
        /**
        *
        */
        return view('main.payment.notify.payment-received', compact('client', 'payment'));
      }
    }
  }
  /**
  * gestionar otro tipo de pago [paypal..etc]
  */
  public function otherPayment (Request $request) {
    $request->session()->put('key-sesion', null);
    $code = $request->p;
    if (is_null($code)) {
      return redirect('/solicitude')->with('errorMessage', trans('messages.invalid_code'));
    } else {
        $client = Client::byRememberToken($code)->first();
        $solicitude = Solicitude::byClient($client->id)->first();
        if (is_null($client)) {
          return redirect('/solicitude')->with('errorMessage', trans('messages.invalid_client'));
        } else {
          if ($request->ajax()) {
              return view('main.payment.form-paypal', compact('client', 'solicitude'));
          }
          return redirect('/');
      }
    }
  }
  /**
  *
  */
  public function returnPayment (Request $request) {
    $request->session()->put('key-sesion', null);
    $code = $request->p;
    if (is_null($code)) {
      return redirect('/solicitude')->with('errorMessage', trans('messages.invalid_code'));
    } else {
      $client = Client::byRememberToken($code)->first();
      if (is_null($client)) {
        return redirect('/solicitude')->with('errorMessage', trans('messages.invalid_client'));
      } else {

      }
    }
    dd($request);
  }
  /**
  * Validar los datos de solicitud
  */
  private function validateSolicitudeData (Request $request) {
      return Validator::make($request->all(), [
        'name'        => 'required|string|min:5|max:100',
        'email'       => 'required|email|min:5|max:100|unique:client,email',
        'subject'     => 'required|string|min:5|max:20',
        'profile'     => 'required|not_in:0',
        'description' => 'required|string|min:5|max:200'
      ]);
  }
  /**
  * Validar datos cambio de contraseña
  */
  private function validateSolicitudePass (Request $request) {
      return Validator::make($request->all(), [
        'current'     => 'required|string|min:4|max:8',
        'pass'        => 'required|string|min:4|max:8',
      ]);
  }
  /**
  * Validar datos de contacto
  */
  private function validateContactData (Request $request) {
      return Validator::make($request->all(), [
        'name'    => 'required|string|min:5|max:100',
        'email'   => 'required|email|min:5|max:100',
        'subject' => 'required|string|min:5|max:20',
        'message' => 'required|string|min:5|max:200'
      ]);
  }
  /**
  * Validar datos de cliente
  */
  private function validateClientData (Request $request, $id = null) {
    return Validator::make($request->all(), [
      'name'              => 'required|string|min:5|max:100',
      'email'             => 'required|email|min:5|max:100|exists:client,email',
      'dni'               => 'required|string|min:5|max:20',
      'country'           => 'not_in:0|required|exists:country,id',
      'region'            => 'required|string|min:5|max:100',
      'city'              => 'required|string|min:5|max:100',
      'postal_code'       => 'required|string|min:4|max:100',
      'address'           => 'required|string|min:5|max:100',
      'phone'             => 'required|string|min:5|max:100',
      'email'             => 'required|email|min:5|max:100|unique:client,email' . (is_null($id) ? '' : ",$id"),
      'webpage'           => 'required|string|min:5|max:100',
      'name_manager'      => 'required|string|min:5|max:100',
      'last_name_manager' => 'required|string|min:5|max:100',
      'phone_manager'     => 'required|string|min:5|max:100',
      'email_manager'     => 'required|email|min:5|max:100|unique:client,email_manager'
    ]);
  }
  /**
  * Validar datos de pago
  */
  private function validatePaymentData (Request $request, $max, $contract) {
    return Validator::make($request->all(), [
      'years'       => 'not_in:0'.isset($contract) ? '|required' : '',
      'amount'      => 'required|numeric|min:1|max:'.$max,
      'bank'        => 'required|string',
      'transaction' => 'required|string|min:5|max:20|unique:payment,transaction',
      'attachment'  => 'required|file'
    ]);
  }

}
