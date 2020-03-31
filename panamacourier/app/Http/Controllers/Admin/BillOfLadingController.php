<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Admin\Pickup;
use App\Models\Admin\BillOfLading;
use App\Models\Admin\DetailsPickup;
use App\Models\Admin\Package;
use App\Models\Admin\User;
use App\Models\Admin\Service;
use App\Models\Admin\Detailspackage;
use App\Models\Admin\Category;
use App\Models\Admin\Configuration;
use App;
use DateTime;



class BillOfLadingController extends Controller
{
      /**
    *Bill of lading para los pickup order
    */
    public function create (Request $request,$id )
    {
      $session      = $request->session()->get('key-sesion');
      $pickup       = Pickup::find($id);
      $billoflading = BillOfLading::query()->where('pickup','=',$id)->first();

      /**
      *  Se valida que la sesion este activa
      */
      if ($session == null)
      {
        return redirect('login');
      }
      /**
      *
      */
      $vars =
      [
        'pickup'       => $pickup,
        'billoflading' => $billoflading

      ];

      /**
      *
      */
      //dd($vars);
      if($this->isGET($request))
      {
        return view('pages.admin.billoflading.view',$vars);
      }
      /**
      *
      */
    /*  if (!is_null($validator))
      {
        if ($validator->fails())
        {
          return view('pages.admin.typepickup.create')
            ->withErrors($validator)
            ->with('errorMessage', trans('messages.checkRedFields'));
        }
      }*/
      /**
      *
      */

      if(isset($billoflading)){

      $billodladingData = [
        'exporter'        => nl2br($request->all()['exporter']),
        'consignedto'     => nl2br($request->all()['consigne']),
        'document'        => nl2br($request->all()['document']),
        'notify'          => nl2br($request->all()['notify']),
        'blnumber'        => nl2br($request->all()['bl']),
        'exportreference' => nl2br($request->all()['exportre']),
        'exporting'       => nl2br($request->all()['exporting']),
        'forwarding'      => nl2br($request->all()['forwarding']),
        'foreing'         => nl2br($request->all()['foreing']),
        'point'           => nl2br($request->all()['point']),
        'place'           => nl2br($request->all()['place']),
        'placedeli'       => nl2br($request->all()['placedeli']),
        'port'            => nl2br($request->all()['port']),
        'precarri'        => nl2br($request->all()['precarri']),
        'purchaseorder'   => nl2br($request->all()['purchase']),
        'loadingpier'     => nl2br($request->all()['loadingpier']),
        'typemovie'       => nl2br($request->all()['typemovie']),
        'containerized'   => nl2br($request->all()['containe']),
        'package'         => $id
        ];
      $billoflading->update($billodladingData);
      $billoflading->save();

      }else{
        $billodladingData = [
        'exporter'        => nl2br($request->all()['exporter']),
        'consignedto'     => nl2br($request->all()['consigne']),
        'document'        => nl2br($request->all()['document']),
        'notify'          => nl2br($request->all()['notify']),
        'blnumber'        => nl2br($request->all()['bl']),
        'exportreference' => nl2br($request->all()['exportre']),
        'exporting'       => nl2br($request->all()['exporting']),
        'forwarding'      => nl2br($request->all()['forwarding']),
        'foreing'         => nl2br($request->all()['foreing']),
        'point'           => nl2br($request->all()['point']),
        'place'           => nl2br($request->all()['place']),
        'placedeli'       => nl2br($request->all()['placedeli']),
        'port'            => nl2br($request->all()['port']),
        'precarri'        => nl2br($request->all()['precarri']),
        'purchaseorder'   => nl2br($request->all()['purchase']),
        'loadingpier'     => nl2br($request->all()['loadingpier']),
        'typemovie'       => nl2br($request->all()['typemovie']),
        'containerized'   => nl2br($request->all()['containe']),
        'pickup'          => $id

      ];

      $billoflading = BillOfLading::create($billodladingData);
      }
      return response()->json([
        "message" => $request->all()
      ]);
   }



    public function receiptbill (Request $request,$id ){
      $session      = $request->session()->get('key-sesion');
      $pickup       = Pickup::find($id);
      $billoflading = BillOfLading::query()->where('pickup','=',$id)->first();

      $vars =
      [
        'pickup'       => $pickup,
        'billoflading' => $billoflading

      ];

      $pdf = PDF::loadView('pages/admin/billoflading/receiptbill',$vars);
      $pdf->setPaper('A4', 'auto');
      return $pdf->stream('Bill Of Lading-'.$pickup->code.'.pdf');

    }

    public function pdfbill (Request $request, $id){
      $session       = $request->session()->get('key-sesion');
      $pickup        = Pickup::find($id);
      $billoflading  = BillOfLading::query()->where('pickup','=',$id)->first();
      $detailspikcup = DetailsPickup::query()->where('pickup','=',$id)->get();
      $countdetails  = DetailsPickup::query()->where('pickup','=',$id)->count();
      $resultpackweight = DetailsPickup::query()->where('pickup','=',$id)->sum('weight');
      $resultpackvol    = DetailsPickup::query()->where('pickup','=',$id)->sum('volumetricweightm');

      //dd($billoflading);
      $vars =
      [
        'pickup'        => $pickup,
        'billoflading'  => $billoflading,
        'detailspikcup' => $detailspikcup,
        'count'         => $countdetails

      ];
     // dd($vars);


      $fpdi = new \fpdi\FPDI();
      $fpdf = new \fpdf\FPDF();

      $pageCount = $fpdi->setSourceFile('tmpreport/bill.pdf');
      $tplIdx    = $fpdi->importPage(1, '/BleedBox');
      $fpdi->SetTitle('Bill Of Lading');

      $fpdi->addPage();
      $fpdi->useTemplate($tplIdx, 10, 10, 200);

      //$fpdi->Image(asset('/dist/images/logoazul.jpg'),10,4,30,0,'JPG');


      $fpdi->SetFont('Arial','',10);
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(20, 25);
      $fpdi->MultiCell(85, 3, $billoflading->exporter);

      //Primera Columna
      $fpdi->SetXY(20, 50);
      $fpdi->MultiCell(85, 3, $billoflading->consignedto);

      $fpdi->SetXY(20, 50);
      $fpdi->MultiCell(85, 3, $billoflading->consignedto);

      $fpdi->SetXY(20, 70);
      $fpdi->MultiCell(85, 3, $billoflading->notify);

      $fpdi->SetXY(20, 90);
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

      $fpdi->SetXY(155, 32);
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

      $height=130;

      foreach ($detailspikcup as $details)
        {


          $fpdi->SetXY(25, $height);
          $fpdi->MultiCell(85, 3, $pickup->code);

          $fpdi->SetXY(70, $height);
          $fpdi->MultiCell(85, 3, $details->description);

          $fpdi->SetXY(153, $height);
          $fpdi->MultiCell(85, 3, $details->weight." lbl");

          $fpdi->SetXY(175, $height);
          $fpdi->MultiCell(85, 3, $details->volumetricweightm." Vlb");

          $height=$height+10;


        }

      $fpdi->SetXY(15, 191);
      $fpdi->MultiCell(85, 3, "TOTAL OF PIECES");

      $fpdi->SetXY(58, 191);
      $fpdi->MultiCell(85, 3, $countdetails);


      $fpdi->SetXY(153, 191);
      $fpdi->MultiCell(85, 3, $resultpackweight." lbl");


      $fpdi->SetXY(175, 191);
      $fpdi->MultiCell(85, 3, $resultpackvol." Vbl");

      $fpdi->SetXY(178, 257);
      $fpdi->MultiCell(85, 3, $pickup->code);

      $formato = 'Y-m-d H:i:s';
      $fecha = DateTime::createFromFormat($formato, $billoflading->created_at);

      $fpdi->SetXY(178, 245);
      $fpdi->MultiCell(85, 3, $fecha->format('Y'));

      $fpdi->SetXY(120, 245);
      $fpdi->MultiCell(85, 3, $fecha->format('M'));

      $fpdi->SetXY(150, 245);
      $fpdi->MultiCell(85, 3, $fecha->format('d'));

      $fpdi->SetFont('Arial','',13);
      $fpdi->SetTextColor(173, 173, 173);
      $fpdi->SetXY(90, 182);
      $fpdi->MultiCell(85, 3, "ORIGINAL");
      $fpdi->Output();


    }


    /**
    *Bill Of Lading Para WareHouse
    */
    public function createwr (Request $request,$id )
    {
      $session      = $request->session()->get('key-sesion');
      $package      = Package::find($id);
      $billoflading = BillOfLading::query()->where('package','=',$id)->first();

      /**
      *  Se valida que la sesion este activa
      */
      if ($session == null)
      {
        return redirect('login');
      }
      /**
      *
      */
      $vars =
      [
        'package'      => $package,
        'billoflading' => $billoflading

      ];

      /**
      *
      */
      //dd($vars);
      if($this->isGET($request))
      {
        return view('pages.admin.billoflading.viewwr',$vars);
      }
      /**
      *
      */
    /*  if (!is_null($validator))
      {
        if ($validator->fails())
        {
          return view('pages.admin.typepickup.create')
            ->withErrors($validator)
            ->with('errorMessage', trans('messages.checkRedFields'));
        }
      }*/
      /**
      *
      */

      if(isset($billoflading)){
         $billodladingData = [
        'exporter'        => nl2br($request->all()['exporter']),
        'consignedto'     => nl2br($request->all()['consigne']),
        'document'        => nl2br($request->all()['document']),
        'notify'          => nl2br($request->all()['notify']),
        'blnumber'        => nl2br($request->all()['bl']),
        'exportreference' => nl2br($request->all()['exportre']),
        'exporting'       => nl2br($request->all()['exporting']),
        'forwarding'      => nl2br($request->all()['forwarding']),
        'foreing'         => nl2br($request->all()['foreing']),
        'point'           => nl2br($request->all()['point']),
        'place'           => nl2br($request->all()['place']),
        'placedeli'       => nl2br($request->all()['placedeli']),
        'port'            => nl2br($request->all()['port']),
        'precarri'        => nl2br($request->all()['precarri']),
        'purchaseorder'   => nl2br($request->all()['purchase']),
        'loadingpier'     => nl2br($request->all()['loadingpier']),
        'typemovie'       => nl2br($request->all()['typemovie']),
        'containerized'   => nl2br($request->all()['containe']),
        'package'              => $id
        ];
         $billoflading->update($billodladingData);
         $billoflading->save();


      }else{
        $billodladingData = [
        'exporter'        => nl2br($request->all()['exporter']),
        'consignedto'     => nl2br($request->all()['consigne']),
        'document'        => nl2br($request->all()['document']),
        'notify'          => nl2br($request->all()['notify']),
        'blnumber'        => nl2br($request->all()['bl']),
        'exportreference' => nl2br($request->all()['exportre']),
        'exporting'       => nl2br($request->all()['exporting']),
        'forwarding'      => nl2br($request->all()['forwarding']),
        'foreing'         => nl2br($request->all()['foreing']),
        'point'           => nl2br($request->all()['point']),
        'place'           => nl2br($request->all()['place']),
        'placedeli'       => nl2br($request->all()['placedeli']),
        'port'            => nl2br($request->all()['port']),
        'precarri'        => nl2br($request->all()['precarri']),
        'purchaseorder'   => nl2br($request->all()['purchase']),
        'loadingpier'     => nl2br($request->all()['loadingpier']),
        'typemovie'       => nl2br($request->all()['typemovie']),
        'containerized'   => nl2br($request->all()['containe']),
        'package'          => $id

      ];

      $billoflading = BillOfLading::create($billodladingData);
      }
      return response()->json([
        "message" => $request->all()
      ]);
   }


   public function pdfbillwr (Request $request, $id){
      $session       = $request->session()->get('key-sesion');
      $configuration = Configuration::find(1);

      $package = Package::find($id);
      $shipper = User::find($package->consigner_user);
      $consigner = User::find($package->to_user);
      $fpdi = new \fpdi\FPDI();
      $fpdf = new \fpdf\FPDF();
      $fpdi->SetAutoPageBreak(true,1);
      $lang = $configuration->language;
      if ($lang=='es') {
        $pageCount = $fpdi->setSourceFile('tmpreport/MBL.pdf');
      }else {
        $pageCount = $fpdi->setSourceFile('tmpreport/MBL.pdf');
      }
      $tplIdx    = $fpdi->importPage(1, '/BleedBox');
      $fpdi->SetTitle('WAREHOUSE B/L');

      $fpdi->addPage();
      $fpdi->useTemplate($tplIdx, 0, 0, 210, 279-5);

      $nombre = $configuration->logo_ics;
      $isJPG = strrpos($nombre,".jpg");
      if((!($isJPG)) && ($nombre!=null)) {
        $fpdi->Image(isset($configuration) ? ($configuration->logo_ics == '') ? asset('/dist/images/logoazul.jpg') : $configuration->logo_ics : asset('/dist/images/logoazul.jpg'),5,1,20,0,'PNG');
      }
      if($isJPG) {
        $fpdi->Image(isset($configuration) ? ($configuration->logo_ics == '') ? asset('/dist/images/logoazul.jpg') : $configuration->logo_ics : asset('/dist/images/logoazul.jpg'),5,1,20,0,'JPG');
      }

      /*$fpdi->SetFont('Arial','B',10);
      $fpdi->SetTextColor(59, 59, 59);
      $fpdi->SetXY(40, 5);
      $fpdi->MultiCell(85, 3, isset($configuration->name_company) ? $configuration->name_company: 'International Cargo System');
*/
      $fpdi->SetFont('Arial','',18);
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(123, 7);
      $fpdi->MultiCell(85, 3, 'HOUSE');

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
      $fpdi->SetXY(85, 32);
      $fpdi->MultiCell(80, 3,  isset($shipper) ? strtoupper($shipper->postal_code) : '');

      //NRO DOCUMENTO
      $fpdi->SetXY(90, 16);
      $bl = isset($package->code) ? str_replace("WRH-",utf8_decode("N° "),$package->code) : '';
      $fpdi->MultiCell(85, 3, $bl,0,'C');

      //B/L NUMERO
      $fpdi->SetXY(138, 16);
      $bl = isset($package->code) ? str_replace("WRH","BL",$package->code) : '';
      $fpdi->MultiCell(85, 3, $bl,0,'C');

      //REFERENCIA DE EXPORTACION
      $fpdi->SetXY(112, 25);
      $fpdi->MultiCell(85, 3, 'MBL' ,0,'C');

      //CONSIGNADO A
      $fpdi->SetFont('Arial','',9);

      $fpdi->SetXY(5, 82-18-23);
      $fpdi->MultiCell(85, 3, isset($consigner) ? strtoupper($consigner->name.' '.$consigner->last_name): '');
      $fpdi->SetXY(5, 85-18-23);
      $fpdi->MultiCell(90, 3,  isset($consigner) ? strtoupper($consigner->address.', '.$consigner->city.', '.$consigner->postal_code) : '');
      $fpdi->SetXY(5, 88-18-23);
      $fpdi->MultiCell(80, 3,  isset($consigner) ? strtoupper($consigner->region.', '.$consigner->country) : '');
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

      $toNotify = $consigner;
      //NOTIFICAR A INTERMEDIARIO
      $fpdi->SetXY(5, 108-40);
      $fpdi->MultiCell(85, 3,  isset($toNotify) ? strtoupper($toNotify->name.' '.$toNotify->last_name) : '');

      $fpdi->SetXY(5, 111-40);
      $fpdi->MultiCell(90, 3,  isset($toNotify) ? strtoupper($toNotify->address.', '.$toNotify->city.', '.$toNotify->postal_code) : '');
      $fpdi->SetXY(5, 114-40);
      $fpdi->MultiCell(85, 3,  isset($toNotify) ? strtoupper($toNotify->region.', '.$toNotify->country) : '');

      $fpdi->SetXY(5, 117-40);
      $fpdi->MultiCell(85, 3,  isset($toNotify) ? 'PHONE: '.strtoupper($toNotify->celular) : '');
      $fpdi->SetXY(5, 120-40);
      $fpdi->MultiCell(85, 3,  isset($toNotify) ? strtolower($toNotify->email) : '');
      //TYPE OF MOVE
      $fpdi->SetXY(135, 106);
      $fpdi->MultiCell(85, 3,($package->type == 1) ?'MARITIMO': 'AEREO');
      //PURCHASE ORDER AND INVOICE (SHIPPER)
      $fpdi->SetXY(110, 65);
      $inv = isset($package->code) ? str_replace("WRH","INV",$package->code) : '';
      $fpdi->MultiCell(100, 3, strtoupper($inv),0,'L');

      //LUGAR DE RECEPCION
      $fpdi->SetXY(65, 91);
      $fpdi->MultiCell(85, 3,  isset($configuration->city_company) ? strtoupper($configuration->city_company) :  '--');

      //PUNTO DE CARGA/EXPORTACION
      $fpdi->SetXY(65, 100);
      $fpdi->MultiCell(85, 3, isset($shipper->city) ? $shipper->city : '--');
      //PUERTO EXTRANJERO DE DESCARGA
      $fpdi->SetXY(5, 108);
      $fpdi->MultiCell(85, 3, isset($consigner->city) ? ($consigner->city) : '--');

      $fpdi->SetXY(5, 125);
      $fpdi->MultiCell(40, 3, isset($package->code) ? ($package->code) : '--' , 0 , 'C');

      $fpdi->SetXY(34, 125);
      $detailspackage = Detailspackage::query()->where('package','=',$id)->count();
      $countdetails = $detailspackage;
      $fpdi->MultiCell(40, 3, isset($detailspackage) ? $detailspackage : '--' , 0 , 'C');

      $fpdi->SetXY(65, 125);
      $detailspackage = Detailspackage::query()->where('package','=',$id)->first();
      $fpdi->MultiCell(60, 3, isset($detailspackage->description) ? isset($package->details_type) ? isset($package->details_type) : ($detailspackage->description) : '--' , 0 , 'L');

      $und_peso = ($package->unidad == 1)? ' kg' : ' lb' ;
      $fpdi->SetXY(142, 125);
      $fpdi->MultiCell(30, 3, isset($detailspackage->weight) ? number_format($detailspackage->weight,2,',','.').$und_peso : '--' , 0 , 'R');

      $und_vol = ($package->unidad == 1)? ' ft3' : ' m3' ;
      $fpdi->SetXY(170, 125);
      $fpdi->MultiCell(30, 3, isset($detailspackage->volumetricweightm) ? number_format($detailspackage->volumetricweightm,2,',','.').$und_vol : '--' , 0 , 'R');
/*
      //PESO
      $fpdi->SetXY(115, 128);
      $fpdi->MultiCell(50, 3, number_format($detailspackage->weight,2,',','.').' Lb',0,'R');

      //DIMENSIONES
      //dd($detailspackage);
      $fpdi->SetXY(168, 128);
      $fpdi->MultiCell(50, 3,$detailspackage->volumetricweightm.$und_vol,0,'C');*/
      //NUMERO DE PAQUETE
      $fpdi->SetXY(15, 199);
      $fpdi->MultiCell(50, 3, isset($package->value) ? number_format($package->value,2,',','.') : '' , 0 , 'C');
      $fpdi->SetFont('Arial','B',9);
      $fpdi->SetXY(12, 193);
      $fpdi->MultiCell(85, 3, "TOTAL OF PIECES");

      $fpdi->SetFont('Arial','B',10);
      $fpdi->SetXY(39, 193);
      $fpdi->MultiCell(30, 3, $countdetails.'',0,'C');

      $fpdi->SetXY(151, 193);
      $fpdi->MultiCell(30, 3, isset($detailspackage->weight) ? number_format($detailspackage->weight,2,',','.').$und_peso : '',0,'C');

      $fpdi->SetXY(178, 193);
      $fpdi->MultiCell(30, 3, isset($detailspackage->volumetricweightm) ? number_format($detailspackage->volumetricweightm,2,',','.').$und_vol : '',0,'C');

      $fpdi->SetXY(134, 193);
      $fpdi->MultiCell(85, 3, "TOTALS");

      $fpdi->SetXY(117, 249);
      $fpdi->MultiCell(85, 3, isset($package->created_at) ? $package->created_at->format('M                               d,                                Y') : '',0,'L');

      $fpdi->SetFont('Arial','B',14);
      $fpdi->SetTextColor(119, 119, 119);
      $fpdi->SetXY(95, 192);
      $fpdi->MultiCell(85, 3, "ORIGINAL");

      $fpdi->Output();


    }






}
