<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Admin\Pickup;
use App\Models\Admin\BillOfLading;
use App\Models\Admin\DetailsPickup;
use App\Models\Admin\Package;
use App\Models\Admin\Detailspackage;
use App\Models\Admin\Category;
use App\Models\Admin\Configuration;
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
      $pickup        = Package::find($id);
      $billoflading  = BillOfLading::query()->where('package','=',$pickup->id)->first();

      $detailspikcup = Detailspackage::query()->where('package','=',$id)->get();
      $countdetails  = Detailspackage::query()->where('package','=',$id)->count();
      $resultpackweight = Detailspackage::query()->where('package','=',$id)->sum('weight');
      $detailspackage   = Detailspackage::query()->where('package','=',$id)->first();
      $configuration = Configuration::find(1);
      $category = Category::query()->where('id','=',$pickup->category)->first();
      //dd($detailspackage);
      $vars =
      [
        'pickup'        => $pickup,
        'billoflading'  => $billoflading,
        'detailspikcup' => $detailspikcup,
        'count'         => $countdetails

      ];

      $fpdi = new \fpdi\FPDI();
      $fpdf = new \fpdf\FPDF();

      $pageCount = $fpdi->setSourceFile('tmpreport/MBL.pdf');
      $tplIdx    = $fpdi->importPage(1, '/BleedBox');
      $fpdi->SetTitle('WAREHOUSE B/L');

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
      $fpdi->SetXY(30, 53);
      $fpdi->MultiCell(85, 3, preg_replace("<<BR />>","", strtoupper($billoflading->exporter)));
      //dd($billoflading);
      //NRO DOCUMENTO
      $fpdi->SetXY(115, 53);
      $fpdi->MultiCell(85, 3, $billoflading->document);
      //B/L NUMERO
      $fpdi->SetXY(160, 53);
      $fpdi->MultiCell(85, 3, $billoflading->blnumber);

      $fpdi->SetFont('Arial','',8);
      //REFERENCIA DE EXPORTACION
      $fpdi->SetXY(105, 75-10);
      $fpdi->MultiCell(80, 3, strtoupper($billoflading->exportreference),0,'C');

      //CONSIGNADO A
      $fpdi->SetXY(30, 90-10);
      $fpdi->MultiCell(85, 3, preg_replace("<<BR />>","",strtoupper($billoflading->consignedto)));

      //AGENTE DE CARGA
      $fpdi->SetXY(105, 90-10);
      $fpdi->MultiCell(85, 3, strtoupper($billoflading->forwarding),0,'C');

      //NUMERO FTZ
      $fpdi->SetXY(105, 108-10);
      $fpdi->MultiCell(85, 3, strtoupper($billoflading->point),0,'C');

      //NOTIFICAR A INTERMEDIARIO
      $fpdi->SetXY(30, 125-15);
      $fpdi->MultiCell(80, 3, preg_replace("<<BR />>","",strtoupper($billoflading->notify)));

      //INSTRUCCIONES INTERNAS
      $fpdi->SetXY(123, 125);
      $fpdi->MultiCell(50, 3, "",0,'C');

      //PRETRANSPORTADO POR
      $fpdi->SetXY(30, 145-15);
      $fpdi->MultiCell(85, 3, strtoupper($billoflading->precarri));

      //LUGAR DE RECEPCION
      $fpdi->SetXY(70, 145-15);
      $fpdi->MultiCell(85, 3, strtoupper($billoflading->placedeli));

      //TRANSPORTISTA EXPORTADOR
      $fpdi->SetXY(10, 162-20);
      $fpdi->MultiCell(50, 3, strtoupper($billoflading->exporting),0,'C');

      //PUNTO DE CARGA/EXPORTACION
      $fpdi->SetXY(70, 162-20);
      $fpdi->MultiCell(85, 3, strtoupper($billoflading->place));

      //MUELLE DE CARGA/TERMINAL
      $fpdi->SetXY(140, 162-20);
      $fpdi->MultiCell(85, 3, $billoflading->loadingpier);
      //dd();
      //PUERTO EXTRANJERO DE DESCARGA
      $fpdi->SetXY(30, 155);
      $fpdi->MultiCell(85, 3, $billoflading->foreing);

      //LUGAR DE ENTREGA POR EL TRANSPORTISTA
      $fpdi->SetXY(70, 155);
      $fpdi->MultiCell(85, 3, $billoflading->place);

      //TIPO DE CARGA
      $fpdi->SetXY(83, 155);
      $fpdi->MultiCell(50, 3, strtoupper($billoflading->typemovie),0,'R');

      //CONTENERIZADO
      $fpdi->SetXY(125, 155);
      $fpdi->MultiCell(50, 3, strtoupper($billoflading->containerized),0,'R');

      //dd($package);
      $h=165;
      foreach ($detailspikcup as $detailspackage)
        {
          //MARCAS Y NUMERO
          $fpdi->SetXY(20, $h+3);
          $fpdi->MultiCell(25, 3, $billoflading->purchaseorder,0,'R');

          //NUMERO DE PAQUETE
          $fpdi->SetXY(60, $h+3);
          $fpdi->MultiCell(30, 3, $pickup->code,0,'R');

          //DESCRIPCION DEL PRODUCTO
          $fpdi->SetXY(100, $h+3);
          $fpdi->MultiCell(50, 3, strtoupper($detailspackage->description),0,'C');

          //PESO
          $fpdi->SetXY(115, $h+3);
          $fpdi->MultiCell(50, 3, number_format($resultpackweight,2,',','.').' Lb',0,'R');

          //DIMENSIONES
          //dd($detailspackage);
          $fpdi->SetXY(155, $h+3);
          $fpdi->MultiCell(50, 3, $detailspackage->large.'x'.$detailspackage->height.'x'.$detailspackage->width,0,'C');

          $h=$h+5;
        }


      //FOOTER
      $fpdi->SetXY(15, 250);
      $fpdi->MultiCell(180, 3, isset($configuration) ? ($configuration->footer_receipt == '') ? trans('configuration.nofooter') : $configuration->footer_receipt : trans('configuration.nofooter'));
      /*$fpdi->Image(asset('/dist/images/logoazul.jpg'),10,4,30,0,'JPG');


      $fpdi->SetFont('Arial','',9);
      $fpdi->SetTextColor(0, 0, 0);
      $fpdi->SetXY(20, 25);
      $fpdi->MultiCell(85, 3, isset($billoflading->exporter));

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
          $fpdi->MultiCell(85, 3, $details->volumetricweightm." Vlb");

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
    $fpdi->MultiCell(85, 3, "ORIGINAL");*/


      $fpdi->Output();


    }






}
