<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Admin\Transport;
use App\Models\Admin\DetailsTransport;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Validator;

class DetailsTransportController extends Controller
{
    public function create(Request $request,$id)
    {
        $session = $request->session()->get('key-sesion');
        $transport   = Transport::find($id);
        
        $this->checkAuthorization();
        /**
        *  Se valida que la sesion este activa
        */
        if ($session == null) {
          return redirect('login');
        }
         $vars = [
          'transport'         => $transport
          
          
        ];
        /**
        *
        */
        if($this->isGET($request))
        {
          return view('pages.admin.transport.detailstransport', $vars);
        }

        $validator = $this->validateData($request);
        if (!is_null($validator))
        {
          if ($validator->fails())
          {
            return view('pages.admin.transport.detailstransport', $vars)
              ->withErrors($validator)
              ->with('errorMessage', trans('messages.checkRedFields'));
          }
        }
    
        
         $details = [
            'name'               => $request->all()['name'],
            'description'        => $request->all()['description'],
            'transport'          => $id
           ];
        
        ////////////////////////////////////////////////////////////////////////////

            /**
    * Guardar la informacion del paquete
    */

      $session = $request->session()->get('key-sesion');
      $transportdeta = DetailsTransport::create($details);
         return response()->json([
          "message" => "true"
        ]);
        
        
    }

      /**
   *
   */
  private function validateData(Request $request) {
    return Validator::make($this->clear($request->all()), [
      'name'         => 'required|string|min:5|max:100',
      'description'  => 'required|string|min:5'
      
    ]);
  }



}
