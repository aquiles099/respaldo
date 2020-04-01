<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Payment;
use App\Models\Admin\Client;
use App\Models\Admin\Billing;
use DB;
use Validator;
use \Mail;
use Carbon\Carbon;
use App\Helpers\HPayment;
use App\Helpers\HUserType;

class BillingController extends Controller {
  /**
  * Listado de facturas
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
    $billings = Billing::all();
    /**
    *
    */
    \Log::info('listado de facturacion visto por: '.$user->email);
    /**
    *
    */
    return view('pages.admin.billing.list', compact('billings'));
  }
  /**
  * Editar Factura
  */
  public function edit (Request $request, $id) {

  }
  /**
  * Eliminar Factura
  */
  public function delete (Request $request, $id) {

  }
  /**
  *
  */
}
