<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Incidence;
use App\Models\Admin\Contract;
use App\Models\Admin\Test;
use App\Models\Admin\Client;
use App\Models\Admin\Notifiable;
use App\Models\Admin\User;
use Validator;
use DB;
use \Mail;
use App\Models\Admin\Email;
use App\Helpers\HUserType;

class IncidenceController extends Controller {
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
      $user  = $request->session()->get('key-sesion')['data'];
      /**
      *
      */
      if ($request->session()->get('key-sesion')['type'] == HUserType::SELLER  || $request->session()->get('key-sesion')['type'] == HUserType::WRITTER) {
        return redirect('/');
      }
      /**
      *
      */
      $incidences = DB::table('incidence')->join('test', 'incidence.test', '=', 'test.id')->join('client', 'test.client', '=', 'client.id')->select('incidence.*','client.name')->get();
      \Log::info('listado de incidencias visto por: '.$user->email);
      /**
      *
      */
      return view('pages.admin.incidence.list', compact('incidences'));
    }
    /**
    *
    */
    public function create (Request $request) {
      /**
      * se obtiene el email de la persona que registro la incidencia
      */
      $email = $request->all()['email'];
      /**
      * se obtiene cliente
      */
      $client = Client::byEmail($email)->first();
      /**
      * se valida cliente
      */
      if (is_null($client)) {
        return response()->json([
          'message'     => false ,
          'description' => trans('client.notFound')
        ]);
      }
      /**
      * 1) se obtiene prueba
      * 2) se obtiene contrato [opcional]
      */
      $test     = Test::byClient($client->id)->first();
      $contract = Contract::byTest($test->id)->first();
      /**
      * se valida la prueba
      */
      if (is_null($test)) {
        return response()->json([
          'message'     => false ,
          'description' => trans('test.notFound')
        ]);
      }
      /**
      *
      */
      $data_incidence = [
        'type'        => $request->all()['type'],
        'test'        => $test->id,
        'contract'    => (!is_null($contract) ? : null),
        'subject'     => $request->all()['subject'],
        'description' => $request->all()['description'],
        'img'         => $request->all()['image'],
        'profile'     => $request->all()['perfil']
      ];
      /**
      *
      */
      $incidence = Incidence::create($data_incidence);
      \Log::info('incidencia enviada por cliente: '.$client->code);
      /**
      *
      */
      return response()->json([
        'message'     => true ,
        'description' => trans('incidence.created', ['subject' => $incidence->subject]),
        'incidence'   => $incidence
      ]);
    }
    /**
    *
    */
    public function resolveIncidence (Request $request, $id , $incidence) {
      $test = Test::find($id);
      $incidence = Incidence::find($incidence);
      /**
      *
      */
      $user  = $request->session()->get('key-sesion')['data'];
      /**
      *
      */
      if (is_null($test) || is_null($incidence)) {
        return response()->json([
          'message'     => true,
          'description' => trans('incidence.notFound')
        ]);
      }
      /**
      *
      */
      DB::table('incidence')->where('id', '=', $incidence->id)->update(['status' => true, 'admin' => $user->id]);
     \Log::info('incidencia resuelta por: '.$user->email);
      /**
      * se envia correo
      */
      $client = Client::find($test->client);
      $users = User::byType(HUserType::SELLER)->get();
      $emails = array(env('ICS_MAIL_ADDRESS'));
      $notifiable = Notifiable::all();
      /**
      * 1) se verifican usuarios autorizados para recibir correos
      * 2) Se almacenan las direcciones de correo
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
        Mail::send('emails.incidence.incidence-resolve', compact('client' , 'incidence') , function($mail) use ($client, $emails) {
          $mail->from(env('ICS_MAIL_ADDRESS'));
          $mail->to($client->email, $client->name)
               ->bcc($emails, $client->name)
               ->subject(strtoupper(trans('incidence.Resolved')));
        });
      } catch(\Exception $ex) {
          return response()->json([
            'message'     => true,
            'description' => trans('email.notsend'),
            'error'       => $ex->getMessage()
          ]);
      }
      /**
      *
      */
      return response()->json([
        'message'     => true,
        'description' => trans('incidence.resolved')
      ]);
    }
    /**
    *
    */
    public function resolveBug (Request $request, $id , $bug) {
      $test = Test::find($id);
      $bug  = Incidence::find($bug);
      /**
      *
      */
      $user  = $request->session()->get('key-sesion')['data'];
      /**
      *
      */
      if (is_null($test) || is_null($bug)) {
        return response()->json([
          'message'     => true,
          'description' => trans('incidence.notFound')
        ]);
      }
      /**
      *
      */
      DB::table('incidence')->where('id', '=', $bug->id)->update(['status' => true, 'admin' => $user->id]);
      \Log::info('error resuelto por: '.$user->email);
      /**
      *
      */
      return response()->json([
        'message'     => true,
        'description' => trans('incidence.resolved')
      ]);
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
      if ($request->session()->get('key-sesion')['type'] == HUserType::WRITTER ) {
        return redirect('/');
      }
      $user = $request->session()->get('key-sesion')['data'];
      /**
      *
      */
      $incidence = Incidence::find($id);
      /**
      *
      */
      if(is_null($incidence)) {
        return $this->doRedirect($request, '/admin/incidences')->with('errorMessage', trans('incidence.notFound'));
      }
      /**
      *
      */
      $incidence->delete();
      \Log::info('incidencia borrada por: '.$user->email);
      /**
      *
      */
      return $this->doRedirect($request, '/admin/incidences')->with('successMessage', trans('incidence.deleted', [
        'id' => $incidence->id
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
      if ($request->session()->get('key-sesion')['type'] == HUserType::WRITTER ) {
        return redirect('/');
      }
      $user = $request->session()->get('key-sesion')['data'];
      /**
      *
      */
      $incidence = Incidence::find($id);
      /**
      *
      */
      if ($this->isGet($request)) {
        \Log::info('incidencia visualizada por: '.$user->email);
        return view('pages.admin.incidence.view', compact('incidence'));
      }
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
      $user  = $request->session()->get('key-sesion')['data'];
      /**
      *
      */
      if ($request->session()->get('key-sesion')['type'] == HUserType::WRITTER ) {
        return redirect('/');
      }
      /**
      *
      */
      $incidence = Incidence::find($id);
      if (is_null($incidence)) {
        return $this->doRedirect($request, '/admin/incidences')->with('errorMessage', trans('incidence.notFound'));
      }
      /**
      *
      */
      $test   = Test::find($incidence->test);
      $client = Client::find($test->client);
      /**
      *
      */
      $contact = $client;
      /**
      *
      */
      $vars = [
        'contact' => $contact,
        'path'    => "admin/incidences/{$incidence->id}/mail"
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
          return view('pages.admin.mail', $vars )
            ->withErrors($validator);
        }
      }
      /**
      *
      */
      $response = $request->all();

      /**
      *
      */
      try {
        Mail::send('emails.message-contact', compact('contact', 'response') , function($mail) use ($contact, $request) {
          $mail->from(env('ICS_MAIL_ADDRESS'));
          $mail->to($contact->email , $contact->name)
               ->bcc(env('ICS_MAIL_ADDRESS'), $contact->name)
               ->subject(strtoupper($request->all()['subject']));
        });
        /**
        * Se almacena la respuesta
        */
        $email = Email::create($request->all());
        DB::table('incidence')->where('id', '=', $email->id)->update(['admin' => $user->id, 'asnwer' => $request->message]);
        \Log::info('correo enviado por: '.$user->email);
        /**
        *
        */
        return $this->doRedirect($request, '/admin/incidences')->with('successMessage', trans('contact.sendmail',[
          'name' => $contact->name
        ]));
      } catch(\Exception $ex) {
        return $this->doRedirect($request, '/admin/incidences')->with('errorMessage', trans('contact.errormail',[
          'error' => $ex->getMessage()
        ]));
      }

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
