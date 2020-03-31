<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ExceptionController extends Controller
{
    //
    public function notFound(Request $request)
    {
      $session  = $request->session()->get('key-sesion');
        if($session == null)
        {
          return redirect('login');
        }
        else
        {
          return view('errors.404');
        }
    }
}
