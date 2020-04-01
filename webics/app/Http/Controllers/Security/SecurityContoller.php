<?php

namespace App\Http\Controllers\Security;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\HUserType;
use Carbon\Carbon;

class SecurityContoller extends Controller {
    /**
    *
    */
    public function index (Request $request) {
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
      \Log::info('seccion de actividad visualizada por: '.$user->email);
      return view('pages.security.main');
    }
    /**
    * Muestra el registro de actividad
    */
    public function showLog (Request $request) {
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
      try {
        /**
        * Se invierte el archivo para mostrar lo mas reciente primero
        */
        $archivo = storage_path().'/logs/laravel.log';
        $archivo_inv = storage_path().'/logs/invertido.log';
        $lineas = array_reverse(file($archivo));
        $handler = fopen($archivo_inv, "a");
        /**
        *
        */
        foreach ($lineas as $key => $linea) {
          fwrite($handler, $linea);
        }
        /**
        * Se envia la data a la vista
        */
        $log = fopen(storage_path().'/logs/invertido.log', "r") or exit("Unable to open file!");
        \Log::info('detalles de log visualzados por: '.$user->email);
        return response()->view('pages.security.show-log', compact('log'), 200)->header('Content-Type', 'pdf');
        /**
        *
        */
      } catch (Exception $e) {
        return $this->doRedirect($request, '/')->with('errorMessage', trans('messages.fileerror',[
          'error' => $ex->getMessage()
        ]));
      }
    }
    /**
    * Exporta el Registro de Actividad
    */
    public function exportLog (Request $request) {
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
      $date = Carbon::now();
      $date->format('Y-m-d');
      \Log::info('archivo log descargado por: '.$user->email);
      return response()->download(storage_path().'/logs/invertido.log', 'ICS-LOG-'.$date);
    }
    /**
    *
    */
}
