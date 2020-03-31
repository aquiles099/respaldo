<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Admin\Container;
use Validator;

class ContainerController extends Controller
{
    //
    public function index (Request $request){
      $session = $request->session()->get('key-sesion');
      $container = Container::all();
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
          'container' => $container
      ];
      /**
      *
      */
      return view('pages.admin.container.list',$vars);
    }

    /**
    *
    */
    public function create (Request $request){
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
        return view('pages.admin.container.create',$vars);
      }
      /**
      *
      */
      if (!is_null($validator))
      {
        if ($validator->fails())
        {
          return view('pages.admin.container.create')
            ->withErrors($validator)
            ->with('errorMessage', trans('messages.checkRedFields'));
        }
      }
      /**
      *
      */
      $container = Container::create($request->all());
      return $this->doRedirect($request, "/admin/containers/")->with('successMessage', trans('container.created', [
        'name' => $container->name,
        'code' => $container->code
      ]));
    }

    /**
    *
    */
    public function details (Request $request, $id, $readonly = false){
      $session   = $request->session()->get('key-sesion');
      $container = Container::find($id);
      $edit      = true;
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
      if (is_null($container))
      {
        return $this->doRedirect($container, '/admin/containers')
                    ->with('errorMessage', trans('container.notFound'));
      }
      /**
      *
      */
      $vars =
      [
        'container'  => $container,
        'edit'       => $edit,
        'readonly'   => $readonly
      ];
      /**
       * Se obtiene la vista para editar
       */
      if($this->isGET($request))
      {
        return view('pages.admin.container.view', $vars);
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
      $container->update($validator->getData());
      $container->save();
      return response()->json([
        "message" => "true"
      ]);
    }

    /**
    *
    */
    public function readDetails (Request $request, $id){
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
    public function delete(Request $request, $id){
      $redirect = $this->doRedirect($request, '/admin/containers');
      $container = Container::find($id);
      /**
      *
      */
      if(is_null($container))
      {
        $redirect->with('errorMessage', trans('container.notFound'));
      }
      else
      {
        $container->delete();
        $redirect->with('successMessage', trans('container.deleted',
        [
          'name' => $container->name,
          'code' => $container->code
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
        'name'  => 'required|string|min:3|max:100|unique:container,name'
      ]);
    }
}
