<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Transport;
use Validator;

class TransportController extends Controller
{

    /**
    * Test function for edit (VS)
    */
      public function edit(Request $request, $id)
      {
        $transport = Transport::find($id);
        $validator = $this->validateData($request);
        /**
        * Use the validator
        */
        if (!is_null($validator))
        {
          if ($validator->fails())
          {
             return response()->json([
               "message" => "false",
               "alert"   => $validator->messages()
             ]);
          }
        }
        $transport->update($request->all());
        $transport->save();
        return response()->json([
          "message" => "true"
        ]);
      }

   /**
    * Show ReadOnly
    */
    public function readDetails(Request $request, $id)
    {
        return $this->details($request, $id, true);
    }

   /**
    * Show Edit
    */
    public function details(Request $request, $id, $readonly = false)
    {
      $this->checkAuthorization();
      $transport = Transport::find($id);
      if(is_null($transport))
      {
        return $this->doRedirect($transport, '/admin/service')
          ->with('errorMessage', trans('courier.notFound'));
      }
      $vars = [
        'transport' => $transport,
        'readonly'  => $readonly
      ];
      if($this->isGET($request)) {
        return view('pages.admin.transport.view', $vars);
      }
    }

   /**
    * Show List
    */
    public function index(Request $request)
    {
      $session = $request->session()->get('key-sesion');
      $this->checkAuthorization();
      $transports = Transport::orderBy('created_at', 'desc')->get();
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
        'transports' => $transports
      ];
      /**
      *
      */
      return view('pages.admin.transport.list', $vars);

    }

   /**
    * Create Transport
    */
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
          return view('pages.admin.transport.create');
        }
        $validator = $this->validateData($request);
        if (!is_null($validator))
        {
          if ($validator->fails())
          {
            return view('pages.admin.transport.create')
              ->withErrors($validator)
              ->with('errorMessage', trans('messages.checkRedFields'));
          }
        }
        ////////////////////////////////////////////////////////////////////////////
        $transport = Transport::create($validator->getData());
        return $this->doRedirect($request, "/admin/service/")
        ->with('successMessage', trans('transport.created', [
          'name' => $transport->spanish,
          'code' => $transport->id
        ]));
    }

    /**
     *
     */
    public function delete(Request $request, $id)
    {
      $redirect = $this->doRedirect($request, '/admin/service');
      $transport = Transport::find($id);
      if(is_null($transport))
      {
        $redirect->with('errorMessage', trans('transport.notFound'));
      } else {
        $transport->delete();
        $redirect->with('successMessage', trans('transport.deleted', [
          'name' => $transport->spanish,
          'code' => $transport->id
        ]));
      }
      return $redirect;
    }

    /**
     * Validate Data
     */
    private function validateData(Request $request)
    {
      return Validator::make($this->clear($request->all()), [
        'spanish'       => 'required|string|min:5|max:100',
        'price'        => 'required|numeric|min:0.1'
      ]);
    }

}
