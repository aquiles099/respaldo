<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Client;
use App\Models\Admin\User;
use App\Models\Admin\Consolidated;
use App\Models\Admin\Transport;
use App\Models\Admin\Office;
use App\Models\Admin\DetailsTransport;
use App\Models\Admin\Package;
use App\Models\Admin\PackageConsolidated;
use Validator;
use DB;

/**
 *
 */
class ConsolidatedController extends Controller {

  /**
   *
   */
  public function readDetails(Request $request, $id)
  {
    return $this->details($request, $id, true);
  }

  /**
   *
   */
  public function deletePackage(Request $request, $id)
  {
    $session = $request->session()->get('key-sesion');

    $packageConsolidated = PackageConsolidated::find($id);
    $packageConsolidatedResponse = [];

    if(is_null($packageConsolidated))
    {
      $packageConsolidatedResponse = [
        'error' => trans('consolidated.notFound')
      ];
    }
    else
    {
      $packageConsolidated->delete();
      $packageConsolidatedResponse = [
        'error' => trans('consolidated.packageConsolidateDeleted')
      ];

      //Insertar paquete al log  con el evento 1 viniendo del 2
      $this->insertLog($packageConsolidated->package, 1,"",2,$session['data']->id);

    }
    return $packageConsolidatedResponse;
  }

  /**
   *
   */
  public function addPackage(Request $request, $id)
  {
    $session = $request->session()->get('key-sesion');
    if (! is_null($session))
    {
      $package = Package::byTracking($request->all()['tracking'])->first();
      $consolidatedData = [];
      if(!empty($package->id))
      {
        $packageConsolidated = packageConsolidated::byPackage($package->id)->first();
        if(empty($packageConsolidated))
        {
          $consolidated = packageConsolidated::create([
            'package'        => $package->id,
            'consolidated'   => $request->all()['id'],
            'observation'    => $request->all()['packageObservation']
          ]);

          //Insertar paquete al log  con el evento 2 viniendo del 1
          $this->insertLog($package->id, 2,$request->all()['packageObservation'],1,$session['data']->id);

          $consolidatedData = [
            'id'          => $consolidated->id,
            'description' => $request->all()['description'],
            'tracking'    => $package->tracking,
            'observation' => $request->all()['packageObservation']
         ];
        }
        else {
          $consolidatedData = [
            'error' => "Paquete ya existe en un consolidado"
          ];
        }
      }
      else {
        $consolidatedData = [
          'error' => "Paquete no encontrado"
        ];
      }
    }
    else {
      $consolidatedData = [
        'error' => "Su sesión ha expirado. Necesita estar logueado para realizar esta acción"
      ];
    }
    return $consolidatedData;
  }
  /**
   *
   */
  public function details(Request $request, $id, $readonly = false)
  {
    $this->checkAuthorization();
    $consolidated = Consolidated::find($id);
    $packageConsolidated = packageConsolidated::byConsolidated($consolidated->id)->get();

    if(is_null($consolidated))
    {
      return $this->doRedirect($request, '/admin/consolidated')
        ->with('errorMessage', trans('consolidated.notFound'));
    }

    $vars =  [
      'consolidated'        => $consolidated,
      'packageConsolidated' => $packageConsolidated,
      'readonly'            => $readonly,
      'transports'          => Transport::all(),
      'offices'             => Office::all()
    ];

    if($this->isGET($request))
    {
      return view('pages.admin.consolidated.edit',$vars);
    }

    //Actualizar el consolidado
    $validator = $this->validateData($request);
    if (!is_null($validator))
    {
      if ($validator->fails())
      {
        return view('pages.admin.consolidated.edit', $vars)->withErrors($validator)
          ->with('errorMessage', trans('messages.checkRedFields'));
      }
    }

    ///Actualizar Consolidado
    ////////////////////////////////////////////////////////////////////////////
    $consolidatedData = [
      'code'              => $request->all()['code'],
      'description'       => $request->all()['description'],
      'observation'       => $request->all()['observation'],
      'status'            => empty($request->all()['status']) ? false : true,
      'office'            => $request->all()['office'],
      'transport'         => $request->all()['typeservice'],
      'detailstransport'  => '0'
    ];
    $consolidated->update($consolidatedData);
    $consolidated->save();

    return view('pages.admin.consolidated.edit', $vars)->with('successMessage', trans('consolidated.updated', [
      'description' => $consolidated->description,
      'id' => $consolidated->id
    ]));
  }

  /**
   * Creacion
   */
  public function create(Request $request)
  {
    $session = $request->session()->get('key-sesion');
    $this->checkAuthorization();
    /**
    *  Se valida que la sesion este activa
    */
    if ($session == null)
    {
      return redirect('login');
    }
    /**
    *
    */
   $vars = [
     'transports'    => Transport::all(),
     'offices'       => Office::all()
    ];

    if($this->isGET($request))
    {
      return view('pages.admin.consolidated.create', $vars);
    }

    //VALIDAR el consolidado
    $validator = $this->validateData($request);
    if (!is_null($validator))
    {
      if ($validator->fails())
      {
        return view('pages.admin.consolidated.create', $vars)
          ->withErrors($validator)
          ->with('errorMessage', trans('messages.checkRedFields'));
      }
    }
    ///GUARDAR EL CONSOLIDADO
    ////////////////////////////////////////////////////////////////////////////
    $consolidatedData = [
      'code'              => $request->all()['code'],
      'description'       => $request->all()['description'],
      'observation'       => $request->all()['observation'],
      'status'            =>true,
      'last_event'        =>'1',
      'office'            =>$request->all()['office'],
      'transport'         =>$request->all()['typeservice'],
      'detailstransport'  =>'0'
      ];


    $consolidated = Consolidated::create($consolidatedData);

    return redirect("/admin/consolidated")->with('successMessage', trans('consolidated.created', [
      'id' => $consolidated->id,
      'code' => $consolidated->code,
      'description' => $consolidated->description,
    ]));
  }

  /**
   * Listado
   */
  public function index(Request $request)
  {
    $session = $request->session()->get('key-sesion');
    $this->checkAuthorization();
    $consolidates = Consolidated::all();
    /**
    *
    */
    $vars = [
       'transports'    => Transport::all(),
       'offices'       => Office::all(),
       'consolidates'  => $consolidates
    ];
    /**
    *  Se valida que la sesion este activa
    */
    if ($session == null)
    {
      return redirect('login');
    }
    /**
    *
    */
    return view('pages.admin.consolidated.list', $vars);
  }
  /**
   *
   */
  public function delete(Request $request, $id)
  {
    $redirect = redirect("/admin/consolidated");
    $consolidated = Consolidated::find($id);
    if(is_null($consolidated))
    {
      $redirect->with('errorMessage', trans('consolidated.notFound'));
    }
    else
    {
      $consolidated->delete();
      $redirect->with('successMessage', trans('consolidated.deleted', [
        'tracking' => $consolidated->code,
        'id' => $consolidated->id,
        'description'=> $consolidated->description
      ]));
    }
    return $redirect;
  }

  /**
   *
   */
  private function validateData(Request $request)
  {
    if (!empty($request->all()['_method']))
    {
      if ($request->all()['_method'] === "patch")
      {
        return Validator::make($this->clear($request->all()), [
          'observation'       => 'string|min:5|max:255'
        ]);
      }
      else {
        return Validator::make($this->clear($request->all()), [
          'code'              => 'required|string|min:5|max:100|unique:consolidated,code',
          'description'       => 'required|string|min:5|max:100|unique:consolidated,description',
          'observation'       => 'string|min:5|max:255'
        ]);
      }
    }
    else {
      return Validator::make($this->clear($request->all()), [
        'code'              => 'required|string|min:5|max:100|unique:consolidated,code',
        'description'       => 'required|string|min:5|max:100|unique:consolidated,description',
        'observation'       => 'string|min:5|max:255'
      ]);
    }
  }




}
