<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Test;
use App\Models\Admin\Status;
use App\Models\Admin\Client;
use App\Models\Admin\Solicitude;
use App\Models\Admin\Incidence;
use App\Models\Admin\Log;
use App\Models\Admin\Contract;
use App\Helpers\HUserType;
use App\Models\Admin\Email;
use App\Helpers\HStatus;
use App\Helpers\HAccess;
use Validator;
use \Mail;
use DB;
use Carbon\Carbon;

class TestController extends Controller {
    /**
    *
    */
    public function __construct (Request $request) {
      $this->middleware('requireAccess:' . HAccess::TESTS);
    }
    /**
    * Listado de incidencias
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
      $tests = Test::all();
      /**
      *
      */
      if ($request->session()->get('key-sesion')['type'] == HUserType::WRITTER ) {
        return redirect('/');
      } elseif ($request->session()->get('key-sesion')['type'] == HUserType::SELLER ) {
        $tests = Test::byUser($user->id)->get();
      }
      /**
      *
      */
      \Log::info('listado de pruebas visto por: '.$user->email);
      return view('pages.admin.test.list', compact('tests'));
    }
    /**
    * Borrar una prueba
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
      $user  = $request->session()->get('key-sesion')['data'];
      /**
      *
      */
      $test = Test::find($id);
      /**
      *
      */
      if(is_null($test)) {
        return $this->doRedirect($request, '/admin/tests')->with('errorMessage', trans('test.notFound'));
      }
      /**
      *
      */
      $test->delete();
      \Log::info('prueba borrada por: '.$user->email);
      return $this->doRedirect($request, '/admin/tests')->with('successMessage', trans('test.deleted', [
        'code' => $test->code
      ]));
    }
    /**
    * Editar una prueba
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
      $user = $request->session()->get('key-sesion')['data'];
      $test = Test::find($id);
      /**
      *
      */
      if (is_null($test)) {
        return $this->doRedirect($request, '/admin/tests')->with('errorMessage', trans('test.notFound'));
      }
      /**
      *
      */
      $status = Status::all();
      $client = Client::find($test->client);
      $logs   = Log::byTest($test->id)->get();
      /**
      *
      */
      if ($request->session()->get('key-sesion')['type'] == HUserType::WRITTER ) {
        return redirect('/');
      }/* elseif ($request->session()->get('key-sesion')['type'] == HUserType::SELLER ) {
        $test = Test::byUser($user->id)->first();
      }*/
      /**
      *
      */
      if ($this->isGET($request)) {
        if($request->ajax()) {
          return view('pages.admin.test.view', compact('user', 'status', 'logs', 'test'));
        }
        return redirect('/admin/tests');
      }
      /**
      *
      */
      $parse_date = Carbon::parse($test->cutoff_date);
      $test->status = $request->all()['status'];
      $test->save();
      /**
      *
      */
      switch ($request->status) {
        case HStatus::ACTIVE :
            DB::table('test')->where('id', '=', $test->id)->update(['cutoff_date' => $parse_date->addDays(30)]);
          break;
        case HStatus::EXTENDED :
            DB::table('test')->where('id', '=', $test->id)->update(['cutoff_date' => $parse_date->addDays(15)]);
          break;
      }
      /**
      * Se inserta este evento en el log
      */
      $data_log_register = [
        'admin'       => $user->id,
        'client'      => $client->id,
        'test'        => $test->id,
        'status'      => $request->status,
        'description' => is_null($request->description) ? trans('messages.unknown') : $request->description
      ];
      $this->registerLog($data_log_register);
      \Log::info('prueba editada por: '.$user->email);
      /**
      * Return Response to client
      */
      return response()->json([
        "message" => true
      ]);
    }
    /**
    * enviar un correo al cliente actual de la prueba
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
      $test = Test::find($id);
      /**
      *
      */
      if(is_null($test)) {
        return $this->doRedirect($request, '/admin/tests')->with('errorMessage', trans('test.notFound'));
      }
      /**
      *
      */
      $client =  Client::find($test->client);
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
        'path'     => "admin/tests/{$test->id}/mail",
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
        return $this->doRedirect($request, '/admin/tests')->with('successMessage', trans('contact.sendmail',[
          'name' => $contact->name
        ]));
      } catch(\Exception $ex) {
        return $this->doRedirect($request, '/admin/tests')->with('errorMessage', trans('contact.errormail',[
          'error' => $ex->getMessage()
        ]));
      }
    }
    /**
    * contratar una prueba
    */
    public function contract (Request $request, $id) {
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
      $test = Test::find($id);
      /**
      *
      */
      if(is_null($test)) {
        return $this->doRedirect($request, '/admin/tests')->with('errorMessage', trans('tests.notFound'));
      }
      /**
      *
      */
      $contract_test = Contract::byTest($test->id)->first();
      if (!is_null($contract_test)) {
        return $this->doRedirect($request, '/admin/tests')->with('errorMessage', trans('test.contrated',[
          'code' => $test->code
        ]));
      }
      /**
      *
      */
      $solicitude = Solicitude::find($test->solicitude);
      /**
      *
      */
      if ($request->session()->get('key-sesion')['type'] == HUserType::WRITTER ) {
        return redirect('/');
      } elseif ($request->session()->get('key-sesion')['type'] == HUserType::SELLER ) {
        $test = Test::byUser($user->id)->get();
      }
      /**
      *
      */
      $data_contract = [
        'solicitude' => $solicitude->id,
        'test'       => $test->id
      ];
      $contract = Contract::create($data_contract);
      \Log::info('prueba movida a contrato por: '.$user->email);
      /**
      *
      */
      return $this->doRedirect($request, '/admin/tests')->with('successMessage', trans('contract.created',[
        'code' => $contract->code
      ]));
    }
    /**
    * Retorna todas las pruebas para ser verificadas en javascript
    */
    public function ajaxAll (Request $request) {
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
      $tests = DB::table('test')->join('client', 'test.client', '=', 'client.id')->select('client.email', 'client.sub_domain' ,'test.id')->get();
      /**
      *
      */
      if ($request->session()->get('key-sesion')['type'] == HUserType::WRITTER ) {
        return redirect('/');
      } elseif ($request->session()->get('key-sesion')['type'] == HUserType::SELLER ) {
        $tests = Test::byUser($user->id)->get();
      }
      /**
      *
      */
      if($request->ajax()) {
        return response()->json([
          'message' => true,
          'tests'   => $tests
        ]);
       }
       return redirect('admin/tests');
    }
    /**
    * verfica el estatus de una prueba
    */
    public function apiClient (Request $request, $url) {

        $client = Client::bySubDomain($url)->first();
        /**
        * se verifica el cliente
        */
        if (is_null($client)) {
          return response()->json([
            'message'     => false,
            'description' => trans('client.notFound')
          ]);
        }
        /**
        * se busca la prueba asociada a este cliente
        */
        $test = Test::byClient($client->id)->first();
        /**
        *
        */
        if (is_null($test)) {
          return response()->json([
            'message' => false,
            'test'    => null,
            'description' => 'No se ha agregado a prueba'
          ]);
        }
        /**
        *
        */
        return response()->json([
          'message' => true,
          'tests'   => $test,
          'client'  => $client
        ]);
    }
    /**
    * revisar terminos y condiciones
    */
    public function review (Request $request, $id) {
      $test = Test::find($id);
      /**
      *
      */
      if (is_null($test)) {
        return response()->json([
          'message'     => false,
          'description' => trans('test.notFound')
        ]);
      }
      /**
      * se configura data para editar
      */
      $data = [
        'accept_terms'      => $request->status == "true" ? true : null,
        'date_accept_terms' => $request->date,
        'operators'         => $request->operators,
        'clients'           => $request->clients
      ];
      /**
      * se edita la prueba
      */
      $test->update($data);
      /**
      * se envia el json
      */
      return response()->json([
        'message'     => true
      ]);
    }
    /**
    * mostrar incidencias[ayudas] reportadas a una prueba
    */
    public function incidence (Request $request, $id) {
      /**
      *
      */
      if(is_null($request->session()->get('key-sesion'))) {
        return redirect('login');
      }
      /**
      *
      */
      $user   = $request->session()->get('key-sesion')['data'];
      $test  = Test::find($id);
      /**
      *
      */
      if (is_null($test)) {
        return $this->doRedirect($request, '/admin/tests')->with('errorMessage', trans('test.notFound'));
      }
      /**
      *
      */
      $client = Client::find($test->client);
      /**
      *
      */
      $incidences    = Incidence::byTestNotResolveIncidence($test->id)->get();
      $allIncidences = Incidence::byTypeTest(1, $test->id)->get();
      /**
      *
      */
      if ($request->session()->get('key-sesion')['type'] == HUserType::WRITTER ) {
        return redirect('/');
      } elseif ($request->session()->get('key-sesion')['type'] == HUserType::SELLER ) {
        if ($user->id != $test->admin) {
          return $this->doRedirect($request, '/admin/clients')->with('errorMessage', trans('client.unauthorized'));
        }
      }
      /**
      *
      */
      if ($this->isGET($request)) {
        \Log::info('incidencia visualizada por: '.$user->email);
        return view('pages.admin.test.incidences', compact('incidences', 'test', 'client', 'allIncidences'));
      }

    }
    /**
    * mostrar errores reportados a una prueba
    */
    public function bug (Request $request, $id) {
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
      $test = Test::find($id);
      /**
      *
      */
      if (is_null($test)) {
        return $this->doRedirect($request, '/admin/tests')->with('errorMessage', trans('test.notFound'));
      }
      /**
      *
      */
      $client = Client::find($test->client);
      /**
      *
      */
      $bugs = Incidence::byTestNotResolveBugs($test->id)->get();
      $allBugs = Incidence::byTypeTest(0, $test->id)->get();
      /**
      *
      */
      if ($request->session()->get('key-sesion')['type'] == HUserType::WRITTER ) {
        return redirect('/');
      } elseif ($request->session()->get('key-sesion')['type'] == HUserType::SELLER ) {
        if ($user->id != $test->admin) {
          return $this->doRedirect($request, '/admin/clients')->with('errorMessage', trans('client.unauthorized'));
        }
      }
      /**
      *
      */
      if ($this->isGET($request)) {
        \Log::info('error visualizado por: '.$user->email);
        return view('pages.admin.test.bugs', compact('bugs', 'test', 'client', 'allBugs'));
      }
    }
    /**
    *
    */
    public function showTerms (Request $request, $id) {
      $test = Test::find($id);
      $user  = $request->session()->get('key-sesion')['data'];
      \Log::info('terminos y condiciones de prueba '.$test->code.' visualizada por: '.$user->email);
      return response()->json([
        'message' => true,
        'terms'   => $test->date_accept_terms
      ]);
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
