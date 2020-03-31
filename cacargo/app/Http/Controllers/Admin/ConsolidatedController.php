<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Client;
use App\Models\Admin\User;
use App\Models\Admin\Consolidated;
use App\Models\Admin\Package;
use App\Models\Admin\PackageConsolidated;
use Validator;
use App\Helpers\HConstants;

use DB;

/**
 *
 */
class ConsolidatedController extends Controller {

  /**
   *
   */
  public function readDetails(Request $request, $id) {
    return $this->details($request, $id, true);
  }
  /**
   *
   */
  public function deletePackage(Request $request, $id) {
    $session = $request->session()->get('key-sesion');

    $packageConsolidated = PackageConsolidated::find($id);
    $packageConsolidatedResponse = [];

    if(is_null($packageConsolidated)) {
      $packageConsolidatedResponse = [
        'error' => trans('consolidated.notFound')
      ];
    }
    else {
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
  public function addPackage(Request $request, $id) {
    $session = $request->session()->get('key-sesion');
    if (! is_null($session)) {
      $package = Package::byTracking($request->all()['tracking'])->first();
      $consolidatedData = [];
      if(!empty($package->id)) {
        $packageConsolidated = packageConsolidated::byPackage($package->id)->first();
        if(empty($packageConsolidated)) {
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
  public function details(Request $request, $id, $readonly = false) {
    $session = $request->session()->get('key-sesion');
    /**
    *
    */
    if ($session == null) {
      return redirect('login');
    }
    /**
    *
    */
    $consolidated = Consolidated::find($id);
    /**
    *
    */
    if(is_null($consolidated)) {
      return $this->doRedirect($request, '/admin/consolidated')
        ->with('errorMessage', trans('consolidated.notFound'));
    }
    /**
    *
    */
    $package = Package::byStatus(HConstants::EVENT_RECEIVED)->get();
    $packageConsolidated = PackageConsolidated::byConsolidated($consolidated->id)->get();
    /**
    *
    */
    $vars =  [
      'consolidated'        => $consolidated,
      'packageConsolidated' => $packageConsolidated,
      'readonly'            => $readonly,
      'package'             => $package
    ];
    /**
    *
    */
    if ($this->isGET($request)) {
      return view('pages.admin.consolidated.edit',$vars);
    }
    /**
    *
    */
    $validator = $this->validateData($request);
    if (!is_null($validator)) {
      if ($validator->fails()) {
        return view('pages.admin.consolidated.edit', $vars)->withErrors($validator)
          ->with('errorMessage', trans('messages.checkRedFields'));
      }
    }
    /**
    * Actualizar el consolidado
    */
    $consolidatedData = [
      'description' => $request->all()['description'],
      'observation' => $request->all()['observation'],
      'status'      => empty($request->all()['status']) ? false : true
    ];
    /**
    *
    */
    $consolidated->update($consolidatedData);
    $consolidated->save();
    /**
    * se borran los paquetes agregados al consolidado actual
    */
    $package_consolidated  = DB::table('package_consolidated')->where('consolidated','=', $consolidated->id)->delete();
    /**
    *se obtienen todos los paquetes relacionados con el consolidado actual
    */
    $packages_consolidates = Package::byConsolidated($consolidated->id)->get();
    /**
    * se recorre la coleccion de paquetes asociados al consolidado actual y se modifica la columna 'consolidated' a null
    */
    foreach ($packages_consolidates as $key => $value) {
      $value->consolidated = null;
      $value->update();
      $value->save();
    }
    /**
    * se recorre el request paver obtener los id de los paquetes 
    */
    $package_consolidated = [];
    foreach($request->all() as $value){
      if(strstr($value, 'wr')) {
        /**
        * 1) se busca el paquete con el id resultante de cortar la cadena
        * 2) se edita la columna 'consolidated'
        * 3) se guarda el resultado
        */
        $id = substr($value, -1);
        $package = Package::find($id);
        $package->consolidated = $consolidated->id;
        $package->update();
        $package->save();
        /**
        *
        */
        $package_consolidated = [
          'package'      => substr($value, -1),
          'consolidated' => $consolidated->id
        ];
        /**
        *
        */
        $consolidated_detail = PackageConsolidated::create($package_consolidated);
      }
    }
    /**
    *
    */
    return redirect("/admin/consolidated/$consolidated->id")->with('successMessage', trans('consolidated.updated', [
      'id'   => $consolidated->id,
      'code' => $consolidated->code
    ]));
  }
  /**
   * Creacion
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
    $vars = [

    ];
    /**
    *
    */
    if($this->isGET($request)) {
      return view('pages.admin.consolidated.create', $vars);
    }
    /**
    * Valdar el consolidado
    */
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
    /**
    *
    */
    $consolidatedData = [
      'description' => $request->all()['description'],
      'observation' => $request->all()['observation'],
      'status'      =>true,
      'last_event'  =>'1'
        ];
    /**
    *
    */
    $consolidated = Consolidated::create($consolidatedData);
    /**
    *
    */
    return redirect("/admin/consolidated/$consolidated->id")->with('successMessage', trans('consolidated.created', [
      'id'   => $consolidated->id,
      'code' => $consolidated->code
    ]));
  }
  /**
   * Listado
   */
  public function index(Request $request)
  {
    $session = $request->session()->get('key-sesion');
    $this->checkAuthorization();
    $this->setCurrentPage($request->query('page'));
    $page = Consolidated::paginate($this->pageSize);
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
    if($page->lastPage() < $page->currentPage())
    {
      $this->setCurrentPage($page->lastPage());
      $page = Consolidated::paginate($this->pageSize);;
    }
    $query = [];
    if($request->query('search'))
    {
      $query['search'] = $request->query('search');
    }
    $page->appends($query);
    return view('pages.admin.consolidated.list', [
      'data' => $page
    ])->with('successMessage', $request->query('search') ? "Realizar el filtrado de la data : {$query['search']}": null);
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
        'id'   => $consolidated->id,
        'code' => $consolidated->code
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
          'description'       => 'required|string|min:5|max:100|unique:consolidated,description',
          'observation'       => 'string|min:5|max:255'
        ]);
      }
    }
    else {
      return Validator::make($this->clear($request->all()), [
        'description'       => 'required|string|min:5|max:100|unique:consolidated,description',
        'observation'       => 'string|min:5|max:255'
      ]);
    }
  }

}
