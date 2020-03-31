<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Admin\Package;
use App\Models\Admin\Category;
use App\Models\Admin\Log;
use App\Models\Admin\Event;
use App\Models\Admin\Consolidated;
use App\Models\Admin\Receipt;
use App\Models\Admin\DetailsReceipt;
use App\Models\Admin\TransportType;
use App\Models\Admin\Client;
use App\Models\Admin\Company;
use App\Models\Admin\AddCharge;
use PDF;
use App\Models\Admin\Configuration;
use DB;


class ReceiptController extends Controller
{
    public function create(Request $request)
    {
      $this->checkAuthorization();
      $vars = [
        'transports' => Transport::all(),
        'usersType' => UserType::all()
      ];
      if ($this->isGET($request)) {
        return view('pages.admin.promotions.create', $vars);
      }
     /**
      * Guardar Recibo
      */
      $validator = $this->validateData($request);
      if (!is_null($validator)) {
        if ($validator->fails()) {
          return view('pages.admin.promotions.create', $vars)
            ->withErrors($validator)
            ->with('errorMessage', trans('messages.checkRedFields'));
        }
      }
     /**
      * Redirecciona a la ruta enviando en id, luego muestra el mensaje 'success'
      */
      $promotions = Promotion::create($request->all());
      return $this->doRedirect($request, "/admin/promotions/{$promotions->id}")->with('successMessage', trans('promotion.created', [
        'name' => $promotions->name,
        'id' => $promotions->code
      ]));
    }



public function readreceipt(Request $request, $id)
  {
    $package = Package::find($id);
    $packageLog = Log::ByPackage($package->id)->get();
    $event = Event::all();
    $vars = [
      'package'    => $package,
      'packageLog' => $packageLog,
      'date'       => date('Y-m-d')
    ];
    $pdf = PDF::loadView('sections/pdf',$vars);
    $pdf->setPaper('A4', 'auto');
    return $pdf->stream('invoice.pdf');
  }

  public function read(Request $request)
  {
    $session = $request->session()->get('key-sesion');
    $this->checkAuthorization();
    /**
    *  Se valida que la sesion este activa
    */
    if ($session == null)
    {
      return redirect('login');
    }

    $receipt = Receipt::all();
    //dd($receipt);

    $vars = [
      'receipt'    => $receipt

    ];
    return view('pages.admin.package.receipts', $vars);

  }
  /**
  * reporte de paquetes
  */
  public function readreceiptpackage(Request $request)
  {
    $package = Package::all();
    $configuration = Configuration::find(1);
    $detailreceipt=null;
    $detailreceiptpro=null;

    $vars = [
      'package'       => $package,
      'configuration' => $configuration
    ];

    $pdf = PDF::loadView('sections/paquetespdf',$vars);
    $pdf->setPaper('A4', 'auto');
    return $pdf->stream('invoice.pdf');
  }

  public function readreceiptpackageid(Request $request,$id)
  {

    $package       = Package::find($id);


    $companyclient="";
    if(isset($package->to_client)){
    $client          = Client::find($package->to_client);
    $companyclient   = Company::find($client->company);
    }


    $receipt       = Receipt::query()->where('package','=',$id)->first();


    if(isset($receipt)){
    $detailreceipt  = DB::table('detailsreceipt')
                      ->join('tax', 'detailsreceipt.id_complemento', '=', 'tax.id')
                      ->select('detailsreceipt.id', 'tax.name', 'detailsreceipt.value_oring','detailsreceipt.value_package')
                      ->where("detailsreceipt.type_attribute","=",'I')
                      ->where("detailsreceipt.receipt","=",$receipt->id)
                      ->get();


    $detailreceiptpro = DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','P')->first();
    }else{

    }




    /*$detailreceipt = DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','I')->get();*/



    $configuration = Configuration::find(1);


    $vars = [
      'package'        => $package,
      'receipt'        => $receipt,
      'detailreceipt'  => (isset($detailreceipt) ? $detailreceipt: null),
      'promo'          => (isset($detailreceiptpro) ? $detailreceiptpro:null),
      'configuration'  => $configuration,
      'companyclient'  => $companyclient
    ];





    $pdf = PDF::loadView('sections/receiptpackage',$vars);
    $pdf->setPaper('A4', 'auto');
    return $pdf->stream('invoice.pdf');
  }

  public function readreceiptconsolidated(Request $request)
  {
    $consolidated = consolidated::all();
    $configuration = Configuration::find(1);

    $vars = [
      'consolidated'  => $consolidated,
      'configuration' => $configuration
    ];

    $pdf = PDF::loadView('sections/consolidadespdf',$vars);
    $pdf->setPaper('A4', 'auto');
    return $pdf->stream('invoice.pdf');
  }



  /**
    *invoice package
    */
    public function invoicepackage(Request $request, $id){
      $session       = $request->session()->get('key-sesion');
      $package       = Package::find($id);
      $receipt       = Receipt::query()->where('package','=',$id)->first();
      $configuration = Configuration::find(1);

      if(isset($package->dettype)){
        $transporty    = TransportType::query()->where('transport','=',$package->getType->id)->first();
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


         $detailtytran= isset($detailreceiptty) ? TransportType::find($detailreceiptty->id_complemento):'';
         //dd($detailtytran);

         $detailreceiptinsu = DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','S')->first();

         $detailreceiptadd = DetailsReceipt::query()->where('receipt','=',$receipt->id)->where('type_attribute','=','A')->first();

         $detailadd= isset($detailreceiptadd) ? AddCharge::find($detailreceiptadd->id_complemento):'';
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

       if(isset($package->type)){
        if($package->type==1){
          $vol=$package->volumetricweightm;
        }else if($package->type==2){
          $vol=$package->volumetricweightm;
        }

      }



      $fpdi = new \fpdi\FPDI();
      $fpdf = new \fpdf\FPDF();
      $fpdi->SetAutoPageBreak(true,5);
      $pageCount = $fpdi->setSourceFile('tmpreport/invoice.pdf');
      $tplIdx    = $fpdi->importPage(1, '/BleedBox');
      $fpdi->SetTitle('Invoice '.$receipt->code);

      $fpdi->addPage();
      $fpdi->useTemplate($tplIdx, 0, 0, 210);

      //Datos de la empresa
      $nombre = $configuration->logo_ics;
      $isJPG = strrpos($nombre,".jpg");
      if(!($isJPG)) {
        $fpdi->Image(isset($configuration) ? ($configuration->logo_ics == '') ? asset('/dist/images/logoazul.jpg') : $configuration->logo_ics : asset('/dist/images/logoazul.jpg'),10,8,30,0,'PNG');
      }
      if($isJPG) {
        $fpdi->Image(isset($configuration) ? ($configuration->logo_ics == '') ? asset('/dist/images/logoazul.jpg') : $configuration->logo_ics : asset('/dist/images/logoazul.jpg'),10,8,30,0,'JPG');
      }
      $isJPG = strrpos($nombre,".JPG");
      if(!($isJPG)) {
        $fpdi->Image(isset($configuration) ? ($configuration->logo_ics == '') ? asset('/dist/images/logoazul.jpg') : $configuration->logo_ics : asset('/dist/images/logoazul.jpg'),10,8,30,0,'PNG');
      }
      if($isJPG) {
        $fpdi->Image(isset($configuration) ? ($configuration->logo_ics == '') ? asset('/dist/images/logoazul.jpg') : $configuration->logo_ics : asset('/dist/images/logoazul.jpg'),10,8,30,0,'JPG');
      }




      $fpdi->SetFont('Arial','B',12);
      $fpdi->SetTextColor(59, 59, 59);
      $fpdi->SetXY(40, 10);
      $fpdi->MultiCell(85, 3, isset($configuration->name_company) ? $configuration->name_company: 'International Cargo System');

      $fpdi->SetFont('Arial','',12);
      $fpdi->SetTextColor(59, 59, 59);
      $fpdi->SetXY(40, 15);
      $fpdi->MultiCell(85, 3, isset($configuration->dni_company) ? $configuration->dni_company: 'DNI:1234567890');

      $fpdi->SetFont('Arial','',11);
      $fpdi->SetTextColor(83, 83, 83);
      $fpdi->SetXY(40, 20);
      $fpdi->MultiCell(85, 3, isset($configuration->email_company) ? $configuration->email_company: 'www.internationalcargosystem.com');



      //Titulo del Invoice
    /*$fpdi->SetFont('Arial','B',16);
      $fpdi->SetTextColor(255, 255, 255);
      $fpdi->SetXY(80, 50);
      $fpdi->MultiCell(85, 3, 'INVOICE '.$receipt->code);*/
      $fpdi->SetFont('Arial','',9);
      //NUMERO DE FACTURA
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(183, 27);
      $fpdi->MultiCell(85, 3, $package->code);
      //FECHA

      $fpdi->SetXY(183, 32);
      $fpdi->MultiCell(40, 3,$package->created_at->format('d-m-y/H:i'));
      //POSTAL CODE
      $fpdi->SetXY(183, 37);
      $fpdi->MultiCell(85, 3, isset($package->getToUser->postal_code) ? ($package->getToUser->postal_code) : '');

      $fpdi->SetFont('Arial','',10);
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(115, 65);
      $fpdi->MultiCell(85, 3, 'CATEGORY:');

      $category = Category::find($package->category);
      $fpdi->SetXY(140, 65);
      $fpdi->MultiCell(85, 3, isset($category) ? strtoupper($category->label) : '');

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(115, 80-10);
      $fpdi->MultiCell(85, 3, 'DIMENSIONS:');
      //dd($package);
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(140, 80-10);
      $fpdi->MultiCell(85, 3, isset($package) ? $package->large.'x'.$package->width.'x'.$package->height : '');

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(115, 85-10);
      $fpdi->MultiCell(85, 3, 'VOL. WEIGHT:');
    //  dd($package);
      if($package->type == 1){
        $fpdi->SetTextColor(0, 0, 0);
        $fpdi->SetXY(140, 85-10);
        $fpdi->MultiCell(85, 3, isset($package) ? $package->volumetricweightm.'ft3' : '');
      }else {
        $fpdi->SetTextColor(0, 0, 0);
        $fpdi->SetXY(140, 85-10);
        $fpdi->MultiCell(85, 3, isset($package) ? $package->volumetricweighta.'Vlb' : '');
      }


      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(115, 90-10);
      $fpdi->MultiCell(85, 3, 'COUNTRY:');

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(140, 90-10);
      $fpdi->MultiCell(85, 3, isset($package) ? (isset($package->to_client) ?$package->getToClient['country'] : strtoupper($package->getToUser['country'])) : '');

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(115, 95-10);
      $fpdi->MultiCell(85, 3, 'TRANSPORT:');

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(140, 95-10);
      $fpdi->MultiCell(85, 3,utf8_decode(strtoupper($package->getType['spanish'])));


      //Detalle del usuario
      if(isset($package->to_client)){
        $fpdi->SetTextColor(0, 0, 0);
        $fpdi->SetXY(20, 65);
        $fpdi->MultiCell(85, 3, $package->getToClient->code." ".$package->getToClient->name);

      }elseif (isset($package->to_user)) {

        $fpdi->SetFont('Arial','',10);
        $fpdi->SetTextColor(0, 0, 0);
        $fpdi->SetXY(20, 65);
        $fpdi->MultiCell(85, 3, 'NAME:');

        $fpdi->SetXY(40, 65);
        $fpdi->MultiCell(85, 3, strtoupper( $package->getToUser->code." ".$package->getToUser->name." ".$package->getToUser->last_name));
        $fpdi->SetTextColor(0, 0, 0);
        $fpdi->SetXY(20, 80-10);
        $fpdi->MultiCell(85, 3, 'DNI:');

        $fpdi->SetTextColor(0, 0, 0);
        $fpdi->SetXY(40, 80-10);
        $fpdi->MultiCell(85, 3, isset($package) ? (isset($package->to_user) ?$package->getToUser['dni'] : $package->getToUser['dni']) : '');

        $fpdi->SetTextColor(0, 0, 0);
        $fpdi->SetXY(20, 85-10);
        $fpdi->MultiCell(85, 3, 'ADRESS:');

        $fpdi->SetTextColor(0, 0, 0);
        $fpdi->SetXY(40, 85-10);
        $fpdi->MultiCell(85, 3, isset($package) ? (isset($package->to_user) ?$package->getToUser['postal_code'] : strtoupper($package->getToUser['postal_code']." ".$package->getToUser['region'])) : '');

        $fpdi->SetTextColor(0, 0, 0);
        $fpdi->SetXY(20, 90-10);
        $fpdi->MultiCell(85, 3, 'COUNTRY:');

        $fpdi->SetTextColor(0, 0, 0);
        $fpdi->SetXY(40, 90-10);
        $fpdi->MultiCell(85, 3, isset($package) ? (isset($package->to_user) ? strtoupper($package->getToUser['country']) : strtoupper($package->getToUser['country'])) : '');

        $fpdi->SetTextColor(0, 0, 0);
        $fpdi->SetXY(20, 95-10);
        $fpdi->MultiCell(85, 3, 'PHONE:');
        $fpdi->SetTextColor(0, 0, 0);
        $fpdi->SetXY(40, 95-10);
        $fpdi->MultiCell(85, 3, isset($package) ? (isset($package->to_user) ?$package->getToUser['celular'] : strtoupper($package->getToUser['celular'])) : '');

      }


      //Datos de Facturacion
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(30-10, 145-20);
      $fpdi->MultiCell(85, 3, isset($package->getType['spanish']) ? utf8_decode(strtoupper($package->getType['spanish'])): '');

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(85-10, 145-20);
      $fpdi->MultiCell(20, 3, isset($package->weight) ? number_format($vol,2,',','.').$unidad: '0,00 $',0,'R');

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(128, 145-20);
      $fpdi->MultiCell(20, 3, isset($detailreceiptty) ? number_format($detailreceiptty->value_oring,2,',','.')." $": '0,00 $',0,'R');

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(165, 145-20);
      $fpdi->MultiCell(30, 3, isset($detailreceiptty) ? number_format($detailreceiptty->value_oring*$vol , 2,',','.')." $": '0,00 $',0,'R');

      // Cargos Adicionales
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(30-10, 150-20);
      $fpdi->MultiCell(85, 3, $detailadd!='' ? $detailadd->name: '');

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(69-10, 150-20);
      $fpdi->MultiCell(30, 3, isset($detailreceiptadd) ? '1': '0',0,'R');

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(118, 150-20);
      $fpdi->MultiCell(30, 3, isset($detailreceiptadd) ? number_format($detailreceiptadd->value_oring,2,',','.')." $": '0,00 $',0,'R');

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(165, 150-20);
      $fpdi->MultiCell(30, 3, isset($detailreceiptadd) ? number_format($detailreceiptadd->value_package,2,',','.')." $": '0,00 $',0,'R');

      // Seguro
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(30-10, 155-20);
      $fpdi->MultiCell(85, 3, isset($detailreceiptinsu) ? 'SEGURO': '');

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(69-10, 155-20);
      $fpdi->MultiCell(30, 3, isset($detailreceiptinsu) ? '1': '0',0,'R');


      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(118, 155-20);
      $fpdi->MultiCell(30, 3, isset($detailreceiptinsu) ? number_format($detailreceiptinsu->value_package,2,',','.')." $": '',0,'R');

      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(165, 155-20);
      $fpdi->MultiCell(30, 3, isset($detailreceiptinsu) ? number_format($detailreceiptinsu->value_package,2,',','.')." $": '',0,'R');


      //Detalle de totales
      $fpdi->SetFont('Arial','B',11);
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(168, 230);
      $fpdi->MultiCell(30, 3, number_format($receipt->subtotal,2,',','.')." $",0,'R');

      $fpdi->SetFont('Arial','B',11);
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(168, 249);
      $fpdi->MultiCell(30, 3, number_format($receipt->total,2,',','.')." $",0,'R');

      $fpdi->SetFont('Arial','',9);
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(121, 236);
      //dd($detailreceipt);
      $fpdi->MultiCell(30, 3, isset($detailreceipt) ? $detailreceipt->value_oring.'%' : '0%',0,'R');

      $fpdi->SetFont('Arial','',11);
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(168, 236);
      //dd($detailreceipt);
      $fpdi->MultiCell(30, 3, isset($detailreceipt) ? (number_format($detailreceipt->value_package,2,',','.'))." $" : '0,00 $',0,'R');

      $fpdi->SetFont('Arial','',11);
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(168, 243);
      $fpdi->MultiCell(30, 3, isset($detailreceiptpro) ? "-".number_format($detailreceiptpro->value_package,2,',','.')." $" : '-0,00 $',0,'R');

      $fpdi->SetFont('Arial','',10);
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(20, 265);
      $fpdi->MultiCell(180, 3, isset($configuration->footer_receipt) ? $configuration->footer_receipt : '');

      /*$fpdi->SetFont('Arial','',12);
      $fpdi->SetXY(140, 232);
      $fpdi->MultiCell(85, 3, strftime( "%Y-%m-%d", time()));*/


      $fpdi->Output();


    }
  }
