<?php

namespace App\Http\Controllers\Exception;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExceptionController extends Controller {
    /**
    *
    */
    public function methodNotFound (Request $request) {
      \Log::info('se ha realizado una peticion al servidor con un metodo no declararo en el archivo de rutas');
      return view('errors.exception', [
        'error'  => trans('error.methodnotfound'),
        'method' => $request->method()
      ]);
    }
    /**
    *
    */
}
