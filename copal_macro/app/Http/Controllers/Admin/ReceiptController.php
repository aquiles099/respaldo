<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Admin\Package;
use App\Models\Admin\Log;
use App\Models\Admin\Event;
use App\Models\Admin\Consolidated;
use App\Models\Admin\Receipt;
use App\Models\Admin\Category;
use App\Models\Admin\DetailsReceipt;
use App\Models\Admin\Detailspackage;
use App\Models\Admin\DetailsTransport;
use App\Models\Admin\Client;
use App\Models\Admin\Pickup;
use App\Models\Admin\Transporters;
use App\Models\Admin\Transport;
use App\Models\Admin\Company;
use App\Models\Admin\User;
use App\Models\Admin\CargoRelease;
use App\Models\Admin\CargoReleaseDetail;
use App\Models\Admin\Operator;
use App\Models\Admin\Courier;
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
      $service           = DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','S')->first();
      $addcharge         = DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','A')->first();
      $detailreceipt     = DB::table('detailsreceipt')->select('id', 'name_oring', 'value_oring','value_package')->where("type_attribute","=",'I')->where("receipt","=",$receipt->id)->get();
      $detailreceiptpro  = DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','P')->first();
      $configuration     = Configuration::find(HConstants::FIRST_CONFIGURATION);
      $aplicate_charges  = DetailsReceipt::byReceipt($receipt->id)->get();
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
      if(!($isJPG)) {
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

      //Recepit number
      $fpdi->SetXY(160, 35-8);
      $fpdi->MultiCell(85, 3,$package->code);

      //Tipo de envio
      $label = isset($package->getCategory->label) ? $package->getCategory->label : '';
      $fpdi->SetXY(160, 40-8);
      $fpdi->MultiCell(80, 3,$package->getCategory != '' ? strtoupper($package->getCategory->label) : trans('messages.unknown'));


      //Estatus
      $estado = Event::all();
      $stat = (($estado[(($package->last_event)-1)]));
      //dd($stat);
      $fpdi->SetXY(160, 55-9);
      $fpdi->MultiCell(85, 3, isset($stat) ? strtoupper($stat->name) : '');

      //Oficina de recepcion
      $fpdi->SetXY(160, 60-9);
      $fpdi->MultiCell(85, 3,$package->getOffice['name'] != '' ? strtoupper($package->getOffice['name']) : trans('messages.unknown'));

      //Date/time
      $fpdi->SetFont('Arial','',9);
      $fpdi->SetXY(160, 51-9);
      $fpdi->MultiCell(50, 2,$package->created_at);
      $fpdi->SetFont('Arial','',9);
      //Tipo de Transporte
      $fpdi->SetXY(160, 46-9);
      $fpdi->MultiCell(30, 3,isset($transport->spanish) ? strtoupper(utf8_decode($transport->spanish))  : trans('messages.unknown'));

      //SHIPPER INFORMATION
      $fpdi->SetXY(20+5, 83-18);
      $fpdi->MultiCell(85, 3,'Nombre: ');
      $fpdi->SetXY(35+5, 83-18);
      $fpdi->MultiCell(85, 3,isset($userconsig->name) ? strtoupper($userconsig->name." ".$userconsig->last_name):'');

      $fpdi->SetXY(20+5, 87-18);
      $fpdi->MultiCell(85, 3,'DNI: ');
      $fpdi->SetXY(35+5, 87-18);
      $fpdi->MultiCell(85, 3,isset($userconsig->dni) ? $userconsig->dni:'');

      $fpdi->SetXY(20+5, 90-18);
      $fpdi->MultiCell(85, 3,'Region: ');
      $fpdi->SetXY(35+5, 90-18);
      $fpdi->MultiCell(85, 3,isset($userconsig->country) ? $userconsig->country."-".$userconsig->region:'');

      $fpdi->SetXY(20+5, 94-18);
      $fpdi->MultiCell(85, 3,'Address: ');
      $fpdi->SetXY(35+5, 94-18);
      $fpdi->MultiCell(85, 3,isset($userconsig->postal_code) ? $userconsig->postal_code."-".$userconsig->address:'');

      $fpdi->SetXY(20+5, 98-18);
      $fpdi->MultiCell(85, 3,'Phone: ');
      $fpdi->SetXY(35+5, 98-18);
      $fpdi->MultiCell(85, 3,isset($userconsig->local_phone) ? $userconsig->local_phone."/".$userconsig->celular:'');

      //CONSIGNEE INFORMATION
      $fpdi->SetXY(110+10, 83-18);
      $fpdi->MultiCell(85, 3,'Nombre: ');
      $fpdi->SetXY(125+10, 83-18);
      $fpdi->MultiCell(85, 3,isset($userdesti->name) ? strtoupper($userdesti->name." ".$userdesti->last_name):'');

      $fpdi->SetXY(110+10, 87-18);
      $fpdi->MultiCell(85, 3,'DNI: ');
      $fpdi->SetXY(125+10, 87-18);
      $fpdi->MultiCell(85, 3,isset($userdesti->dni) ? $userdesti->dni:'');

      $fpdi->SetXY(110+10, 90-18);
      $fpdi->MultiCell(85, 3,'Region: ');
      $fpdi->SetXY(125+10, 90-18);
      $fpdi->MultiCell(85, 3,isset($userdesti->country) ? $userdesti->country."-".$userdesti->region:'');

      $fpdi->SetXY(110+10, 94-18);
      $fpdi->MultiCell(85, 3,'Address: ');
      $fpdi->SetXY(125+10, 94-18);
      $fpdi->MultiCell(85, 3,isset($userdesti->postal_code) ? $userdesti->postal_code."-".$userdesti->address:'');

      $fpdi->SetXY(110+10, 98-18);
      $fpdi->MultiCell(85, 3,'Phone: ');
      $fpdi->SetXY(125+10, 98-18);
      $fpdi->MultiCell(85, 3,isset($userdesti->local_phone) ? $userdesti->local_phone."/".$userdesti->celular:'');


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

      $h = 135;

      $unidad = " ft3";
      if ($package->type == 3) {
        $fpdi->SetXY(165, $h);
        $fpdi->MultiCell(25, 3,number_format($row->volumetricweightm,2,',','.').' Vlb', 0, 'R');
      }

      //dd($detailspackage);
      foreach ($detailspackage as $row){

        $fpdi->SetXY(1, $h);
        $fpdi->MultiCell(30, 3,$row->pieces,0,'R');

        $fpdi->SetXY(62, $h);
        $fpdi->MultiCell(25, 3,$row->height.'x'.$row->large.'x'.$row->width.'"', 0, 'C');

        $fpdi->SetXY(107, $h);
        $fpdi->MultiCell(25, 3,$row->description, 0, 'C');

        $fpdi->SetXY(140, $h);
        $fpdi->MultiCell(25, 3, number_format($row->weight,2,',','.').' Lb', 0, 'R');

        $fpdi->SetXY(175, $h);
        $fpdi->MultiCell(25, 3,isset($package->type) ? number_format($row->volumetricweightm,2,',','.').$unidad : '0,00ft3', 0, 'R');

        if ($package->type == 2) {
          $fpdi->SetXY(175, $h);
          $fpdi->MultiCell(25, 3,isset($package->type) ? number_format($row->volumetricweighta,2,',','.').$unidad : '0,00Vlb  ', 0, 'R');
        }

        $fpdi->SetXY(160, $h);
        $fpdi->MultiCell(25, 3,$row->process, 0, 'R');

        $h+=3;
      }

      $fpdi->SetXY(105, 248);
      $fpdi->MultiCell(25, 3,number_format($resultpackpieces,2,',','.'), 0, 'R');

      $fpdi->SetXY(135+10, 248);
      $fpdi->MultiCell(25, 3,number_format($resultpackweight,2,',','.').' Lb', 0, 'R');


      if($package->type == \App\Helpers\HConstants::TRANSPORT_MARITHIME){
        $fpdi->SetXY(160+10, 248);
        $fpdi->MultiCell(25, 3,number_format($resultpackvol,2,',','.')." ft3", 0, 'R');
      }
      if($package->type == \App\Helpers\HConstants::TRANSPORT_AERIAL){
          $fpdi->SetXY(160+15, 248);
          $fpdi->MultiCell(25, 3,number_format($resultpackvol,2,',','.')." Vlb", 0, 'R');
      }
      $fpdi->SetXY(15, 265);
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
      $service          = DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','S')->first();
      $addcharge        = DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','A')->first();
      $insurance        = DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','IN')->first();
      $transport        = DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','T')->first();
      $detailreceipt    = DB::table('detailsreceipt')->select('id', 'name_oring', 'value_oring','value_package')->where("type_attribute","=",'I')->where("receipt","=",$receipt->id)->get();
      $detailreceiptpro = DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','P')->first();
      $configuration    = Configuration::find(1);
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
      if(!($isJPG)) {
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
            $fpdi->MultiCell(50, 3,'SERVICE '.$service->name_oring, 0, 'L');

            $fpdi->SetXY($x+65, $y+120);
            $fpdi->MultiCell(20, 3,'1', 0, 'R');

            $fpdi->SetXY($x+120, $y+120);
            $fpdi->MultiCell(20, 3,number_format($service->value_package,2,',','.').' $', 0, 'R');

            $fpdi->SetXY($x+175, $y+120);
            $fpdi->MultiCell(20, 3,number_format($service->value_package,2,',','.').' $', 0, 'R');
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
        $fpdi->MultiCell(30, 3,number_format($receipt->subtotal,2,',','.').' $', 0, 'R');

        $fpdi->SetFont('Arial','',10);
        $fpdi->SetTextColor(0, 0, 0);
        foreach($detailreceipt as $row){
          //TAX
          $fpdi->SetXY($x+150, $y+221);
          $fpdi->MultiCell(30, 3,number_format($row->value_package,2,',','.').' $', 0, 'R');
        }
        //PROMOTION
        $fpdi->SetXY($x+150, $y+227);
        $fpdi->MultiCell(30, 3,number_format(isset($detailreceiptpro->value_package)?$detailreceiptpro->value_package:0,2,',','.').' $', 0, 'R');
        //TOTAL
        $fpdi->SetFont('Arial','',12);
        $fpdi->SetTextColor(0, 0, 0);
        $fpdi->SetXY($x+150, $y+232);
        $fpdi->MultiCell(30, 3,number_format($receipt->total,2,',','.').' $', 0, 'R');
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
      $receipt          = Receipt::query()->where('pickup','=',$id)->first();
      $userconsig       = User::find($package->consigner_user);
      $useroring        = User::find($package->from_user);
      $userdesti        = User::find($package->to_user);
      $detailspackage   = DetailsPickup::query()->where('pickup','=',$id)->get();
      $resultpackpieces = DB::table('details_pickup_order')->where('pickup','=',$id)->sum('pieces');
      $resultpackweight = DB::table('details_pickup_order')->where('pickup','=',$id)->sum('weight');
      $resultpackvol    = DB::table('details_pickup_order')->where('pickup','=',$id)->sum('volumetricweight');
      $service          = DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','S')->first();
      $addcharge        = DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','A')->first();
      $detailreceipt    = DB::table('detailsreceipt')->select('id', 'name_oring', 'value_oring','value_package')->where("type_attribute","=",'I')->where("receipt","=",$receipt->id)->get();
      $detailreceiptpro = DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','P')->first();
      $configuration    = Configuration::find(HConstants::FIRST_CONFIGURATION);
      $aplicate_charges = DetailsReceipt::byReceipt($receipt->id)->get();
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
      $fpdi->SetAutoPageBreak(true,5);
      $pageCount = $fpdi->setSourceFile('tmpreport/pickupOrder.pdf');
      $tplIdx    = $fpdi->importPage(1, '/BleedBox');

      $fpdi->SetTitle('PickUp Order'.' '.$package->code);

      $fpdi->addPage();
      $fpdi->useTemplate($tplIdx, 10, 10, 190);


      $nombre = $configuration->logo_ics;
      $isJPG = strrpos($nombre,".jpg");
      if(!($isJPG)) {
        $fpdi->Image(isset($configuration) ? ($configuration->logo_ics == '') ? asset('/dist/images/logoazul.jpg') : $configuration->logo_ics : asset('/dist/images/logoazul.jpg'),10,15,30,0,'PNG');
      }
      if($isJPG) {
        $fpdi->Image(isset($configuration) ? ($configuration->logo_ics == '') ? asset('/dist/images/logoazul.jpg') : $configuration->logo_ics : asset('/dist/images/logoazul.jpg'),10,15,30,0,'JPG');
      }

      $fpdi->SetFont('Arial','B',14);
      $fpdi->SetTextColor(59, 59, 59);
      $fpdi->SetXY(40, 15);
      $fpdi->MultiCell(85, 3, isset($configuration->name_company) ? $configuration->name_company: 'International Cargo System');

      $fpdi->SetFont('Arial','',12);
      $fpdi->SetTextColor(59, 59, 59);
      $fpdi->SetXY(40, 20);
      $fpdi->MultiCell(85, 3, isset($configuration->dni_company) ? $configuration->dni_company: 'DNI:1234567890');

      $fpdi->SetFont('Arial','',12);
      $fpdi->SetTextColor(83, 83, 83);
      $fpdi->SetXY(40, 25);
      $fpdi->MultiCell(85, 3, isset($configuration->email_company) ? $configuration->email_company: 'www.internationalcargosystem.com');


      $fpdi->SetFont('Arial','',8);
      $fpdi->SetTextColor(0, 0, 0);

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(170, 41-7);
      $fpdi->MultiCell(85, 3, $package->code);

      $label = isset($package->getCategory) ? $package->getCategory->label : '';
      $fpdi->SetXY(170, 45-7);
      if(strlen($label)>15){
        $fpdi->SetXY(170, 44-7);
      }
      $fpdi->MultiCell(30, 3, $package->getCategory != '' ? strtoupper($package->getCategory->label) : trans('messages.unknown'));

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(170, 50-7);
      $fpdi->MultiCell(85, 3,$package->getType != '' ? utf8_decode(strtoupper($package->getType->spanish)) : trans('messages.unknown') );

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(170, 54-7);
      $fpdi->MultiCell(85, 3,$package->created_at );

      //Estatus
      $fpdi->SetXY(170, 58-7);
      $fpdi->MultiCell(85, 3,$package->last_event);

      //OFICINA
      $fpdi->SetXY(170, 63-7);
      $fpdi->MultiCell(85, 3,$package->getOffice['name'] != '' ? strtoupper($package->getOffice['name']) : trans('messages.unknown'));


      $fpdi->SetFont('Arial','',8);
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(115,70-3);
      $fpdi->MultiCell(95, 3, 'NAME:');

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(140, 70-3);
      $fpdi->MultiCell(95, 3, isset($package) ? (isset($package->to_client) ?strtoupper($package->getToClient['name']) : strtoupper($package->getToUser['name'])." ".strtoupper($package->getToUser['last_name'])) : '');


            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(115, 74-3);
            $fpdi->MultiCell(85, 3, 'DNI:');

            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(140, 74-3);
            $fpdi->MultiCell(85, 3,isset($package) ? (isset($package->to_client) ?strtoupper($package->getToClient['dni']) : strtoupper($package->getToUser['dni'])) : '');

            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(115, 77-3);
            $fpdi->MultiCell(85, 3, 'ADRESS:');

            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(140, 77-3);
            $fpdi->MultiCell(85, 3,isset($package) ? (isset($package->to_client) ?strtoupper($package->getToClient['postal_code']) : strtoupper($package->getToUser['postal_code'].' '.$package->getToUser['region'])) : '');

            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(115, 80-3);
            $fpdi->MultiCell(85, 3, 'COUNTRY:');

            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(140, 80-3);
            $fpdi->MultiCell(85, 3,isset($package) ? (isset($package->to_client) ?strtoupper($package->getToClient['country']) : strtoupper($package->getToUser['country'])) : '');

            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(115, 84-3);
            $fpdi->MultiCell(85, 3, 'PHONE:');

            //TIPO DE TRANSPORTE
            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(140, 81);
            $fpdi->MultiCell(85, 3,isset($package) ? (isset($package->to_client) ?strtoupper($package->getToClient['celular']) : strtoupper($package->getToUser['celular'])) : '');

            if(isset($package->to_client)){
              $fpdi->SetTextColor(0, 0, 0);
              $fpdi->SetXY(25, 75);
              $fpdi->MultiCell(85, 3, $package->getToClient->code." ".strtoupper($package->getToClient->name));

            }elseif (isset($package->to_user)) {
              $fpdi->SetTextColor(0, 0, 0);
              $fpdi->SetXY(30, 75);
              $fpdi->MultiCell(85, 3, $package->getToUser->code." ".strtoupper($package->getToUser->name)." ".strtoupper($package->getToUser->last_name));
            }

          //CARGOS APLICABLES
          foreach($aplicate_charges as $key => $value){
            if($value->type_attribute == "IN"){
              $fpdi->SetXY(130, 100);
              $fpdi->MultiCell(85, 3, "IMPUESTOS");
              $fpdi->SetXY(170, 100);
              $fpdi->MultiCell(15, 3, number_format($value->value_oring,2,',','.')." $", 0, 'R');
            }

            if($value->type_attribute == "S"){
              $fpdi->SetXY(130, 103);
              $fpdi->MultiCell(85, 3, "SEGURO");
              $fpdi->SetXY(170, 103);
              $fpdi->MultiCell(15, 3, number_format($value->value_oring,2,',','.')." $", 0, 'R');
            }
            if($value->type_attribute == "T"){
              $fpdi->SetXY(130, 106);
              $fpdi->MultiCell(85, 3, "TRANSPORTE");
              $fpdi->SetXY(170, 106);
              $fpdi->MultiCell(15, 3, number_format($value->value_oring,2,',','.')." $", 0, 'R');
            }
            if($value->type_attribute == "A"){
              $fpdi->SetXY(130, 109);
              $fpdi->MultiCell(85, 3, "CARGOS ADICIONALES");
              $fpdi->SetXY(170, 109);
              $fpdi->MultiCell(15, 3, number_format($value->value_oring,2,',','.')." $", 0, 'R');
            }
            if($value->type_attribute == "P"){
              $fpdi->SetXY(130, 112);
              $fpdi->MultiCell(85, 3, "PROMOCION");
              $fpdi->SetXY(170, 112);
              $fpdi->MultiCell(15, 3, number_format($value->value_oring,2,',','.')." $", 0, 'R');
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
          $h = 130;
          foreach ($detailspackage as $row){
            $fpdi->SetXY(25, $h);
            $fpdi->MultiCell(15, 3, $row->pieces,0,'C');

            $fpdi->SetXY(58, $h);
            $fpdi->MultiCell(30, 3, $row->large.'x'.$row->width.'x'.$row->height,0,'C');

            $fpdi->SetXY(100, $h);
            $fpdi->MultiCell(36, 3, strtoupper($row->description),0,'J');

            $fpdi->SetXY(135, $h);
            $fpdi->MultiCell(30, 3, $row->weight.'Lb',0,'C');

            $fpdi->SetXY(160, $h);
            $fpdi->MultiCell(30, 3, $row->volumetricweight.$unidad,0,'C');
            //$h += 5;
          }
          //NOTA
          $fpdi->SetXY(65, 220);
          $fpdi->MultiCell(80, 3, $package->observation,0,'C');

          //PIEZAS
          $fpdi->SetXY(110, 237);
          $fpdi->MultiCell(15, 3, $resultpackpieces,0,'R');

          //PESO
          $fpdi->SetXY(140, 237);
          $fpdi->MultiCell(30, 3, $resultpackweight.' Lb',0,'C');

          //VOLUMEN
            $fpdi->SetXY(170, 237);
            $fpdi->MultiCell(30, 3, $row->volumetricweight.$unidad,0,'C');

          //FOOTER
          $fpdi->SetXY(15, 250);
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
      $vars = [
        'package'      => $package,
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
    /**
    *Master Bill Of Lading
    */
    public function masterbill (Request $request, $id){
      $session       = $request->session()->get('key-sesion');
      $shipment      = Shipment::find($id);
      $shipmentroute = ShipmentRoute::query()->where('shipment','=',$id)->first();
      $shipmentdetail = ShipmentDetail::query()->where('shipment','=',$id)->first();
      $package = null;
      if(!($shipmentdetail==null)){
          $package = Package::find($shipmentdetail->warehouse);
      }
      $detailspackage = null;
      $courier = null;
      $category = null;
      if(!($package==null)){
        $detailspackage = Detailspackage::find($package->id);
        $courier        = Courier::find($package->from_courier);
        $category = Category::find($package->type);
      }
      $configuration = Configuration::find(1);
      $consigner     = User::find($shipment->consigner);
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

      $pageCount = $fpdi->setSourceFile('tmpreport/MBL.pdf');
      $tplIdx    = $fpdi->importPage(1, '/BleedBox');
      $fpdi->SetTitle('Master Bill Of Lading');

      $fpdi->addPage();
      $fpdi->useTemplate($tplIdx, 10, 10, 190);

      $nombre = $configuration->logo_ics;
      $isJPG = strrpos($nombre,".jpg");
      if(!($isJPG)) {
        $fpdi->Image(isset($configuration) ? ($configuration->logo_ics == '') ? asset('/dist/images/logoazul.jpg') : $configuration->logo_ics : asset('/dist/images/logoazul.jpg'),10,15,30,0,'PNG');
      }
      if($isJPG) {
        $fpdi->Image(isset($configuration) ? ($configuration->logo_ics == '') ? asset('/dist/images/logoazul.jpg') : $configuration->logo_ics : asset('/dist/images/logoazul.jpg'),10,15,30,0,'JPG');
      }

      $fpdi->SetFont('Arial','B',14);
      $fpdi->SetTextColor(59, 59, 59);
      $fpdi->SetXY(40, 15);
      $fpdi->MultiCell(85, 3, isset($configuration->name_company) ? $configuration->name_company: 'International Cargo System');

      $fpdi->SetFont('Arial','',12);
      $fpdi->SetTextColor(59, 59, 59);
      $fpdi->SetXY(40, 20);
      $fpdi->MultiCell(85, 3, isset($configuration->dni_company) ? $configuration->dni_company: 'DNI:1234567890');

      $fpdi->SetFont('Arial','',12);
      $fpdi->SetTextColor(83, 83, 83);
      $fpdi->SetXY(40, 25);
      $fpdi->MultiCell(85, 3, isset($configuration->email_company) ? $configuration->email_company: 'www.internationalcargosystem.com');

      $fpdi->SetFont('Arial','',9);
      $fpdi->SetTextColor(0, 0, 0);

      //EXPORTADOR
      $fpdi->SetXY(30, 55);
      $fpdi->MultiCell(85, 3, $shipment->code);

      //NRO DOCUMENTO
      $fpdi->SetXY(115, 54);
      $fpdi->MultiCell(85, 3, $shipment->number_reservation);

      //B/L NUMERO
      $fpdi->SetXY(160, 54);
      $fpdi->MultiCell(85, 3, $shipment->number_guide);

      //REFERENCIA DE EXPORTACION
      $fpdi->SetXY(128, 65);
      $fpdi->MultiCell(45, 3, isset($courier) ? $courier->code.' '.strtoupper($courier->name) : '',0,'C');

      //CONSIGNADO A
      $fpdi->SetFont('Arial','',8);

      $fpdi->SetXY(30, 90-10);
      $fpdi->MultiCell(85, 3, isset($consigner) ? 'NOMBRE: '.strtoupper($consigner->name.' '.$consigner->last_name): '');
      $fpdi->SetXY(30, 94-10);
      $fpdi->MultiCell(85, 3,  isset($consigner) ? 'DNI: '.$consigner->dni : '');
      $fpdi->SetXY(30, 100-10);
      $fpdi->MultiCell(30, 3, 'ADDRESS:');
      $fpdi->SetXY(50, 99-10);
      $fpdi->MultiCell(40, 4,  isset($consigner) ? strtoupper($consigner->postal_code.' '.$consigner->city.' '.$consigner->region.' '.$consigner->country) : '');

      //AGENTE DE CARGA
      $fpdi->SetXY(135, 83);
      $fpdi->MultiCell(85, 3, 'ADMINISTRADOR');

      //NUMERO FTZ
      $fpdi->SetXY(105, 98);
      $fpdi->MultiCell(85, 3, strtoupper($shipmentroute->origin_point),0,'C');

      //NOTIFICAR A INTERMEDIARIO
      $fpdi->SetXY(30, 110);
      $fpdi->MultiCell(80, 3,  isset($consigner) ? 'NOMBRE:'.strtoupper($toNotify->name.' '.$toNotify->last_name) : '');

      $fpdi->SetXY(30, 115);
      $fpdi->MultiCell(85, 3,  isset($toNotify) ? 'TELEFONO: '.strtoupper($toNotify->celular) : '');


      //INSTRUCCIONES INTERNAS
      $fpdi->SetXY(123, 115);
      $fpdi->MultiCell(50, 3, strtoupper($shipment->description),0,'C');

      //PRETRANSPORTADO POR
      $fpdi->SetXY(30, 132);
      $fpdi->MultiCell(85, 3,  isset($trasportista) ? $transportista->code : '');

      //LUGAR DE RECEPCION
      $fpdi->SetXY(70, 132);
      $fpdi->MultiCell(85, 3,  isset($trasportista) ? strtoupper($transportista->billing_address_country.' '.$transportista->billing_address_state) :  '');

      //TRANSPORTISTA EXPORTADOR
      $fpdi->SetXY(10, 144);
      $fpdi->MultiCell(50, 3, isset($trasportista) ? strtoupper($transportista->name.' '.$transportista->last_name) : '',0,'C');

      //PUNTO DE CARGA/EXPORTACION
      $fpdi->SetXY(70, 144);
      $fpdi->MultiCell(85, 3, isset($trasportista) ? $transportista->billing_address_port : '');

      //MUELLE DE CARGA/TERMINAL
      $fpdi->SetXY(140, 144);
      $fpdi->MultiCell(85, 3, $shipment->dock_terminal);

      //PUERTO EXTRANJERO DE DESCARGA
      $fpdi->SetXY(30, 157);
      $fpdi->MultiCell(85, 3, isset($detailsTransport) ? $detailsTransport->name : '');

      //LUGAR DE ENTREGA POR EL TRANSPORTISTA
      $fpdi->SetXY(70, 157);
      $fpdi->MultiCell(85, 3, isset($detailsTransport) ? $detailsTransport->name : '');

      //TIPO DE CARGA
      $fpdi->SetXY(83, 157);
      $fpdi->MultiCell(50, 3, isset($category) ? $category->label : 'dsfd',0,'R');

      //CONTENERIZADO
      $fpdi->SetXY(125, 157);
      $fpdi->MultiCell(50, 3, $shipment->name,0,'R');

      //dd($package);

      //MARCAS Y NUMERO
      $fpdi->SetXY(20, 170);
      $fpdi->MultiCell(25, 3, isset($package) ? $package->tracking : '',0,'R');

      //NUMERO DE PAQUETE
      $fpdi->SetXY(63, 170);
      $fpdi->MultiCell(30, 3, isset($package) ? $package->code : '',0,'R');

      //DESCRIPCION DEL PRODUCTO
      $fpdi->SetXY(100, 170);
      $fpdi->MultiCell(50, 3, isset($package) ? $shipment->description : '',0,'C');

      //PESO
      $fpdi->SetXY(115, 170);
      $fpdi->MultiCell(50, 3, isset($shipmentdetail->weight) ? $shipmentdetail->weight : '0,00',0,'R');

      //DIMENSIONES
      //dd($detailspackage);
      $fpdi->SetXY(160, 170);
      $fpdi->MultiCell(50, 3, isset($detailspackage) ? $detailspackage->large.'x'.$detailspackage->height.'x'.$detailspackage->width : '',0,'C');



      /*$fpdi->SetXY(20, 50);
      $fpdi->MultiCell(85, 3, $shipment->name);

      $fpdi->SetXY(20, 70);
      $fpdi->MultiCell(85, 3, $shipment->name);

      $fpdi->SetXY(110, 24);
      $fpdi->MultiCell(85, 3, $shipment->name);


      $fpdi->SetXY(20, 90);
      $fpdi->MultiCell(85, 3, $shipment->getTransporter['name']);

      $fpdi->SetXY(20, 106);
      $fpdi->MultiCell(85, 3, $shipmentroute->getDetailsPort['name']);

      $fpdi->SetXY(70, 98);
      $fpdi->MultiCell(85, 3, $shipmentroute->getDetailsPort['name']);

      $fpdi->SetXY(110, 32);
      $fpdi->MultiCell(85, 3, $shipmentroute->getDetailsPort['name']);

      $fpdi->SetXY(110, 48);
      $fpdi->MultiCell(85, 3, $shipment->name);

      $fpdi->SetXY(110, 61);
      $fpdi->MultiCell(85, 3, $shipmentroute->getDetailsPort['name']);

      $fpdi->SetXY(110, 105);
      $fpdi->MultiCell(85, 3, $shipmentroute->getVessel['name']);

      $fpdi->SetXY(70, 105);
      $fpdi->MultiCell(85, 3, $shipmentroute->getCity['name']);


      $fpdi->SetXY(169, 106);
      $fpdi->MultiCell(85, 3, "X");
*/
     /* $fpdi->SetXY(20, 90);
      $fpdi->MultiCell(85, 3, $billoflading->precarri);

      $fpdi->SetXY(70, 90);
      $fpdi->MultiCell(85, 3, $billoflading->place);

      $fpdi->SetXY(20, 98);
      $fpdi->MultiCell(85, 3, $billoflading->exporting);

      $fpdi->SetXY(70, 98);
      $fpdi->MultiCell(85, 3, $billoflading->port);

      $fpdi->SetXY(20, 105);
      $fpdi->MultiCell(85, 3, $billoflading->foreing);

      $fpdi->SetXY(70, 105);
      $fpdi->MultiCell(85, 3, $billoflading->placedeli);

      //Segunda Columna
      $fpdi->SetXY(109, 24);
      $fpdi->MultiCell(85, 3, $billoflading->document);

      $fpdi->SetXY(153, 24);
      $fpdi->MultiCell(85, 3, $pickup->code);

      $fpdi->SetXY(109, 32);
      $fpdi->MultiCell(85, 3, $billoflading->exportreference);

      $fpdi->SetXY(109, 47);
      $fpdi->MultiCell(85, 3, $billoflading->forwarding);

      $fpdi->SetXY(109, 61);
      $fpdi->MultiCell(85, 3, $billoflading->point);

      $fpdi->SetXY(109, 69);
      $fpdi->MultiCell(85, 3, $billoflading->purchaseorder);

      $fpdi->SetXY(109, 98);
      $fpdi->MultiCell(85, 3, $billoflading->loadingpier);

      $fpdi->SetXY(109, 105);
      $fpdi->MultiCell(85, 3, $billoflading->typemovie);

      $fpdi->SetXY(168, 106);
      $fpdi->MultiCell(85, 3, "X");

      $height=120;
      foreach ($detailspikcup as $details)
        {


          $fpdi->SetXY(25, $height);
          $fpdi->MultiCell(85, 3, $pickup->code);

          $fpdi->SetXY(70, $height);
          $fpdi->MultiCell(85, 3, $details->description);

          $fpdi->SetXY(153, $height);
          $fpdi->MultiCell(85, 3, $details->weight." lbl");

          $fpdi->SetXY(175, $height);
          $fpdi->MultiCell(85, 3, $details->volumetricweight." Vlb");

          $height=$height+5;


        }

      $fpdi->SetXY(15, 180);
      $fpdi->MultiCell(85, 3, "TOTAL OF PIECES");

      $fpdi->SetXY(58, 180);
      $fpdi->MultiCell(85, 3, $countdetails);


      $fpdi->SetXY(153, 180);
      $fpdi->MultiCell(85, 3, $resultpackweight." lbl");


      $fpdi->SetXY(175, 180);
      $fpdi->MultiCell(85, 3, $resultpackvol." Vbl");

      $fpdi->SetXY(178, 245);
      $fpdi->MultiCell(85, 3, $pickup->code);

      $formato = 'Y-m-d H:i:s';
      $fecha = DateTime::createFromFormat($formato, $billoflading->created_at);

      $fpdi->SetXY(178, 232);
      $fpdi->MultiCell(85, 3, $fecha->format('Y'));

      $fpdi->SetXY(120, 232);
      $fpdi->MultiCell(85, 3, $fecha->format('M'));

      $fpdi->SetXY(150, 232);
      $fpdi->MultiCell(85, 3, $fecha->format('d'));

      $fpdi->SetFont('Arial','',13);
      $fpdi->SetTextColor(173, 173, 173);
      $fpdi->SetXY(90, 182);
      $fpdi->MultiCell(85, 3, "ORIGINAL");

      $fpdi->SetFont('Arial','',12);
      $fpdi->SetXY(140, 232);
      $fpdi->MultiCell(85, 3, strftime( "%Y-%m-%d", time()));*/

      $fpdi->SetFont('Arial','',10);
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(15, 250);
      $fpdi->MultiCell(180, 3, isset($configuration->footer_receipt) ? $configuration->footer_receipt : '');

      $fpdi->Output();


    }

    public function cargomanifest (Request $request, $id){
      $session         = $request->session()->get('key-sesion');
      $cargoRelease    = CargoRelease::find($id);
      $shipment        = Shipment::find($id);

      $shipmentroute   = ShipmentRoute::byShipment($id)->first();
      $shipmentdetail  = ShipmentDetail::query()->where('shipment','=',$id)->first();
      $package = null;
      if($shipmentdetail!=null){
          $package = Package::query()->where('id','=',$shipmentdetail->warehouse)->first();
      }
      $category = null;
      if($package != null){
          $category = Category::find($package->type);
      }
      $transportista = Transporters::find($shipment->transporter);
      $detailsTransport = DetailsTransport::find($shipmentroute->download_port);
      $agent           = Operator::find($shipment->operator);
      $consigner       = User::find($shipment->consigner);
      $shipper         = User::find($shipment->shipper);
      $port            = DetailsTransport::find($shipmentroute->port);
      $port2           = DetailsTransport::find($shipmentroute->download_port);
      $configuration = Configuration::find(1);

      //dd($package);
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
      $fpdi->useTemplate($tplIdx, 0, 5, 210);

      $nombre = $configuration->logo_ics;
      $isJPG = strrpos($nombre,".jpg");
      if(!($isJPG)) {
        $fpdi->Image(isset($configuration) ? ($configuration->logo_ics == '') ? asset('/dist/images/logoazul.jpg') : $configuration->logo_ics : asset('/dist/images/logoazul.jpg'),10,10,30,0,'PNG');
      }
      if($isJPG) {
        $fpdi->Image(isset($configuration) ? ($configuration->logo_ics == '') ? asset('/dist/images/logoazul.jpg') : $configuration->logo_ics : asset('/dist/images/logoazul.jpg'),10,10,30,0,'JPG');
      }

      $fpdi->SetFont('Arial','B',14);
      $fpdi->SetTextColor(59, 59, 59);
      $fpdi->SetXY(45, 10);
      $fpdi->MultiCell(85, 3, isset($configuration->name_company) ? $configuration->name_company: 'International Cargo System');

      $fpdi->SetFont('Arial','',12);
      $fpdi->SetTextColor(59, 59, 59);
      $fpdi->SetXY(45, 15);
      $fpdi->MultiCell(85, 3, isset($configuration->dni_company) ? $configuration->dni_company: 'DNI:1234567890');

      $fpdi->SetFont('Arial','',12);
      $fpdi->SetTextColor(83, 83, 83);
      $fpdi->SetXY(45, 20);
      $fpdi->MultiCell(85, 3, isset($configuration->email_company) ? $configuration->email_company: 'www.internationalcargosystem.com');

      $fpdi->SetFont('Arial','',9);
      $fpdi->SetTextColor(0, 0, 0);

      //CODIGO DE ENTREGA
      $fpdi->SetXY(172, 46-15);
      $fpdi->MultiCell(85, 3, $cargoRelease->code);

      //FECHA DE ENTREGA
      $fpdi->SetXY(172, 51-15);
      $fpdi->MultiCell(85, 3, $cargoRelease->release_date);

      //ENTREGADO
      $fpdi->SetXY(172, 56-15);
      $fpdi->MultiCell(85, 3, $cargoRelease->created_at);

      //CONTENEDOR
      $fpdi->SetXY(38, 53);
      $fpdi->MultiCell(30, 3, isset($package) ? $package->code : '',0,'C');

      //NUMERO DE RESERVACION
      $fpdi->SetXY(143, 53);
      $fpdi->MultiCell(30, 3, $shipment->number_reservation,0,'C');

      //NOMBRE Y DIRECCION DEL AGENTE
      $fpdi->SetXY(0, 70);
      $fpdi->MultiCell(50, 3, strtoupper($agent->name." ".$agent->last_name),0,'C');
      $fpdi->SetXY(13, 110);
      $fpdi->MultiCell(50, 3, strtoupper($agent->country." ".$agent->state),0,'C');

      //NOMBRE Y DIRECCION DEL TRANSPORTISTA
      $fpdi->SetXY(45, 70);
      $fpdi->MultiCell(50, 3, isset($trasportista) ? strtoupper($transportista->name." ".$transportista->last_name) : '',0,'C');
      $fpdi->SetXY(55, 110);
      $fpdi->MultiCell(50, 3,  isset($trasportista) ? strtoupper($transportista->country." ".$transportista->state) : '',0,'C');

      //NUMERO DE GUIA
      $fpdi->SetXY(105, 70);
      $fpdi->MultiCell(30, 3, $shipment->number_guide,0,'C');

      //FECHA
      $fpdi->SetXY(145, 70);
      $fpdi->MultiCell(30, 3, $shipment->realizate_city_date,0,'C');

      //ORIGEN
      $fpdi->SetXY(175, 70);
      $fpdi->MultiCell(30, 3, $shipment->realizate_city_place,0,'C');

      //NUEMRO DE VUELO, VIAJE y BUQUE
      $fpdi->SetXY(112, 90);
      $fpdi->MultiCell(30, 3, $shipmentroute->travel_identifier,0,'C');


      //FECHA DE PARTIDA
      $fpdi->SetXY(145, 90);
      $fpdi->MultiCell(30, 3, $shipment->departure_date_mar,0,'C');
      //DESTINO
      $fpdi->SetXY(175, 90);
      $fpdi->MultiCell(30, 3, isset($port2->name)?$port2->name:'',0,'C');

      $height = 115;
            //WAREHOUSES
            $fpdi->SetXY(8, $height+2);
            $fpdi->MultiCell(85, 3, isset($package) ? $package->code : '');

            //SHIPPER
            $fpdi->SetXY(33, $height);
            $fpdi->MultiCell(30, 3, isset($shipper)?$shipper->name." ".$shipper->last_name : '',0,'C');
            //CONSIGNEE
            $fpdi->SetXY(70, $height);
            $fpdi->MultiCell(30, 3, isset($consigner)?$consigner->name." ".$consigner->last_name : '',0,'C');
            $fpdi->SetFont('Arial','',8);
            $detailpackages = null;
            if ($package != null) {
              $detailpackages = Detailspackage::query()->where('package','=',$package->id)->get();
              foreach ($detailpackages as $key => $detailpackage) {
                if ($detailpackage != null) {
                    //PIECES
                    $fpdi->SetXY(86, $height+2);
                    $fpdi->MultiCell(30, 3, $detailpackage->pieces,0,'R');
                    //WEIGHT
                    $fpdi->SetXY(95+5, $height+2);
                    $fpdi->MultiCell(30, 3, number_format($detailpackage->weight,2,',','.'),0,'R');
                    //VOLUME
                    $fpdi->SetXY(102+5, $height+2);
                    $fpdi->MultiCell(40, 3, number_format($detailpackage->volumetricweightm,2,',','.').' ft3',0,'R');
                    //DESCRIPTION
                    $fpdi->SetXY(125, $height+2);
                    $fpdi->MultiCell(85, 3, isset($category->label) ? $category->label : ''  ,0,'C');
                }
                $height += 5;
                //ADUANA
                $fpdi->SetXY(180, $height-3);
                $fpdi->MultiCell(30, 3, isset($shipment->for_aduana)?$shipment->for_aduana : 'NO INFO',0,'C');
              }
            }
            $fpdi->SetFont('Arial','',9);



            //TOTAL
            $fpdi->SetFont('Arial','',11);
            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(170, 256);
            $fpdi->MultiCell(30, 3, number_format($shipment->declarate_value,2,',','.').' $',0,'C');

            //FOOTER
            $fpdi->SetFont('Arial','',10);
            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(15, 270);
            $fpdi->MultiCell(180, 3, isset($configuration->footer_receipt) ? $configuration->footer_receipt : '');

      /*

      //Bond Number
      $fpdi->SetXY(160, 41);
      $fpdi->MultiCell(85, 3, $shipment->number_reservation);

      //Ship
      $fpdi->SetXY(20, 65);
      $fpdi->MultiCell(85, 3, $shipment->code." ".$shipment->name);

      //Name of Master or Person in Charge
      $fpdi->SetXY(110, 65);
      $fpdi->MultiCell(85, 3, $agent->name." ".$agent->last_name);

      // Name and Address of Owner
      $fpdi->SetXY(20, 78);
      $fpdi->MultiCell(85, 3, $consigner->name." ".$consigner->last_name." ".$consigner->address);

      if($port){
        //Origin
        $fpdi->SetXY(105, 78);
        $fpdi->MultiCell(85, 3, $port->name);
      }

      if($port2){
        //Date
        $fpdi->SetXY(20, 88);
        $fpdi->MultiCell(85, 3, $shipment->arrived_date_mar);
      }

      //Destination
      $fpdi->SetXY(155, 78);
      $fpdi->MultiCell(85, 3, isset($port2->name) ? $port2->name:'');

      //Departure Date
      $fpdi->SetXY(105, 88);
      $fpdi->MultiCell(85, 3, $shipment->departure_date_mar);

      $height = 100;
      $i = 0;
    foreach ($packages as $package)
        {
          //WAREHOUSES
          $fpdi->SetXY(15, $height+2);
          $fpdi->MultiCell(85, 3, $package->code);

          //SHIPPER
          $fpdi->SetXY(35, $height);
          $fpdi->MultiCell(85, 3, $shipper->name." ".$shipper->last_name);
          $fpdi->SetXY(35, $height+3);
          $fpdi->MultiCell(85, 3,$shipper->region.", ".$shipper->country);
          $fpdi->SetXY(35, $height+6);
          $fpdi->MultiCell(85, 3,$shipper->city.", ".$shipper->postal_code);
          //CONSIGNEE
          $fpdi->SetXY(75, $height);
          $fpdi->MultiCell(85, 3, $consigner->name." ".$consigner->last_name);
          $fpdi->SetXY(75, $height+3);
          $fpdi->MultiCell(85, 3,$consigner->region.", ".$consigner->country);
          $fpdi->SetXY(75, $height+6);
          $fpdi->MultiCell(85, 3,$consigner->city.", ".$consigner->postal_code);

          $detailpackage = Detailspackage::query()->where('id','=',$packages[$i]->id)->get();
          //dd($detailpackage[$i]);
          //PIECES
          $fpdi->SetXY(122, $height+2);
          $fpdi->MultiCell(85, 3, $detailpackage[0]->pieces);
          //WEIGHT
          $fpdi->SetXY(138, $height+2);
          $fpdi->MultiCell(85, 3, $detailpackage[0]->weight);
          //VOLUME
          $fpdi->SetXY(151, $height+2);
          $fpdi->MultiCell(85, 3, $detailpackage[0]->volumetricweightm);
          //DESCRIPTION
          $fpdi->SetXY(165, $height+2);
          $fpdi->MultiCell(85, 3, $detailpackage[0]->description);

          $height += 13;
          $i +=1;
        }

      $fpdi->SetFont('Arial','',13);
      $fpdi->SetXY(47, 234);
      $fpdi->MultiCell(85, 3, strftime( "%Y-%m-%d", time()));*/

      $fpdi->Output();


    }

    public function loadingguide (Request $request, $id){
      $session       = $request->session()->get('key-sesion');
      $shipment      = Shipment::find($id);
      $vars =
      [
        'shipment'    => $shipment


      ];



      $fpdi = new \fpdi\FPDI();
      $fpdf = new \fpdf\FPDF();

      $pageCount = $fpdi->setSourceFile('tmpreport/billof.pdf');
      $tplIdx    = $fpdi->importPage(1, '/BleedBox');
      $fpdi->SetTitle('Bill Of Lading');

      $fpdi->addPage();
      $fpdi->useTemplate($tplIdx, 10, 10, 190);

      $fpdi->Image(asset('/dist/images/logoazul.jpg'),10,4,30,0,'JPG');

      $fpdi->SetFont('Arial','',16);
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(119, 16);
      $fpdi->MultiCell(85, 3, 'MASTER');

      $fpdi->Output();


    }


      public function invoicepackage(Request $request, $id){
      $session       = $request->session()->get('key-sesion');
      $package       = Package::find($id);

      $receipt       = Receipt::query()->where('package','=',$id)->first();

      $configuration = Configuration::find(1);

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
      if(!($isJPG)) {
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

      $fpdi->SetFont('Arial','',10);
      $fpdi->SetTextColor(0, 0, 0);

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(160, 35-8.5);
      $fpdi->MultiCell(85, 3, isset($package) ? $package->code : '');

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(160, 45-8.5);
      $fpdi->MultiCell(85, 3, isset($package->getToUser->postal_code)?$package->getToUser->postal_code:'');

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(160, 40-8.5);
      $fpdi->MultiCell(85, 3,isset($package) ? $package->created_at->format('d-M-Y H:i:s'): '');

      $estados = Event::all();
      $stat = ($estados[($package->last_event)-1]);
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(160, 50-9.5);
      $fpdi->MultiCell(85, 3,isset($stat) ? $stat->name : '');

      //***********************************************************************
      $fpdi->SetFont('Arial','',10);
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(115, 70);
      $fpdi->MultiCell(95, 3, 'Consignee:');

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(150, 70);
      $fpdi->MultiCell(95, 3, isset($package) ? (isset($package->to_client) ?$package->getToClient['name'] : $package->getToUser['name']." ".$package->getToUser['last_name']) : '');


      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(115, 75);
      $fpdi->MultiCell(85, 3, 'Dimensions:');

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(150, 75);
      $fpdi->MultiCell(85, 3,isset($package) ? $resultwidth."x".$resultheight."x".$resultlarge: '');

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(115, 80);
      $fpdi->MultiCell(85, 3, 'Weight:');

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(150, 80);
      $fpdi->MultiCell(25, 3,isset($package) ?number_format($resultwieght,2,',','.')." Lb" : '');

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(115, 85);
      $fpdi->MultiCell(85, 3, 'Transport:');

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(150, 85);
      $fpdi->MultiCell(85, 3,isset($package) ?utf8_decode($package->getType['spanish']): '');


      //Detalle del usuario
      if(isset($package->to_client)){
        $fpdi->SetTextColor(0, 0, 0);
        $fpdi->SetXY(16, 65);
        $fpdi->MultiCell(85, 3, $package->getToClient->code." ".$package->getToClient->name);

      }elseif (isset($package->to_user)) {

        $fpdi->SetFont('Arial','',10);
        $fpdi->SetTextColor(0, 0, 0);
        $fpdi->SetXY(20, 70);
        $fpdi->MultiCell(95, 3, 'NAME:');

        $fpdi->SetTextColor(0, 0, 0);
        $fpdi->SetXY(40, 70);
        $fpdi->MultiCell(85, 3, $package->getToUser->code." ".$package->getToUser->name." ".$package->getToUser->last_name);

        $fpdi->SetFont('Arial','',10);
        $fpdi->SetTextColor(0, 0, 0);
        $fpdi->SetXY(20, 75);
        $fpdi->MultiCell(95, 3, 'DNI:');

        $fpdi->SetTextColor(0, 0, 0);
        $fpdi->SetXY(40, 75);
        $fpdi->MultiCell(85, 3, $package->getToUser->dni);

        $fpdi->SetFont('Arial','',10);
        $fpdi->SetTextColor(0, 0, 0);
        $fpdi->SetXY(20, 80);
        $fpdi->MultiCell(95, 3, 'PHONE:');

        $fpdi->SetTextColor(0, 0, 0);
        $fpdi->SetXY(40, 80);
        $fpdi->MultiCell(85, 3, $package->getToUser->celular);

        $fpdi->SetFont('Arial','',10);
        $fpdi->SetTextColor(0, 0, 0);
        $fpdi->SetXY(20, 85);
        $fpdi->MultiCell(95, 3, 'EMAIL:');

        $fpdi->SetTextColor(0, 0, 0);
        $fpdi->SetXY(40, 85);
        $fpdi->MultiCell(85, 3, $package->getToUser->email);
      }

      //Datos de Facturacion
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(17, 145-20);
      $fpdi->MultiCell(85, 3, isset($transporty) ? utf8_decode($package->getType['spanish'])."-".$transporty->name: '');

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(68, 145-20);
      $fpdi->MultiCell(25, 3, isset($resultpackvol) ? number_format($resultpackvol,2,',','.').$unidad: '', 0, 'R');

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(115, 145-20);
      $fpdi->MultiCell(25, 3, isset($detailreceiptty) ? number_format($detailreceiptty->value_oring,2,',','.')." $": '', 0, 'R');

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(168, 145-20);
      $fpdi->MultiCell(25, 3, isset($detailreceiptty) ? number_format($detailreceiptty->value_oring*$resultpackvol,2,',','.')." $": '', 0, 'R');

      // Cargos Adicionales
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(17, 150-20);
      $fpdi->MultiCell(25, 3, isset($detailadd->name) ? $detailadd->name : '');

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(68, 150-20);
      $fpdi->MultiCell(25, 3, isset($detailreceiptadd) ? '1': '', 0, 'R');

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(115, 150-20);
      $fpdi->MultiCell(25, 3, isset($detailreceiptadd) ? number_format($detailreceiptadd->value_oring,2,',','.')." $": '', 0, 'R');

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(168, 150-20);
      $fpdi->MultiCell(25, 3, isset($detailreceiptadd) ? number_format($detailreceiptadd->value_package,2,',','.')." $": '', 0, 'R');

      // Seguro
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(17, 155-20);
      $fpdi->MultiCell(85, 3, isset($detailreceiptinsu) ? 'Seguro': '');

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(68, 155-20);
      $fpdi->MultiCell(25, 3, isset($detailreceiptinsu) ? '1': '', 0, 'R');


      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(115, 155-20);
      $fpdi->MultiCell(25, 3, isset($detailreceiptinsu) ? number_format($detailreceiptinsu->value_package,2,',','.')." $": '', 0, 'R');

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(168, 155-20);
      $fpdi->MultiCell(25, 3, isset($detailreceiptinsu) ? number_format($detailreceiptinsu->value_package,2,',','.')." $": '', 0, 'R');

    //  dd($detailreceipt);
      //Detalle de totales
      $fpdi->SetFont('Arial','B',11);
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(167, 221+9);
      $fpdi->MultiCell(25, 3, isset($receipt) ? number_format($receipt->subtotal,2,',','.')." $" : '', 0, 'R');

      $fpdi->SetFont('Arial','B',11);
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(167, 241+8);
      $fpdi->MultiCell(25, 3, isset($receipt) ? number_format($receipt->total,2,',','.')." $" : '', 0, 'R');

      //dd($detailreceipt);
      $fpdi->SetFont('Arial','',10);
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(126, 228+8.8);
      $fpdi->MultiCell(25, 3, isset($detailreceipt) ? $detailreceipt->value_oring."%" : '0%', 0, 'R');

      $fpdi->SetFont('Arial','',11);
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(167, 228+9);
      $fpdi->MultiCell(25, 3, isset($detailreceipt) ? number_format($detailreceipt->value_package,2,',','.')." $" : '0$', 0, 'R');

      $fpdi->SetFont('Arial','',11);
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(162, 235+9);
      $fpdi->MultiCell(30, 3, isset($detailreceiptpro) ? "-".number_format($detailreceiptpro->value_package,2,',','.')." $" : '-0$', 0, 'R');

      $fpdi->SetFont('Arial','',10);
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(20, 265);
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
        if(!($isJPG)) {
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
