<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Transport;
use App\Models\Admin\DetailsTransport;
use Validator;
use DB;

class TransportController extends Controller
{
    /**
    * Ver puerto modo readonly
    */
    public function editPortRead(Request $request, $id) {
      return $this->editPort($request, $id, true);
    }
    /**
    * Editar un puerto
    */
    public function editPort(Request $request, $id, $readonly = false) {
      $port      = DetailsTransport::find($id);
      $transport = Transport::find($port->transport);
       /**
        *
        */
        $vars = [
          'port'      => $port,
          'readonly'  => $readonly,
          'transport' => $transport
        ];
        /**
        *
        */
        if($this->isGET($request)) {
          return view('pages.admin.transport.formPort', $vars);
        }
        /**
        *
        */
        $validator = $this->validateDataPort($request);
        if (!is_null($validator)) {
          if ($validator->fails()) {
            return response()->json([
            "message" => "false",
            "alert"   => $validator->messages()
            ]);
          }
        }
        /**
        * data
        */
        $data = [
          'name'        => $request->all()['name'],
          'description' => $request->all()['description']
        ];
        /**
        *
        */
        $port->update($data);
        $port->save();
        return response()->json([
        "message" => "true"
        ]);
    }
    /**
    * Test function for edit (VS)
    */
    public function edit(Request $request, $id, $readonly = false) {
        $transport = Transport::find($id);
        /**
        *
        */
        $vars = [
          'transport' => $transport,
          'readonly'  => $readonly
        ];
        /**
        *
        */
        if($this->isGET($request)) {
            return view('pages.admin.transport.formPort', $vars);
        }
        /**
        *
        */
        $validator = $this->validateDataPort($request);
        if (!is_null($validator)) {
          if ($validator->fails()) {
             return response()->json([
               "message" => "false",
               "alert"   => $validator->messages()
             ]);
          }
        }
        /**
        *
        */
        $data = [
            'name'         => $request->all()['name'],
            'description'  => $request->all()['description'],
            'transport'    => $id
        ];
        /**
        *
        */
        $port = DetailsTransport::create($data);
        return response()->json([
          "message" => "true"
        ]);
    }
   /**
    * Show ReadOnly
    */
    public function readDetails(Request $request, $id) {
        return $this->details($request, $id, true);
    }
   /**
    * Show Edit
    */
    public function details(Request $request, $id, $readonly = false) {
      $transport = Transport::find($id);
      $ports     = DetailsTransport::byTransport($transport->id)->get();
      /**
      *
      */
      if(is_null($transport)) {
        return $this->doRedirect($transport, '/admin/transport')
          ->with('errorMessage', trans('courier.notFound'));
      }
      /**
      *
      */
      $vars = [
        'transport'        => $transport,
        'readonly'         => $readonly,
        'ports'            => $ports
      ];
      /**
      *
      */
      if($this->isGET($request)) {
        return view('pages.admin.transport.view', $vars);
      }
    }
    /**
    * cargar formulario de transporte para editar
    */
    public function viewTransport(Request $request, $id, $readonly= false) {
      $transport = Transport::find($id);
      /**
      *
      */
      $vars = [
        'transport'        => $transport,
        'readonly'         => $readonly
      ];
      /**
      *
      */
      if($this->isGET($request)) {
        return view('pages.admin.transport.viewTransport', $vars);
      }
      /**
      *
      */
      $transport->update($request->all());
      $transport->save();
      return response()->json([
      "message" => "true"
      ]);
    }
   /**
    * Show List
    */
    public function index(Request $request) {
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
    public function create(Request $request) {
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
        if($this->isGET($request)) {
          return view('pages.admin.transport.create');
        }
        /**
        *
        */
        $validator = $this->validateData($request);
        if (!is_null($validator)) {
          if ($validator->fails()) {
            return view('pages.admin.transport.create')
              ->withErrors($validator)
              ->with('errorMessage', trans('messages.checkRedFields'));
          }
        }
        /**
        *
        */
        $transport = Transport::create($validator->getData());
        return $this->doRedirect($request, "/admin/transport/")
        ->with('successMessage', trans('transport.created', [
          'name' => $transport->spanish,
          'code' => $transport->id
        ]));
    }
    /**
     *
     */
    public function delete(Request $request, $id) {
      $redirect = $this->doRedirect($request, '/admin/transport');
      $transport = Transport::find($id);
      if(is_null($transport)) {
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
    * Borrar un puerto
    */
    public function deletePort(Request $request, $id) {

      $port = DetailsTransport::find($id);
      /**
      *
      */
      if(is_null($port)) {
        return response()->json([
          "message" => "true"
        ]);
      } else {
        $port->delete();
        return response()->json([
          "message" => "true"
        ]);
      }
    }
    /**
    *
    */
    public function readjsondetailstransport(Request $request, $id) {

       $detailsport = DB::table('detailstransport')->where('transport', $id)->get();
       $vars = [
        'detailsport' => $detailsport
       ];
       /**
       *
       */
       return $vars;
    }
    /**
     * Validate Data
     */
    private function validateData(Request $request) {
      return Validator::make($this->clear($request->all()), [
        'spanish'      => 'required|string|min:5|max:100',
        'price'        => 'required|numeric|min:0.1'
      ]);
    }

    /**
     * Validate Data Port
     */
    private function validateDataPort(Request $request) {
      return Validator::make($this->clear($request->all()), [
        'name'        => 'required|string|min:5|max:100',
        'description' => 'required|string|min:5|max:100'
      ]);
    }

    /**
     * Obtener puertos para el select
     */
     public function getPorts(Request $request) {
       $ports      = DetailsTransport::all();

       if ($ports) {
         $vars = [
          'message' => 'true',
          'ports' => $ports
         ];
       }else {
         $vars = [
          'message' => 'false'
         ];
       }
       /**
       *
       */
       return $vars;
     }
}
