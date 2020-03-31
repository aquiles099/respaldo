<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use DateTime;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Admin\Package;
use App\Models\Admin\Log;
use App\Models\Admin\Event;
use App\Models\Admin\Consolidated;
use App\Models\Admin\Receipt;
use App\Models\Admin\Route;
use App\Models\Admin\Category;
use App\Models\Admin\DetailsReceipt;
use App\Models\Admin\Detailspackage;
use App\Models\Admin\DetailsTransport;
use App\Models\Admin\Client;
use App\Models\Admin\IataCode;
use App\Models\Admin\Currency;
use App\Models\Admin\Vessel;
use App\Models\Admin\Pickup;
use App\Models\Admin\Pais;
use App\Models\Admin\Country;
use App\Models\Admin\City;
use App\Models\Admin\State;
use App\Models\Admin\Container;
use App\Models\Admin\Transporters;
use App\Models\Admin\Transport;
use App\Models\Admin\Company;
use App\Models\Admin\User;
use App\Models\Admin\BillOfLading;
use App\Models\Admin\CargoRelease;
use App\Models\Admin\CargoReleaseDetail;
use App\Models\Admin\Operator;
use App\Models\Admin\Courier;
use App\Models\Admin\Booking;
use App\Models\Admin\BookingDetail;
use App\Models\Admin\Configuration;
use PDF;
use DB;
use App\Models\Admin\Invoice;
use App\Models\Admin\File;
use App\Models\Admin\InvoiceDetail;
use App\Models\Admin\DetailsPickup;
use App\Models\Admin\Shipment;
use App\Models\Admin\Service;
use App\Models\Admin\ShipmentRoute;
use App\Models\Admin\AddCharge;
use App\Models\Admin\ShipmentDetail;
use Validator;
use \App\Helpers\HConstants;

class ReceiptController extends Controller
{
    /**
    * Retorna la vista mostrando un listado de todos los recibos
    */
    public function index (Request $request) {
      $session = $request->session()->get('key-sesion');
      $receipt = Receipt::orderBy('created_at', 'desc')->get();
      /**
      *  Se valida que la sesion este activa
      */
      if ($session == null) {
        return redirect('login');
      }
      /**
      *
      */
      $vars = [
        'receipt'        => $receipt
      ];
      /**
      *
      */
      return view('pages.admin.package.receipts', $vars);
    }
    /**
    * Busca recibos pagados , deudas o todos
    */
    public function search (Request $request, $id) {
      $session       = $request->session()->get('key-sesion');
      $receipt       = Receipt::all();
      $invoiceDetail = InvoiceDetail::all();
      $response      = "";
      /**
      *  Se valida que la sesion este activa
      */
      if ($session == null) {
        return redirect('login');
      }
      /**
      *
      */
      if ($id == 1 ) {
        $response = "Todos";
      }
      /**
      *
      */
      if ($id == 2 ) {
        $response = "Pagados";
      }
      /**
      *
      */
      if ($id == 3 ) {
        $response = "Deudas";
      }
      /**
      *
      */
      $vars = [
        'receipt'        => $receipt,
        'invoiceDetails' => $invoiceDetail,
        'response'       => $response
      ];
      /**
      *
      */
      if(!$this->isGET($request)) {
        return response()->json([
          "message" => "true",
          "alert"   => $response
        ]);
     }
      /**
      *
      */
      return view('pages.admin.package.listReceipt', $vars);
    }
    /**
    * Ejecuta amortizaciones de facturas
    */
    public function checkIn (Request $request, $id) {
      $session   = $request->session()->get('key-sesion');
      $paytype   = $this->payType();
      $receipt   = Receipt::find($id);
      $invoice   = Invoice::byReceipt($id)->first();
      $validator = $this->validateData($request, $invoice->value);
      /**
      *  Se valida que la sesion este activa
      */
      if ($session == null) {
        return redirect('login');
      }
      /**
      *
      */
      $vars = [
        'payTypes' => $paytype,
        'receipt'  => $receipt
      ];
      /**
      *
      */
      if($this->isGET($request)) {
        return view('pages.admin.package.checkIn', $vars);
      }
      /**
      * Use the validator
      */
      if (!is_null($validator)) {
        if ($validator->fails()) {
           return response()->json([
             "message" => "false",
             "alert"   => $validator->messages()
           ]);
        }
      }
      /**
      *
      */
      $debt = ($invoice->value > $request->all()['value']) ? $invoice->value - $request->all()['value'] : '';
      $data = [
        'invoice'     => $invoice->id,
        'debt'        => $debt,
        'paidOut'     => $request->all()['value'],
        'type'        => $request->all()['type'],
        'observation' => $request->all()['observation']
      ];
      /**
      * se almacenan los pagos de las facturas
      */
      InvoiceDetail::create($data);
      /**
      * se realizan los calculos para mostrar total pagado y deuda actual
      */
      $currentValueInvoice = $invoice->value;
      $lastPayInvoice      = InvoiceDetail::byInvoice($invoice->id)->get()->last();
      /**
      * se almacenan los calculos
      */
      $invoice->value      = $currentValueInvoice - $lastPayInvoice->paidOut;
      $invoice->save();
      /**
      * se cambia el estatus de la factura a cancelada
      */
      if ($invoice->value == 0 || $invoice->value == '0') {
        $invoice->status = true;
        $invoice->save();
      }
      /**
      *
      */
      return response()->json([
        "message" => "true"
      ]);
    }
    /**
    * Registra una factura asociada a un recibo
    */
    public function innerChekin (Request $request, $id) {
      $session = $request->session()->get('key-sesion');
      $receipt = Receipt::find($id);
      /**
      *  Se valida que la sesion este activa
      */
      if ($session == null) {
        return redirect('login');
      }
      /**
      * se crea la factura asociado al recibo
      */
      $this->insertInvoice(false , $receipt->total, $receipt->id);
      /**
      * se obtiene las factura creada
      */
      $invoice = Invoice::byReceipt($id)->first();
      /**
      * se asocia la factura creada en la tabla recibo
      */
      $receipt->invoice = $invoice->id;
      $receipt->save();
      /**
      *
      */
      return response()->json([
        "message" => "true"
      ]);
    }
    /**
    * Muestra un listado con todos los pagos realizados a una factura
    */
    public function showPayment(Request $request, $id) {
      $session = $request->session()->get('key-sesion');
      $configuration = Configuration::find(1);
      $timezone = explode(" ", $configuration->time_zone);
      date_default_timezone_set($timezone[0]);
      /**
      * Se obtiene los datos de la factura de un recibo dado ($id)
      */
      $invoice = Invoice::byReceipt($id)->first();
      /**
      * Se obtiene los datos de
      */
      $receipt = Receipt::find($id);
      /**
      * Se obtienen los pagos de la factura
      */
      $invoiceDetail = InvoiceDetail::byInvoice($invoice->id)->get();
      /**
      *
      */
      $vars = [
        'configuration' => $configuration,
        'receipt'       => $receipt,
        'invoiceDetail' => $invoiceDetail
      ];
      /**
      *
      */
     return view('pages.admin.package.showPayment',$vars);
    }
    /**
    *
    */
    public function paymentDetail(Request $request, $id) {
      $session = $request->session()->get('key-sesion');
      $configuration = Configuration::find(1);
      $timezone = explode(" ", $configuration->time_zone);
      date_default_timezone_set($timezone[0]);
      $detail  = InvoiceDetail::find($id);
      $invoice = Invoice::find($detail->invoice);
      $receipt = Receipt::byInvoice($invoice->id)->first();
      /**
      *  Se valida que la sesion este activa
      */
      if ($session == null) {
        return redirect('login');
      }
      /**
      *
      */
      $vars = [
        'receipt'       => $receipt,
        'invoice'       => $invoice,
        'detail'        => $detail,
        'configuration' => $configuration,
        'pdf'           => (!$this->isGET($request)) ? true : false
      ];
      /**
      *
      */
      return view('pages.admin.package.paymentDetail',$vars);
    }
    /**
    *
    */
    public function readreceiptpackageid(Request $request, $id) {
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
      $package = Package::find($id);
      /**
      *
      */
      if(is_null($package)) {
        return $this->doRedirect($request, '/admin/package')
          ->with('errorMessage', trans('package.notFound'));
      }
      /**
      *
      */
      $companyclient = "";
      /**
      *
      */
      if(isset($package->to_client)) {
        $client          = Client::find($package->to_client);
        $companyclient   = Company::find($client->company);
      }
      /**
      *
      */
      if(!($receipt     = Receipt::query()->where('package', '=', $id)->first())){
        //dd("error");
        $receipt ="";
      }
      if(!($userconsig = User::find($package->consigner_user))){
        //dd("error");
        $userconsig ="";
      }
      if(!($useroring         = User::find($package->from_user))){
        //dd("error");
          $useroring ="";
      }
      if(!($userdesti         = User::find($package->to_user))){
        $userdesti ="";
      }
      $detailspackage    = Detailspackage::query()->where('package','=',$id)->get();

      if(!(sizeof($detailspackage))){
        dd("ERROR: No se encontro informacion de paquete");
      }

      $resultpackpieces  = DB::table('detailspackage')->where('package','=',$id)->sum('pieces');
      $resultpackweight  = DB::table('detailspackage')->where('package','=',$id)->sum('weight');
      $resultpackvol     = DB::table('detailspackage')->where('package','=',$id)->sum('volumetricweightm');
      $service           = isset($receipt->id) ? DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','S')->first() : null;
      $addcharge         = isset($receipt->id) ? DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','A')->first() : null;
      $detailreceipt     = isset($receipt->id) ? DB::table('detailsreceipt')->select('id', 'name_oring', 'value_oring','value_package')->where("type_attribute","=",'I')->where("receipt","=",$receipt->id)->get() : null;
      $detailreceiptpro  = isset($receipt->id) ? DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','P')->first() : null;
      $configuration     = Configuration::find(HConstants::FIRST_CONFIGURATION);
      $timezone = explode(" ", $configuration->time_zone);
      date_default_timezone_set($timezone[0]);
      $aplicate_charges  = isset($receipt->id) ? DetailsReceipt::byReceipt($receipt->id)->get() : null;
      $transport         = Transport::query()->where('id', '=', $package->type)->first();
      //dd($transport);
      /**
      *
      */
      $vars = [
        'package'           => $package,
        'detailspackage'    => $detailspackage,
        'resultpackpieces'  => $resultpackpieces,
        'resultpackweight'  => $resultpackweight,
        'resultpackvol'     => $resultpackvol,
        'receipt'           => $receipt,
        'detailreceipt'     => $detailreceipt,
        'promo'             => $detailreceiptpro,
        'configuration'     => $configuration,
        'companyclient'     => $companyclient,
        'userconsig'        => $userconsig,
        'useroring'         => $useroring,
        'userdesti'         => $userdesti,
        'service'           => $service,
        'addcharge'         => $addcharge,
        'aplicate_charges'  => $aplicate_charges
      ];

    //  dd($vars);

      /**
      *
      *//*
      $pdf = PDF::loadView('sections/receiptpackage',$vars);
      $pdf->setPaper('A4', 'auto');
      return $pdf->stream('invoice.pdf');*/


      $fpdi = new \fpdi\FPDI();
      $fpdf = new \fpdf\FPDF();

      $pageCount = $fpdi->setSourceFile('tmpreport/WHR.pdf');
      $tplIdx    = $fpdi->importPage(1, '/BleedBox');
      $fpdi->SetTitle(''.$package->code);
      $fpdi->SetAutoPageBreak(true,5);
      $fpdi->addPage();
      $fpdi->useTemplate($tplIdx, 0, 0, 210);

      $nombre = $configuration->logo_ics;
      $isJPG = strrpos($nombre,".jpg");
      if((!($isJPG)) && ($nombre!=null)) {
        $fpdi->Image(isset($configuration) ? ($configuration->logo_ics == '') ? asset('/dist/images/logoazul.jpg') : $configuration->logo_ics : asset('/dist/images/logoazul.jpg'),10,5,30,0,'PNG');
      }
      if($isJPG) {
        $fpdi->Image(isset($configuration) ? ($configuration->logo_ics == '') ? asset('/dist/images/logoazul.jpg') : $configuration->logo_ics : asset('/dist/images/logoazul.jpg'),10,5,30,0,'JPG');
      }

      $fpdi->SetFont('Arial','B',14);
      $fpdi->SetTextColor(59, 59, 59);
      $fpdi->SetXY(40, 8);
      $fpdi->MultiCell(85, 3, isset($configuration->name_company) ? $configuration->name_company: 'International Cargo System');

      $fpdi->SetFont('Arial','',12);
      $fpdi->SetTextColor(59, 59, 59);
      $fpdi->SetXY(40, 13);
      $fpdi->MultiCell(85, 3, isset($configuration->dni_company) ? $configuration->dni_company: 'DNI:1234567890');

      $fpdi->SetFont('Arial','',12);
      $fpdi->SetTextColor(83, 83, 83);
      $fpdi->SetXY(40, 18);
      $fpdi->MultiCell(85, 3, isset($configuration->email_company) ? $configuration->email_company: 'www.internationalcargosystem.com');


      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetFont('Arial','',9);
      //Recepit number
      $fpdi->SetXY(178, 33);
      $fpdi->MultiCell(85, 3,$package->code);
      $fpdi->SetFont('Arial','',8);

      //Tipo de envio
      $fpdi->SetXY(178, 36);
      $fpdi->MultiCell(80, 3,$package->getCategory != '' ? strtoupper($package->getCategory->label) : trans('messages.unknown'));


      //Estatus
      /*$estado = Event::all();
      $stat = (($estado[(($package->last_event)-1)]));
      //dd($stat);
      $fpdi->SetXY(178, 44);
      $fpdi->MultiCell(85, 3, isset($stat) ? strtoupper($stat->name) : '');
*/
      //Oficina de recepcion
      $fpdi->SetXY(178, 46.5);
      $fpdi->MultiCell(85, 3,$package->getOffice['name'] != '' ? strtoupper($package->getOffice['name']) : trans('messages.unknown'));

      //Date/time
      $fpdi->SetFont('Arial','',8);
      $fpdi->SetXY(178, 41.5);
      $fpdi->MultiCell(50, 2,$package->created_at);
      $fpdi->SetFont('Arial','',8);
      //Tipo de Transporte
      $fpdi->SetXY(178, 38.5);
      $fpdi->MultiCell(30, 3,isset($transport->spanish) ? strtoupper(utf8_decode($transport->spanish))  : trans('messages.unknown'));

      //SHIPPER INFORMATION
      $fpdi->SetXY(20+5, 83-23);
      $fpdi->MultiCell(85, 3,'Nombre: ');
      $fpdi->SetXY(35+5, 83-23);
      $fpdi->MultiCell(85, 3,isset($userconsig->name) ? strtoupper($userconsig->name." ".$userconsig->last_name):'');

      $fpdi->SetXY(20+5, 87-23);
      $fpdi->MultiCell(85, 3,'DNI: ');
      $fpdi->SetXY(35+5, 87-23);
      $fpdi->MultiCell(85, 3,isset($userconsig->dni) ? $userconsig->dni:'');

      $fpdi->SetXY(20+5, 90-23);
      $fpdi->MultiCell(85, 3,'Region: ');
      $fpdi->SetXY(35+5, 90-23);
      $fpdi->MultiCell(85, 3,isset($userconsig->country) ? $userconsig->country."-".$userconsig->region:'');

      $fpdi->SetXY(20+5, 94-23);
      $fpdi->MultiCell(85, 3,'Address: ');
      $fpdi->SetXY(35+5, 94-23);
      $fpdi->MultiCell(85, 3,isset($userconsig->postal_code) ? $userconsig->postal_code."-".$userconsig->address:'');

      $fpdi->SetXY(20+5, 98-23);
      $fpdi->MultiCell(85, 3,'Phone: ');
      $fpdi->SetXY(35+5, 98-23);
      $fpdi->MultiCell(85, 3,isset($userconsig->local_phone) ? $userconsig->local_phone."/".$userconsig->celular:'');

      //CONSIGNEE INFORMATION
      $fpdi->SetXY(110+10, 83-23);
      $fpdi->MultiCell(85, 3,'Nombre: ');
      $fpdi->SetXY(125+10, 83-23);
      $fpdi->MultiCell(85, 3,isset($userdesti->name) ? strtoupper($userdesti->name." ".$userdesti->last_name):'');

      $fpdi->SetXY(110+10, 87-23);
      $fpdi->MultiCell(85, 3,'DNI: ');
      $fpdi->SetXY(125+10, 87-23);
      $fpdi->MultiCell(85, 3,isset($userdesti->dni) ? $userdesti->dni:'');

      $fpdi->SetXY(110+10, 90-23);
      $fpdi->MultiCell(85, 3,'Region: ');
      $fpdi->SetXY(125+10, 90-23);
      $fpdi->MultiCell(85, 3,isset($userdesti->country) ? $userdesti->country."-".$userdesti->region:'');

      $fpdi->SetXY(110+10, 94-23);
      $fpdi->MultiCell(85, 3,'Address: ');
      $fpdi->SetXY(125+10, 94-23);
      $fpdi->MultiCell(85, 3,isset($userdesti->postal_code) ? $userdesti->postal_code."-".$userdesti->address:'');

      $fpdi->SetXY(110+10, 98-23);
      $fpdi->MultiCell(85, 3,'Phone: ');
      $fpdi->SetXY(125+10, 98-23);
      $fpdi->MultiCell(85, 3,isset($userdesti->local_phone) ? $userdesti->local_phone."/".$userdesti->celular:'');

      $fpdi->SetFont('Arial','',9);

      //NOTES
      $fpdi->SetXY(10, 100);
      $fpdi->MultiCell(85, 3,$package->observation);

      //Aplicable Charges
      $height = 100;
      foreach($aplicate_charges as $key => $value){
          if($value->type_attribute == "I"){
            $fpdi->SetXY(130, $height);
            $fpdi->MultiCell(80, 3,'Taxes: ');
            $fpdi->SetXY(160, $height);
            $fpdi->MultiCell(25, 3,number_format($value->value_oring,2,',','.').' $', 0, 'R');
          }
          if($value->type_attribute == "S"){
            $fpdi->SetXY(130, $height+4);
            $fpdi->MultiCell(80, 3,'Insurance: ');
            $fpdi->SetXY(160, $height+4);
            $fpdi->MultiCell(25, 3,number_format($value->value_oring,2,',','.').' $' , 0, 'R');
          }
          if($value->type_attribute == "T"){
            $fpdi->SetXY(130, $height+8);
            $fpdi->MultiCell(80, 3,'Transport: ');
            $fpdi->SetXY(160, $height+8);
            $fpdi->MultiCell(25, 3,number_format($value->value_oring,2,',','.').' $' , 0, 'R');
          }
          if($value->type_attribute == "A"){
            $fpdi->SetXY(130, $height+12);
            $fpdi->MultiCell(80, 3,'Aditional Charge: ');
            $fpdi->SetXY(160, $height+12);
            $fpdi->MultiCell(25, 3,number_format($value->value_oring,2,',','.').' $' , 0, 'R');
          }
          if($value->type_attribute == "P"){
            $fpdi->SetXY(130, $height+16);
            $fpdi->MultiCell(80, 3,'Promotions ');
            $fpdi->SetXY(160, $height+16);
            $fpdi->MultiCell(25, 3,($value->type_attribute == "P" ? '-' : '+').number_format($value->value_oring,2,',','.').' $' , 0, 'R');
          }
      }

      $h = 138;

      $unidad = " ft3";
      if ($package->type == 3) {
        $fpdi->SetXY(165, $h);
        $fpdi->MultiCell(25, 3,number_format($row->volumetricweightm,2,',','.').' Vlb', 0, 'R');
      }
      $unidadm = ($package->unidad == 0)&&($package->type == 1) ? 'ft3' : (($package->unidad == 1)&&($package->type == 1) ? 'm3': 'ft3');
      $unidada = ($package->unidad == 0)&&($package->type != 1) ? 'Vlb' : (($package->unidad == 1)&&($package->type != 1) ? 'Vkg': 'Vlb');
      $medition = ($package->unidad == 0 ? '"' : 'cm');
      $med_weight = ($package->unidad == 0 ? 'lb' : 'kg');
      foreach ($detailspackage as $row){

        $fpdi->SetXY(1, $h);
        $fpdi->MultiCell(30, 3,$row->pieces,0,'R');

        $fpdi->SetXY(49.5, $h);
        $fpdi->MultiCell(50, 3,$row->height.$medition.'x'.$row->large.$medition.'x'.$row->width.$medition, 0, 'C');

        $fpdi->SetXY(107, $h);
        $fpdi->MultiCell(25, 3,$row->description, 0, 'C');

        $fpdi->SetXY(140, $h);
        $fpdi->MultiCell(25, 3, number_format($row->weight,2,',','.').' '.$med_weight, 0, 'R');
        if ($package->type == 1) {
        $fpdi->SetXY(175, $h);
        $fpdi->MultiCell(25, 3,isset($package->type) ? number_format($row->volumetricweightm,2,',','.').' '.$unidadm : '0,00 '.$unidadm, 0, 'R');
        }
        if ($package->type == 2) {
          $fpdi->SetXY(175, $h);
          $fpdi->MultiCell(25, 3,isset($package->type) ? number_format($row->volumetricweighta,2,',','.').' '.$unidada : '0,00 '.$unidada, 0, 'R');
        }

        $fpdi->SetXY(160, $h);
        $fpdi->MultiCell(25, 3,$row->process, 0, 'R');

        $h+=3;
      }

      $fpdi->SetFont('Arial','B',9);
      $fpdi->SetXY(108, 255);
      $fpdi->MultiCell(25, 3,($resultpackpieces), 0, 'C');

      $fpdi->SetXY(143, 255);
      $fpdi->MultiCell(25, 3,number_format($resultpackweight,2,',','.').$med_weight, 0, 'C');


      if($package->type == \App\Helpers\HConstants::TRANSPORT_MARITHIME){
        $fpdi->SetXY(160+10, 255);
        $fpdi->MultiCell(25, 3,number_format($resultpackvol,2,',','.').$unidadm, 0, 'C');
      }
      if($package->type == \App\Helpers\HConstants::TRANSPORT_AERIAL){
          $fpdi->SetXY(160+15, 255);
          $fpdi->MultiCell(25, 3,number_format($resultpackvol,2,',','.').$unidada, 0, 'C');
      }
      $fpdi->SetFont('Arial','',8);
      $fpdi->SetXY(15, 270);
      $fpdi->MultiCell(180, 3, isset($configuration) ? ($configuration->footer_receipt == '') ? trans('configuration.nofooter') : $configuration->footer_receipt : trans('configuration.nofooter'));

      $fpdi->Output();
    }

   /**
   * Retorna el invoice de un wr
   */
   public function readinvoicepackageid(Request $request, $id) {
      $receipt = Receipt::find($id);
      /**
      * Verificamos la existencia del recibo
      */
      if(is_null($receipt)) {
        return $this->doRedirect($request, '/admin/receipt')
          ->with('errorMessage', trans('invoice.notFound'));
      }
      $package = Package::find($receipt->package);
      $invoice = Invoice::find($receipt->invoice);
      /**
      *
      */
      $companyclient = "";
      if(isset($package->to_client)){
        $client          = Client::find($package->to_client);
        $companyclient   = Company::find($client->company);
      }
      /**
      *
      */
      $userconsig       = User::find($package->consigner_user);
      $useroring        = User::find($package->from_user);
      $userdesti        = User::find($package->to_user);
      $detailspackage   = Detailspackage::query()->where('package', '=', $package->$id)->get();
      $service          = DetailsReceipt::query()->where('receipt', '=', $receipt->id)->where('type_attribute','=','S')->first();
      $addcharge        = DetailsReceipt::query()->where('receipt', '=', $receipt->id)->where('type_attribute','=','A')->first();
      $insurance        = DetailsReceipt::query()->where('receipt', '=', $receipt->id)->where('type_attribute','=','IN')->first();
      $transport        = DetailsReceipt::query()->where('receipt', '=', $receipt->id)->where('type_attribute','=','T')->first();
      $detailreceipt    = DB::table('detailsreceipt')->select('id', 'name_oring', 'value_oring','value_package')->where("type_attribute","=",'I')->where("receipt","=",$receipt->id)->get();
      $detailreceiptpro = DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','P')->first();
      $configuration    = Configuration::find(1);
      $timezone = explode(" ", $configuration->time_zone);
      date_default_timezone_set($timezone[0]);
      /**
      *
      */
      $vars = [
        'package'        => $package,
        'detailspackage' => $detailspackage,
        'receipt'        => $receipt,
        'detailreceipt'  => $detailreceipt,
        'promo'          => $detailreceiptpro,
        'configuration'  => $configuration,
        'companyclient'  => $companyclient,
        'userconsig'     => $userconsig,
        'useroring'      => $useroring,
        'userdesti'      => $userdesti,
        'service'        => $service,
        'addcharge'      => $addcharge,
        'invoice'        => $invoice,
        'insurance'      => $insurance,
        'transport'      => $transport
      ];
      /**
      *
      */
      $pdf = PDF::loadView('sections/invoicepackage',$vars);
      $pdf->setPaper('A4', 'auto');
      return $pdf->stream('invoice.pdf');
   }
   /**
   * retorna el inovoice de un pickup
   */
    public function readInvoicePickup(Request $request, $id) {
      $receipt  = Receipt::find($id);
      /**
      * Verificamos la existencia del recibo
      */
      if(is_null($receipt)) {
        return $this->doRedirect($request, '/admin/receipt')
          ->with('errorMessage', trans('invoice.notFound'));
      }
      /**
      * se obtienes los datos del pickup
      */
      $pickup  = Pickup::find($receipt->pickup);
      $invoice = Invoice::find($receipt->invoice);
      /**
      *
      */
      $companyclient = "";
      if(isset($pickup->to_client)){
        $client          = Client::find($pickup->to_client);
        $companyclient   = Company::find($client->company);
      }
      /**
      *
      */
      $receipt          = Receipt::query()->where('pickup','=',$pickup->$id)->first();
      $userconsig       = User::find($pickup->consigner_user);
      $useroring        = User::find($pickup->from_user);
      $userdesti        = User::find($pickup->to_user);
      /**
      *
      */
      $detailspackage   = DetailsPickup::query()->where('pickup','=', $pickup->$id)->get();
      $service          = isset($receipt->id) ? DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','S')->first() : null;
      $addcharge        =  isset($receipt->id) ? DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','A')->first() : null;
      $insurance        =  isset($receipt->id) ? DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','IN')->first() : null;
      $transport        =  isset($receipt->id) ? DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','T')->first() : null;
      $detailreceipt    = isset($receipt->id) ? DB::table('detailsreceipt')->select('id', 'name_oring', 'value_oring','value_package')->where("type_attribute","=",'I')->where("receipt","=",$receipt->id)->get() : null;
      $detailreceiptpro =  isset($receipt->id) ? DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','P')->first() : null;
      $configuration    = Configuration::find(1);
      $timezone = explode(" ", $configuration->time_zone);
      date_default_timezone_set($timezone[0]);
      /**
      *
      */
      $vars = [
        'package'        => $pickup,
        'detailspackage' => $detailspackage,
        'receipt'        => $receipt,
        'detailreceipt'  => $detailreceipt,
        'promo'          => $detailreceiptpro,
        'configuration'  => $configuration,
        'companyclient'  => $companyclient,
        'userconsig'     => $userconsig,
        'useroring'      => $useroring,
        'userdesti'      => $userdesti,
        'service'        => $service,
        'addcharge'      => $addcharge,
        'invoice'        => $invoice,
        'insurance'      => $insurance,
        'transport'      => $transport
      ];
      //dd($vars);
      /**
      *
      */
      /*$pdf = PDF::loadView('sections/invoicepackage',$vars);
      $pdf->setPaper('A4', 'auto');
      return $pdf->stream('invoice.pdf');*/

      $fpdi = new \fpdi\FPDI();
      $fpdf = new \fpdf\FPDF();
      $fpdi->SetAutoPageBreak(true,5);
      $pageCount = $fpdi->setSourceFile('tmpreport/invoice.pdf');
      $tplIdx    = $fpdi->importPage(1, '/BleedBox');
      $fpdi->SetTitle('INVOICE '.$pickup->code);

      $fpdi->addPage();
      $fpdi->useTemplate($tplIdx, 0, 0, 210);


      $nombre = $configuration->logo_ics;
      $isJPG = strrpos($nombre,".jpg");
      if((!($isJPG)) && ($nombre!=null)) {
        $fpdi->Image(isset($configuration) ? ($configuration->logo_ics == '') ? asset('/dist/images/logoazul.jpg') : $configuration->logo_ics : asset('/dist/images/logoazul.jpg'),10,5,30,0,'PNG');
      }
      if($isJPG) {
        $fpdi->Image(isset($configuration) ? ($configuration->logo_ics == '') ? asset('/dist/images/logoazul.jpg') : $configuration->logo_ics : asset('/dist/images/logoazul.jpg'),10,5,30,0,'JPG');
      }
      $fpdi->SetFont('Arial','B',14);
      $fpdi->SetTextColor(59, 59, 59);
      $fpdi->SetXY(40, 8);
      $fpdi->MultiCell(85, 3, isset($configuration->name_company) ? $configuration->name_company: 'International Cargo System');

      $fpdi->SetFont('Arial','',12);
      $fpdi->SetTextColor(59, 59, 59);
      $fpdi->SetXY(40, 13);
      $fpdi->MultiCell(85, 3, isset($configuration->dni_company) ? $configuration->dni_company: 'DNI:1234567890');

      $fpdi->SetFont('Arial','',12);
      $fpdi->SetTextColor(83, 83, 83);
      $fpdi->SetXY(40, 18);
      $fpdi->MultiCell(85, 3, isset($configuration->email_company) ? $configuration->email_company: 'www.internationalcargosystem.com');

      $fpdi->SetFont('Arial','',9);
      $fpdi->SetTextColor(0, 0, 0);

      /*
      $fpdi->SetXY(110, 260);
      $fpdi->MultiCell(25, 3,number_format('$resultpackpieces',2,',','.'), 0, 'R');
      */
      $x = 30;
      $y = 13;

      //HEAD
      $fpdi->SetXY($x+160, $y+15);
      $fpdi->MultiCell(30, 3,$pickup->code, 0, 'L');

      $fpdi->SetXY($x+160, $y+20);
      $fpdi->MultiCell(30, 3,$pickup->start_at, 0, 'L');

      $fpdi->SetXY($x+160, $y+25);
      $fpdi->MultiCell(30, 3,isset($userdesti->postal_code)?$userdesti->postal_code:'', 0, 'L');

      $fpdi->SetXY($x+160, $y+30);
      $fpdi->MultiCell(30, 3,$pickup->start_at, 0, 'L');

      //dd($pickup);
      $y-=5;
      $x=10;
      //BILL TO
      if(isset($userdesti)){
        $fpdi->SetXY($x+10, $y+50);
        $fpdi->MultiCell(30, 3,'NAME:', 0, 'L');
        $fpdi->SetXY($x+35, $y+50);
        $fpdi->MultiCell(40, 3,strtoupper($userdesti->name.' '.$userdesti->last_name), 0, 'L');
        $y+=2;
        $fpdi->SetXY($x+10, $y+55);
        $fpdi->MultiCell(30, 3,'DNI:', 0, 'L');
        $fpdi->SetXY($x+35, $y+55);
        $fpdi->MultiCell(30, 3,$userdesti->dni, 0, 'L');

        $fpdi->SetXY($x+10, $y+60);
        $fpdi->MultiCell(30, 3,'COUNRTY:', 0, 'L');
        $fpdi->SetXY($x+35, $y+60);
        $fpdi->MultiCell(30, 3,strtoupper($userdesti->country), 0, 'L');

        $fpdi->SetXY($x+10, $y+65);
        $fpdi->MultiCell(30, 3,'ADRESS:', 0, 'L');
        $fpdi->SetXY($x+35, $y+65);
        $fpdi->MultiCell(50, 3,strtoupper($userdesti->postal_code.' '.$userdesti->region.' '.$userdesti->address), 0, 'L');
        $y+=2;
        $fpdi->SetXY($x+10, $y+73);
        $fpdi->MultiCell(30, 3,'PHONE:', 0, 'L');
        $fpdi->SetXY($x+35, $y+73);
        $fpdi->MultiCell(30, 3,$userdesti->celular, 0, 'L');
      }
      $x-=20;
        //DETAILS
        if($userconsig){
            $fpdi->SetXY($x+120, $y+50);
            $fpdi->MultiCell(30, 3,'PICKUP CODE:', 0, 'L');
            $fpdi->SetXY($x+155, $y+50);
            $fpdi->MultiCell(30, 3,$pickup->code, 0, 'L');

            $y-=5;;

            $fpdi->SetXY($x+120, $y+62);
            $fpdi->MultiCell(30, 3,'Consignee:', 0, 'L');
            $fpdi->SetXY($x+155, $y+62);
            $fpdi->MultiCell(80, 3,strtoupper($userconsig->name.' '.$userconsig->last_name), 0, 'L');
            $y+=3;;
            $fpdi->SetXY($x+120, $y+67);
            $fpdi->MultiCell(30, 3,'DNI:', 0, 'L');
            $fpdi->SetXY($x+155, $y+67);
            $fpdi->MultiCell(50, 3,$userconsig->dni, 0, 'L');

            $fpdi->SetXY($x+120, $y+75);
            $fpdi->MultiCell(30, 3,'Phone:', 0, 'L');
            $fpdi->SetXY($x+155, $y+75);
            $fpdi->MultiCell(50, 3,$userconsig->celular, 0, 'L');

            $fpdi->SetXY($x+120, $y+85);
            $fpdi->MultiCell(30, 3,'Invoice Status:', 0, 'L');
            $fpdi->SetXY($x+155, $y+85);
            $fpdi->MultiCell(30, 3,(isset($invoice) ? strtoupper(($invoice->status==1)? 'Pagado': 'Por Pagar') : 'Por Pagar'), 0, 'L');
        }
        $x+=10;
        $y+=2;
        //dd($service);
        //DATA TABLE

        //SERVICE
        if(!$service){
            $fpdi->SetXY($x+15, $y+120);
            $fpdi->MultiCell(50, 3,isset($service->name_oring) ? 'SERVICE '.$service->name_oring : '', 0, 'L');

            $fpdi->SetXY($x+65, $y+120);
            $fpdi->MultiCell(20, 3,'1', 0, 'R');

            $fpdi->SetXY($x+120, $y+120);
            $fpdi->MultiCell(20, 3,isset($service->value_package) ? number_format($service->value_package,2,',','.').' $' : '', 0, 'R');

            $fpdi->SetXY($x+175, $y+120);
            $fpdi->MultiCell(20, 3,isset($service->value_package) ?number_format($service->value_package,2,',','.').' $': '', 0, 'R');
        }else{
            $fpdi->SetXY($x+15, $y+120);
            $fpdi->MultiCell(50, 3,'SERVICE ', 0, 'L');

            $fpdi->SetXY($x+65, $y+120);
            $fpdi->MultiCell(20, 3,'0', 0, 'R');

            $fpdi->SetXY($x+120, $y+120);
            $fpdi->MultiCell(20, 3,'0,00'.' $', 0, 'R');

            $fpdi->SetXY($x+175, $y+120);
            $fpdi->MultiCell(20, 3,'0,00'.' $', 0, 'R');
        }
        //AddCharge
        if(!$addcharge){
            $fpdi->SetXY($x+15, $y+125);
            $fpdi->MultiCell(50, 3,isset($addcharge->name_oring)?'CHARGES '.$addcharge->name_oring:'', 0, 'L');

            $fpdi->SetXY($x+65, $y+125);
            $fpdi->MultiCell(20, 3,'0', 0, 'R');

            $fpdi->SetXY($x+120, $y+125);
            $fpdi->MultiCell(20, 3,number_format(isset($addcharge->value_package)?$addcharge->value_package:0,2,',','.').' $', 0, 'R');

            $fpdi->SetXY($x+175, $y+125);
            $fpdi->MultiCell(20, 3,number_format(isset($addcharge->value_package)?$addcharge->value_package:0,2,',','.').' $', 0, 'R');
        }else{
            $fpdi->SetXY($x+15, $y+125);
            $fpdi->MultiCell(50, 3,'CHARGES ', 0, 'L');

            $fpdi->SetXY($x+65, $y+125);
            $fpdi->MultiCell(20, 3,'0', 0, 'R');

            $fpdi->SetXY($x+120, $y+125);
            $fpdi->MultiCell(20, 3,'0,00'.' $', 0, 'R');

            $fpdi->SetXY($x+175, $y+125);
            $fpdi->MultiCell(20, 3,'0,00'.' $', 0, 'R');
        }

        //INSURANCE
        if($insurance){
            $fpdi->SetXY($x+15, $y+130);
            $fpdi->MultiCell(50, 3,'INSURANCE '.$insurance->name_oring, 0, 'L');

            $fpdi->SetXY($x+65, $y+130);
            $fpdi->MultiCell(20, 3,'1', 0, 'R');

            $fpdi->SetXY($x+120, $y+130);
            $fpdi->MultiCell(20, 3,number_format($insurance->value_package,2,',','.').' $', 0, 'R');

            $fpdi->SetXY($x+175, $y+130);
            $fpdi->MultiCell(20, 3,number_format($insurance->value_package,2,',','.').' $', 0, 'R');
        }else{
            $fpdi->SetXY($x+15, $y+130);
            $fpdi->MultiCell(50, 3,'INSURANCE ', 0, 'L');

            $fpdi->SetXY($x+65, $y+130);
            $fpdi->MultiCell(20, 3,'0', 0, 'R');

            $fpdi->SetXY($x+120, $y+130);
            $fpdi->MultiCell(20, 3,'0,00'.' $', 0, 'R');

            $fpdi->SetXY($x+175, $y+130);
            $fpdi->MultiCell(20, 3,'0,00'.' $', 0, 'R');
        }
        //TRANSPORT
        //dd($transport);
        if($transport){
            $fpdi->SetXY($x+15, $y+135);
            $fpdi->MultiCell(50, 3,'TRANSPORT '.$transport->name_oring, 0, 'L');

            $fpdi->SetXY($x+65, $y+135);
            $fpdi->MultiCell(20, 3,'1', 0, 'R');

            $fpdi->SetXY($x+120, $y+135);
            $fpdi->MultiCell(20, 3,number_format($transport->value_package,2,',','.').' $', 0, 'R');

            $fpdi->SetXY($x+175, $y+135);
            $fpdi->MultiCell(20, 3,number_format($transport->value_package,2,',','.').' $', 0, 'R');
        }

        //SUBTOTAL
      //dd($detailreceiptpro);
      $y += 6;
      $x += 20;
      $fpdi->SetFont('Arial','',12);
      $fpdi->SetTextColor(0, 0, 0);
        $fpdi->SetXY($x+150, $y+214);
        $fpdi->MultiCell(30, 3,isset($receipt->subtotal) ? number_format($receipt->subtotal,2,',','.').' $' : '', 0, 'R');

        $fpdi->SetFont('Arial','',10);
        $fpdi->SetTextColor(0, 0, 0);
        if (isset($detailreceipt)) {
          foreach($detailreceipt as $row){
            //TAX
            $fpdi->SetXY($x+150, $y+221);
            $fpdi->MultiCell(30, 3,number_format($row->value_package,2,',','.').' $', 0, 'R');
          }
        }

        //PROMOTION
        $fpdi->SetXY($x+150, $y+227);
        $fpdi->MultiCell(30, 3,isset($detailreceiptpro->value_package) ? number_format($detailreceiptpro->value_package,2,',','.').' $' : '' , 0, 'R');
        //TOTAL
        $fpdi->SetFont('Arial','',12);
        $fpdi->SetTextColor(0, 0, 0);
        $fpdi->SetXY($x+150, $y+232);
        $fpdi->MultiCell(30, 3,isset($receipt->total) ? number_format($receipt->total,2,',','.').' $' : '', 0, 'R');
        $fpdi->SetXY(15, 265);
        $fpdi->MultiCell(180, 3, isset($configuration) ? ($configuration->footer_receipt == '') ? trans('configuration.nofooter') : $configuration->footer_receipt : trans('configuration.nofooter'));
      $fpdi->Output();
    }
    /**
    *
    */
    public function receiptpickupid(Request $request, $id) {
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
      $package = Pickup::find($id);
      $pickup = Package::find($id);
      /**
      *
      */
      if(is_null($package)) {
        return $this->doRedirect($request, '/admin/pickup')
          ->with('errorMessage', trans('package.notFound'));
      }
      /**
      *
      */
      $companyclient = "";
      /**
      *
      */
      if(isset($package->to_client)){
        $client          = Client::find($package->to_client);
        $companyclient   = Company::find($client->company);
      }
      /**
      *
      */
      $receipt          = Receipt::query()->where('package','=',$package->id)->first();
      //dd($receipt);
      $userconsig       = User::find($package->consigner_user);
      $useroring        = User::find($package->from_user);
      $userdesti        = User::find($package->to_user);
      $detailspackage   = DetailsPickup::query()->where('pickup','=',$id)->get();
      $resultpackpieces = DB::table('details_pickup_order')->where('pickup','=',$id)->sum('pieces');
      $resultpackweight = DB::table('details_pickup_order')->where('pickup','=',$id)->sum('weight');
      $resultpackvol    = DB::table('details_pickup_order')->where('pickup','=',$id)->sum('volumetricweight');
      $service          = isset($receipt->id) ? DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','S')->first() : null;
      $addcharge        = isset($receipt->id) ? DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','A')->first() : null;
      $detailreceipt    = isset($receipt->id) ? DB::table('detailsreceipt')->select('id', 'name_oring', 'value_oring','value_package')->where("type_attribute","=",'I')->where("receipt","=",$receipt->id)->get() : null;
      $detailreceiptpro = isset($receipt->id) ? DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','P')->first() : null;
      $configuration    = Configuration::find(HConstants::FIRST_CONFIGURATION);
      $timezone = explode(" ", $configuration->time_zone);
      date_default_timezone_set($timezone[0]);
      $aplicate_charges = isset($receipt->id) ? DetailsReceipt::query()->where('receipt','=',$receipt->id)->get() :null;

      /**
      *
      */
      $vars = [
        'package'           => $package,
        'detailspackage'    => $detailspackage,
        'resultpackpieces'  => $resultpackpieces,
        'resultpackweight'  => $resultpackweight,
        'resultpackvol'     => $resultpackvol,
        'receipt'           => $receipt,
        'detailreceipt'     => $detailreceipt,
        'promo'             => $detailreceiptpro,
        'configuration'     => $configuration,
        'companyclient'     => $companyclient,
        'userconsig'        => $userconsig,
        'useroring'         => $useroring,
        'userdesti'         => $userdesti,
        'service'           => $service,
        'addcharge'         => $addcharge,
        'aplicate_charges'  => $aplicate_charges
      ];

      /**
      *
      */
      /*$pdf = PDF::loadView('pages/admin/pickup/receiptpickup',$vars);
      $pdf->setPaper('A4', 'auto');
      return $pdf->stream('invoice.pdf');*/

      //large
      $resultlarge    = DB::table('detailspackage')->where('package','=',$package->id)->sum('large');
      //height
      $resultheight    = DB::table('detailspackage')->where('package','=',$package->id)->sum('height');
      //width
      $resultwidth    = DB::table('detailspackage')->where('package','=',$package->id)->sum('width');
      //weight
      $resultwieght    = DB::table('detailspackage')->where('package','=',$package->id)->sum('weight');

      $fpdi = new \fpdi\FPDI();
      $fpdf = new \fpdf\FPDF();
      $fpdi->SetAutoPageBreak(true,1);
      $pageCount = $fpdi->setSourceFile('tmpreport/pickupOrder.pdf');
      $tplIdx    = $fpdi->importPage(1, '/BleedBox');

      $fpdi->SetTitle('PickUp Order'.' '.$package->code);

      $fpdi->addPage();
      $fpdi->useTemplate($tplIdx, 0, 0, 210, 279-5);

      $nombre = $configuration->logo_ics;
      $isJPG = strrpos($nombre,".jpg");
      if((!($isJPG)) && ($nombre!=null)) {
        $fpdi->Image(isset($configuration) ? ($configuration->logo_ics == '') ? asset('/dist/images/logoazul.jpg') : $configuration->logo_ics : asset('/dist/images/logoazul.jpg'),10,5,30,0,'PNG');
      }
      if($isJPG) {
        $fpdi->Image(isset($configuration) ? ($configuration->logo_ics == '') ? asset('/dist/images/logoazul.jpg') : $configuration->logo_ics : asset('/dist/images/logoazul.jpg'),10,5,30,0,'JPG');
      }

      $fpdi->SetFont('Arial','B',14);
      $fpdi->SetTextColor(59, 59, 59);
      $fpdi->SetXY(40, 15-8);
      $fpdi->MultiCell(85, 3, isset($configuration->name_company) ? $configuration->name_company: 'International Cargo System');

      $fpdi->SetFont('Arial','',12);
      $fpdi->SetTextColor(59, 59, 59);
      $fpdi->SetXY(40, 20-8);
      $fpdi->MultiCell(85, 3, isset($configuration->dni_company) ? $configuration->dni_company: 'DNI:1234567890');

      $fpdi->SetFont('Arial','',12);
      $fpdi->SetTextColor(83, 83, 83);
      $fpdi->SetXY(40, 25-8);
      $fpdi->MultiCell(85, 3, isset($configuration->email_company) ? $configuration->email_company: 'www.internationalcargosystem.com');

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(140, 32);
      $fpdi->SetFillColor(255, 255, 255);
      $fpdi->MultiCell(30, 15, '',0,'L',true);

      $fpdi->SetFillColor(255, 255, 255);
      $fpdi->SetXY(140, 26);
      $fpdi->MultiCell(80, 5, ' ',0,'L',true);

      $fpdi->SetFont('Arial','',15);
      $fpdi->SetXY(128-8, 26.6);
      $fpdi->MultiCell(80, 4, 'ORDEN DE RECOLECTA',0,'L');

      $fpdi->SetFont('Arial','',9);
      $fpdi->SetTextColor(0, 0, 0);

      //NUMERO DE ENVIO
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(110, 32);
      $fpdi->MultiCell(40, 3, 'No. de Orden:',0,'R');
      $fpdi->SetXY(150, 32);
      $fpdi->MultiCell(85, 3, $package->code);

      //TIPO DE ENVIO
      $fpdi->SetXY(110, 35);
      $fpdi->MultiCell(40, 3, 'Tipo:',0,'R');
      $label = isset($package->getCategory) ? $package->getCategory->label : '';
      $fpdi->SetXY(150, 35);
      if(strlen($label)>50){
        $fpdi->SetXY(150, 35);
      }
      $fpdi->MultiCell(30, 3, $package->getCategory != '' ? strtoupper($package->getCategory->label) : trans('messages.unknown'));

      //TIPO DE TRANSPORTE
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(110, 38);
      $fpdi->MultiCell(40, 3, 'Tipo de Transporte:',0,'R');
      $fpdi->SetXY(150, 38);
      $fpdi->MultiCell(85, 3,$package->getType != '' ? utf8_decode(strtoupper($package->getType->spanish)) : trans('messages.unknown') );

      $fpdi->SetXY(110, 41);
      $fpdi->MultiCell(40, 3, 'Fecha de Registro:',0,'R');
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(150, 41);
      $fpdi->MultiCell(85, 3,$package->created_at );

    /*  //Estatus
      $fpdi->SetXY(170, 58-7);
      $fpdi->MultiCell(85, 3,$package->last_event);*/

      //OFICINA
      $fpdi->SetXY(110, 44);
      $fpdi->MultiCell(40, 3, 'Oficina:',0,'R');
      $fpdi->SetXY(150, 44);
      $fpdi->MultiCell(85, 3,$package->getOffice['name'] != '' ? strtoupper($package->getOffice['name']) : trans('messages.unknown'));

      //USUARIO DESTINO

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(120, 55);
      $fpdi->MultiCell(95, 3, isset($userdesti) ? ucwords($userdesti->name.' '.$userdesti->last_name) : '');

            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(120, 59);
            $fpdi->MultiCell(85, 3,isset($package) ? (isset($userdesti) ?strtolower($userdesti->email) : strtolower($package->getToUser['email'])) : '');

            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(120, 63);
            $fpdi->MultiCell(85, 3,isset($package) ? (isset($userdesti) ?strtoupper($userdesti->postal_code.' '.$userdesti->city) : strtoupper($package->getToUser['postal_code'].' '.$package->getToUser['region'])) : '');

            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(120, 67);
            $fpdi->MultiCell(85, 3,isset($package) ? (isset($userdesti) ?strtoupper($userdesti->region.' '.$userdesti->country) : strtoupper($package->getToUser['country'])) : '');            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(120, 71);
            $fpdi->MultiCell(85, 3,isset($package) ? (isset($userdesti) ? strtoupper('Phone: '.$userdesti->celular) : strtoupper($package->getToUser['celular'])) : '');

            if(isset($userconsig)){
              $fpdi->SetXY(25, 55);
              $fpdi->MultiCell(85, 3, ucwords($userconsig->name)." ".($userconsig->last_name));

              $fpdi->SetXY(25, 67);
              $fpdi->MultiCell(85, 3, strtoupper($userconsig->postal_code.' '.$userconsig->city));
              $fpdi->SetXY(25, 63);
              $fpdi->MultiCell(85, 3, strtolower($userconsig->email));
              $fpdi->SetXY(25, 59);
              $fpdi->MultiCell(85, 3, strtoupper('PHONE: '.$userconsig->celular)  );
              $fpdi->SetXY(25, 71);
              $fpdi->MultiCell(85, 3, strtoupper($userconsig->city).", ".strtoupper($userconsig->region).", ".strtoupper($userconsig->country));

            }

          //CARGOS APLICABLES
          if (isset($aplicate_charges)) {
            foreach($aplicate_charges as $key => $value){
              if($value->type_attribute == "I"){
                $fpdi->SetXY(130, 100-15);
                $fpdi->MultiCell(85, 3, "IMPUESTOS");
                $fpdi->SetXY(170, 100-15);
                $fpdi->MultiCell(15, 3, number_format($value->value_oring,2,',','.')." $", 0, 'R');
              }

              if($value->type_attribute == "S"){
                $fpdi->SetXY(130, 103-15);
                $fpdi->MultiCell(85, 3, "SEGURO");
                $fpdi->SetXY(170, 103-15);
                $fpdi->MultiCell(15, 3, number_format($value->value_oring,2,',','.')." $", 0, 'R');
              }
              if($value->type_attribute == "T"){
                $fpdi->SetXY(130, 106-15);
                $fpdi->MultiCell(85, 3, "TRANSPORTE");
                $fpdi->SetXY(170, 106-15);
                $fpdi->MultiCell(15, 3, number_format($value->value_oring,2,',','.')." $", 0, 'R');
              }
              if($value->type_attribute == "A"){
                $fpdi->SetXY(130, 109-15);
                $fpdi->MultiCell(85, 3, "CARGOS ADICIONALES");
                $fpdi->SetXY(170, 109-15);
                $fpdi->MultiCell(15, 3, number_format($value->value_oring,2,',','.')." $", 0, 'R');
              }
              if($value->type_attribute == "P"){
                $fpdi->SetXY(130, 112-15);
                $fpdi->MultiCell(85, 3, "PROMOCION");
                $fpdi->SetXY(170, 112-15);
                $fpdi->MultiCell(15, 3, number_format($value->value_oring,2,',','.')." $", 0, 'R');
              }
            }
          }

          $unidad='ft3';
          if(isset($pickup->type)){
            if($package->type==1){
              $unidad=' ft3';
            }else if($pickup->type==2){
              $unidad=' Vlb';
            }

          }
          $h = 115;
          foreach ($detailspackage as $row){
            $fpdi->SetXY(5, $h);
            $fpdi->MultiCell(50, 3, $row->pieces.' PKGS',0,'C');

            $fpdi->SetXY(60, $h);
            $fpdi->MultiCell(30, 3, $row->large.'x'.$row->width.'x'.$row->height,0,'C');

            $fpdi->SetXY(100, $h);
            $fpdi->MultiCell(36, 3, strtoupper($row->description),0,'J');

            $fpdi->SetXY(139, $h);
            $fpdi->MultiCell(30, 3, isset($row->weight)? (number_format($row->weight,2,',','.').' Lb') : '',0,'C');

            $fpdi->SetXY(170, $h);
            $fpdi->MultiCell(30, 3, number_format($row->volumetricweight,2,',','.').$unidad,0,'C');
            $h += 4;
          }
          //NOTA
          $fpdi->SetXY(65, 225.5);
          $fpdi->MultiCell(80, 3, isset($package->observation) ? ($package->observation) : '',0,'C');

          //PIEZAS
          $fpdi->SetXY(110, 242);
          $fpdi->MultiCell(15, 3, number_format($resultpackpieces,2,',','.'),0,'R');

          //PESO
          $fpdi->SetXY(140, 242);
          $fpdi->MultiCell(30, 3, number_format($resultpackweight,2,',','.').' Lb',0,'C');

          //VOLUMEN
            $fpdi->SetXY(170, 242);
            $fpdi->MultiCell(30, 3, number_format($row->volumetricweight,2,',','.').$unidad,0,'C');

          //FOOTER
          $fpdi->SetXY(15, 255);
          $fpdi->MultiCell(180, 3, isset($configuration) ? ($configuration->footer_receipt == '') ? trans('configuration.nofooter') : $configuration->footer_receipt : trans('configuration.nofooter'));
      $fpdi->Output();
    }
    /**
    *
    */
    public function showWarehouse(Request $request, $id) {

      $session         = $request->session()->get('key-sesion');
      $package         = Package::find($id);
      $packageLog      = Log::ByPackage($package->id)->get();
      $invoice         = File::query()->where("id_package", "=", $id)->get();
      $detailspackage  = Detailspackage::query()->where('package','=',$id)->get();
      $noInvoice       = true;
      /**
      *
      */
      $event=Event::query()->where('id','>=',$package->last_event)->get();
      /**
      *  Se valida que la sesion este activa
      */
      if ($session == null) {
        return redirect('login');
      }
      /**
      *
      */
      $companyclient="";
      if(isset($package->to_client)){
        $client          = Client::find($package->to_client);
        $companyclient   = Company::find($client->company);
      }
      /**
      *
      */
      $events = Event::query()->where('active','=',1)->count();
      $vars = [
        'package'      => $package,
        'detailspack'  => $detailspackage,
        'packageLog'   => $packageLog,
        'event'        => $event,
        'invoice'      => $invoice,
        'companyclient'=> $companyclient,
        'noInvoice'    => $noInvoice,
        'events_num'   => $events,
        'event'        => Event::query()->where('active','=',1)->get()
      ];
      /**
      * Se obtiene la vista para ver detalles del paquete
      */
      if($this->isGET($request)) {
        return view('pages.admin.showpackage.view', $vars);
      }
    }
    /**
    *
    */
    public function showPickup(Request $request, $id) {
      /**
      *
      */
      $session         = $request->session()->get('key-sesion');
      $pickup          = Pickup::find($id);
      $packageLog      = Log::ByPickup($pickup->id)->get();
      $invoice         = File::query()->where("id_package", "=", $id)->get();
      $detailspackage  = DetailsPickup::query()->where('pickup','=',$id)->get();
      $noInvoice       = true;
      $event = Event::query()->where('id','>=',$pickup->last_event)->get();
      /**
      *  Se valida que la sesion este activa
      */
      if ($session == null) {
        return redirect('login');
      }
      /**
      *
      */
      $companyclient="";
      if(isset($pickup->to_client)){
        $client          = Client::find($pickup->to_client);
        $companyclient   = Company::find($client->company);
      }
      /**
      *
      */
      $vars = [
        'package'      => $pickup,
        'detailspack'  => $detailspackage,
        'packageLog'   => $packageLog,
        'event'        => $event,
        'invoice'      => $invoice,
        'companyclient'=> $companyclient,
        'noInvoice'    => $noInvoice
      ];

      /**
      * Se obtiene la vista para ver detalles del paquete
      */
      if($this->isGET($request)) {
        return view('pages.admin.pickup.view', $vars);
      }
    }
    /**
    *
    */
    private function validateData(Request $request, $max) {
      return Validator::make($this->clear($request->all()), [
        'concept'     => 'required|string|min:5|max:100',
        'type'        => 'required',
        'value'       => 'required|numeric|min:1|max:'.$max,
        'observation' => 'required|string|min:5|max:100'
      ]);
    }

    public function airwayBill (Request $request, $id){
      /*
      * Seccion de lectura de los datos a utilizar
      */
      $configuration = Configuration::find(1);
      $timezone = explode(" ", $configuration->time_zone);
      date_default_timezone_set($timezone[0]);
      $shipment = shipment::find($id);
      $shipper = User::find($shipment->shipper);
      $consigner = User::find($shipment->consigner);
      $transporter = Transporters::find($shipment->transporter);
      $shipmentdetail = ShipmentDetail::query()->where('shipment','=',$id)->get();
      $shipmentroute = ShipmentRoute::query()->where('shipment','=',$id)->first();
      $airport1 = City::find($shipmentroute->from_city_departure);
      $airport2 = City::find($shipmentroute->from_city_arrived);

      $iata_origin = IataCode::find($shipment->from_airport);
      $iata_destin = IataCode::find($shipment->to_airport);

      $packages = Package::query()->where('process','=',$shipment->code)->get();
      $packs = Package::query()->where('process','=',$shipment->code)->count();
      /**
       *       Usar esta variable para crear nuevas paginas
       */

      /*

      *DEFINICION DEL PDF
      */
      $fpdi = new \fpdi\FPDI();
      $fpdf = new \fpdf\FPDF();
      $fpdi->SetAutoPageBreak(true,1);
      $pageCount = $fpdi->setSourceFile('tmpreport/AWB.pdf');
      $tplIdx    = $fpdi->importPage(1, '/BleedBox');
      $fpdi->SetTitle(utf8_decode('Air Way Bill'));

      $flag = 0;
      for ($i=0; $i < ($packs/6); $i++) {
        $y = 22; //Coordenada Y de los items para el pdf
        $x = 11; //Coordenada X de los items para el pdf

          $fpdi->addPage();
          $fpdi->useTemplate($tplIdx, 0, 0, 210, 279-5);

          $nombre = $configuration->logo_ics;
          $isJPG = strrpos($nombre,".jpg");
          if((!($isJPG)) && ($nombre!=null)) {
            $fpdi->Image(isset($configuration) ? ($configuration->logo_ics == '') ? asset('/dist/images/logoazul.jpg') : $configuration->logo_ics : asset('/dist/images/logoazul.png'),150,3,30,0,'PNG');
          }
          if($isJPG) {
            $fpdi->Image(isset($configuration) ? ($configuration->logo_ics == '') ? asset('/dist/images/logoazul.jpg') : $configuration->logo_ics : asset('/dist/images/logoazul.jpg'),130,3,30,0,'JPG');
          }

          $fpdi->SetFont('Arial','',11);
          $fpdi->SetTextColor(0, 0, 0);
          $fpdi->SetXY(24, 15);
          $fpdi->MultiCell(85, 3, isset($iata_origin) ? strtoupper($iata_origin->iata): '');
          $fpdi->SetXY(0, 15);
          $num = isset($shipment->code) ? str_replace("SHP-0",'',$shipment->code) : '';
          //$fpdi->MultiCell(23, 3, isset($num) ? strtoupper($num): '' ,0,'R');
          $fpdi->MultiCell(23, 3, 'HA' ,0,'R');

          //NUMBER GUIDE ON TOP
          $fpdi->SetXY(35, 15);
          $fpdi->MultiCell(85, 3, isset($shipment->number_guide) ? strtoupper($shipment->number_guide): '');

          $fpdi->SetFont('Arial','',8 );

          try {
            //NOMBRE Y DIRECCION DEL REMITENTE
            $fpdi->SetXY($x, ++$y);
            $fpdi->MultiCell(85, 3, isset($shipper) ? ucwords($shipper->name.' '.$shipper->last_name) : '');
            $fpdi->SetXY($x, $y+3);
            $fpdi->MultiCell(85, 3, isset($shipper) ? strtoupper($shipper->address) : '');
            $fpdi->SetXY($x, $y+6);
            $fpdi->MultiCell(85, 3, isset($shipper) ? $shipper->postal_code.', '.$shipper->city : '');
            $fpdi->SetXY($x, $y+9);
            $fpdi->MultiCell(85, 3, isset($shipper) ? ucwords($shipper->region.', '.$shipper->country) : '');
            $fpdi->SetXY($x, $y+12);
            $fpdi->MultiCell(85, 3, isset($shipper) ? 'PHONE: '.$shipper->celular : '');

            //AIRWAY EMITIDO POR
            $x+=130;
            $fpdi->SetXY($x, $y-2);
            $fpdi->MultiCell(85, 3, isset($configuration->name_company) ? $configuration->name_company: 'International Cargo System');
            $fpdi->SetXY($x, $y+1);
            $fpdi->MultiCell(85, 3, isset($configuration->dni_company) ? 'DNI: '.$configuration->dni_company: 'DNI:1234567890');
            $fpdi->SetXY($x, $y+4);
            $fpdi->MultiCell(85, 3, isset($configuration->email_company) ? $configuration->email_company: 'www.internationalcargosystem.com');
            $fpdi->SetXY($x, $y+7);
            $fpdi->MultiCell(85, 3, isset($configuration->city_company) ? $configuration->city_company.', '.$configuration->region_company: 'DNI:1234567890');
            $fpdi->SetXY($x, $y+10);
            $country_company = isset($configuration->country_company) ? Country::find($configuration->country_company) : null;
            $fpdi->MultiCell(85, 3, isset($country_company) ? strtoupper($country_company->name): '');

            //NOMBRE Y DIRECCION DEL CONSIGNATARIO
            $y += 23;
            $x-=130;
            $fpdi->SetXY($x, $y);
            $fpdi->MultiCell(85, 3, isset($consigner) ? ucwords($consigner->name.' '.$consigner->last_name) : '');
            $fpdi->SetXY($x, $y+3);
            $fpdi->MultiCell(85, 3, isset($consigner) ? strtoupper($consigner->address) : '');
            $fpdi->SetXY($x, $y+6);
            $fpdi->MultiCell(85, 3, isset($consigner) ? $consigner->postal_code.', '.$consigner->city : '');
            $fpdi->SetXY($x, $y+9);
            $fpdi->MultiCell(85, 3, isset($consigner) ? ucwords($consigner->region.', '.$consigner->country) : '');
            $fpdi->SetXY($x, $y+12);
            $fpdi->MultiCell(85, 3, isset($consigner) ? 'PHONE: '.$consigner->celular : '');

            //TRANSPORTISTA EMISOR
            $y += 23;
            $fpdi->SetXY($x, $y);
            $fpdi->MultiCell(85, 3, isset($transporter) ? $transporter->name : '');
            $fpdi->SetXY($x, $y+3);
            $fpdi->MultiCell(85, 3, isset($transporter) ? (isset($transporter->address_city) ? ($transporter->address_city).', ': '').(isset($transporter->address_state) ? $transporter->address_state.', ' : '').( isset($transporter->address_country) ? $transporter->address_country : '') : '');
            $fpdi->SetXY($x, $y+6);
            $fpdi->MultiCell(85, 3, isset($transporter) ? 'PHONE: '.$transporter->phone : '');
            $fpdi->SetXY($x, $y+9);
            $fpdi->MultiCell(85, 3, isset($transporter) ? $transporter->email : '');

            $fpdi->SetXY($x+100, $y+1);
            $fpdi->MultiCell(85, 3, isset($shipment->invoice_number) && isset($shipment->po_number) ? 'INV: '.$shipment->invoice_number.' PO: '.$shipment->po_number : '');

            //CODIGO IATA DEL AGENTE
            $fpdi->SetXY($x, $y+16);
            $fpdi->MultiCell(85, 3, isset($transporter) ? $transporter->code : '');

            //Cuenta nro
            $fpdi->SetXY($x+48, $y+16);
            $fpdi->MultiCell(85, 3, isset($transporter) ? $transporter->account_number : '');

            //Aeropuerto de salida (direccion de primer transportista)
            $fpdi->SetXY($x, $y+24);
            $fpdi->MultiCell(85, 3, isset($iata_origin) ? ucwords($iata_origin->iata.' - '.$iata_origin->name) : '');

            //A
            $fpdi->SetXY($x-1, $y+32);
            $fpdi->MultiCell(85, 3, isset($airport1->name) ? '' : '');

            //Enrutamiento y Destino
            $fpdi->SetXY($x, $y+32.5);
            $fpdi->MultiCell(85, 3, isset($iata_destin) ? ucwords($iata_destin->iata) : '');
            $fpdi->SetXY($x+10, $y+32.5);
            $fpdi->MultiCell(85, 3, isset($transporter->name) ? ucwords($transporter->name) : '');

            // a/por a/por
            $fpdi->SetXY($x+57-1, $y+32);
            $fpdi->MultiCell(85, 3, isset($iata_destin) ? $iata_destin->iata : '');

            $fpdi->SetXY($x+67-1, $y+32);
            $fpdi->MultiCell(85, 3, isset($iata_origin) ? $iata_origin->iata : '');

            $fpdi->SetXY($x+74, $y+32);
            $fpdi->MultiCell(85, 3, '');

            $fpdi->SetXY($x+84, $y+32);
            $fpdi->MultiCell(85, 3, isset($iata_origin) ? $iata_origin->iata : '');

            //MONEDA
            $fpdi->SetXY($x+92, $y+32);
            $currency = Currency::find($shipment->currency);
            $fpdi->MultiCell(85, 3, isset($currency) ? $currency->code : '');

            //CGHS CARGOS
            $fpdi->SetXY($x+101, $y+32.5);

            $cghs = null;

            if(isset($shipment->type_payment)){
              if ($shipment->type_payment == 1) { $cghs = 'CA';}
              if ($shipment->type_payment == 2) { $cghs = 'CB';}
              if ($shipment->type_payment == 3) { $cghs = 'CC';}
              if ($shipment->type_payment == 4) { $cghs = 'CE';}
              if ($shipment->type_payment == 5) { $cghs = 'CG';}
              if ($shipment->type_payment == 6) { $cghs = 'CH';}
              if ($shipment->type_payment == 7) { $cghs = 'CP';}
              if ($shipment->type_payment == 8) { $cghs = 'CX';}
              if ($shipment->type_payment == 9) { $cghs = 'CZ';}
              if ($shipment->type_payment == 10) { $cghs = 'NC';}
              if ($shipment->type_payment == 11) { $cghs = 'NG';}
              if ($shipment->type_payment == 12) { $cghs = 'NP';}
              if ($shipment->type_payment == 13) { $cghs = 'NT';}
              if ($shipment->type_payment == 14) { $cghs = 'NX';}
              if ($shipment->type_payment == 15) { $cghs = 'NZ';}
              if ($shipment->type_payment == 16) { $cghs = 'PC';}
              if ($shipment->type_payment == 17) { $cghs = 'PD';}
              if ($shipment->type_payment == 18) { $cghs = 'PE';}
              if ($shipment->type_payment == 19) { $cghs = 'PF';}
              if ($shipment->type_payment == 20) { $cghs = 'PG';}
              if ($shipment->type_payment == 21) { $cghs = 'PH';}
              if ($shipment->type_payment == 22) { $cghs = 'PP';}
              if ($shipment->type_payment == 23) { $cghs = 'PX';}
              if ($shipment->type_payment == 24) { $cghs = 'PZ' ;}
            }
            $fpdi->MultiCell(85, 3, isset($cghs) ? $cghs : '');

            //PPD
            $fpdi->SetFillColor(255, 255, 255);
            $fpdi->SetXY($x+107.7, $y+31.9);
            $fpdi->MultiCell(4.5, 3.9, '', 0,'L',true);
            $fpdi->SetXY($x+118.1, $y+31.9);
            $fpdi->MultiCell(4.5, 3.9, '', 0,'L',true);

            if ($shipment->payment == 1) {
              $fpdi->SetFont('Arial','',12.5 );
              $fpdi->SetXY($x+107.7, $y+31.9);
              $fpdi->MultiCell(5, 3.9, 'X', 0,'L',true);
              $fpdi->SetXY($x+118.2, $y+31.9);
              $fpdi->MultiCell(5, 3.9, 'X', 0,'L',true);
              $fpdi->SetFont('Arial','',8 );
            }
            if ($shipment->payment == 2) {
              $fpdi->SetFont('Arial','',12.5 );
              $fpdi->SetXY($x+107.7+5, $y+31.9);
              $fpdi->MultiCell(5, 3.9, 'X', 0,'L',true);
              $fpdi->SetXY($x+118.2+5, $y+31.9);
              $fpdi->MultiCell(5, 3.9, 'X', 0,'L',true);
              $fpdi->SetFont('Arial','',8 );
            }


            //Aeropuerto de Destino
            $fpdi->SetXY($x, $y+41);
            $fpdi->MultiCell(85, 3, isset($airport2->name) ? ucwords($airport2->name) : '');

            //FECHA DE VUELO
            $fpdi->SetXY($x+46, $y+41);
            $fpdi->MultiCell(85, 3, isset($shipment->realizate_city_date) ? ucwords($shipment->realizate_city_date) : '');
            //FECHA DE VUELO
            $fpdi->SetXY($x+69, $y+41);
            $fpdi->MultiCell(85, 3, isset($shipment->realizate_city_date) ? ucwords($shipment->realizate_city_date) : '');
            //FECHA DE VUELO
            $fpdi->SetXY($x+94, $y+41);
            $fpdi->MultiCell(15, 3, isset($shipment->insurance).'%' ? ucwords($shipment->insurance).'%' : '',0,'C');
            //Valor Declarado Trans
            $fpdi->SetXY($x+137, $y+32);
            $fpdi->MultiCell(85, 3, isset($shipment->declarate_value) ? $shipment->declarate_value.'$' : 'NVD');
            //Valor Declarado Aduana
            $fpdi->SetXY($x+168, $y+32);
            $fpdi->MultiCell(85, 3, isset($shipment->declarate_value) ? $shipment->declarate_value.'$' : 'NVD');

            //Airport of Destination
            $fpdi->SetXY($x-1, $y+40);
            $fpdi->MultiCell(85, 3, isset($iata_destin) ? $iata_destin->name:'');

            //Codigo CHGS
            $fpdi->SetXY($x+102, $y+32.5);
            $fpdi->MultiCell(85, 3, '');
            //PPD
            $fpdi->SetXY($x+108, $y+32.5);
            $fpdi->MultiCell(85, 3, '');
            //Coll
            $fpdi->SetXY($x+113, $y+32.5);
            $fpdi->MultiCell(85, 3, '');
            //PPD
            $fpdi->SetXY($x+118, $y+32.5);
            $fpdi->MultiCell(85, 3, '');
            //Coll
            $fpdi->SetXY($x+123, $y+32.5);
            $fpdi->MultiCell(85, 3, '');
            $h=$y;
            $total = 0;
            $total_piezas = 0;
            $total_peso = 0;
            for ($j=0; ($j < 6)&&($flag<$packs); $j++) {
              if ($flag <= 0) {
                $package = $packages[$j];
              }else {
                $package = $packages[$flag];
              }
              $details = Detailspackage::query()->where('package','=',$package->id)->count();
              $detailspackage = Detailspackage::query()->where('package','=',$package->id)->get();
              $detail_first = Detailspackage::query()->where('package','=',$package->id)->first();

              $weight = 0;
              foreach ($detailspackage as $key => $detail) {
                $weight += $detail->weight;
              }

              //NUMERO DE PIEZAS
              $fpdi->SetXY($x-3, $y+70);
              $fpdi->MultiCell(15, 3, isset($details) ? $details : '',0,'C');
              $total_piezas += $details;

              //PESO
              $fpdi->SetXY($x+4, $y+70);
              $fpdi->MultiCell(30, 3, isset($weight) ? $weight : '',0,'C');

              //PESO
              $fpdi->SetXY($x+4, $y+73);
              $fpdi->MultiCell(30, 3, isset($weight) ? '\''.number_format($weight/(2.2046),2,',','.').'\'' : '',0,'C');

              $total_peso += $weight;
              //LB/KG
              $fpdi->SetFont('Arial','',8);
              $fpdi->SetXY($x+14.2, $y+70);
              $fpdi->MultiCell(30, 3, 'lb',0,'C');

              $fpdi->SetXY($x+14.2, $y+73);
              $fpdi->MultiCell(30, 3, 'kg',0,'C');

              //Comodities Number
              $fpdi->SetXY($x+29, $y+70);
              $fpdi->MultiCell(30, 3, isset($package->code) ? $package->code : '',0,'C');

              //Chargeable Weight
              $fpdi->SetXY($x+50, $y+70);
              $fpdi->MultiCell(30, 3, isset($weight) ? $weight : '',0,'C');

              //Value
              $fpdi->SetXY($x+65, $y+70);
              $fpdi->MultiCell(30, 3, isset($detail_first->value) ? number_format($detail_first->value,2,',','.') : '',0,'R');
              $total += isset($detail_first->value) ? $detail_first->value : 0;

              //Total
              $fpdi->SetXY($x+95, $y+70);
              $fpdi->MultiCell(30, 3, isset($total) ? number_format($total,2,',','.') : '',0,'R');

              //Nature and Quantity of Goods
              $fpdi->SetXY($x+135, $y+70);
              $fpdi->MultiCell(45, 3, isset($detail_first->description) ? strtoupper($detail_first->description) : '',0,'L');

              $y+=8;

              $flag++;
            }
            $y=$h+10;

            $fpdi->SetXY($x+10, $y+38);
            if ($shipment->dangerous == 1) {
              $fpdi->MultiCell(90, 3,'Dangerous Goods as per attached Shipper\'s Declaration');
            }

            $fpdi->SetXY($x+80, $y+47);
            $country_des = isset($shipment->to_country) ? Pais::find($shipment->to_country) : null;
            $fpdi->SetFont('Arial','B',9);
            $fpdi->MultiCell(50, 3,isset($country_des) ? strtoupper($country_des->name) : '',0,'C');
            $fpdi->SetFont('Arial','',8);
            $fpdi->SetXY($x-3, $y+110);
            $fpdi->MultiCell(15, 3, isset($total_piezas) ? $total_piezas : '',0,'C');
            //PESO
            $fpdi->SetXY($x+4, $y+110);
            $fpdi->MultiCell(30, 3, isset($total_peso) ? $total_peso : '',0,'C');

            $fpdi->SetXY($x+95, $y+110);
            $fpdi->MultiCell(30, 3, isset($total) ? number_format($total,2,',','.') : '',0,'R');

            $fpdi->SetFont('Arial','B',9);
            if ($shipment->payment == 1) {
              $fpdi->SetXY($x, $y+118);
              $fpdi->MultiCell(30, 3, isset($total_peso) ? number_format($total_peso) : '' ,0,'R');

              $fpdi->SetXY($x, $y+125);
              $fpdi->MultiCell(30, 3,  isset($total) ? number_format($total,2,',','.') : '' ,0,'R');

              $fpdi->SetXY($x, $y+133);
              $fpdi->MultiCell(30, 3,  isset($shipment->tax) ? $shipment->tax.'%' : '' ,0,'R');

              $fpdi->SetXY($x, $y+142);
              $fpdi->MultiCell(30, 3,  isset($shipment->agent_charges) ? number_format($shipment->agent_charges) : '' ,0,'R');

              $fpdi->SetXY($x, $y+150);
              $fpdi->MultiCell(30, 3,  isset($shipment->transport_charges) ? number_format($shipment->transport_charges) : '' ,0,'R');
              //TOTAL
              $total += (isset($shipment->tax) && ($shipment->tax>0)) ? ($total * $shipment->tax)/100 : 0;
              $total +=  $shipment->agent_charges + $shipment->transport_charges;
              $fpdi->SetXY($x, $y+166);
              $fpdi->MultiCell(30, 3, isset($total) ? number_format($total,2,',','.') : '',0,'R');

            }
            if ($shipment->payment == 2) {

              $fpdi->SetXY($x+35, $y+118);
              $fpdi->MultiCell(30, 3, isset($total_peso) ? number_format($total_peso) : '' ,0,'R');

              $fpdi->SetXY($x+35, $y+125);
              $fpdi->MultiCell(30, 3,  isset($total) ? number_format($total,2,',','.') : '' ,0,'R');

              $fpdi->SetXY($x+35, $y+133);
              $fpdi->MultiCell(30, 3,  isset($shipment->tax) ? $shipment->tax.'%' : '' ,0,'R');

              $fpdi->SetXY($x+35, $y+142);
              $fpdi->MultiCell(30, 3,  isset($shipment->agent_charges) ? number_format($shipment->agent_charges) : '' ,0,'R');

              $fpdi->SetXY($x+35, $y+150);
              $fpdi->MultiCell(30, 3,  isset($shipment->transport_charges) ? number_format($shipment->transport_charges) : '' ,0,'R');
              //TOTAL
              $total +=  $shipment->agent_charges + $shipment->transport_charges;
              $total = ($total * $shipment->tax)/100;
              $fpdi->SetXY($x+35, $y+166);
              $fpdi->MultiCell(30, 3, isset($total) ? number_format($total,2,',','.') : '',0,'R');

            }
            $fpdi->SetFont('Arial','',9);
            $fpdi->SetXY($x+75, $y+150);
            $fpdi->MultiCell(85, 3, isset($transporter) ? strtoupper($transporter->name) : '',0,'l');
            $fpdi->SetXY($x+75, $y+153);
            $fpdi->MultiCell(85, 3, isset($transporter) ? 'Authorized Agent: '.strtoupper($transporter->name_contac.' '.$transporter->lastname_contac) : '',0,'L');

            $fpdi->SetXY($x+75, $y+170);
            $external = $shipment->realizate_city_date.' '.$shipment->realizate_city_hour;
            $dateobj = new DateTime($external);
            $fpdi->MultiCell(85, 3, isset($dateobj) ? $dateobj->format('M/d/Y') : '',0,'l');

            $fpdi->SetXY($x+87 , $y+170);
            $fpdi->MultiCell(85, 3, isset($shipment->realizate_city_place) ? strtoupper($shipment->realizate_city_place) : '',0,'C');

            $fpdi->SetFont('Arial','',13);
            $fpdi->SetXY($x+160, $y+180);
            $fpdi->MultiCell(85, 3, isset($shipment->number_guide) ? 'HA  '.strtoupper($shipment->number_guide): '');
          } catch (Exception $e) {
            dd('error: '.$e);
          }
      }
      $fpdi->Output();
}

public function airwayBillHouse (Request $request, $id){
  $y = 22; //Coordenada Y de los items para el pdf
  $x = 11; //Coordenada X de los items para el pdf

  /*
  * Seccion de lectura de los datos a utilizar
  */
  $configuration = Configuration::find(1);
  $timezone = explode(" ", $configuration->time_zone);
  date_default_timezone_set($timezone[0]);
  $package = Package::find($id);
  $shipper = User::find($package->to_user);
  $consigner = User::find($package->consigner_user);
  if ($package->shipper_is == 2) {
    $transporter = Transporters::find($shipment->transporter);
  }
  $package_detail = Detailspackage::query()->where('package','=',$id)->get();
  /*
  *DEFINICION DEL PDF
  */
  $fpdi = new \fpdi\FPDI();
  $fpdf = new \fpdf\FPDF();
  $fpdi->SetAutoPageBreak(true,1);
  $pageCount = $fpdi->setSourceFile('tmpreport/AWB.pdf');
  $tplIdx    = $fpdi->importPage(1, '/BleedBox');
  $fpdi->SetTitle(utf8_decode('Air Way Bill'));

  $fpdi->addPage();
  $fpdi->useTemplate($tplIdx, 0, 0, 210, 279-5);

  $nombre = $configuration->logo_ics;
  $isJPG = strrpos($nombre,".jpg");
  if((!($isJPG)) && ($nombre!=null)) {
    $fpdi->Image(isset($configuration) ? ($configuration->logo_ics == '') ? asset('/dist/images/logoazul.jpg') : $configuration->logo_ics : asset('/dist/images/logoazul.png'),150,3,30,0,'PNG');
  }
  if($isJPG) {
    $fpdi->Image(isset($configuration) ? ($configuration->logo_ics == '') ? asset('/dist/images/logoazul.jpg') : $configuration->logo_ics : asset('/dist/images/logoazul.jpg'),130,3,30,0,'JPG');
  }
  //dd($courier);
  /*
  $fpdi->SetFont('Arial','B',11);
  $fpdi->SetTextColor(59, 59, 59);
  $fpdi->SetXY(45, 2+1);
  $fpdi->MultiCell(85, 3, isset($configuration->name_company) ? $configuration->name_company: 'International Cargo System');

  $fpdi->SetFont('Arial','',11);
  $fpdi->SetTextColor(59, 59, 59);
  $fpdi->SetXY(45, 6+1);
  $fpdi->MultiCell(85, 3, isset($configuration->dni_company) ? $configuration->dni_company: 'DNI:1234567890');

  $fpdi->SetFont('Arial','',11);
  $fpdi->SetTextColor(0, 0, 0);
  $fpdi->SetXY(45, 10+1);
  $fpdi->MultiCell(85, 3, isset($configuration->email_company) ? $configuration->email_company: 'www.internationalcargosystem.com');
*/
  $fpdi->SetFont('Arial','',11);
  $fpdi->SetTextColor(0, 0, 0);
  $fpdi->SetXY(24, 15);
  $fpdi->MultiCell(85, 3, isset($iata_origin) ? strtoupper($iata_origin->iata): '');
  $fpdi->SetXY(0, 15);
  $num = isset($package->code) ? str_replace("WRH-0",'',$package->code) : '';
  //$fpdi->MultiCell(23, 3, isset($num) ? strtoupper($num): '' ,0,'R');
  $fpdi->MultiCell(23, 3, 'HA' ,0,'R');

  //NUMBER GUIDE ON TOP
  $fpdi->SetXY(35, 15);
  $fpdi->MultiCell(85, 3, isset($package->code) ? strtoupper($package->code): '');

  $fpdi->SetFont('Arial','',8 );

  try {
    //NOMBRE Y DIRECCION DEL REMITENTE
    $fpdi->SetXY($x, ++$y);
    $fpdi->MultiCell(85, 3, isset($shipper) ? ucwords($shipper->name.' '.$shipper->last_name) : '');
    $fpdi->SetXY($x, $y+3);
    $fpdi->MultiCell(85, 3, isset($shipper) ? strtoupper($shipper->address) : '');
    $fpdi->SetXY($x, $y+6);
    $fpdi->MultiCell(85, 3, isset($shipper) ? $shipper->postal_code.', '.$shipper->city : '');
    $fpdi->SetXY($x, $y+9);
    $fpdi->MultiCell(85, 3, isset($shipper) ? ucwords($shipper->region.', '.$shipper->country) : '');
    $fpdi->SetXY($x, $y+12);
    $fpdi->MultiCell(85, 3, isset($shipper) ? 'PHONE: '.$shipper->celular : '');

    //AIRWAY EMITIDO POR
    $x+=130;
    $fpdi->SetXY($x, $y-2);
    $fpdi->MultiCell(85, 3, isset($configuration->name_company) ? $configuration->name_company: 'International Cargo System');
    $fpdi->SetXY($x, $y+1);
    $fpdi->MultiCell(85, 3, isset($configuration->dni_company) ? 'DNI: '.$configuration->dni_company: 'DNI:1234567890');
    $fpdi->SetXY($x, $y+4);
    $fpdi->MultiCell(85, 3, isset($configuration->email_company) ? $configuration->email_company: 'www.internationalcargosystem.com');
    $fpdi->SetXY($x, $y+7);
    $fpdi->MultiCell(85, 3, isset($configuration->city_company) ? $configuration->city_company.', '.$configuration->region_company: 'DNI:1234567890');
    $fpdi->SetXY($x, $y+10);
    $country_company = isset($configuration->country_company) ? Country::find($configuration->country_company) : null;
    $fpdi->MultiCell(85, 3, isset($country_company) ? strtoupper($country_company->name): '');

    //NOMBRE Y DIRECCION DEL CONSIGNATARIO
    $y += 23;
    $x-=130;
    $fpdi->SetXY($x, $y);
    $fpdi->MultiCell(85, 3, isset($consigner) ? ucwords($consigner->name.' '.$consigner->last_name) : '');
    $fpdi->SetXY($x, $y+3);
    $fpdi->MultiCell(85, 3, isset($consigner) ? strtoupper($consigner->address) : '');
    $fpdi->SetXY($x, $y+6);
    $fpdi->MultiCell(85, 3, isset($consigner) ? $consigner->postal_code.', '.$consigner->city : '');
    $fpdi->SetXY($x, $y+9);
    $fpdi->MultiCell(85, 3, isset($consigner) ? ucwords($consigner->region.', '.$consigner->country) : '');
    $fpdi->SetXY($x, $y+12);
    $fpdi->MultiCell(85, 3, isset($consigner) ? 'PHONE: '.$consigner->celular : '');

    //TRANSPORTISTA EMISOR
    $y += 23;
    $fpdi->SetXY($x, $y);
    $fpdi->MultiCell(85, 3, isset($transporter) ? $transporter->name : '');
    $fpdi->SetXY($x, $y+3);
    $fpdi->MultiCell(85, 3, (isset($transporter->address_city)&&($transporter->address_city!=''))&&(isset($transporter->address_state)&&($transporter->address_state!=''))&&(isset($transporter->address_country)&&($transporter->address_country!=0)) ? $transporter->address_city.', '.$transporter->address_state.', '.$transporter->address_country : '');
    $fpdi->SetXY($x, $y+6);
    $fpdi->MultiCell(85, 3, isset($transporter) ? 'PHONE: '.$transporter->phone : '');
    $fpdi->SetXY($x, $y+9);
    $fpdi->MultiCell(85, 3, isset($transporter) ? $transporter->email : '');

    //CODIGO IATA DEL AGENTE
    $fpdi->SetXY($x, $y+16);
    $fpdi->MultiCell(85, 3, isset($transporter) ? $transporter->code : '');

    //Cuenta nro
    $fpdi->SetXY($x+50, $y+16);
    $fpdi->MultiCell(85, 3, isset($transporter) ? '' : '');

    //Aeropuerto de salida (direccion de primer transportista)
    $ruta = Route::find($package->details_type);
    $origin_city = City::find($ruta->origin_city);
    $destiny_city = City::find($ruta->destiny_city);
    $fpdi->SetXY($x, $y+24);
    $fpdi->MultiCell(85, 3, isset($origin_city) ? strtoupper($origin_city->name) : '');

    //A
    $fpdi->SetXY($x-1, $y+32);
    $fpdi->MultiCell(85, 3, isset($airport1->name) ? '' : '');

    //Enrutamiento y Destino
    $fpdi->SetXY($x, $y+32.5);
    $fpdi->MultiCell(85, 3, isset($iata_destin) ? ucwords($iata_destin->iata) : '');
    $fpdi->SetXY($x+10, $y+32.5);
    $fpdi->MultiCell(85, 3, isset($destiny_city->name) ? strtoupper($destiny_city->name) : '');

    // a/por a/por
    $fpdi->SetXY($x+57-1, $y+32);
    $fpdi->MultiCell(85, 3, isset($iata_destin) ? $iata_destin->iata : '');

    $fpdi->SetXY($x+67-1, $y+32);
    $fpdi->MultiCell(85, 3, isset($iata_origin) ? $iata_origin->iata : '');

    $fpdi->SetXY($x+74, $y+32);
    $fpdi->MultiCell(85, 3, '');

    $fpdi->SetXY($x+84, $y+32);
    $fpdi->MultiCell(85, 3, isset($iata_origin) ? $iata_origin->iata : '');

    //PPD
    $fpdi->SetFillColor(255, 255, 255);
    $fpdi->SetXY($x+107.7, $y+31.9);
    $fpdi->MultiCell(4.5, 3.9, '', 0,'L',true);
    $fpdi->SetXY($x+118.1, $y+31.9);
    $fpdi->MultiCell(4.5, 3.9, '', 0,'L',true);
    //MONEDA
    /*$fpdi->SetXY($x+92, $y+32);
    $currency = Currency::find($shipment->currency);
    $fpdi->MultiCell(85, 3, isset($currency) ? $currency->code : '');*/

    //CGHS CARGOS
    $fpdi->SetXY($x+101, $y+32.5);

    $cghs = null;


      $details = Detailspackage::query()->where('package','=',$package->id)->count();
      $detailspackage = Detailspackage::query()->where('package','=',$package->id)->get();
      $detail_first = Detailspackage::query()->where('package','=',$package->id)->first();

      $weight = 0;
      foreach ($detailspackage as $key => $detail) {
        $weight += $detail->weight;
      }
      $total_piezas = 0;
      $total_peso = 0;
      $total = 0;
      //NUMERO DE PIEZAS
      $fpdi->SetXY($x-3, $y+70);
      $fpdi->MultiCell(15, 3, isset($details) ? $details : '',0,'C');
      $total_piezas += $details;
      //PESO
      $fpdi->SetXY($x+4, $y+70);
      $fpdi->MultiCell(30, 3, isset($weight) ? $weight : '',0,'C');
      $total_peso += $weight;
      //LB/KG
      $fpdi->SetFont('Arial','',8);
      $fpdi->SetXY($x+14.2, $y+70);
      $fpdi->MultiCell(30, 3, 'lb',0,'C');

      //Comodities Number
      $fpdi->SetXY($x+29, $y+70);
      $fpdi->MultiCell(30, 3, isset($package->code) ? $package->code : '',0,'C');

      //Chargeable Weight
      $fpdi->SetXY($x+50, $y+70);
      $fpdi->MultiCell(30, 3, isset($weight) ? $weight : '',0,'C');

      //Value
      $fpdi->SetXY($x+65, $y+70);
      $fpdi->MultiCell(30, 3, isset($detail_first->value) ? number_format($detail_first->value,2,',','.') : '',0,'R');
      $total += $detail_first->value;

      //Total
      $fpdi->SetXY($x+95, $y+70);
      $fpdi->MultiCell(30, 3, isset($total) ? number_format($total,2,',','.') : '',0,'R');

      //Nature and Quantity of Goods
      $fpdi->SetXY($x+135, $y+70);
      $fpdi->MultiCell(45, 3, isset($detail_first->description) ? strtoupper($detail_first->description) : '',0,'L');

    $y=$y+10;

    $fpdi->SetXY($x+80, $y+47);
    //$country_des = isset($shipment->to_country) ? Pais::find($shipment->to_country) : null;
    $fpdi->SetFont('Arial','B',9);
    $fpdi->MultiCell(50, 3,isset($country_des) ? strtoupper($country_des->name) : '',0,'C');
    $fpdi->SetFont('Arial','',8);
    $fpdi->SetXY($x-3, $y+110);
    $fpdi->MultiCell(15, 3, isset($total_piezas) ? $total_piezas : '',0,'C');
    //PESO
    $fpdi->SetXY($x+4, $y+110);
    $fpdi->MultiCell(30, 3, isset($total_peso) ? $total_peso : '',0,'C');

    $fpdi->SetXY($x+95, $y+110);
    $fpdi->MultiCell(30, 3, isset($total) ? number_format($total,2,',','.') : '',0,'R');

    $fpdi->SetFont('Arial','B',9);
    $fpdi->SetFont('Arial','',9);
    $fpdi->SetXY($x+75, $y+150);
    $fpdi->MultiCell(85, 3, isset($transporter) ? strtoupper($transporter->name) : '',0,'l');
    $fpdi->SetXY($x+75, $y+153);
    $fpdi->MultiCell(85, 3, isset($transporter) ? 'Authorized Agent: '.strtoupper($transporter->name_contac.' '.$transporter->lastname_contac) : '',0,'L');

    $fpdi->SetXY($x+75, $y+170);
    $fpdi->MultiCell(85, 3, isset($shipment->created_at) ? $shipment->created_at->format('M/d/Y') : '',0,'l');

    $fpdi->SetXY($x+87 , $y+170);
    $fpdi->MultiCell(85, 3, isset($shipment->realizate_city_place) ? strtoupper($shipment->realizate_city_place) : '',0,'C');

    $fpdi->SetXY($x+160, $y+180);
    $fpdi->MultiCell(85, 3, isset($shipment->number_guide) ? 'HA  '.strtoupper($shipment->number_guide): '');

    $fpdi->SetXY($x, $y+126);
    $fpdi->MultiCell(30, 3, isset($total) ? number_format($total,2,',','.') : '',0,'R');
    $fpdi->SetXY($x, $y+166);
    $fpdi->MultiCell(30, 3, isset($total) ? number_format($total,2,',','.') : '',0,'R');

  } catch (Exception $e) {
    dd('error: '.$e);
  }
  $fpdi->Output();
}

    /*
    *Bookings
    */
    public function bookingReceipt (Request $request, $id){
      $configuration = Configuration::find(1);
      $timezone = explode(" ", $configuration->time_zone);
      date_default_timezone_set($timezone[0]);
      $y = 37; //Coordenada Y de los items para el pdf
      $x = 8; //Coordenada X de los items para el pdf
      $booking = Booking::find($id);
      $bookingdetails = BookingDetail::query()->where('booking','=',$id)->get();
      $consigneer = User::find($booking->consigneer);
      $shipper = User::find($booking->shipper);
      $agent = User::find($booking->agent);
      $employee = Operator::find($booking->employee);
      $transporter = Transporters::find($booking->transporter);
      $from_country = Country::find($booking->from_country);
      $to_country = Country::find($booking->to_country);

      $fpdi = new \fpdi\FPDI();
      $fpdf = new \fpdf\FPDF();
      $fpdi->SetAutoPageBreak(true,1);
      $pageCount = $fpdi->setSourceFile('tmpreport/BOOKING.pdf');
      $tplIdx    = $fpdi->importPage(1, '/BleedBox');
      $fpdi->SetTitle(utf8_decode('Reservación'));

      $fpdi->addPage();
      $fpdi->useTemplate($tplIdx, 0, 0, 210, 279-5);

      $nombre = $configuration->logo_ics;
      $isJPG = strrpos($nombre,".jpg");
      if((!($isJPG)) && ($nombre!=null)) {
        $fpdi->Image(isset($configuration) ? ($configuration->logo_ics == '') ? asset('/dist/images/logoazul.jpg') : $configuration->logo_ics : asset('/dist/images/logoazul.png'),5,4,40,0,'PNG');
      }
      if($isJPG) {
        $fpdi->Image(isset($configuration) ? ($configuration->logo_ics == '') ? asset('/dist/images/logoazul.jpg') : $configuration->logo_ics : asset('/dist/images/logoazul.jpg'),5,4,40,0,'JPG');
      }
      //dd($courier);
      $fpdi->SetFont('Arial','B',12);
      $fpdi->SetTextColor(59, 59, 59);
      $fpdi->SetXY(45, 10-2);
      $fpdi->MultiCell(85, 3, isset($configuration->name_company) ? $configuration->name_company: 'International Cargo System');

      $fpdi->SetFont('Arial','',11);
      $fpdi->SetTextColor(59, 59, 59);
      $fpdi->SetXY(45, 15-2);
      $fpdi->MultiCell(85, 3, isset($configuration->dni_company) ? $configuration->dni_company: 'DNI:1234567890');

      $fpdi->SetFont('Arial','',9);
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(45, 20-2);
      $fpdi->MultiCell(85, 3, isset($configuration->email_company) ? $configuration->email_company: 'www.internationalcargosystem.com');

      //SHIPPER
      $fpdi->SetXY($x, $y);
      $fpdi->MultiCell(60, 3, isset($shipper) ? strtoupper($shipper->name.' '.$shipper->last_name) : '',0,'L');
      $fpdi->SetXY($x, $y+3);
      $fpdi->MultiCell(60, 3, isset($shipper) ? strtoupper('PHONE: '.$shipper->celular) : '',0,'L');
      $fpdi->SetXY($x, $y+6);
      $fpdi->MultiCell(60, 3, isset($shipper) ? strtoupper($shipper->postal_code.' '.$shipper->city) : '',0,'L');
      $fpdi->SetXY($x, $y+9);
      $fpdi->MultiCell(60, 3, isset($shipper) ? strtoupper($shipper->region.', '.$shipper->country) : '',0,'L');
      $fpdi->SetXY($x, $y+12);
      $fpdi->MultiCell(60, 3, isset($shipper) ? strtolower($shipper->email) : '',0,'L');

      $x = $x+100;
      //CONSIGNEE
      $fpdi->SetXY($x, $y);
      $fpdi->MultiCell(60, 3, isset($consigneer) ? strtoupper($consigneer->name.' '.$consigneer->last_name) : '',0,'L');
      $fpdi->SetXY($x, $y+3);
      $fpdi->MultiCell(60, 3, isset($consigneer) ? strtoupper('PHONE: '.$consigneer->celular) : '',0,'L');
      $fpdi->SetXY($x, $y+6);
      $fpdi->MultiCell(60, 3, isset($consigneer) ? strtoupper($consigneer->postal_code.' '.$consigneer->city) : '',0,'L');
      $fpdi->SetXY($x, $y+9);
      $fpdi->MultiCell(60, 3, isset($consigneer) ? strtoupper($consigneer->region.', '.$consigneer->country) : '',0,'L');
      $fpdi->SetXY($x, $y+12);
      $fpdi->MultiCell(60, 3, isset($consigneer) ? strtolower($consigneer->email) : '',0,'L');

      $x = $x-100;
      $x = $x+20;
      $y = $y+22;
      //NOTIFICACION
      $fpdi->SetXY($x, $y);
      $fpdi->MultiCell(60, 3,   isset($consigneer) ? 'Notify to Consignee' : '',0,'L');
      //CONTACTO
      $fpdi->SetXY($x, $y+5);
      $fpdi->MultiCell(60, 3, isset($configuration->email_company) ? ucwords($configuration->email_company) : 'www.internationalcargosystem.com',0,'L');
      //TELEFONO
      $fpdi->SetXY($x, $y+10.5);
      $fpdi->MultiCell(60, 3, isset($agent->celular) ? ($agent->celular) : '',0,'L');
      //REFERENCIA
      $fpdi->SetXY($x, $y+15.5);
      $fpdi->MultiCell(60, 3, $booking->reference,0,'L');
      //COTIZACION
      $fpdi->SetXY($x, $y+20.5);
      $fpdi->MultiCell(60, 3, $booking->cotiza,0,'L');
      //GUIA MARITIMA
      $fpdi->SetXY($x, $y+25.5);
      $fpdi->MultiCell(60, 3, isset($booking->guide) ? ($booking->guide) : '',0,'L');
      //EMPLEADOR;
      $fpdi->SetXY($x, $y+30.5);
      $fpdi->MultiCell(60, 3, isset($employee->name) ? ($employee->name) : '',0,'L');
      //CARGA PELIGROSA
      if ($booking->dangerous == 1) {
        $fpdi->SetXY($x+8, $y+34.6);
        $fpdi->MultiCell(60, 3, 'x',0,'L');
      }elseif ($booking->dangerous == 2) {
        $fpdi->SetXY($x+25.4, $y+34.6);
        $fpdi->MultiCell(60, 3, 'x',0,'L');
      }


      $x+=100;
      //AGENTE DE CARGA
      $fpdi->SetXY($x, $y);
      $fpdi->MultiCell(60, 3, isset($configuration->name_company) ? ucwords($configuration->name_company): 'International Cargo System',0,'L');
      //AGENTE
      $fpdi->SetXY($x, $y+5);
      $fpdi->MultiCell(60, 3, isset($agent->name) ? ucwords($agent->name.' '.$agent->last_name) : '',0,'L');
      //TRANSPORTISTA
      $fpdi->SetXY($x, $y+10.5);
      $fpdi->MultiCell(60, 3, isset($transporter->name) ? ucwords($transporter->name) : '',0,'L');
      //BARCO/VIAJE
      $fpdi->SetXY($x, $y+15.5);
      $fpdi->MultiCell(60, 3, isset($booking->vessel) ? ucwords($booking->vessel) : '',0,'L');
      //VIA
      $fpdi->SetXY($x, $y+20.5);
      $fpdi->MultiCell(60, 3, isset($booking->way) ? ucwords($booking->way) : '',0,'L');
      //FECHA SALIDA
      $fpdi->SetXY($x, $y+25.5);
      $fpdi->MultiCell(60, 3, isset($booking->since_departure_date) ? ucwords($booking->since_departure_date) : '',0,'L');
      //FECHA LLEGADA
      $fpdi->SetXY($x+48, $y+25.5);
      $fpdi->MultiCell(60, 3, isset($booking->until_arrived_date) ? ucwords($booking->until_arrived_date) : '',0,'L');
      //FROM COUNTRY
      $fpdi->SetXY($x, $y+30.5);
      $fpdi->MultiCell(60, 3, isset($from_country->name) ? ucwords($from_country->name) : '',0,'L');
      //TO COUNTRY
      $fpdi->SetXY($x, $y+35.5);
      $fpdi->MultiCell(60, 3, isset($to_country->name) ? ucwords($to_country->name) : '',0,'L');

      $y+=53;
      $x=5;
      $total_pieces =0;
      $total_weight =0;
      $total_vol =0;
      foreach ($bookingdetails as $key => $detail) {
        //MARCAS Y NUMERO
        $fpdi->SetXY($x, $y);
        $fpdi->MultiCell(30, 3, isset($booking->code) ? ucwords($booking->code) : '',0,'C');
        //CANTIDAD
        $fpdi->SetXY($x+32, $y);
        $fpdi->MultiCell(30, 3, isset($detail->pieces) ? ucwords($detail->pieces) : '',0,'C');
        $total_pieces += $detail->pieces;
        //DESCRIPTION
        $fpdi->SetXY($x+62, $y);
        $fpdi->MultiCell(85, 3, isset($detail->description) ? ucwords($detail->description) : '',0,'C');
        //PESO
        $fpdi->SetXY($x+138, $y);
        $fpdi->MultiCell(30, 3, isset($detail->weight) ? ucwords($detail->weight).' lb' : '',0,'R');
        $total_weight += $detail->weight;
        //VOLUMEN
        $fpdi->SetXY($x+168, $y);
        $fpdi->MultiCell(30, 3, isset($detail->maritime_volume) ? ucwords($detail->maritime_volume).' ft3' : '',0,'R');
        $total_vol += $detail->maritime_volume;

        $y+=3;
      }
      $x+=121;
      $y= 187;
      $fpdi->SetFont('Arial','B',9);
      //TOTAL PIEZAS
      $fpdi->SetXY($x, $y);
      $fpdi->MultiCell(30, 3, isset($total_pieces) ? ($total_pieces) : '',0,'C');
      //TOTAL PESO
      $fpdi->SetXY($x+26, $y);
      $fpdi->MultiCell(30, 3, isset($total_weight) ? ($total_weight).' lb' : '',0,'C');
      //TOTAL VOL
      $fpdi->SetXY($x+51, $y);
      $fpdi->MultiCell(30, 3, isset($total_vol) ? ($total_vol).' ft3' : '',0,'C');
      $fpdi->SetFont('Arial','',9);
      //NOTAS
      $fpdi->SetXY($x-20, $y+15);
      $fpdi->MultiCell(98, 3, isset($booking->aditional_information) ? ($booking->aditional_information) : '',0,'J');

      $fpdi->Output();
    }

    /**
    *Master Bill Of Lading
    */
    public function masterbill (Request $request, $id){
      $session       = $request->session()->get('key-sesion');
      $shipment      = Shipment::find($id);
      $shipmentroute = ShipmentRoute::query()->where('shipment','=',$id)->first();
      $shipmentdetails = ShipmentDetail::query()->where('shipment','=',$id)->get();


      //dd($shipmentdetails);

      //dd($detailspackage);
      $configuration = Configuration::find(1);
      $timezone = explode(" ", $configuration->time_zone);
      date_default_timezone_set($timezone[0]);
      $consigner     = User::find($shipment->consigner);
      $shipper     = User::find($shipment->shipper);
      $toNotify     = User::find($shipment->entity_to_notify);
      $transportista = Transporters::find($shipment->transporter);

      $detailsTransport = DetailsTransport::find($shipmentroute->download_port);
      /**
      *
      */
      $vars = [
        'shipment'      => $shipment,
        'shipmentroute' => $shipmentroute
      ];

      $fpdi = new \fpdi\FPDI();
      $fpdf = new \fpdf\FPDF();
      $fpdi->SetAutoPageBreak(true,1);
      $pageCount = $fpdi->setSourceFile('tmpreport/MBL.pdf');
      $tplIdx    = $fpdi->importPage(1, '/BleedBox');
      $fpdi->SetTitle('Master Bill Of Lading');

      $fpdi->addPage();
      $fpdi->useTemplate($tplIdx, 0, 0, 210, 279-5);

      $nombre = $configuration->logo_ics;
      $isJPG = strrpos($nombre,".jpg");
      if((!($isJPG)) && ($nombre!=null)) {
        $fpdi->Image(isset($configuration) ? ($configuration->logo_ics == '') ? asset('/dist/images/logoazul.jpg') : $configuration->logo_ics : asset('/dist/images/logoazul.png'),5,0,25,0,'PNG');
      }
      if($isJPG) {
        $fpdi->Image(isset($configuration) ? ($configuration->logo_ics == '') ? asset('/dist/images/logoazul.jpg') : $configuration->logo_ics : asset('/dist/images/logoazul.jpg'),5,0,25,0,'JPG');
      }
      //dd($courier);
      /*$fpdi->SetFont('Arial','B',14);
      $fpdi->SetTextColor(59, 59, 59);
      $fpdi->SetXY(45, 10-2);
      $fpdi->MultiCell(85, 3, isset($configuration->name_company) ? $configuration->name_company: 'International Cargo System');

      $fpdi->SetFont('Arial','',12);
      $fpdi->SetTextColor(59, 59, 59);
      $fpdi->SetXY(45, 15-2);
      $fpdi->MultiCell(85, 3, isset($configuration->dni_company) ? $configuration->dni_company: 'DNI:1234567890');

      $fpdi->SetFont('Arial','',12);
      $fpdi->SetTextColor(83, 83, 83);
      $fpdi->SetXY(45, 20-2);
      $fpdi->MultiCell(85, 3, isset($configuration->email_company) ? $configuration->email_company: 'www.internationalcargosystem.com');
*/
      $fpdi->SetFont('Arial','',9);
      $fpdi->SetTextColor(0, 0, 0);

      //EXPORTADOR
      $fpdi->SetXY(5, 48-30);
      $fpdi->MultiCell(85, 3, isset($shipper) ? strtoupper($shipper->name.' '.$shipper->last_name): '');

      $fpdi->SetXY(5, 51-30);
      $fpdi->MultiCell(80, 3,  isset($shipper) ? strtoupper($shipper->address.', '.$shipper->city.', '.$shipper->postal_code) : '');
      $fpdi->SetXY(5, 54-30);
      $fpdi->MultiCell(80, 3,  isset($shipper) ? strtoupper($shipper->region.', '.$shipper->country) : '');
      $fpdi->SetXY(5, 57-30);
      $fpdi->MultiCell(80, 3,  isset($shipper) ? strtoupper($shipper->email) : '');
      $fpdi->SetXY(73, 33);
      $fpdi->MultiCell(40, 3,  isset($shipper) ? strtoupper($shipper->postal_code) : '',0,'C');

      //NRO DOCUMENTO
      $fpdi->SetXY(90, 16);
      $fpdi->MultiCell(85, 3, $shipment->number_reservation,0,'C');

      //B/L NUMERO
      $fpdi->SetXY(138, 16);
      $fpdi->MultiCell(85, 3, 'BL-'.$shipment->number_guide,0,'C');

      //REFERENCIA DE EXPORTACION
      $fpdi->SetXY(112, 25);
      $fpdi->MultiCell(85, 3, isset($shipment) ? $shipment->code.' '.strtoupper($shipment->name) : '',0,'C');

      //CONSIGNADO A
      $fpdi->SetFont('Arial','',9);

      $fpdi->SetXY(5, 82-18-23);
      $fpdi->MultiCell(85, 3, isset($consigner) ? strtoupper($consigner->name.' '.$consigner->last_name): '');
      $fpdi->SetXY(5, 85-18-23);
      $fpdi->MultiCell(90, 3,  isset($consigner) ? strtoupper($consigner->address.', '.$toNotify->city.', '.$toNotify->postal_code) : '');
      $fpdi->SetXY(5, 88-18-23);
      $fpdi->MultiCell(80, 3,  isset($consigner) ? strtoupper($consigner->region.', '.$toNotify->country) : '');
      $fpdi->SetXY(5, 91-18-23);
      $fpdi->MultiCell(80, 3,  isset($consigner) ? strtoupper($consigner->email) : '');

      $fpdi->SetXY(5, 94-18-23);
      $fpdi->MultiCell(30, 3, 'PHONE:');
      $fpdi->SetXY(18, 94-18-23.5);
      $fpdi->MultiCell(40, 4,  isset($consigner) ? strtoupper($consigner->celular) : '');

      //AGENTE DE CARGA
      $fpdi->SetXY(110, 79-15-23);
      $fpdi->MultiCell(85, 3, isset($configuration->name_company) ? strtoupper($configuration->name_company): 'International Cargo System',0,'L');
      $fpdi->SetXY(110, 82-15-23);
      $fpdi->MultiCell(85, 3, isset($configuration) ? strtoupper($configuration->city_company.', '.$configuration->region_company.', '.$configuration->country_company): 'www.internationalcargosystem.com',0,'L');
      $fpdi->SetXY(110, 85-15-23);
      $fpdi->MultiCell(85, 3, isset($configuration->email_company) ? strtoupper($configuration->email_company): 'www.internationalcargosystem.com',0,'L');
      //NUMERO FTZ
      $fpdi->SetXY(110, 84-27);
      $fpdi->MultiCell(85, 3, isset($shipmentroute->origin_point) ? strtoupper($shipmentroute->origin_point) : '',0,'C');

      //NOTIFICAR A INTERMEDIARIO
      $fpdi->SetXY(5, 108-40);
      $fpdi->MultiCell(85, 3,  isset($toNotify) ? strtoupper($toNotify->name.' '.$toNotify->last_name) : '');

      $fpdi->SetXY(5, 111-40);
      $fpdi->MultiCell(90, 3,  isset($toNotify) ? strtoupper($toNotify->address.', '.$toNotify->city.', '.$toNotify->postal_code) : '');
      $fpdi->SetXY(5, 114-40);
      $fpdi->MultiCell(85, 3,  isset($toNotify) ? strtoupper($toNotify->region.', '.$toNotify->country) : '');

      $fpdi->SetXY(5, 117-40);
      $fpdi->MultiCell(85, 3,  isset($toNotify) ? 'PHONE: '.strtoupper($toNotify->celular) : '');
      $fpdi->SetFont('Arial','',8);
      //INSTRUCCIONES INTERNAS
      $fpdi->SetXY(110, 65);
      $fpdi->MultiCell(100, 3, strtoupper($shipment->description),0,'L');

      //PRETRANSPORTADO POR
      $fpdi->SetXY(5, 91);
      $fpdi->MultiCell(85, 3,  isset($transportista) ? strtoupper($transportista->name) : '--');

      //LUGAR DE RECEPCION
      $fpdi->SetXY(65, 91);
      $fpdi->MultiCell(85, 3,  isset($transportista->name) ? strtoupper($transportista->billing_address_country.' '.$transportista->billing_address_state) :  '--');

      //TRANSPORTISTA EXPORTADOR
      $fpdi->SetXY(5, 100);
      $fpdi->MultiCell(50, 3, isset($transportista) ? strtoupper($transportista->name.' '.$transportista->last_name) : '--');

      //PUNTO DE CARGA/EXPORTACION
      $fpdi->SetXY(65, 100);
      $fpdi->MultiCell(85, 3, isset($transportista) ? $transportista->billing_address_port : '--');


      //MUELLE DE CARGA/TERMINAL
      $fpdi->SetXY(110, 100);
      $fpdi->MultiCell(85, 3, isset($shipmentroute->dock_terminal) ? strtoupper($shipmentroute->dock_terminal) : '--');

      //PUERTO EXTRANJERO DE DESCARGA
      $fpdi->SetXY(5, 108);
      $fpdi->MultiCell(85, 3, isset($detailsTransport) ? strtoupper($detailsTransport->name) : '--');

      //LUGAR DE ENTREGA POR EL TRANSPORTISTA
      $fpdi->SetXY(65, 108);
      $fpdi->MultiCell(85, 3, isset($detailsTransport) ? strtoupper($detailsTransport->name) : '--');

      //TIPO DE CARGA
      $fpdi->SetXY(103, 108);
      $fpdi->MultiCell(50, 3, $shipment->transport == '1' ? 'MARITIMA' : 'AEREA',0,'C');

      //CONTENERIZADO
      $fpdi->SetFont('Arial','',16);
      if ($shipment->containerized == 0) {
        $fpdi->SetXY(195, 108);
        $fpdi->MultiCell(50, 3, 'X',0,'L');
      }else
      {
        $fpdi->SetXY(177, 108);
        $fpdi->MultiCell(50, 3, 'X',0,'L');
      }

      $h=122;
      $countpack = 0;
      $packages_num = 0;
      $countpick = 0;
      $pickup_num = 0;
      $resultpackweight = 0;
      $total_vol = 0;
      $fpdi->SetFont('Arial','',9);
      foreach ($shipmentdetails as $key => $shipmentdetail) {
        $package = null;
        if(!($shipmentdetail==null)){
            $package = Package::find($shipmentdetail->warehouse);
        }else{dd('falla');}
        $detailspackage = null;
        $courier = null;
        $category = Category::find(1);;
        if(!($package==null)){
          $detailspackage = Detailspackage::query()->where('package','=',$package->id)->first();
          $countpack = Detailspackage::query()->where('package','=',$package->id)->count();
          $courier        = Courier::find($package->from_courier);
          $category = Category::find($package->category);
          //dd($detailspackage);

            //MARCAS Y NUMERO
            $fpdi->SetXY(13, $h);
            $fpdi->MultiCell(24, 3, isset($package) ? $package->code : '',0,'C');

            //NUMERO DE PAQUETE
            $fpdi->SetXY(28, $h);
            $fpdi->MultiCell(30, 3, isset($package) ? $countpack : '',0,'R');
            $packages_num = $packages_num + $countpack;
            //DESCRIPCION DEL PRODUCTO
            $fpdi->SetXY(65, $h);
            $fpdi->MultiCell(80, 3, isset($package) ? isset($category->label) ? strtoupper($category->label) :'--' : '--',0,'L');

            //PESO
            $fpdi->SetXY(141, $h);
            $fpdi->MultiCell(50, 3, isset($detailspackage->weight) ? number_format($detailspackage->weight,2,',','.').' Lb' : '0,00',0,'C');
            if (isset($detailspackage->weight)) {
              $resultpackweight = $resultpackweight + $detailspackage->weight;
            }

            //DIMENSIONES
            //dd($detailspackage);
            $fpdi->SetXY(168, $h);
            $fpdi->MultiCell(50, 3, isset($detailspackage) ? number_format($detailspackage->volumetricweightm,2,',','.').' ft3' : '',0,'C');
            if (isset($detailspackage->volumetricweightm)) {
              $total_vol = $total_vol + $detailspackage->volumetricweightm;
            }
        }else {
          $pickup = null;
          if(!($shipmentdetail==null)){
              $pickup = Pickup::find($shipmentdetail->pickup);
          }
          $pickup_category = Category::find($pickup->category);
          $detailspickups = DetailsPickup::query()->where('pickup','=',$pickup->id)->first();
          $countpick = DetailsPickup::query()->where('pickup','=',$pickup->id)->count();
          //dd($detailspickups);
          //MARCAS Y NUMERO
          $fpdi->SetXY(13, $h);
          $fpdi->MultiCell(25, 3, isset($pickup) ? $pickup->code : '',0,'L');

          //NUMERO DE PAQUETE
          $fpdi->SetXY(28, $h);
          $fpdi->MultiCell(30, 3, isset($pickup) ? $countpick.'' : '',0,'R');
          $packages_num = $packages_num + $countpick;
          //DESCRIPCION DEL PRODUCTO
          $fpdi->SetXY(65, $h);
          $fpdi->MultiCell(70, 3, isset($pickup_category->label) ? strtoupper(''.$pickup_category->label) : '',0,'L');

          //PESO
          $fpdi->SetXY(141, $h);
          $fpdi->MultiCell(50, 3, isset($detailspickups->weight) ? number_format($detailspickups->weight,2,',','.').' Lb' : '0,00 Lb',0,'C');
          if (isset($detailspickups->weight)) {
            $resultpackweight = $resultpackweight + $detailspickups->weight;
          }

          //DIMENSIONES
          //dd($detailspackage);
          $fpdi->SetXY(168, $h);
          $fpdi->MultiCell(50, 3, isset($detailspickups) ? number_format($detailspickups->volumetricweight,2,',','.').' ft3' : '',0,'C');
          if (isset($detailspickups->volumetricweight)) {
            $total_vol = $total_vol + $detailspickups->volumetricweight;
          }
        }

        $h+=3;
      }
      $fpdi->SetFont('Arial','B',8);
      $fpdi->SetXY(25, 198.5);
      $fpdi->MultiCell(30, 3, number_format($shipment->declarate_value,2,',','.').'$',0,'C');

      $fpdi->SetFont('Arial','B',9);
      $fpdi->SetXY(9, 193);
      $fpdi->MultiCell(85, 3, "TOTAL OF PIECES");

      $fpdi->SetFont('Arial','B',9  );
      $fpdi->SetXY(25, 193);
      $fpdi->MultiCell(30, 3, $packages_num,0,'R');

      $fpdi->SetXY(151, 193);
      $fpdi->MultiCell(30, 3, number_format($resultpackweight,2,',','.').' Lb',0,'C');

      $fpdi->SetXY(178, 193);
      $fpdi->MultiCell(30, 3, number_format($total_vol,2,',','.').' ft3',0,'C');

      $fpdi->SetXY(133, 193);
      $fpdi->MultiCell(85, 3, "TOTALS");

      $fpdi->SetXY(120, 249);
      //dd($shipment);
      $fpdi->MultiCell(80, 3, isset($shipment->created_at) ? $shipment->created_at->format('M                              d,                                     Y') : '' ,0,'L');

      $fpdi->SetFont('Arial','B',16);
      $fpdi->SetTextColor(119, 119, 119);
      $fpdi->SetXY(90, 192.5);
      $fpdi->MultiCell(85, 3, "ORIGINAL");

      /*$fpdi->SetFont('Arial','',8);
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(15, 269-8);
      $fpdi->MultiCell(180, 3, isset($configuration->footer_receipt) ? $configuration->footer_receipt : '');
*/
      $fpdi->Output();


    }

    public function cargomanifest (Request $request, $id){
      $session         = $request->session()->get('key-sesion');
      $cargoRelease    = CargoRelease::find($id);
      $shipment        = Shipment::find($id);
      $shipmentroute   = ShipmentRoute::byShipment($id)->first();
      $shipmentdetails  = ShipmentDetail::query()->where('shipment','=',$id)->get();
      $category = null;
      $transportista = Transporters::find($shipment->transporter);
      $detailsTransport = DetailsTransport::find($shipmentroute->download_port);
      $agent           = Operator::find($shipment->operator);
      $port            = DetailsTransport::find($shipmentroute->port);
      $port2           = DetailsTransport::find($shipmentroute->download_port);
      $configuration = Configuration::find(1);
      $timezone = explode(" ", $configuration->time_zone);
      date_default_timezone_set($timezone[0]);
      $packages = null;
      $bl = null;
      if(isset($shipmentdetails[0])){
          $packages = Package::query()->where('id','=',$shipmentdetails[0]->warehouse)->first();
          $bl = BillOfLading::query()->where('package','=',$packages->id)->first();
      }

      //dd($shipment);
      $vars =
      [
        'shipment'      => $shipment,
        'shipmentroute' => $shipmentroute
      ];

      $fpdi = new \fpdi\FPDI();
      $fpdf = new \fpdf\FPDF();
      $fpdi->SetAutoPageBreak(true,5);
      $pageCount = $fpdi->setSourceFile('tmpreport/cargomanifest.pdf');
      $tplIdx    = $fpdi->importPage(1, '/BleedBox');
      $fpdi->SetTitle('Manifiesto de Carga');

      $fpdi->addPage();
      $fpdi->useTemplate($tplIdx, 0, 0, 210, 279-5);

      $nombre = $configuration->logo_ics;
      $isJPG = strrpos($nombre,".jpg");
      if((!($isJPG)) && ($nombre!=null)) {
        $fpdi->Image(isset($configuration) ? ($configuration->logo_ics == '') ? asset('/dist/images/logoazul.png') : $configuration->logo_ics : asset('/dist/images/logoazul.jpg'),10,5,35,0,'PNG');
      }
      if($isJPG) {
        $fpdi->Image(isset($configuration) ? ($configuration->logo_ics == '') ? asset('/dist/images/logoazul.jpg') : $configuration->logo_ics : asset('/dist/images/logoazul.jpg'),10,5,35,0,'JPG');
      }

      $fpdi->SetFont('Arial','B',14);
      $fpdi->SetTextColor(59, 59, 59);
      $fpdi->SetXY(45, 8);
      $fpdi->MultiCell(85, 3, isset($configuration->name_company) ? $configuration->name_company: 'International Cargo System');

      $fpdi->SetFont('Arial','',12);
      $fpdi->SetTextColor(59, 59, 59);
      $fpdi->SetXY(45, 13);
      $fpdi->MultiCell(85, 3, isset($configuration->dni_company) ? $configuration->dni_company: 'DNI:1234567890');

      $fpdi->SetFont('Arial','',12);
      $fpdi->SetTextColor(83, 83, 83);
      $fpdi->SetXY(45, 18);
      $fpdi->MultiCell(85, 3, isset($configuration->email_company) ? $configuration->email_company: 'www.internationalcargosystem.com');

      $fpdi->SetFont('Arial','',8);
      $fpdi->SetTextColor(0, 0, 0);;

      //ENTREGADO
      $fpdi->SetXY(173, 30.5);
      $fpdi->MultiCell(85, 3, $shipment->departure_date_mar);

      //CONTENEDOR
      $fpdi->SetXY(12, 42);
      $container = Container::find($shipment->container_name);
      $fpdi->MultiCell(85, 3, ($shipment->containerized != '0') ? $container->name : 'NO CONTAINERIZADO',0,'C');

      //NUMERO DE RESERVACION
      $fpdi->SetXY(143, 42);
      $fpdi->MultiCell(30, 3, $shipment->number_reservation,0,'C');

      //NOMBRE Y DIRECCION DEL AGENTE
      $country_company = Country::find($configuration->country_company);
      $fpdi->SetXY(8, 55);
      $fpdi->MultiCell(85, 3, isset($configuration->name_company) ? strtoupper($configuration->name_company): 'International Cargo System',0,'L');
      $fpdi->SetXY(8, 60);
      $fpdi->MultiCell(85, 3, isset($configuration) ? strtoupper($configuration->city_company): 'www.internationalcargosystem.com',0,'L');
      $fpdi->SetXY(8, 65);
      $fpdi->MultiCell(85, 3, isset($configuration) ? strtoupper($configuration->region_company.', '.$country_company->name): 'www.internationalcargosystem.com',0,'L');
      $fpdi->SetXY(8, 70);
      $fpdi->MultiCell(85, 3, isset($configuration->email_company) ? strtolower($configuration->email_company): 'www.internationalcargosystem.com',0,'L');
      $fpdi->SetXY(8, 75);
      $fpdi->MultiCell(85, 3, isset($configuration->phone) ? strtoupper($configuration->phone): 'www.internationalcargosystem.com',0,'L');


      //NOMBRE Y DIRECCION DEL TRANSPORTISTA
      $state = null;
      $country = null;
      //dd($country);
      $fpdi->SetXY(70, 70-15);
      $fpdi->MultiCell(50, 3, isset($transportista) ? strtoupper($transportista->name) : '  ',0,'L');
      $fpdi->SetXY(70, 75-15);
      $fpdi->MultiCell(50, 3, isset($transportista) ? 'PHONE: '.strtoupper($transportista->phone) : '',0,'L');
      $fpdi->SetXY(70, 90-15);
      $fpdi->MultiCell(50, 3, isset($transportista) ? strtolower($transportista->email) : '',0,'L');
      $fpdi->SetXY(70, 80-15);
      $fpdi->MultiCell(50, 3,  isset($transportista) ? strtoupper($transportista->address_code." ".$transportista->address_state) : '',0,'L');
      $fpdi->SetXY(70, 85-15);
      $fpdi->MultiCell(50, 3,  isset($transportista->address_country) ? strtoupper($transportista->address_country) : '',0,'L');

      $shipmentruote = ShipmentRoute::query()->where('shipment','=',$id)->first();

      $vessel = Vessel::find($shipmentruote->vessel);
      //dd($vessel);
      //NUMERO DE GUIA
      $fpdi->SetXY(125, 57);

      if ($shipment->transport == 1) {
          $fpdi->MultiCell(30, 3, 'BL: '.$shipment->number_guide,0,'C');
      }
      if ($shipment->transport == 2) {
        $fpdi->MultiCell(30, 3, 'AWB: '.$shipment->number_guide,0,'C');
      }

      //FECHA
      $fpdi->SetXY(153, 57);
      $fpdi->MultiCell(30, 3, $shipment->realizate_city_date,0,'C');

      $fpdi->SetFont('Arial','',7);
      //ORIGEN
      if ($shipment->transport == 1) {
        $fpdi->SetXY(177, 55-2);
        $fpdi->MultiCell(30, 3, isset($shipment->realizate_city_place) ? strtoupper($shipment->realizate_city_place) : '',0,'C');
        $v = isset($shipmentroute->travel_identifier) ? $shipmentroute->travel_identifier : null;
        $f = isset($vessel->flag) ? $vessel->name : null;
      }
      if ($shipment->transport == 2) {
        $fpdi->SetXY(179, 53.5-2);
        $airport = isset($shipment->from_airport) ? IataCode::find($shipment->from_airport) : null;
        $fpdi->MultiCell(25, 3, isset($airport) ? strtoupper($airport->iata.' - '.$airport->name) : '',0,'C');
      }

      //NUEMRO DE VUELO, VIAJE y BUQUE
      $fpdi->SetXY(125, 73);
      if ($shipment->transport == 1) {
        $fpdi->MultiCell(30, 3, isset($v) ? strtoupper($v) : '',0,'C');
        $fpdi->SetXY(125, 76);
        $fpdi->MultiCell(30, 3, isset($f) ?strtoupper($f) : '',0,'C');
      }
      if ($shipment->transport == 2) {
        $fpdi->MultiCell(30, 3, isset($shipmentroute->fly_number) ? ($shipmentroute->fly_number) : '',0,'C');
      }

      //FECHA DE PARTIDA
      $fpdi->SetFont('Arial','',8);

      $fpdi->SetXY(153, 75);
      $fpdi->MultiCell(30, 3, isset($shipment->departure_date_mar) ? $shipment->departure_date_mar : '',0,'C');
      $fpdi->SetFont('Arial','',7);

      //DESTINO
      if ($shipment->transport == 1){
        $fpdi->SetXY(179, 73-2);
        $fpdi->MultiCell(25, 3, isset($port2->name)?strtoupper($port2->name):'',0,'C');
      }
      if ($shipment->transport == 2) {
        $fpdi->SetXY(179, 73-2);
        $airport2 = isset($shipment->to_airport) ? IataCode::find($shipment->to_airport) : null;
        $fpdi->MultiCell(25, 3, isset($airport2) ? strtoupper($airport2->iata.' - '.$airport2->name):'',0,'C');
      }
      $fpdi->SetFont('Arial','B',9);
      $height = 96;
      $total_pieces = 0;
      $total_weight = 0;
      $total_vol = 0;
      $i = 1;
      foreach ($shipmentdetails as $key => $shipmentdetail) {
        $package = null;
        if($shipmentdetail!=null){
            $packages = Package::query()->where('id','=',$shipmentdetail->warehouse)->get();
        }
        //  dd($packages);
        foreach ($packages as $key => $package) {
          if($package != null){
              $category = Category::find($package->category);
          }

          $detailpackages = null;
          if ($package != null) {
            //dd($package);
            $detailpackages = Detailspackage::query()->where('package','=',$package->id)->get();
            foreach ($detailpackages as $key => $detailpackage) {
              if ($detailpackage != null) {
                if ($i>8) {

                  $fpdi->SetFont('Arial','B',9);
                  //TOTAL PIEZAS
                  $fpdi->SetXY(87, 249);
                  $fpdi->MultiCell(30, 3, ($total_pieces),0,'C');

                  $fpdi->SetXY(97, 249);
                  $fpdi->MultiCell(30, 3, number_format($total_weight,2,',','.').'Lb',0,'R');

                  $fpdi->SetXY(118, 249);
                  $fpdi->MultiCell(39, 3, number_format($total_vol,2,',','.').'ft3',0,'C');

                  //TOTAL
                  $fpdi->SetFont('Arial','',15);
                  $fpdi->SetTextColor(0, 0, 0);
                  $fpdi->SetXY(15, 249);
                  $fpdi->MultiCell(85, 3,'TOTAL',0,'L');

                  $fpdi->SetFont('ZapfDingbats','',25);
                  $fpdi->SetXY(35, 249);
                  $fpdi->MultiCell(85, 3,chr(135),0,'L');

                  //FOOTER
                  $fpdi->SetFont('Arial','',9);
                  $fpdi->SetTextColor(0, 0, 0);
                  $fpdi->SetXY(8, 261);
                  $fpdi->MultiCell(180, 3, 'Notas:');

                  $fpdi->addPage();
                  $fpdi->useTemplate($tplIdx, 0, 0, 210, 279-5);

                  $nombre = $configuration->logo_ics;
                  $isJPG = strrpos($nombre,".jpg");
                  if((!($isJPG)) && ($nombre!=null)) {
                    $fpdi->Image(isset($configuration) ? ($configuration->logo_ics == '') ? asset('/dist/images/logoazul.jpg') : $configuration->logo_ics : asset('/dist/images/logoazul.jpg'),10,5,35,0,'PNG');
                  }
                  if($isJPG) {
                    $fpdi->Image(isset($configuration) ? ($configuration->logo_ics == '') ? asset('/dist/images/logoazul.jpg') : $configuration->logo_ics : asset('/dist/images/logoazul.jpg'),10,5,35,0,'JPG');
                  }

                  $fpdi->SetFont('Arial','B',14);
                  $fpdi->SetTextColor(59, 59, 59);
                  $fpdi->SetXY(45, 8);
                  $fpdi->MultiCell(85, 3, isset($configuration->name_company) ? $configuration->name_company: 'International Cargo System');

                  $fpdi->SetFont('Arial','',12);
                  $fpdi->SetTextColor(59, 59, 59);
                  $fpdi->SetXY(45, 13);
                  $fpdi->MultiCell(85, 3, isset($configuration->dni_company) ? $configuration->dni_company: 'DNI:1234567890');

                  $fpdi->SetFont('Arial','',12);
                  $fpdi->SetTextColor(83, 83, 83);
                  $fpdi->SetXY(45, 18);
                  $fpdi->MultiCell(85, 3, isset($configuration->email_company) ? $configuration->email_company: 'www.internationalcargosystem.com');

                  $fpdi->SetFont('Arial','',8);
                  $fpdi->SetTextColor(0, 0, 0);;

                  //ENTREGADO
                  $fpdi->SetXY(173, 30.5);
                  $fpdi->MultiCell(85, 3, $shipment->departure_date_mar);

                  //CONTENEDOR
                  $fpdi->SetXY(12, 42);
                  //dd($shipment);
                  $fpdi->MultiCell(85, 3, ($shipment->containerized == '0') ? $shipment->container_name : 'NO CONTAINERIZADO',0,'C');

                  //NUMERO DE RESERVACION
                  $fpdi->SetXY(143, 42);
                  $fpdi->MultiCell(30, 3, $shipment->number_reservation,0,'C');

                  //NOMBRE Y DIRECCION DEL AGENTE
                  $fpdi->SetXY(8, 55);
                  $fpdi->MultiCell(85, 3, isset($configuration->name_company) ? strtoupper($configuration->name_company): 'International Cargo System',0,'L');
                  $fpdi->SetXY(8, 60);
                  $fpdi->MultiCell(85, 3, isset($configuration) ? strtoupper($configuration->city_company): 'www.internationalcargosystem.com',0,'L');
                  $fpdi->SetXY(8, 65);
                  $fpdi->MultiCell(85, 3, isset($configuration) ? strtoupper($configuration->region_company.', '.$configuration->country_company): 'www.internationalcargosystem.com',0,'L');
                  $fpdi->SetXY(8, 70);
                  $fpdi->MultiCell(85, 3, isset($configuration->email_company) ? strtolower($configuration->email_company): 'www.internationalcargosystem.com',0,'L');
                  $fpdi->SetXY(8, 75);
                  $fpdi->MultiCell(85, 3, isset($configuration->phone) ? strtoupper($configuration->phone): 'www.internationalcargosystem.com',0,'L');


                  //NOMBRE Y DIRECCION DEL TRANSPORTISTA
                  $state = State::query()->where('name','=',$transportista->address_state)->first();
                  $country = Country::find($state->country);
                  //dd($country);
                  $fpdi->SetXY(70, 70-15);
                  $fpdi->MultiCell(50, 3, isset($transportista) ? strtoupper($transportista->name) : '  ',0,'L');
                  $fpdi->SetXY(70, 75-15);
                  $fpdi->MultiCell(50, 3, isset($transportista) ? 'PHONE: '.strtoupper($transportista->phone) : '',0,'L');
                  $fpdi->SetXY(70, 90-15);
                  $fpdi->MultiCell(50, 3, isset($transportista) ? strtolower($transportista->email) : '',0,'L');
                  $fpdi->SetXY(70, 80-15);
                  $fpdi->MultiCell(50, 3,  isset($transportista) ? strtoupper($transportista->address_code." ".$transportista->address_state) : '',0,'L');
                  $fpdi->SetXY(70, 85-15);
                  $fpdi->MultiCell(50, 3,  isset($transportista) ? strtoupper($country->name) : '',0,'L');

                  $shipmentruote = ShipmentRoute::query()->where('shipment','=',$id)->first();

                  $vessel = Vessel::find($shipmentruote->vessel);
                  //dd($vessel);
                  //NUMERO DE GUIA
                  $fpdi->SetXY(125, 57);
                  if ($shipment->transport == 1) {
                      $fpdi->MultiCell(30, 3, 'BL: '.$shipment->number_guide,0,'C');
                  }
                  if ($shipment->transport == 2) {
                    $fpdi->MultiCell(30, 3, 'AWB: '.$shipment->number_guide,0,'C');
                  }
                  //FECHA
                  $fpdi->SetXY(153, 57);
                  $fpdi->MultiCell(30, 3, $shipment->realizate_city_date,0,'C');

                  //ORIGEN
                  $fpdi->SetXY(177, 57);
                  $fpdi->MultiCell(30, 3, isset($shipment->realizate_city_place) ? strtoupper($shipment->realizate_city_place) : '',0,'C');
                  $v = isset($shipmentroute->travel_identifier) ? $shipmentroute->travel_identifier : null;
                  $f = isset($vessel->flag) ? $vessel->name : null;

                  //NUEMRO DE VUELO, VIAJE y BUQUE
                  $fpdi->SetXY(125, 73);
                  $fpdi->MultiCell(30, 3, isset($v) ? strtoupper($v) : '',0,'C');
                  $fpdi->SetXY(125, 76);
                  $fpdi->MultiCell(30, 3, isset($f) ?strtoupper($f) : '',0,'C');


                  //FECHA DE PARTIDA
                  $fpdi->SetXY(153, 77);
                  $fpdi->MultiCell(30, 3, isset($shipment->departure_date_mar) ? $shipment->departure_date_mar : '',0,'C');
                  //DESTINO
                  $fpdi->SetXY(177, 73);
                  $fpdi->MultiCell(30, 3, isset($port2->name)?strtoupper($port2->name):'',0,'C');

                  $i=1;
                  $height = 96;


                }
                  $shipper       = User::find($package->consigner_user);
                  $consigner         = User::find($package->to_user);
                  $fpdi->SetFont('Arial','',7.5);
                  //WAREHOUSES
                  $fpdi->SetXY(3, $height+2);
                  $fpdi->MultiCell(30, 3, isset($package) ? $package->code : '', 0, 'C');
                  //SHIPPER
                  $fpdi->SetXY(28.5, $height+2);
                  //dd($shipper);
                  $fpdi->MultiCell(35, 3, isset($shipper)?strtoupper(utf8_decode($shipper->name." ".$shipper->last_name)) : '',0,'L');
                  if (isset($shipper) && (strlen($shipper->name." ".$shipper->last_name)>16)) {
                    $fpdi->SetXY(28.5, $height+8) ;
                    $fpdi->MultiCell(35, 3, isset($shipper)?strtoupper($shipper->city." ".$shipper->region." ".$shipper->country) : '',0,'L');
                    $fpdi->SetXY(28.5, $height+14);
                    $fpdi->MultiCell(40, 3, isset($shipper)?strtoupper('PHONE: '.$shipper->celular) : '',0,'L');
                  }else {
                    $fpdi->SetXY(28.5, $height+5) ;
                    $fpdi->MultiCell(35, 3, isset($shipper)?strtoupper($shipper->city." ".$shipper->region." ".$shipper->country) : '',0,'L');
                    $fpdi->SetXY(28.5, $height+11);
                    $fpdi->MultiCell(40, 3, isset($shipper)?strtoupper('PHONE: '.$shipper->celular) : '',0,'L');
                  }
                  //CONSIGNEE
                  $fpdi->SetXY(59, $height+2);
                  $fpdi->MultiCell(40, 3, isset($consigner)?strtoupper(utf8_decode($consigner->name." ".$consigner->last_name)) : '',0,'L');
                  if (isset($consigner) && (strlen($consigner->name." ".$consigner->last_name)>20)) {
                    $fpdi->SetXY(59, $height+8);
                    $fpdi->MultiCell(35, 3, isset($consigner)?strtoupper($consigner->city." ".$consigner->region." ".$consigner->country) : '',0,'L');
                    $fpdi->SetXY(59, $height+16);
                    $fpdi->MultiCell(35, 3, isset($consigner)?strtoupper('PHONE: '.$consigner->celular) : '',0,'L');
                  }else {
                    $fpdi->SetXY(59, $height+5);
                    $fpdi->MultiCell(35, 3, isset($consigner)?strtoupper($consigner->city." ".$consigner->region." ".$consigner->country) : '',0,'L');
                    $fpdi->SetXY(59, $height+11);
                    $fpdi->MultiCell(35, 3, isset($consigner)?strtoupper('PHONE: '.$consigner->celular) : '',0,'L');
                  }
                  //PIECES
                  $fpdi->SetXY(87, $height+2);
                  $fpdi->MultiCell(30, 3, $detailpackage->pieces,0,'C');
                  $total_pieces = $total_pieces + $detailpackage->pieces;
                  //WEIGHT
                  $fpdi->SetXY(105, $height+2);
                  $fpdi->MultiCell(30, 3, number_format($detailpackage->weight,2,',','.').'Lb',0,'C');
                  $total_weight = $total_weight +$detailpackage->weight;
                  //VOLUME
                  $fpdi->SetXY(118, $height+2);
                  $fpdi->MultiCell(40, 3, number_format($detailpackage->volumetricweightm,2,',','.').' ft3',0,'C');
                  $total_vol = $total_vol + $detailpackage->volumetricweightm;
                  //DESCRIPTION
                  $fpdi->SetXY(143, $height+2);
                  $fpdi->MultiCell(45, 3, isset($category->label) ? strtoupper($detailpackage->description) : ''  ,0,'C');
                  //ADUANA
                  $fpdi->SetFont('Arial','',7);
                  $fpdi->SetXY(183.5, $height+2);
                  $aduana = isset($package->description_aduana) ? $package->description_aduana : 'NO REQUIERE ADUANA';
                  $fpdi->MultiCell(21, 3, strtoupper($aduana),0,'C');
                  $fpdi->SetFont('Arial','',8);
                    if (isset($consigner) && (strlen($consigner->name." ".$consigner->last_name)>20)) {
                      $height=$height+4;
                    }elseif (isset($shipper) && (strlen($shipper->name." ".$shipper->last_name)>17)) {
                        $height=$height+4;
                    }elseif ((strlen($aduana)>10)) {
                      $height=$height+4;
                    }elseif (isset($category->label) && (strlen($category->label)>20)) {
                      $height=$height+4;
                    }

                  $height += 14;
                  $i++;
              }


            }

          }
        }
      }

      $fpdi->SetFont('Arial','B',9);
      //TOTAL PIEZAS
      $fpdi->SetXY(87, 249);
      $fpdi->MultiCell(30, 3, ($total_pieces),0,'C');

      $fpdi->SetXY(97, 249);
      $fpdi->MultiCell(30, 3, number_format($total_weight,2,',','.').'Lb',0,'R');

      $fpdi->SetXY(118, 249);
      $fpdi->MultiCell(39, 3, number_format($total_vol,2,',','.').'ft3',0,'C');

      //TOTAL
      $fpdi->SetFont('Arial','',15);
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(15, 249);
      $fpdi->MultiCell(85, 3,'TOTAL',0,'L');

      $fpdi->SetFont('ZapfDingbats','',25);
      $fpdi->SetXY(35, 249);
      $fpdi->MultiCell(85, 3,chr(135),0,'L');

      //FOOTER
      $fpdi->SetFont('Arial','',9);
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(8, 261);
      $fpdi->MultiCell(180, 3, 'Notas:');

      $fpdi->Output();


    }
    public function loadingguide (Request $request, $id){
      $session         = $request->session()->get('key-sesion');
      $cargoRelease    = CargoRelease::find($id);
      $shipment        = Shipment::find($id);
      $shipmentroute   = ShipmentRoute::byShipment($id)->first();
      $shipmentdetails  = ShipmentDetail::query()->where('shipment','=',$id)->get();
      $category = null;
      $transportista = Transporters::find($shipment->transporter);
      $detailsTransport = isset($shipmentroute->download_port) ? DetailsTransport::find($shipmentroute->download_port) : null;
      $agent           = Operator::find($shipment->operator);
      $port            = isset($shipmentroute->port) ? DetailsTransport::find($shipmentroute->port) : null;
      $port2           = isset($shipmentroute->download_port) ? DetailsTransport::find($shipmentroute->download_port) : null;
      $configuration = Configuration::find(1);
      $timezone = explode(" ", $configuration->time_zone);
      date_default_timezone_set($timezone[0]);
      $packages = null;
      $bl = null;
      if(isset($shipmentdetails[0])){
          $packages = Package::query()->where('id','=',$shipmentdetails[0]->warehouse)->first();
          $bl = BillOfLading::query()->where('package','=',$packages->id)->first();
      }

      //dd($shipment);
      $vars =
      [
        'shipment'      => $shipment,
        'shipmentroute' => $shipmentroute
      ];

      $fpdi = new \fpdi\FPDI();
      $fpdf = new \fpdf\FPDF();
      $fpdi->SetAutoPageBreak(true,5);
      $pageCount = $fpdi->setSourceFile('tmpreport/loadingGuide.pdf');
      $tplIdx    = $fpdi->importPage(1, '/BleedBox');
      $fpdi->SetTitle('Guia de Carga');

      $fpdi->addPage();
      $fpdi->useTemplate($tplIdx, 0, 0, 210, 279-5);

      $nombre = $configuration->logo_ics;
      $isJPG = strrpos($nombre,".jpg");
      if((!($isJPG)) && ($nombre!=null)) {
        $fpdi->Image(isset($configuration) ? ($configuration->logo_ics == '') ? asset('/dist/images/logoazul.png') : $configuration->logo_ics : asset('/dist/images/logoazul.jpg'),10,5,35,0,'PNG');
      }
      if($isJPG) {
        $fpdi->Image(isset($configuration) ? ($configuration->logo_ics == '') ? asset('/dist/images/logoazul.jpg') : $configuration->logo_ics : asset('/dist/images/logoazul.jpg'),10,5,35,0,'JPG');
      }

      $fpdi->SetFont('Arial','B',14);
      $fpdi->SetTextColor(59, 59, 59);
      $fpdi->SetXY(50,10);
      $fpdi->MultiCell(85, 3, isset($configuration->name_company) ? ucwords($configuration->name_company): 'International Cargo System');

      $fpdi->SetFont('Arial','',12);
      $fpdi->SetTextColor(59, 59, 59);
      $fpdi->SetXY(50, 15 );
      $fpdi->MultiCell(85, 3, isset($configuration->dni_company) ? $configuration->dni_company: 'DNI:1234567890');

      $fpdi->SetFont('Arial','',8);
      $fpdi->SetTextColor(0, 0, 0);;

      //ENTREGADO
      $fpdi->SetXY(5, 37);
      $fpdi->MultiCell(30, 3, $shipment->realizate_city_date,0,'C');

      //CONTENEDOR
      $fpdi->SetXY(40, 37);
      $container = Container::find($shipment->container_name);
      $fpdi->MultiCell(85, 3, ($shipment->containerized != '0')&&(isset($container)) ? $container->code : 'NO CONTAINERIZADO',0,'C');

      //NUMERO DE RESERVACION
      $fpdi->SetXY(150, 37);
      $fpdi->MultiCell(30, 3, $shipment->number_reservation,0,'C');

      //NOMBRE Y DIRECCION DEL AGENTE
      $fpdi->SetXY(12, 55-8);
      $fpdi->MultiCell(85, 3, isset($configuration->name_company) ? strtoupper($configuration->name_company): 'International Cargo System',0,'L');
      $fpdi->SetXY(12, 58-8);
      $fpdi->MultiCell(85, 3, isset($configuration) ? strtoupper($configuration->city_company): 'www.internationalcargosystem.com',0,'L');
      $fpdi->SetXY(12, 61-8);
      $fpdi->MultiCell(85, 3, isset($configuration) ? strtoupper($configuration->region_company.', '.(($configuration->country_company != '0') ? $configuration->country_company : '')): 'www.internationalcargosystem.com',0,'L');
      $fpdi->SetXY(12, 64-8);
      $fpdi->MultiCell(85, 3, isset($configuration->email_company) ? strtolower($configuration->email_company): 'www.internationalcargosystem.com',0,'L');
      $fpdi->SetXY(12, 68-8);
      $fpdi->MultiCell(85, 3, isset($configuration->phone) ? strtoupper($configuration->phone): 'www.internationalcargosystem.com',0,'L');

      $consigner = User::find($shipment->consigner);
      //NOMBRE Y DIRECCION DEL AGENTE
      $fpdi->SetXY(12, 55+15);
      $fpdi->MultiCell(85, 3, isset($consigner) ? strtoupper($consigner->name.' '.$consigner->last_name): 'International Cargo System',0,'L');
      $fpdi->SetXY(12, 58+15);
      $fpdi->MultiCell(85, 3, isset($consigner) ? strtoupper('DNI: '.$consigner->dni): '',0,'L');
      $fpdi->SetXY(12, 61+15);
      $fpdi->MultiCell(85, 3, isset($consigner) ? strtoupper($consigner->region.', '.(($consigner->country != '0') ? $consigner->country : '')): '',0,'L');
      $fpdi->SetXY(12, 64+15);
      $fpdi->MultiCell(85, 3, isset($consigner) ? strtolower($consigner->email): '',0,'L');
      $fpdi->SetXY(12, 68+15);
      $fpdi->MultiCell(85, 3, isset($consigner) ? strtoupper('PHONE: '.$consigner->celular): '',0,'L');

      //Notas
      $fpdi->SetXY(115, 60);
      $fpdi->MultiCell(85, 3,isset($configuration->name_company) ? strtoupper($configuration->name_company) : '');

      //Notas
      $fpdi->SetXY(115, 55+15);
      $fpdi->MultiCell(85, 3,isset($shipment->description) ? strtoupper($shipment->description) : '');


      $shipmentruote = ShipmentRoute::query()->where('shipment','=',$id)->first();
      $vessel = isset($shipmentruote->vessel) ? Vessel::find($shipmentruote->vessel) :null;
      //NUMERO DE GUIA
      $fpdi->SetXY(117, 37);
      $numberBL = isset($shipment->code) ? str_replace("SHP","BL",$shipment->code) : '';
      $fpdi->MultiCell(30, 3, $numberBL,0,'C');

      $fpdi->SetFont('Arial','',7);
      $fpdi->SetXY(117, 48);
      //ORIGEN
      if ($shipment->transport == 1) {
        $fpdi->SetXY(105, 46.5);
        $fpdi->MultiCell(55, 3, isset($shipment->realizate_city_place) ? strtoupper($shipment->realizate_city_place) : '',0,'C');
        $v = isset($shipmentroute->travel_identifier) ? $shipmentroute->travel_identifier : null;
        $f = isset($vessel->flag) ? $vessel->name : null;
      }
      if ($shipment->transport == 2) {
        $fpdi->SetXY(105, 46.5);
        $airport = isset($shipment->from_airport) ? IataCode::find($shipment->from_airport) : null;
        $fpdi->MultiCell(55, 3, isset($airport) ? strtoupper($airport->iata.' - '.$airport->name) : '',0,'C');
      }
      //DESTINO
      if ($shipment->transport == 1){
        $fpdi->SetXY(156, 46.5);
        $fpdi->MultiCell(49, 3, isset($port2->name)?strtoupper($port2->name):'',0,'C');
      }
      if ($shipment->transport == 2) {
        $fpdi->SetXY(156, 46.5);
        $airport2 = isset($shipment->to_airport) ? IataCode::find($shipment->to_airport) : null;
        $fpdi->MultiCell(49, 3, isset($airport2) ? strtoupper($airport2->iata.' - '.$airport2->name):'',0,'C');
      }


      $height = 92;
      $total_pieces = 0;
      $total_weight = 0;
      $total_vol = 0;
      $i = 1;
      foreach ($shipmentdetails as $key => $shipmentdetail) {
        $package = null;
        if($shipmentdetail!=null){
            $packages = Package::query()->where('id','=',$shipmentdetail->warehouse)->get();
        }
        //  dd($packages);
        foreach ($packages as $key => $package) {
          if($package != null){
              $category = Category::find($package->category);
          }

          $detailpackages = null;
          if ($package != null) {
            //dd($package);
            $detailpackages = Detailspackage::query()->where('package','=',$package->id)->get();
            foreach ($detailpackages as $key => $detailpackage) {
              if ($detailpackage != null) {
                if ($i>8) {

                  $fpdi->SetFont('Arial','B',9);
                  //TOTAL PIEZAS
                  $fpdi->SetXY(87, 249);
                  $fpdi->MultiCell(30, 3, ($total_pieces),0,'C');

                  $fpdi->SetXY(97, 249);
                  $fpdi->MultiCell(30, 3, number_format($total_weight,2,',','.').'Lb',0,'R');

                  $fpdi->SetXY(118, 249);
                  $fpdi->MultiCell(39, 3, number_format($total_vol,2,',','.').'ft3',0,'C');

                  $fpdi->addPage();
                  $fpdi->useTemplate($tplIdx, 0, 0, 210, 279-5);

                  $nombre = $configuration->logo_ics;
                  $isJPG = strrpos($nombre,".jpg");
                  if((!($isJPG)) && ($nombre!=null)) {
                    $fpdi->Image(isset($configuration) ? ($configuration->logo_ics == '') ? asset('/dist/images/logoazul.jpg') : $configuration->logo_ics : asset('/dist/images/logoazul.jpg'),10,5,35,0,'PNG');
                  }
                  if($isJPG) {
                    $fpdi->Image(isset($configuration) ? ($configuration->logo_ics == '') ? asset('/dist/images/logoazul.jpg') : $configuration->logo_ics : asset('/dist/images/logoazul.jpg'),10,5,35,0,'JPG');
                  }

                  $fpdi->SetFont('Arial','B',14);
                  $fpdi->SetTextColor(59, 59, 59);
                  $fpdi->SetXY(45, 8);
                  $fpdi->MultiCell(85, 3, isset($configuration->name_company) ? $configuration->name_company: 'International Cargo System');

                  $fpdi->SetFont('Arial','',12);
                  $fpdi->SetTextColor(59, 59, 59);
                  $fpdi->SetXY(45, 13);
                  $fpdi->MultiCell(85, 3, isset($configuration->dni_company) ? $configuration->dni_company: 'DNI:1234567890');

                  $fpdi->SetFont('Arial','',12);
                  $fpdi->SetTextColor(83, 83, 83);
                  $fpdi->SetXY(45, 18);
                  $fpdi->MultiCell(85, 3, isset($configuration->email_company) ? $configuration->email_company: 'www.internationalcargosystem.com');

                  $fpdi->SetFont('Arial','',8);
                  $fpdi->SetTextColor(0, 0, 0);;

                  //ENTREGADO
                  $fpdi->SetXY(173, 30.5);
                  $fpdi->MultiCell(85, 3, $shipment->departure_date_mar);

                  //CONTENEDOR
                  $fpdi->SetXY(12, 42);
                  //dd($shipment);
                  $fpdi->MultiCell(85, 3, ($shipment->containerized == '0') ? $shipment->container_name : 'NO CONTAINERIZADO',0,'C');

                  //NUMERO DE RESERVACION
                  $fpdi->SetXY(143, 42);
                  $fpdi->MultiCell(30, 3, $shipment->number_reservation,0,'C');

                  //NOMBRE Y DIRECCION DEL AGENTE
                  $fpdi->SetXY(8, 55);
                  $fpdi->MultiCell(85, 3, isset($configuration->name_company) ? strtoupper($configuration->name_company): 'International Cargo System',0,'L');
                  $fpdi->SetXY(8, 60);
                  $fpdi->MultiCell(85, 3, isset($configuration) ? strtoupper($configuration->city_company): 'www.internationalcargosystem.com',0,'L');
                  $fpdi->SetXY(8, 65);
                  $fpdi->MultiCell(85, 3, isset($configuration) ? strtoupper($configuration->region_company.', '.$configuration->country_company): 'www.internationalcargosystem.com',0,'L');
                  $fpdi->SetXY(8, 70);
                  $fpdi->MultiCell(85, 3, isset($configuration->email_company) ? strtolower($configuration->email_company): 'www.internationalcargosystem.com',0,'L');
                  $fpdi->SetXY(8, 75);
                  $fpdi->MultiCell(85, 3, isset($configuration->phone) ? strtoupper($configuration->phone): 'www.internationalcargosystem.com',0,'L');


                  //NOMBRE Y DIRECCION DEL TRANSPORTISTA
                  $state = State::query()->where('name','=',$transportista->address_state)->first();
                  $country = Country::find($state->country);
                  //dd($country);
                  $fpdi->SetXY(70, 70-15);
                  $fpdi->MultiCell(50, 3, isset($transportista) ? strtoupper($transportista->name) : '  ',0,'L');
                  $fpdi->SetXY(70, 75-15);
                  $fpdi->MultiCell(50, 3, isset($transportista) ? 'PHONE: '.strtoupper($transportista->phone) : '',0,'L');
                  $fpdi->SetXY(70, 90-15);
                  $fpdi->MultiCell(50, 3, isset($transportista) ? strtolower($transportista->email) : '',0,'L');
                  $fpdi->SetXY(70, 80-15);
                  $fpdi->MultiCell(50, 3,  isset($transportista) ? strtoupper($transportista->address_code." ".$transportista->address_state) : '',0,'L');
                  $fpdi->SetXY(70, 85-15);
                  $fpdi->MultiCell(50, 3,  isset($transportista) ? strtoupper($country->name) : '',0,'L');

                  $shipmentruote = ShipmentRoute::query()->where('shipment','=',$id)->first();

                  $vessel = Vessel::find($shipmentruote->vessel);
                  //dd($vessel);
                  //NUMERO DE GUIA
                  $fpdi->SetXY(125, 57);

                  $numberBL = isset($shipment->code) ? str_replace("SHP","BL",$shipment->code) : '';
                  $fpdi->MultiCell(30, 3, $numberBL,0,'C');

                  //FECHA
                  $fpdi->SetXY(153, 57);
                  $fpdi->MultiCell(30, 3, $shipment->realizate_city_date,0,'C');

                  //ORIGEN
                  $fpdi->SetXY(177, 57);
                  $fpdi->MultiCell(30, 3, isset($shipment->realizate_city_place) ? strtoupper($shipment->realizate_city_place) : '',0,'C');
                  $v = isset($shipmentroute->travel_identifier) ? $shipmentroute->travel_identifier : null;
                  $f = isset($vessel->flag) ? $vessel->name : null;

                  //NUEMRO DE VUELO, VIAJE y BUQUE
                  $fpdi->SetXY(125, 73);
                  $fpdi->MultiCell(30, 3, isset($v) ? strtoupper($v) : '',0,'C');
                  $fpdi->SetXY(125, 76);
                  $fpdi->MultiCell(30, 3, isset($f) ?strtoupper($f) : '',0,'C');

                  //DESTINO
                  $fpdi->SetXY(177, 73);
                  $fpdi->MultiCell(30, 3, isset($port2->name)?strtoupper($port2->name):'',0,'C');

                  $i=1;
                  $height = 96;


                }
                  $fpdi->SetFont('Arial','',7.5);
                  //WAREHOUSES
                  $fpdi->SetXY(4, $height+2);
                  $fpdi->MultiCell(30, 3, isset($package) ? $package->code : '', 0, 'C');

                  //TIPO
                  $fpdi->SetXY(22, $height+2);
                  $tipo = Transport::find($shipment->transport);
                  $fpdi->MultiCell(30, 3, isset($package) ? ucwords(utf8_decode($tipo->spanish)) : '', 0, 'C');

                  //PIECES
                  $fpdi->SetXY(41, $height+2);
                  $fpdi->MultiCell(30, 3, $detailpackage->pieces,0,'C');
                  $total_pieces = $total_pieces + $detailpackage->pieces;

                  //DESCRIPTION
                  $fpdi->SetXY(85, $height+2);
                  $category = Category::find($package->category);
                  $fpdi->MultiCell(70, 3, isset($category) ? strtoupper($category->label) : 'SIN CATEGORIA',0,'L');

                  //WEIGHT
                  $fpdi->SetXY(105+50, $height+2);
                  $fpdi->MultiCell(30, 3, number_format($detailpackage->weight,2,',','.').'Lb',0,'C');
                  $total_weight = $total_weight +$detailpackage->weight;
                  //VOLUME
                  $fpdi->SetXY(118+55, $height+2);
                  $fpdi->MultiCell(40, 3, number_format($detailpackage->volumetricweightm,2,',','.').' ft3',0,'C');
                  $total_vol = $total_vol + $detailpackage->volumetricweightm;

                  $fpdi->SetFont('Arial','',8);
                    if (isset($consigner) && (strlen($consigner->name." ".$consigner->last_name)>20)) {
                      $height=$height+4;
                    }elseif (isset($shipper) && (strlen($shipper->name." ".$shipper->last_name)>17)) {
                        $height=$height+4;
                    }

                  $height += 4;
                  $i++;
              }


            }

          }
        }
      }

      $fpdi->SetFont('Arial','B',9);
      //TOTAL PIEZAS
      $fpdi->SetXY(40, 241);
      $fpdi->MultiCell(30, 3, ($total_pieces),0,'C');

      $fpdi->SetXY(145, 241);
      $fpdi->MultiCell(30, 3, number_format($total_weight,2,',','.').'Lb',0,'R');

      $fpdi->SetXY(175, 241);
      $fpdi->MultiCell(39, 3, number_format($total_vol,2,',','.').'ft3',0,'C');

      //FOOTER
      $fpdi->SetFont('Arial','',9);
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(8, 261);
      $fpdi->MultiCell(180, 3, isset($configuration->footer_receipt) ? $configuration->footer_receipt : '');

      $fpdi->Output();


    }

      public function invoicepackage(Request $request, $id){
      $session       = $request->session()->get('key-sesion');
      $package       = Package::find($id);

      $receipt       = Receipt::query()->where('package','=',$id)->first();

      $configuration = Configuration::find(1);
      $timezone = explode(" ", $configuration->time_zone);
      date_default_timezone_set($timezone[0]);

      if(isset($package->details_type)){
        $transporty    = Service::query()->where('transport','=',$package->getType->id)->first();
      }



       if(isset($receipt)){
        $detailreceipt  = DB::table('detailsreceipt')
                      ->join('tax', 'detailsreceipt.id_complemento', '=', 'tax.id')
                      ->select('detailsreceipt.id', 'tax.name', 'detailsreceipt.value_oring','detailsreceipt.value_package')
                      ->where("detailsreceipt.type_attribute","=",'I')
                      ->where("detailsreceipt.receipt","=",$receipt->id)
                      ->first();

         $detailreceiptpro = DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','P')->first();

         $detailreceiptty = DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','T')->first();
         $detailreceiptTax = DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','I')->first();
         $detailtytran= isset($detailreceiptty) ? Service::find($detailreceiptty->id_complemento):'';
         $detailreceiptinsu = DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','S')->first();

         $detailreceiptadd = DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','A')->first();

         $detailadd= isset($detailreceiptadd) ? AddCharge::find($detailreceiptadd->id_complemento):'';
         if($package->type==1){
          $resultpackvol    = DB::table('detailspackage')->where('package','=',$id)->sum('volumetricweightm');
         }else if($package->type==2){
          $resultpackvol    = DB::table('detailspackage')->where('package','=',$id)->sum('volumetricweighta');
         }

         //large
         $resultlarge    = DB::table('detailspackage')->where('package','=',$id)->sum('large');
         //height
         $resultheight    = DB::table('detailspackage')->where('package','=',$id)->sum('height');
         //width
         $resultwidth    = DB::table('detailspackage')->where('package','=',$id)->sum('width');
         //weight
         $resultwieght    = DB::table('detailspackage')->where('package','=',$id)->sum('weight');

        }


      /**
      *  Se valida que la sesion este activa
      */
      if ($session == null)
      {
        return redirect('login');
      }

      if(isset($package->type)){
        if($package->type==1){
          $unidad=' ft3';
        }else if($package->type==2){
          $unidad=' Vlb';
        }

      }

       /*if(isset($package->type)){
        if($package->type==1){
          $vol=$package->volumetricweightm;
        }else if($package->type==2){
          $vol=$package->volumetricweightm;
        }*/

      $fpdi = new \fpdi\FPDI();
      $fpdf = new \fpdf\FPDF();

      $fpdi->SetAutoPageBreak(true,5);
      $pageCount = $fpdi->setSourceFile('tmpreport/invoice.pdf');
      $tplIdx    = $fpdi->importPage(1, '/BleedBox');
      $fpdi->SetTitle(isset($receipt) ? 'Invoice '.$receipt->code : '');

      $fpdi->addPage();
      $fpdi->useTemplate($tplIdx, 0, 0, 210);


      //Datos de la empresa
      $nombre = $configuration->logo_ics;
      $isJPG = strrpos($nombre,".jpg");
      if((!($isJPG)) && ($nombre!=null)) {
        $fpdi->Image(isset($configuration) ? ($configuration->logo_ics == '') ? asset('/dist/images/logoazul.jpg') : $configuration->logo_ics : asset('/dist/images/logoazul.jpg'),10,5,30,0,'PNG');
      }
      if($isJPG) {
        $fpdi->Image(isset($configuration) ? ($configuration->logo_ics == '') ? asset('/dist/images/logoazul.jpg') : $configuration->logo_ics : asset('/dist/images/logoazul.jpg'),10,5,30,0,'JPG');
      }

      $fpdi->SetFont('Arial','B',14);
      $fpdi->SetTextColor(59, 59, 59);
      $fpdi->SetXY(45, 7);
      $fpdi->MultiCell(85, 3, isset($configuration->name_company) ? $configuration->name_company: 'International Cargo System');

      $fpdi->SetFont('Arial','',12);
      $fpdi->SetTextColor(59, 59, 59);
      $fpdi->SetXY(45, 12);
      $fpdi->MultiCell(85, 3, isset($configuration->dni_company) ? $configuration->dni_company: 'DNI:1234567890');

      $fpdi->SetFont('Arial','',12);
      $fpdi->SetTextColor(83, 83, 83);
      $fpdi->SetXY(45, 17);
      $fpdi->MultiCell(85, 3, isset($configuration->email_company) ? $configuration->email_company: 'www.internationalcargosystem.com');


      //Titulo del Invoice
      /*$fpdi->SetFont('Arial','B',16);
      $fpdi->SetTextColor(255, 255, 255);
      $fpdi->SetXY(80, 60);
      $fpdi->MultiCell(85, 3, 'INVOICE '.$receipt->code);*/

      //Detalle del paquete

      $fpdi->SetFont('Arial','',8);
      $fpdi->SetTextColor(0, 0, 0);

      $fpdi->SetXY(165, 33.7);
      $numberBL = isset($package->code) ? str_replace("WRH","INV",$package->code) : '';
      $fpdi->MultiCell(30, 3, $receipt->code,0,'C');


      $fpdi->SetXY(172, 39);
      $fpdi->MultiCell(85, 3, isset($package->getToUser->postal_code)?$package->getToUser->postal_code:'');


      $fpdi->SetXY(172, 36.2);
      $fpdi->MultiCell(85, 3,isset($package) ? $package->created_at->format('d-M-Y H:i:s'): '');

      $estados = Event::all();
      $stat = isset($package->last_event) ? ($estados[($package->last_event)-1])   : null;
      $fpdi->SetFillColor(255, 255, 255);
      $fpdi->SetXY(142, 41.5);
      $fpdi->MultiCell(35, 3,'',0,'R',true);

      //***********************************************************************
      $fpdi->SetFont('Arial','',9);
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(115, 60);
      $fpdi->MultiCell(95, 3, 'Consignee:');

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(140, 60);
      $fpdi->MultiCell(95, 3, isset($package) ? (isset($package->to_client) ? ucwords($package->getToClient['name']) : ucwords($package->getToUser['name']." ".$package->getToUser['last_name'])) : '');

      $fpdi->SetXY(115, 65);
      $fpdi->MultiCell(95, 3, 'Address:');
      $fpdi->SetXY(140, 65);
      $fpdi->MultiCell(95, 3, isset($package) ? (isset($package->to_client) ? ucwords($package->getToClient['country']) : ucwords($package->getToUser['city'].", ".$package->getToUser['country'])) : '');

      $fpdi->SetXY(115, 70);
      $fpdi->MultiCell(95, 3, 'Phone:');
      $fpdi->SetXY(140, 70);
      $fpdi->MultiCell(95, 3, isset($package) ? (isset($package->to_client) ? ucwords($package->getToClient['phone']) : ucwords($package->getToUser['celular'])) : '');

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(115, 75);
      $fpdi->MultiCell(85, 3, 'Dimensions:');

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(140, 75);
      $fpdi->MultiCell(85, 3,isset($package) ? $resultlarge.'x'.$resultwidth."x".$resultheight: '');

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(115, 80);
      $fpdi->MultiCell(85, 3, 'Weight:');

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(140, 80);
      $fpdi->MultiCell(25, 3,isset($package) ?number_format($resultwieght,2,',','.')." Lb" : '');

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(115, 85);
      $fpdi->MultiCell(85, 3, 'Transport:');

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(140, 85);
      $fpdi->MultiCell(85, 3,(isset($package->type) && ($package->type == 1)) ?'MARITIMO': 'AEREO');


      //Detalle del usuario
      if(isset($package->to_client)){
        $fpdi->SetTextColor(0, 0, 0);
        $fpdi->SetXY(16, 65);
        $fpdi->MultiCell(85, 3, $package->getToClient->code." ".$package->getToClient->name);

      }elseif (isset($package->to_user)) {

        $fpdi->SetFont('Arial','',9);
        $fpdi->SetTextColor(0, 0, 0);
        $fpdi->SetXY(10, 70-10);
        $fpdi->MultiCell(95, 3, 'NAME:');

        $fpdi->SetXY(30, 70-10);
        $fpdi->MultiCell(85, 3, ucwords($package->getToUser->name." ".$package->getToUser->last_name));

        $fpdi->SetXY(10, 75-10);
        $fpdi->MultiCell(95, 3, 'DNI:');

        $fpdi->SetTextColor(0, 0, 0);
        $fpdi->SetXY(30, 75-10);
        $fpdi->MultiCell(85, 3, $package->getToUser->dni);

        $fpdi->SetXY(10, 80-10);
        $fpdi->MultiCell(95, 3, 'ADDRESS:');

        $fpdi->SetXY(30, 80-10);
        $fpdi->MultiCell(85, 3, ucwords($package->getToUser->city.', '.$package->getToUser->region.', '.$package->getToUser->country));

        $fpdi->SetXY(10, 85-10);
        $fpdi->MultiCell(95, 3, 'PHONE:');

        $fpdi->SetXY(30, 85-10);
        $fpdi->MultiCell(85, 3, $package->getToUser->celular);

        $fpdi->SetXY(10, 90-10);
        $fpdi->MultiCell(95, 3, 'EMAIL:');

        $fpdi->SetXY(30, 90-10);
        $fpdi->MultiCell(85, 3, $package->getToUser->email);
      }
      $subtotal = 0;
      $total = 0;
      //Datos de Facturacion
      $service = isset($package->details_type) ? Service::find($package->details_type) : null;
      $route = isset($package->details_type) ? Route::find($package->details_type) : null;
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(10, 145-20);
      $fpdi->MultiCell(40, 3, isset($route) ? ucwords($route->name): '' ,0,'C');

      $fpdi->SetXY(68, 145-20);
      $fpdi->MultiCell(25, 3, (isset($resultpackvol)) ? number_format($resultpackvol,2,',','.').$unidad: '', 0, 'R');

      $fpdi->SetXY(115, 145-20);
      $fpdi->MultiCell(25, 3, isset($route->price) ? number_format(floatval($route->price),2,',','.')." $": '', 0, 'R');

      $fpdi->SetXY(168, 145-20);
      $fpdi->MultiCell(25, 3, isset($route->price) ? number_format($route->price*$resultpackvol,2,',','.')." $": '', 0, 'R');
      $subtotal = isset($route->price) ? ($subtotal + $route->price*$resultpackvol) : $subtotal;

      $detail = isset($package->id) ? Detailspackage::query()->where('package','=',$package->id)->first() : null;
      $add_charge = isset($detail->addcharge) ? AddCharge::find($detail->addcharge) : null;
      // Cargos Adicionales
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(10, 153-20);
      $fpdi->MultiCell(40, 3, isset($add_charge->name) ? ucwords($add_charge->name) : '',0,'C');

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(68, 153-20);
      $fpdi->MultiCell(25, 3, (isset($add_charge->value) && ($add_charge->value > 0)) ? '1': '', 0, 'R');

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(115, 153-20);
      $fpdi->MultiCell(25, 3, isset($add_charge->value) ? number_format($add_charge->value,2,',','.')." $": '', 0, 'R');

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(168, 153-20);
      $fpdi->MultiCell(25, 3, isset($add_charge->value) ? number_format($add_charge->value,2,',','.')." $": '', 0, 'R');
      $subtotal = isset($add_charge->value) ? ($subtotal + $add_charge->value) : $subtotal;
      // Seguro
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(10, 161-20);
      $fpdi->MultiCell(40, 3, ((isset($detailreceiptinsu->value_oring))&&($detailreceiptinsu->value_oring != 0)) ? 'Seguro': '',0,'C');

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(68, 161-20);
      $fpdi->MultiCell(25, 3, ((isset($detailreceiptinsu->value_oring))&&($detailreceiptinsu->value_oring != 0)) ? $detailreceiptinsu->value_oring.'%': '', 0, 'R');

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(115, 161-20);

      $seguro = ($package->value * $detailreceiptinsu->value_oring)/100;
      $fpdi->MultiCell(25, 3, ((isset($package->value))&&($detailreceiptinsu->value_oring != 0)) ? number_format($package->value,2,',','.')." $": '', 0, 'R');

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(168, 161-20);
      $fpdi->MultiCell(25, 3, ((isset($seguro))&&($detailreceiptinsu->value_oring != 0)) ? number_format($seguro ,2,',','.')." $": '', 0, 'R');
      $subtotal = isset($seguro) ? $subtotal + $seguro : $subtotal;

    //  dd($detailreceipt);
      //Detalle de totales
      $fpdi->SetFont('Arial','B',11);
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(167, 242);
      $fpdi->MultiCell(25, 3, isset($receipt) ? number_format($subtotal,2,',','.')." $" : '', 0, 'R');
      $total = isset($detailreceiptTax) ? $subtotal + (($subtotal * $detailreceiptTax->value_oring)/100) : $subtotal;
      $total = isset($detailreceiptpro->value_package) ? $total + $detailreceiptpro->value_package : $total;
      $fpdi->SetFont('Arial','B',11);
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(167, 261);
      $fpdi->MultiCell(25, 3, isset($receipt) ? number_format($total,2,',','.')." $" : '', 0, 'R');
      //dd($detailreceipt);
      $fpdi->SetFont('Arial','',10);
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(140, 249);
      $fpdi->MultiCell(25, 3, isset($detailreceiptTax) ? $detailreceiptTax->value_oring."%" : '0%', 0, 'R');

      $fpdi->SetFont('Arial','',11);
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(167, 228+21);
      $fpdi->MultiCell(25, 3, isset($detailreceiptTax) ? number_format(($subtotal * $detailreceiptTax->value_oring)/100,2,',','.')." $" : '0$', 0, 'R');


      if (!isset($detailreceiptpro)) {
        $fpdi->SetFillColor(255, 255, 255);
        $fpdi->SetXY(128, 235+18);
        $fpdi->MultiCell(20, 4, '',0,'R',true);
      }
      $fpdi->SetFont('Arial','',11);
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(162, 235+19);
      $fpdi->MultiCell(30, 3, isset($detailreceiptpro) ? number_format($detailreceiptpro->value_package,2,',','.')." $" : '', 0, 'R');

      $fpdi->SetFont('Arial','',10);
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(20, 270);
      $fpdi->MultiCell(180, 3, isset($configuration->footer_receipt) ? $configuration->footer_receipt : '');

      /*$fpdi->SetFont('Arial','',12);
      $fpdi->SetXY(140, 232);
      $fpdi->MultiCell(85, 3, strftime( "%Y-%m-%d", time()));*/


      $fpdi->Output();


    }

    public function cargoReleasePackage(Request $request, $id){
          $session= $request->session()->get('key-sesion');

          $cargoRelease = CargoRelease::find($id);
          if(CargoReleaseDetail::byCargoRelease($id)->first() == null){
            $details = "";
          }else{
            $details = CargoReleaseDetail::byCargoRelease($id)->first();
          }

          if($cargoRelease==null){
            $ship = "";
            $transporter ="";
          }else{
            if($details != ""){
              $pickupdetails = DetailsPickup::find($details->pickup_order);
              if($pickupdetails==null){
                $pickup = "";
              }else {
                $pickup = Pickup::find($pickupdetails->pickup);
              }
            }else{
              $pickupdetails = "";
              $pickup = "";
            }
            $ship = Shipment::query()->where('consigner','=',$cargoRelease->user)->first();
            if($ship != null){
                $transporter = Transporters::find($ship->transporter);
            }else {
              $transporter ="";
            }
          }

          $configuration = Configuration::find(1);
          $timezone = explode(" ", $configuration->time_zone);
          date_default_timezone_set($timezone[0]);
          $packages       = Package::query()->where('process','=',$cargoRelease->code)->get();
        $fpdi = new \fpdi\FPDI();
        $fpdf = new \fpdf\FPDF();

        $pageCount = $fpdi->setSourceFile('tmpreport/CRD.pdf');
        $tplIdx    = $fpdi->importPage(1, '/BleedBox');
        $fpdi->SetTitle('Cargo Release Details');

        $fpdi->addPage();
        $fpdi->useTemplate($tplIdx, 10, 10, 190);

        //Datos de la empresa
        $nombre = $configuration->logo_ics;
        $isJPG = strrpos($nombre,".jpg");
        if((!($isJPG)) && ($nombre!=null)) {
          $fpdi->Image(isset($configuration) ? ($configuration->logo_ics == '') ? asset('/dist/images/logoazul.jpg') : $configuration->logo_ics : asset('/dist/images/logoazul.jpg'),10,13,30,0,'PNG');
        }
        if($isJPG) {
          $fpdi->Image(isset($configuration) ? ($configuration->logo_ics == '') ? asset('/dist/images/logoazul.jpg') : $configuration->logo_ics : asset('/dist/images/logoazul.jpg'),10,13,30,0,'JPG');
        }

        $fpdi->SetFont('Arial','B',14);
        $fpdi->SetTextColor(59, 59, 59);
        $fpdi->SetXY(49, 15);
        $fpdi->MultiCell(85, 3, isset($configuration->name_company) ? $configuration->name_company: 'International Cargo System');

        $fpdi->SetFont('Arial','',12);
        $fpdi->SetTextColor(59, 59, 59);
        $fpdi->SetXY(49, 20);
        $fpdi->MultiCell(85, 3, isset($configuration->dni_company) ? $configuration->dni_company: 'DNI:1234567890');

        $fpdi->SetFont('Arial','',12);
        $fpdi->SetTextColor(83, 83, 83);
        $fpdi->SetXY(49, 25);
        $fpdi->MultiCell(85, 3, isset($configuration->email_company) ? $configuration->email_company: 'www.internationalcargosystem.com');

        $fpdi->SetFont('Arial','',9);
        $fpdi->SetTextColor(0, 0, 0);

        //Bond Number
        $fpdi->SetXY(170, 37);
        $fpdi->MultiCell(85, 3, isset($cargoRelease->code) ? $cargoRelease->code : '');

        $fpdi->SetXY(170, 52-10);
        $fpdi->MultiCell(85, 3, isset($cargoRelease->release_date) ? $cargoRelease->release_date : 'SIN INFORMACION');

        $fpdi->SetXY(170, 56-10);
        $fpdi->MultiCell(85, 3, "Administrador");

        $fpdi->SetXY(60, 85-22);
        $fpdi->MultiCell(85, 3, isset($transporter->name) ? $transporter->name : 'SIN INFORMACION');

        $fpdi->SetXY(60, 95-22);
        $fpdi->MultiCell(85, 3, isset($transporter->code) ? $transporter->code : 'SIN INFORMACION');

        $fpdi->SetXY(60, 104-22);
        $fpdi->MultiCell(85, 3, isset($pickupdetails->tracking) ? $pickupdetails->tracking : 'SIN INFORMACION');

        $fpdi->SetXY(130, 70);
        $fpdi->MultiCell(85, 3, 'SIN CARGOS ADICIONALES');

        $h=105;
        if($packages != null){
          foreach ($packages as $key => $value) {
            $detailspackage    = Detailspackage::query()->where('package','=',$value->id)->first();
            //dd($detailspackage);
            //PACKAGE
            $fpdi->SetXY(20, $h);
            $fpdi->MultiCell(25, 3, $value->code,0,'C');

            //PIEZAS
            $fpdi->SetXY(42, $h);
            $fpdi->MultiCell(25, 3, $detailspackage->pieces,0,'R');

            //DESCRIPTION
            $fpdi->SetXY(72, $h);
            $fpdi->MultiCell(40, 3, $detailspackage->description,0,'C');

            //PESO
            $fpdi->SetXY(100, $h);
            $fpdi->MultiCell(25, 3, $detailspackage->weight,0,'R');

            //VOLUMEN
            $fpdi->SetXY(130, $h);
            $fpdi->MultiCell(40, 3, $detailspackage->large.'x'.$detailspackage->width.'x'.$detailspackage->height,0,'C');

            if($value->getType->id == 1){
              $fpdi->SetXY(140, $h);
              $fpdi->MultiCell(40, 3, $detailspackage->volumetricweightm,0,'R');
            }
            if($value->getType->id == 2){
              $fpdi->SetXY(140, $h);
              $fpdi->MultiCell(40, 3, $detailspackage->volumetricweighta,0,'R');
            }
            $h += 5;
          }
        }


        $fpdi->SetFont('Arial','',10);
        $fpdi->SetTextColor(0, 0, 0);
        $fpdi->SetXY(15, 250);
        $fpdi->MultiCell(180, 3, isset($configuration->footer_receipt) ? $configuration->footer_receipt : '');

        $fpdi->Output();
      }
}
