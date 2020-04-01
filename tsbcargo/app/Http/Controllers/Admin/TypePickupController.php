<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Admin\TypePickup;
use Validator;


class TypePickupController extends Controller
{
    public function index (Request $request)
    {
      $session = $request->session()->get('key-sesion');
      $tipepickup = TypePickup::orderBy('created_at', 'desc')->get();
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
      $vars =
      [
          'tipepickup' => $tipepickup
      ];
      /**
      *
      */

      return view('pages.admin.typepickup.list',$vars);
    }

    /**
    *
    */
    public function create (Request $request)
    {
      $session   = $request->session()->get('key-sesion');
      $validator = $this->validateData($request);
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
      $vars =
      [

      ];
      /**
      *
      */
      if($this->isGET($request))
      {
        return view('pages.admin.typepickup.create',$vars);
      }
      /**
      *
      */
      if (!is_null($validator))
      {
        if ($validator->fails())
        {
          return view('pages.admin.typepickup.create')
            ->withErrors($validator)
            ->with('errorMessage', trans('messages.checkRedFields'));
        }
      }
      /**
      *
      */


      $tpickup = TypePickup::create($request->all());
      return $this->doRedirect($request, "/admin/tpickup/")->with('successMessage', trans('typepickup.created', [
        'name' => $tpickup->name,
        'code' => $tpickup->code,
      ]));
    }

    /**
    *
    */
    public function details (Request $request, $id, $readonly = false)
    {
      $session    = $request->session()->get('key-sesion');
      $typepickup = TypePickup::find($id);
      $edit       = true;


      /**
      *
      */
      if ($session == null)
      {
        return redirect('login');
      }
      /**
      *
      */
      if (is_null($typepickup))
      {
        return $this->doRedirect($container, '/admin/typepickup')
                    ->with('errorMessage', trans('typepickup.notFound'));
      }
      /**
      *
      */
      $vars =
      [
        'typepickup'  => $typepickup,
        'edit'        => $edit,
        'readonly'    => $readonly
      ];



      /**
       * Se obtiene la vista para editar
       */
      if($this->isGET($request))
      {
        return view('pages.admin.typepickup.view', $vars);
      }
      /**
      * Se verifica la infomacion de los campos cuando se desea actualizar, se muestra mensaje de erro en caso de haberlo
      */
     /* $validator = $this->validateData($request);
      if (!is_null($validator))
      {
        if ($validator->fails())
        {
          return view('pages.admin.typepickup.edit', $vars)->withErrors($validator)
           ->with('errorMessage', trans('messages.checkRedFields'));
        }
      }*/

      $validator = $this->validateData($request);
      if (!is_null($validator)) {
        if ($validator->fails()) {
           return response()->json([
             "message" => "false",
             "alert"   => $validator->messages()
           ]);
        }
      }
      /**
      * Se actualiza la informacion, si es correcta se muestra un mensaje tipo 'success' en dado caso
      */

      $typepickup->update($validator->getData());
      $typepickup->save();
      return response()->json([
        "message" => "true"
      ]);
    }

    /**
    *
    */
    public function readDetails (Request $request, $id)
    {
      $session = $request->session()->get('key-sesion');
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
      return $this->details($request, $id, true);
    }

    /**
     *
     */
    public function delete(Request $request, $id)
    {
      $redirect = $this->doRedirect($request, '/admin/typepickup');
      $tipepickup = TypePickup::find($id);
      /**
      *
      */
      if(is_null($tipepickup))
      {
        $redirect->with('errorMessage', trans('typepickup.notFound'));
      }
      else
      {
        $tipepickup->delete();
        $redirect->with('successMessage', trans('typepickup.deleted',
        [
          'name' => $tipepickup->name,
          'code' => $tipepickup->code
        ]));
      }
      /**
      *
      */
      return $redirect;
    }

    /**
     *
     */
    private function validateData(Request $request)
    {
      return Validator::make($this->clear($request->all()),
      [
        'name'         => 'required|string|min:3|max:100',
        'description'  => 'required|string|min:3|max:100'
      ]);
    }
}
