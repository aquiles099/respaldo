<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Admin\Promotion;
use App\Models\Admin\Packages\Transport;
use App\Models\Admin\Security\UserType;
use Validator;


class PromotionController extends Controller {

    public function view(Request $request, $id) {
        $promotions = Promotion::find($id);
        $edit       = true;
        /**
        *
        */
        $vars = [
          'readonly'   => true,
          'promotions' => $promotions,
          'usersType'  => UserType::all(),
          'transports' => Transport::all(),
          'edit'       => $edit
        ];
        /**
        *
        */
        return view('pages.admin.promotions.view',$vars);
    }
    /**
     * Leer Detalles de Promociones
     */
    public function readDetails(Request $request, $id) {
      $this->checkAuthorization();
      return $this->details($request, $id, true);
    }

    /**
     * Buscar Detalles de Promociones
     */
    public function details(Request $request, $id, $readonly = false) {
      $session = $request->session()->get('key-sesion');
      /**
       * Sino hay ningun error redirige a la ruta indicada
       */
      if ($session == null) {
        return redirect('login');
      }
      /**
      *
      */
      $promotions = Promotion::find($id);
      /**
      *
      */
      if (is_null($promotions)) {
        return $this->doRedirect($request, '/admin/promotions')
          ->with('errorMessage', trans('promotion.notFound'));
      }
      /**
      *
      */
      $vars = [
        'readonly'   => $readonly,
        'promotions' => $promotions,
        'usersType'  => UserType::all(),
        'transports' => Transport::all(),
        'edit'       => true
      ];
      /**
       * Se obtiene la vista para editar
       */
      if($this->isGET($request)) {
        return view('pages.admin.promotions.edit', $vars);
      }

      /**
      * Se verifica la infomacion de los campos cuando se desea actualizar, se muestra mensaje de erro en caso de haberlo
      */
      $validator = $this->validateData($request);
      if (!is_null($validator)) {
        if ($validator->fails()) {
          return view('pages.admin.promotions.edit', $vars)->withErrors($validator)
           ->with('errorMessage', trans('messages.checkRedFields'));
        }
      }

      /**
      * Se actualiza la informacion, si es correcta se muestra un mensaje tipo 'success' en dado caso
      */
      $promotions->update($validator->getData());
      $promotions->save();
      return view('pages.admin.promotions.edit', $vars)->with('successMessage', trans('country.updated', [
        'name' => $promotions->name,
        'code' => $promotions->id
      ]));
    }

    /**
     * Listado de Promociones
     */
    public function index(Request $request)
    {
      $session = $request->session()->get('key-sesion');
      $this->checkAuthorization();
      $promotions = Promotion::orderBy('created_at', 'desc')->get();
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
        'promotions' => $promotions
      ];
      /**
      *
      */
      return view('pages.admin.promotions.list', $vars);
    }

    /**
     * Crear Promociones
     */
    public function create(Request $request)
    {
      $this->checkAuthorization();
      $vars = [
        'transports' => Transport::all(),
        'usersType'  => UserType::all()
      ];

      if ($this->isGET($request)) {
        return view('pages.admin.promotions.create', $vars);
      }
     /**
      * Guardar Promocion
      */
      $validator = $this->validateData($request);
      if (!is_null($validator)) {
        if ($validator->fails()) {
          return view('pages.admin.promotions.create', $vars)
            ->withErrors($validator)
            ->with('errorMessage', trans('messages.checkRedFields'));
        }
      }
     /**
      * Redirecciona a la ruta enviando en id, luego muestra el mensaje 'success'
      */
      $promotions = Promotion::create($request->all());
      return $this->doRedirect($request, "/admin/promotions/{$promotions->id}")->with('successMessage', trans('promotion.created', [
        'name' => $promotions->name,
        'id' => $promotions->code
      ]));
    }

    /**
     * Borrar una Promocion
     */
    public function delete(Request $request, $id)
    {
      $redirect = $this->doRedirect($request, '/admin/promotions');
      $promotions = Promotion::find($id);
      if(is_null($promotions)) {
        $redirect->with('errorMessage', trans('promotion.notFound'));
      } else {
        $promotions->delete();
        $redirect->with('successMessage', trans('promotion.deleted', [
          'name' =>  $promotions->name,
          'id'   =>  $promotions->id
        ]));
      }
      return $redirect;
    }

    /**
     * Validar Estructura de campos
     */
    private function validateData(Request $request)
    {
      return Validator::make($this->clear($request->all()), [
        'name'       => 'required|string|min:5|max:100',
        'value'      => 'required|string|min:1|max:255',
        'start_date' => 'required|string|min:8|max:10',
        'end_date'   => 'required|string|min:8|max:10'
      ]);
    }
}
