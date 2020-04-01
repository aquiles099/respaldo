<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Contract;
use App\Models\Admin\Client;
use App\Models\Admin\Test;
use App\Helpers\HUserType;
use App\Helpers\HAccess;
use DB;
use Validator;
use App\Models\Admin\Email;
use App\Models\Admin\Solicitude;
use App\Models\Admin\Incidence;
use App\Models\Admin\Billing;
use App\Models\Admin\Status;
use App\Models\Admin\Payment;
use \Mail;
use PDF;

class ContractController extends Controller {
    /**
    *
    */
    public function __construct (Request $request) {
      $this->middleware('requireAccess:' . HAccess::CLIENTS);
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
      $user      = $request->session()->get('key-sesion')['data'];
      $contracts = Contract::all();
      /**
      *
      */
      if ($request->session()->get('key-sesion')['type'] == HUserType::WRITTER ) {
        return redirect('/');
      } elseif ($request->session()->get('key-sesion')['type'] == HUserType::SELLER ) {
        $contracts = DB::table('contract')->join('solicitude', 'contract.id', '=', 'solicitude.id')->where('solicitude.admin', '=', $user->id)->get();
      }
      /**
      *
      */
      $vars = [
          'user'      => $user,
          'contracts' => $contracts
      ];
      /**
      *
      */
      \Log::info('listado de contratos visto por: '.$user->email);
      /**
      *
      */
      return view('pages.admin.contract.list', $vars);
    }
    /*
    * Delete contracts
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
      $contract = Contract::find($id);
      /**
      *
      */
      if(is_null($contract)) {
        $this->doRedirect($request, '/admin/contracts')->with('errorMessage', trans('contract.notFound'));
      }
      /**
      *
      */
      $contract->delete();
      /**
      *
      */
      \Log::info('contrato borrado por: '.$user->email);
      /**
      *
      */
      $this->doRedirect($request, '/admin/contracts')->with('successMessage', trans('contract.deleted', [
        'code' => $contract->code
      ]));
      /**
      *
      */
      return $this->doRedirect($request, '/admin/contracts');
     }
    /**
    *
    */
    public function create (Request $request) {
      dd($request->all());
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
      $user = $request->session()->get('key-sesion')['data'];
      /**
      *
      */
      if ($request->session()->get('key-sesion')['type'] == HUserType::WRITTER || $request->session()->get('key-sesion')['type'] == HUserType::SELLER) {
        return redirect('/');
      }
      /**
      *
      */
      $contract = Contract::find($id);
      /**
      *
      */
      if(is_null($contract)) {
        return $this->doRedirect($request, '/admin/contracts')->with('errorMessage', trans('contract.notFound'));
      }
      /**
      *
      */
      $solicitude = Solicitude::find($contract->solicitude);
      $client     = Client::find($solicitude->id);
      $status     = Status::all();
      /**
      *
      */
      if ($this->isGet($request)) {
        return view('pages.admin.contract.edit', compact('contract', 'client', 'status'));
      }
      /**
      *
      */
      $validator = $this->validateData($request);
      if (!is_null($validator)) {
        if ($validator->fails()) {
          return view('pages.admin.contract.edit', compact('contract', 'client', 'status'))->withErrors($validator);
        }
      }
      /**
      *
      */
      $contract->update($request->all());
      $contract->save();
      /**
      *
      */
      \Log::info('contrato editado por: '.$user->email);
      /**
      *
      */
      return $this->doRedirect($request, '/admin/contracts')->with('successMessage', trans('contract.updated', [
        'code' => $contract->code
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
      $contract = Contract::find($id);
      /**
      *
      */
      if(is_null($contract)) {
        return $this->doRedirect($request, '/admin/contracts')->with('errorMessage', trans('contract.notFound'));
      }
      /**
      *
      */
      $test = Test::find($contract->test);
      if (is_null($test)) {
        return $this->doRedirect($request, '/admin/contracts')->with('errorMessage', trans('test.notFound'));
      }
      /**
      *
      */
      $client = Client::find($test->client);
      if (is_null($client)) {
        return $this->doRedirect($request, '/admin/contracts')->with('errorMessage', trans('client.notFound'));
      }
      /**
      *
      */
      if ($request->session()->get('key-sesion')['type'] == HUserType::WRITTER ) {
        return redirect('/');
      } else if ($request->session()->get('key-sesion')['type'] == HUserType::SELLER ) {
        if ($client->admin != $user->user_type) {
          return $this->doRedirect($request, '/admin/contracts')->with('errorMessage', trans('test.unauthorized'));
        }
      }
      /**
      *
      */
      $vars = [
        'contact'  => $client,
        'path'     => "admin/contracts/{$contract->id}/mail",
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
        /**
        *
        */
        \Log::info('correo enviado por: '.$user->email);
        /**
        *
        */
        return $this->doRedirect($request, '/admin/contracts')->with('successMessage', trans('contact.sendmail',[
          'name' => $contact->name
        ]));
      } catch(\Exception $ex) {
        return $this->doRedirect($request, '/admin/contracts')->with('errorMessage', trans('contact.errormail',[
          'error' => $ex->getMessage()
        ]));
      }
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
      $user = $request->session()->get('key-sesion')['data'];
      /**
      *
      */
      if ($request->session()->get('key-sesion')['type'] == HUserType::WRITTER || $request->session()->get('key-sesion')['type'] == HUserType::SELLER) {
        return redirect('/');
      }
      /**
      *
      */
      $contract = Contract::find($id);
      /**
      *
      */
      if(is_null($contract)) {
        return $this->doRedirect($request, '/admin/contracts')->with('errorMessage', trans('contract.notFound'));
      }
      /**
      *
      */
      $solicitude = Solicitude::find($contract->solicitude);
      $client     = Client::find($solicitude->client);
      $status     = Status::all();
      $test       = Test::bySolicitude($solicitude->id)->first();
      /**
      *
      */
      if ($this->isGet($request)) {
        if ($request->ajax()) {
          return view('pages.admin.contract.view', compact('contract', 'client', 'status', 'solicitude', 'test'));
        }
        /**
        *
        */
        \Log::info('contrato visualizado por: '.$user->email);
        /**
        *
        */
        return redirect('/admin/cotnracts');
      }
    }
    /**
    * Exportar contrato
    */
    public function contract (Request $request, $id) {
      $user = $request->session()->get('key-sesion')['data'];
      /**
      *
      */
      $contract = Contract::find($id);
      /**
      *
      */
      if (is_null($contract)) {
        return redirect('/admin/contracts');
      }
      /**
      *
      */
      $solicitude = Solicitude::find($contract->solicitude);
      $client = Client::find($solicitude->client);
      $pdf = PDF::loadView('pages.admin.contract.pdf', compact('contract', 'solicitude', 'client'));
      /**
      *
      */
      \Log::info('dcocumento de contrato generado por: '.$user->email);
      /**
      *
      */
      return $pdf->stream($client->webpage.'-contract.pdf');
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
      $user = $request->session()->get('key-sesion')['data'];
      $contract  = Contract::find($id);
      /**
      *
      */
      if (is_null($contract)) {
        return $this->doRedirect($request, '/admin/contracts')->with('errorMessage', trans('contract.notFound'));
      }
      /**
      *
      */
      $client = Client::find($contract->client);
      /**
      *
      */
      $incidences    = Incidence::byContractNotResolveIncidence($contract->id)->get();
      $allIncidences = Incidence::byTypeContract(1, $contract->id)->get();
      /**
      *
      */
      if ($request->session()->get('key-sesion')['type'] == HUserType::WRITTER ) {
        return redirect('/');
      } elseif ($request->session()->get('key-sesion')['type'] == HUserType::SELLER ) {
        if ($user->id != $contract->admin) {
          return $this->doRedirect($request, '/admin/contracts')->with('errorMessage', trans('client.unauthorized'));
        }
      }
      /**
      *
      */
      if ($this->isGET($request)) {
        /**
        *
        */
        \Log::info('incidencias de contratos vistar por: '.$user->email);
        /**
        *
        */
        return view('pages.admin.contract.incidences', compact('incidences', 'contract', 'client', 'allIncidences'));
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
      $contract = Contract::find($id);
      /**
      *
      */
      if (is_null($contract)) {
        return $this->doRedirect($request, '/admin/contracts')->with('errorMessage', trans('contract.notFound'));
      }
      /**
      *
      */
      $client = Client::find($contract->client);
      /**
      *
      */
      $bugs = Incidence::byContractNotResolveBugs($contract->id)->get();
      $allBugs = Incidence::byTypeContract(0, $contract->id)->get();
      /**
      *
      */
      if ($request->session()->get('key-sesion')['type'] == HUserType::WRITTER ) {
        return redirect('/');
      } elseif ($request->session()->get('key-sesion')['type'] == HUserType::SELLER ) {
        if ($user->id != $contract->admin) {
          return $this->doRedirect($request, '/admin/contracts')->with('errorMessage', trans('client.unauthorized'));
        }
      }
      /**
      *
      */
      if ($this->isGET($request)) {
        /**
        *
        */
        \Log::info('errores de contratos vistar por: '.$user->email);
        /**
        *
        */
        return view('pages.admin.contract.bugs', compact('bugs', 'contract', 'client', 'allBugs'));
      }
    }
    /**
    * retorna un contrato asociado a un cliente
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
        * 1) se busca la prueba asociada a este cliente
        * 2) se busca el contrato que resulto al pagar la prueba
        */
        $test = Test::byClient($client->id)->first();
        /**
        * se valida la prueba
        */
        if (is_null($test)) {
          return response()->json([
            'message' => false,
            'test'    => null,
            'description' => 'No se ha agregado a pruebas'
          ]);
        }
        $contract = Contract::byTest($test->id)->first();
        /**
        * se valida la prueba
        */
        if (is_null($contract)) {
          return response()->json([
            'message' => false,
            'test'    => null,
            'description' => 'No se ha agregado a contratos'
          ]);
        }
        /**
        * se valida el contrato
        */
        return response()->json([
          'message'  => true,
          'contract' => $contract,
          'client'   => $client
        ]);
    }
    /**
     *
     */
     public function payments (Request $request, $id) {

       $user = $request->session()->get('key-sesion')['data'];
       $contract = Contract::find($id);
       if (is_null($contract)) {
         return $this->doRedirect($request, '/admin/contracts')->with('errorMessage', trans('contract.notFound'));
       }
     /**
      *
      */
      $solicitude = Solicitude::find($contract->solicitude);
      if (is_null($solicitude)) {
        return $this->doRedirect($request, '/admin/contracts')->with('errorMessage', trans('solicitude.notFound'));
      }
      /**
      *
      */
      $billing = Billing::bySolicitude($solicitude->id)->first();
      if (is_null($billing)) {
        return $this->doRedirect($request, '/admin/contracts')->with('errorMessage', trans('billing.notFound'));
      }
      /**
      *
      */
      $client = Client::find($solicitude->client);
      if (is_null($client)) {
        return $this->doRedirect($request, '/admin/payments')->with('errorMessage', trans('client.notFound'));
      }
      /**
       *
       */
      $payments = Payment::byBilling($billing->id)->get();
      /**
      * Se inicializan lbrerias para generar reporte [FPDF & FPDI]
      */
      $fpdi = new \fpdi\FPDI();
      $fpdf = new \fpdf\FPDF();
      /**
       *
       */
       $pdf = $fpdi->setSourceFile('src/docs/payment-receipt.pdf');
       $tplIdx = $fpdi->importPage(1, '/BleedBox');
       $fpdi->SetTitle($client->webpage.'-'.trans('messages.paymentreceipt').'-'.$billing->code);
       /**
       * Se crea la plantilla para el pdf
       */
       $fpdi->addPage();
       $fpdi->useTemplate($tplIdx, 10, 10, 190);
       /**
       *
       */
       \Log::info('recibo de pago visto por: '.$user->email);
       $fpdi->Output();
     }
    /**
    *
    */
    private function validateData (Request $request) {
        return Validator::make($request->all(), [
          'register_date' => 'required|date',
          'cut_off_date'  => 'required|date',
          'status'        => 'required'
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
