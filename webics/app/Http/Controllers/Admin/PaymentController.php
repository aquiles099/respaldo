<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\HUserType;
use App\Models\Admin\Payment;
use App\Models\Admin\Client;
use App\Models\Admin\Contract;
use App\Models\Admin\Email;
use App\Models\Admin\Solicitude;
use App\Models\Admin\Log;
use App\Models\Admin\Test;
use App\Models\Admin\Billing;
use DB;
use Validator;
use \Mail;
use Carbon\Carbon;
use App\Helpers\HPayment;
use App\Helpers\HStatus;
use App\Helpers\HYears;
use App\Helpers\HAccess;
use PDF;

class PaymentController extends Controller {

  public function __construct (Request $request) {
    $this->middleware('requireAccess:' . HAccess::PAYMENTS);
  }
  /**
  * Listado de pagos
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
    /**
    *
    */
    if ($request->session()->get('key-sesion')['type'] != HUserType::MASTER ) {
      return redirect('/');
    }
    /**
    *
    */
    $payments = Payment::all();
    /**
    *
    */
    \Log::info('listado de pagos visto por: '.$user->email);
    /**
    *
    */
    return view('pages.admin.payment.list', compact('payments'));
  }
  /**
  * Ver y modificar status de pago
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
    if ($request->session()->get('key-sesion')['type'] != HUserType::MASTER ) {
      return redirect('/');
    }
    /**
    *
    */
    $payment= Payment::findOrFail($id);
    $solicitude = Solicitude::findOrFail($payment->solicitude);
    $client = Client::findOrFail($solicitude->client);
    $status = $this->paymentStatus();
    $log = Log::byPayment($payment->id)->get();
    $contract = Contract::bySolicitude($solicitude->id)->first();
    $test = Test::bySolicitude($solicitude->id)->first();
    /**
    *
    */
    if ($this->isGET($request)) {
      if ($request->ajax()) {
        \Log::info('pago visualizado por: '.$user->email);
        return view('pages.admin.payment.view', compact('payment', 'client', 'contract', 'status', 'log', 'test'));
      }
      return redirect('admin/payments');
    }
    /**
    *
    */
    $payment->update($request->all());
    $payment->save();
    /**
    * Se inserta este evento en el log
    */
    $data_log_register = [
      'admin'       => $user->id,
      'client'      => $client->id,
      'solicitude'  => $solicitude->id,
      'status'      => $request->status == HPayment::DENIED ? HPayment::DENIED : HPayment::APROVED,
      'payment'     => $payment->id,
      'description' => $request->description
    ];
    $this->registerLog($data_log_register);
    /**
    *
    */
    try {
      Mail::send('emails.payment.response-payment', compact('client', 'solicitude', 'payment') , function($mail) use ($solicitude, $client, $payment) {
        $mail->from(env('ICS_MAIL_ADDRESS'));
        $mail->to($client->email , $client->name)
             ->bcc(env('ICS_MAIL_ADDRESS'), $client->name)
             ->subject(strtoupper($payment->status == HPayment::DENIED ? trans('payment.deniedpayment') : trans('payment.aprovedpayment')));
      });
    } catch(\Exception $ex) {
        return response()->json([
          "message"     => false,
          "description" => $ex->getMessage()
        ]);
    }
    \Log::info('estado de pago modificado por: '.$user->email);
    /**
    *  Se crea el contrato si el mismo no existe y ademas si el pago se ha registrado con status 'Aprobado'
    * [3] = pago aprobado
    */
     if ($payment->status == '3' && is_null($contract)) {
       $this->doContract($solicitude, $payment);
     } else {
       if (!is_null($contract)) {
         DB::table('contract')->where('id', '=', $contract->id)->update(['status' => HStatus::ACTIVE]);
       }
     }
    /**
    *
    */
    return response()->json([
      "message" => true
    ]);
  }
  /**
  * 1) se obtiene y valida la solicitud
  * 2) se obtiene la prueba usando como parametro el id de la solicitud
  * 3) se crea el contrato a partir de los datos obtenidos anteriormente
  */
  public function doContract ($solicitude, $payment) {
      $date = Carbon::now();
      $register_date = Carbon::now();
      $cut_off_date  = $date;
      /**
      * se valida la solicitud
      */
      if (is_null($solicitude)) {
        return response()->json([
          "message"     => true,
          "description" => trans('contract.fail')
        ]);
      }
      /**
      * se valida la prueba
      */
      $test = Test::bySolicitude($solicitude->id)->first();
      if (is_null($test)) {
        return response()->json([
          "message"     => true,
          "description" => trans('contract.fail')
        ]);
      }
      /**
      * dependiendo el pago se establecen fechas de contrato [inicio y corte]
      */
      switch ($payment->years) {
        case HYears::ONE:
          $cut_off_date  = $date->addYear();
        break;
        /**
        * para contrato de dos años
        */
        case HYears::TWO:
          $cut_off_date  = $date->addYears(HYears::TWO);
        break;
        /**
        * para contrato de tres años
        */
        case HYears::TRHEE:
          $cut_off_date  = $date->addYears(HYears::TRHEE);
        break;
        /**
        * default
        */
        default:
          return response()->json([
            "message"     => true,
            "description" => trans('contract.fail')
          ]);
        break;
      }
      /**
      * se configura la data del contrato
      */
      $contract_data = [
        'solicitude'    => $solicitude->id,
        'test'          => $test->id,
        'status'        => HStatus::ACTIVE,
        'register_date' => $register_date,
        'cut_off_date'  => $cut_off_date
      ];
      $contract = Contract::create($contract_data);
      \Log::info('la prueba: '.$test->code.' se agrego a contratos mediante el pago: '.$payment->code);
      /**
       * 1) se establece la fecha del proximo pago.
       * 2) se toma en cuenta la deuda existente.
       * 3) si el cliente no posee deuda se iguala la fecha de proximo pago a la fecha de corte del contrato.
       * 4) si el cliente posee deuda se iguala la fecha de pago.
       */
      $billing = Billing::bySolicitude($solicitude->id)->first();
      DB::table('billing')->where('solicitude', '=', $solicitude->id)->update(['next_pay' => isZero($billing->debt) ? $contract->cut_off_date : $date->addMonth()]);
  }
  /**
  * Borrar pago
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
    if ($request->session()->get('key-sesion')['type'] == HUserType::SELLER ) {
      return redirect('/');
    }
    $user = $request->session()->get('key-sesion')['data'];
    /**
    *
    */
    $payment = Payment::findOrFail($id);
    /**
    *
    */
    if(is_null($payment)) {
      $this->doRedirect($request, '/admin/payments')->with('errorMessage', trans('payment.notFound'));
    }
    /**
    *
    */
    $payment->delete();
    \Log::info('pago borrado por: '.$user->email);
    return $this->doRedirect($request, '/admin/payments')->with('successMessage', trans('payment.deleted', [
      'code' => $payment->code
    ]));
  }
  /**
  * Enviar correo
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
    $payment = Payment::findOrFail($id);
    /**
    *
    */
    if(is_null($payment)) {
      return $this->doRedirect($request, '/admin/payments')->with('errorMessage', trans('payment.notFound'));
    }
    /**
    *
    */
    $solicitude = Solicitude::findOrFail($payment->solicitude);
    $client = Client::findOrFail($solicitude->client);
    /**
    *
    */
    if ($request->session()->get('key-sesion')['type'] != HUserType::MASTER ) {
      return redirect('/');
    }
    /**
    *
    */
    $vars = [
      'contact'  => $client,
      'path'     => "admin/payments/{$payment->id}/mail",
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
      return $this->doRedirect($request, '/admin/payments')->with('successMessage', trans('contact.sendmail',[
        'name' => $contact->name
      ]));
    } catch(\Exception $ex) {
      return $this->doRedirect($request, '/admin/payments')->with('errorMessage', trans('contact.errormail',[
        'error' => $ex->getMessage()
      ]));
    }
  }
  /**
  * Descargar adjunto de pago
  */
  public function attachment (Request $request, $id) {
    $pre_path = "www.";
    /**
    *
    */
    if(is_null($request->session()->get('key-sesion'))) {
      return redirect('login');
    }
    /**
    *
    */
    if ($request->session()->get('key-sesion')['type'] != HUserType::MASTER ) {
      return redirect('/');
    }
    /**
    *
    */
    $user = $request->session()->get('key-sesion')['data'];
    $payment = Payment::findOrFail($id);
    $asset = asset('/');
    /**
    * se verifica la existencia de www  en el path del adjunto
    */
    if (strpos($asset, $pre_path)) {
      $asset = str_replace($pre_path, "", $asset);
    }
    $file = public_path().str_replace($asset, "/", $payment->attachment);
    /**
    *
    */
    $date = Carbon::now();
    $date->format('Y-m-d');
    \Log::info('archivo descargado por: '.$user->email);
    return response()->download($file);
  }
  /**
  *
  */
  public function invoice (Request $request, $id) {

    $user = $request->session()->get('key-sesion')['data'];
    if (is_null($user)) {
      return redirect('login');
    }
    /**
    *
    */
    $payment = Payment::find($id);
    if (is_null($payment)) {
      return $this->doRedirect($request, '/admin/payments')->with('errorMessage', trans('payment.notFound'));
    }
    /**
    *
    */
    $solicitude = Solicitude::find($payment->solicitude);
    if (is_null($solicitude)) {
      return $this->doRedirect($request, '/admin/payments')->with('errorMessage', trans('solicitude.notFound'));
    }
    /**
    *
    */
    $client = Client::find($solicitude->client);
    if (is_null($client)) {
      return $this->doRedirect($request, '/admin/payments')->with('errorMessage', trans('client.notFound'));
    }
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
    $fpdi->SetTitle($client->webpage.'-'.trans('messages.paymentreceipt').'-'.$payment->code);
    /**
    * Se crea la plantilla para el pdf
    */
    $fpdi->addPage();
    $fpdi->useTemplate($tplIdx, 10, 10, 190);
    /**
    * Codigo
    */
    $fpdi->SetFont('Arial', '', 12);
    $fpdi->SetTextColor(0, 0, 0);
    $fpdi->SetXY(162, 35);
    $fpdi->MultiCell(85, 3, $payment->code);
    /**
    * Fecha
    */
    $fpdi->SetFont('Arial', '', 8);
    $fpdi->SetXY(162, 46);
    $fpdi->MultiCell(85, 3, strftime( "%Y/%m/%d", time()));
    /**
    * Monto
    */
    $fpdi->SetFont('Arial', '', 8);
    $fpdi->SetTextColor(0, 0, 0);
    $fpdi->SetXY(162, 53);
    $fpdi->MultiCell(85, 3, $payment->amount.' '.env('CURRENCY'));
    /**
    * Nombre del cliente
    */
    $fpdi->SetFont('Arial', '', 7);
    $fpdi->SetTextColor(0, 0, 0);
    $fpdi->SetXY(47, 72);
    $fpdi->MultiCell(85, 3, $client->name);
    /**
    * Tipo [Macro || Micro]
    */
    $fpdi->SetFont('Arial', '', 7);
    $fpdi->SetTextColor(0, 0, 0);
    $fpdi->SetXY(25, 89);
    $fpdi->MultiCell(85, 3, $solicitude->profile == 1 ? trans('messages.micro') : $solicitude->profile == 2 ? trans('messages.macro') : trans('messages.unknown'));
    /**
    * Referencia
    */
    $fpdi->SetFont('Arial', '', 7);
    $fpdi->SetTextColor(0, 0, 0);
    $fpdi->SetXY(55, 89);
    $fpdi->MultiCell(85, 3, 'Payment Receipt'.' '.$payment->code);
    /**
    * Monto Original
    */
    $fpdi->SetFont('Arial', '', 7);
    $fpdi->SetTextColor(0, 0, 0);
    $fpdi->SetXY(135, 89);
    $fpdi->MultiCell(85, 3, $payment->amount.' '.env('CURRENCY'));
    /**
    * Monto a pagar
    */
    $fpdi->SetFont('Arial', '', 7);
    $fpdi->SetTextColor(0, 0, 0);
    $fpdi->SetXY(163, 89);
    $fpdi->MultiCell(85, 3, $payment->amount.' '.env('CURRENCY'));
    /**
    * Monto Total
    */
    $fpdi->SetFont('Arial', '', 7);
    $fpdi->SetTextColor(0, 0, 0);
    $fpdi->SetXY(163, 220);
    $fpdi->MultiCell(85, 3, $payment->amount.' '.env('CURRENCY'));
    /**
    * Monto Pendiente
    */
    $fpdi->SetFont('Arial', '', 7);
    $fpdi->SetTextColor(0, 0, 0);
    $fpdi->SetXY(163, 228);
    $fpdi->MultiCell(85, 3, $payment->amount.' '.env('CURRENCY'));
    /**
    *
    */
    \Log::info('recibo de pago visto por: '.$user->email);
    $fpdi->Output();
  }
  /**
  * Validar datos de correo
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
