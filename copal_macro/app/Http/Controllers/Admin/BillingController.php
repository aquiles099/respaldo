<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Admin\Package;
use App\Models\Admin\Detailspackage;
use App\Models\Admin\Receipt;
use App\Models\Admin\Invoice;
use App\Models\Admin\InvoiceDetail;
use App\Models\Admin\Configuration;
use Input;
use DB;
use Validator;
use App\Helpers\HConstants;

class BillingController extends Controller {
    //
    public function index (Request $request) {
      $session = $request->session()->get('key-sesion');
      $types   = $this->reportTypes();
      $data    = HConstants::EVENT_INITIAL;
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
        'types' => $types,
        'data'  => $data
      ];
      /**
      *
      */
      return view('pages.admin.billing.list', $vars);
    }
    /**
    *
    */
    public function searchData(Request $request) {
        $session       = $request->session()->get('key-sesion');
        $types         = $this->reportTypes();
        $typeSelect    = $request->all()['typeSelect'];
        $typeReport    = HConstants::EVENT_CERO;
        $nameReport    = HConstants::RESPONSE_NULL;
        $receipt       = Receipt::all();
        $invoiceDetail = InvoiceDetail::all();
        $data          = HConstants::RESPONSE_NULL;
        /**
        *
        */
        $since_date = $request->all()['since_date'];
        $until_date = $request->all()['until_date'];
        /**
        *  Se valida que la sesion este activa
        */
        if ($session == HConstants::RESPONSE_NULL) {
          return redirect('login');
        }
        /**
        *
        */
        if ($typeSelect == HConstants::EVENT_INITIAL) {
            $data       = Receipt::query()->whereBetween('created_at', [$since_date, $until_date])->get();
            $typeReport = HConstants::EVENT_INITIAL;
            $nameReport = "Facturas";
        }
        /**
        *
        */
        if ($typeSelect == 2) {
            $data       = Receipt::query()->whereBetween('created_at', [$since_date, $until_date])->get();
            $typeReport = 2;
            $nameReport = "Facturas Pagadas";
        }
        /**
        *
        */
        if ($typeSelect == 3) {
            $data       = Receipt::query()->whereBetween('created_at', [$since_date, $until_date])->get();
            $typeReport = 3;
            $nameReport = "Facturas con Deudas";
        }
        /**
        *
        */
        if ($typeSelect == 4) {
            $data       = Detailspackage::query()->whereBetween('created_at', [$since_date, $until_date])->get();
            $typeReport = 4;
            $nameReport = "Envios Recibidos";
        }
        /**
        *
        */
        if ($typeSelect == 5) {
          $data       = Detailspackage::query()->whereBetween('created_at', [$since_date, $until_date])->get();
          $typeReport = 5;
          $nameReport = "Envios en Transito";
        }
        /**
        *
        */
        $vars = [
          'types'       => $types,
          'data'        => $data,
          'typeReport'  => $typeReport,
          'nameReport'  => $nameReport
        ];
        /**
        * Use the validator
        */
        $validator = $this->validateData($request);
        if (!is_null($validator)) {
          if ($validator->fails()) {
            return view('pages.admin.billing.list', $vars)->withErrors($validator)
             ->with('errorMessage', trans('messages.checkRedFields'));
          }
        }
        /**
        *
        */
        return view('pages.admin.billing.list', $vars);
    }

    /**
    *
    */
    public function returnLogo (Request $request) {
      $session       = $request->session()->get('key-sesion');
      $configuration = Configuration::all()->last();
      /**
      * modifica la fecha en que se visualizan los paquetes en el dashboard
      */
      if($session == null ) {
        return response()->json([
          "message" => "false"
        ]);
      }
      $logo = ($configuration->logo_ics == null || $configuration->logo_ics == '') ? asset('/uploads/logo/005.png') : $configuration->logo_ics;
      /**
      *
      */
      return response()->json([
        "message" => "true",
        "alert"   => $logo
      ]);
    }
    /**
    *
    */
    private function validateData(Request $request) {
      return Validator::make($this->clear($request->all()), [
        'since_date'  => 'required|date|date_format:Y-m-d|',
        'until_date'  => 'required|date|date_format:Y-m-d|after:since_date',
      ]);
    }
}
