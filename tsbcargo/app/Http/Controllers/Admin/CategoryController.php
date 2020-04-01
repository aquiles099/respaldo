<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\Admin\TaxCategory;
use App\Models\Admin\Tax;
use Validator;
use DB;

/**
 *
 */
class CategoryController extends Controller {

  /**
  * Test function for edit (VS)
  */
  public function edit(Request $request, $id)
  {
    $category     = Category::find($id);
    $validator    = $this->validateData($request);
    $taxes        = Tax::byStatus(1)->get();
    $taxCategory  = DB::table('tax_category')->where('category','=',$id)->delete();
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
    /**
    *
    */
    $category->update($request->all());
    $category->save();
    /**
    *
    */
    foreach ($taxes as $tax)
    {
      (isset($request->all()['tax'.$tax->id])) ? $this->insertTaxCategory($category->id, $tax->id) : '' ;
    }
    /**
    *
    */
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
    $category    = Category::find($id);
    $taxes       = Tax::all();
    $taxCategory = TaxCategory::byCategory($id)->get();
    /**
    *
    */
    if(is_null($category))
    {
      return $this->doRedirect($request, '/admin/category')
        ->with('errorMessage', trans('category.notFound'));
    }
    /**
    *
    */
    $vars =  [
      'category'    => $category,
      'readonly'    => $readonly,
      'taxes'       => $taxes,
      'taxCategory' => $taxCategory
    ];
    /**
    *
    */
    if($this->isGET($request))
    {
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
    $taxes = Tax::byStatus(1)->get();
    /**
    *
    */
    $vars = [
      'taxes' => $taxes
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
    if($this->isGET($request)) {
      return view('pages.admin.category.create', $vars);
    }
    /**
    * Validar los datos de la categoria
    */
    $validator = $this->validateData($request);
    if (!is_null($validator))
    {
      if ($validator->fails())
      {
        return view('pages.admin.category.create', $vars)
          ->withErrors($validator)
          ->with('errorMessage', trans('messages.checkRedFields'));
      }
    }
    /**
    * Guardar datos de categoria
    */
    $category = Category::create($request->all());
    /**
    * se obtiene la ultima categoria para crear los nuevos registros en taxCategory
    */
    $lastCategory = Category::all()->last()->id;
    /**
    * se recorre el arreglo de impuestos y se comparan con los seleccionados
    */
    foreach ($taxes as $tax)
    {
      (isset($request->all()['tax'.$tax->id])) ? $this->insertTaxCategory($lastCategory, $tax->id) : '' ;
    }
    /**
    * se retorna la vista con mensaje success
    */
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
  *Funcion que retorna un listado de los impuestos dado la categoria.
  */
  public function readtaxcategory(Request $request, $id)
    {

       $taxcat = DB::table('tax_category')
            ->join('tax', 'tax_category.tax', '=', 'tax.id')
            ->select('tax.id', 'tax.name', 'tax.value', 'tax.type')
            ->where('tax_category.category','=',$id)
            ->get();

       $vars =
       [
        'taxcategory' => $taxcat
       ];
       /**
       *
       */
       return $vars;
    }


  /**
   *
   */
  private function validateData(Request $request)
  {
    return Validator::make($this->clear($request->all()), [
      'label'       => 'required|string|min:5|max:100',
      'percentage'  => 'required|numeric|min:1'
    ]);
  }

}
