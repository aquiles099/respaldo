<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Admin\Invoice;
use App\Models\Admin\InvoiceDetail;

class InvoiceController extends Controller
{
    /**
    *
    */
    public function index(Request $request)
    {
      $session = $request->session()->get('key-sesion')
      /**
      *  Se valida que la sesion este activa
      */
      if ($session == null)
      {
        return redirect('login');
      }

    }
    /**
    *
    */
    public function create(Request $request)
    {

    }

}
