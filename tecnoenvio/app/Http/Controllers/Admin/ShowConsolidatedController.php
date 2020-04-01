<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\Admin\Package;
use App\Models\Admin\Consolidated;
use App\Models\Admin\PackageConsolidated;
use App\Models\Admin\Log;
use App\Models\Admin\Event;
use Validator;

/**
 *
 */
class ShowConsolidatedController extends Controller {

  /**
   * Creacion
   */
  public function create(Request $request,$id)
  {
    $session = $request->session()->get('key-sesion');
    $consolidated = Consolidated::find($id);
    $packageConsolidated = packageConsolidated::ByConsolidated($consolidated->id)->get();
    $event = Event::query()->where('id','>=',$consolidated->last_event)->get();
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
      'consolidated'        => $consolidated,
      'packageConsolidated' => $packageConsolidated,
      'event'               => $event
    ];

    if($this->isGET($request)) {
      return view('pages.admin.showconsolidated.create', $vars);
    }
    /**
    *
    */
    $validator = $this->validateData($request);
    if (!is_null($validator)) {
      if ($validator->fails()) {
        return view('pages.admin.showconsolidated.create', $vars)
          ->withErrors($validator)
          ->with('errorMessage', trans('messages.checkRedFields'));
      }
    }
    /**
    *
    */
    $session = $request->session()->get('key-sesion');
    /**
    *
    */
    foreach ($packageConsolidated as &$row) {
        $this->insertLog($row->package, $request->all()['event'], '', $row->getPackage['last_event'], $session['data']->id);
    }
    /**
    *
    */
    $consolidated->update(['last_event' => $request->all()['event']]);
    $consolidated->save();
    /**
    *
    */
    return response()->json([
        "message" => "true"
    ]);
    /**
    *
    */
  }

  /**
   *
   */
  private function validateData(Request $request) {
    return Validator::make($this->clear($request->all()), []);
  }

}
