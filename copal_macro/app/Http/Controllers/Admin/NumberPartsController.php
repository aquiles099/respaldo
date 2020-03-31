<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Admin\NumberParts;
use Validator;



class NumberPartsController extends Controller
{
    public function index (Request $request)
    {
      $session     = $request->session()->get('key-sesion');
      $numberparts = NumberParts::orderBy('created_at', 'desc')->get();
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
          'numberparts' => $numberparts
      ];
      /**
      *
      */

      return view('pages.admin.numberparts.list',$vars);
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
        return view('pages.admin.numberparts.create',$vars);
      }
      /**
      *
      */
      if (!is_null($validator))
      {
        if ($validator->fails())
        {
          return view('pages.admin.numberparts.create')
            ->withErrors($validator)
            ->with('errorMessage', trans('messages.checkRedFields'));
        }
      }
      /**
      *
      */


      $numberparts = NumberParts::create($request->all());
      return $this->doRedirect($request, "/admin/numberparts/")->with('successMessage', trans('numberparts.created', [
        'name' => $numberparts->name,
        'code' => $numberparts->description,
      ]));
    }

    /**
    *
    */
    public function details (Request $request, $id, $readonly = false)
    {
      $session     = $request->session()->get('key-sesion');
      $numberparts = NumberParts::find($id);
      $edit        = true;


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
      if (is_null($numberparts))
      {
        return $this->doRedirect($numberparts, '/admin/numberparts')
                    ->with('errorMessage', trans('numberparts.notFound'));
      }
      /**
      *
      */
      $vars =
      [
        'numberparts' => $numberparts,
        'edit'        => $edit,
        'readonly'    => $readonly
      ];



      /**
       * Se obtiene la vista para editar
       */
      if($this->isGET($request))
      {
        return view('pages.admin.numberparts.view', $vars);
      }
      /**
      * Se verifica la infomacion de los campos cuando se desea actualizar, se muestra mensaje de erro en caso de haberlo
      */
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

      $numberparts->update($validator->getData());
      $numberparts->save();
      return response()->json([
      "message" => "true"
      ]);

    }

    /**
    *
    */
    public function readDetails(Request $request, $id)
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
      $redirect = $this->doRedirect($request, '/admin/numberparts');
      $numberparts = NumberParts::find($id);


      /**
      *
      */
      if(is_null($numberparts))
      {
        $redirect->with('errorMessage', trans('numberparts.notFound'));
      }
      else
      {
        $numberparts->delete();
        $redirect->with('successMessage', trans('numberparts.deleted',
        [
          'name' => $numberparts->name,
          'code' => $numberparts->code
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
        'name'       => 'required|string|min:3|max:100',
        'description'=> 'required|string|min:3|max:100'
      ]);
    }
}
