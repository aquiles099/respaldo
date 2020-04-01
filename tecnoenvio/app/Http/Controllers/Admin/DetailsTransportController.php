<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DetailsTransportController extends Controller
{
    public function create(Request $request)
    {
        $session = $request->session()->get('key-sesion');
        $this->checkAuthorization();
        /**
        *  Se valida que la sesion este activa
        */
        if ($session == null) {
          return redirect('login');
        }
        /**
        *
        */
        if($this->isGET($request))
        {
          return view('pages.admin.transport.detailstransport');
        }
        $validator = $this->validateData($request);
        if (!is_null($validator))
        {
          if ($validator->fails())
          {
            return view('pages.admin.transport.detailstransport')
              ->withErrors($validator)
              ->with('errorMessage', trans('messages.checkRedFields'));
          }
        }
        ////////////////////////////////////////////////////////////////////////////
        $transport = DetailsTransport::create($validator->getData());
        return $this->doRedirect($request, "/admin/service/")
        ->with('successMessage', trans('transport.created', [
          'name' => $transport->spanish,
          'code' => $transport->id
        ]));
    }
}
