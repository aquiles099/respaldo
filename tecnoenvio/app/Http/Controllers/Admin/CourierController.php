<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Courier;
use Validator;

class CourierController extends Controller
{
  /**
  * Test function for edit (VS)
  */
    public function edit(Request $request, $id)
    {
      $courier = Courier::find($id);
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
             "alert"   => "NO SE HA PODIDO ACTUALIZAR"
           ]);
        }
      }
      $courier->update($request->all());
      $courier->save();
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
    public function details(Request $request, $id, $readonly = false)
    {
      $this->checkAuthorization();
      $courier = Courier::find($id);
      if(is_null($courier))
      {
        return $this->doRedirect($courier, '/admin/courier')
          ->with('errorMessage', trans('courier.notFound'));
      }
      $vars = [
        'courier' => $courier,
        'readonly' => $readonly
      ];
      if($this->isGET($request)) {
        return view('pages.admin.courier.view', $vars);
      }
    }

   /**
    * Create Courier
    */
    public function create(Request $request)
    {
        $session = $request->session()->get('key-sesion');
        $this->checkAuthorization();
        $readonly = false;
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
            'readonly' => $readonly
        ];
        if($this->isGET($request)) {
          return view('pages.admin.courier.create',$vars);
        }

        $validator = $this->validateData($request);
        if (!is_null($validator)) {
          if ($validator->fails()) {
            return view('pages.admin.courier.create',$vars)
              ->withErrors($validator)
              ->with('errorMessage', trans('messages.checkRedFields'));
          }
        }
        ////////////////////////////////////////////////////////////////////////////
        $courier = Courier::create($validator->getData());
        return $this->doRedirect($request, "/admin/courier/")->with('successMessage', trans('courier.created', [
          'name' => $courier->name,
          'code' => $courier->id
        ]));
    }

   /**
    * Show List
    */
    public function index(Request $request)
    {
      $session = $request->session()->get('key-sesion');
      $this->checkAuthorization();
      $couriers = Courier::all();
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
        'couriers' => $couriers
      ];
      /**
      *
      */
      return view('pages.admin.courier.list', $vars);

    }

    /**
     * Delete Rows
     */
    public function delete(Request $request, $id)
    {
      $redirect = $this->doRedirect($request, '/admin/courier');
      $courier = Courier::find($id);
      if(is_null($courier))
      {
        $redirect->with('errorMessage', trans('courier.notFound'));
      }
      else
      {
        $courier->delete();
        $redirect->with('successMessage', trans('courier.deleted', [
          'name' => $courier->name,
          'code' => $courier->id
        ]));
      }
      return $redirect;
    }

    /**
    * Validator
    */
    private function validateData(Request $request) {
        return Validator::make($this->clear($request->all()), [
          'name'       => 'required|string|min:3|max:100|',
        ]);
    }
}
