<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use Validator;

/**
 *
 */
class CategoryController extends Controller {

  /**
  * Test function for edit (VS)
  */
    public function edit(Request $request, $id)
    {
      $category = Category::find($id);
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
      $category->update($request->all());
      $category->save();
      return response()->json([
        "message" => "true"
      ]);
    }
  /**
   *
   */
  public function readDetails(Request $request, $id) {
    return $this->details($request, $id, true);
  }

  /**
   *
   */
  public function details(Request $request, $id, $readonly = false)
  {
    $this->checkAuthorization();
    $category = Category::find($id);

    if(is_null($category))
    {
      return $this->doRedirect($request, '/admin/category')
        ->with('errorMessage', trans('category.notFound'));
    }
    $vars =  [
      'category' => $category,
      'readonly' => $readonly
    ];

    if($this->isGET($request))
    {
      //dd($category);
      return view('pages.admin.category.view',$vars);
    }
  }

  /**
   * Creacion
   */
  public function create(Request $request)
  {
    $session = $request->session()->get('key-sesion');
    $this->checkAuthorization();
    $vars = [];
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
    if($this->isGET($request)) {
      return view('pages.admin.category.create', $vars);
    }
    //Guardar la category
    $validator = $this->validateData($request);
    if (!is_null($validator)) {
      if ($validator->fails()) {
        return view('pages.admin.category.create', $vars)
          ->withErrors($validator)
          ->with('errorMessage', trans('messages.checkRedFields'));
      }
    }
    ////////////////////////////////////////////////////////////////////////////
    $category = Category::create($request->all());
    return $this->doRedirect($request, "/admin/category/")->with('successMessage', trans('category.created', [
      'name' => $category->label,
      'code' => $category->id
    ]));
  }

  /**
   * Listado
   */
  public function index(Request $request)
  {
    $session = $request->session()->get('key-sesion');
    $this->checkAuthorization();
    $categories = Category::orderBy('created_at', 'desc')->get();
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
      'categories' => $categories
    ];
    return view('pages.admin.category.list', $vars);
  }

  /**
   *
   */
  public function delete(Request $request, $id)
  {
    $redirect = $this->doRedirect($request, '/admin/category');
    $category = Category::find($id);
    if(is_null($category)) {
      $redirect->with('errorMessage', trans('category.notFound'));
    } else {
      $category->delete();
      $redirect->with('successMessage', trans('category.deleted', [
        'name' => $category->label,
        'code' => $category->id
      ]));
    }
    return $redirect;
  }

  /**
   *
   */
  private function validateData(Request $request) {
    return Validator::make($this->clear($request->all()), [
      'label'       => 'required|string|min:5|max:100',
      'percentage'  => 'required|numeric|min:1'
    ]);
  }

}
