<?php

namespace App\Http\Controllers\Admin\Packages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Packages\PriceGroup;
use Validator;

/**
 *
 */
class PriceGroupsController extends Controller {
  const LIST_PATH = '/admin/price_groups';

/*
  const EDIT_PATH = '/admin/security/access/%d';
  const EDIT_VIEW = 'pages.admin.security.access.edit';

*/

  const CREATE_VIEW = 'pages.admin.packages.price_group.create';
  const LIST_VIEW = 'pages.admin.packages.price_group.list';


///var/www/html/murano-app/resources/views/pages/admin/packages/price_groups/list.blade.php

/**
 * Creacion
 */
public function create(Request $request) {
  $this->checkAuthorization();
  $view = view(self::CREATE_VIEW);
  if($this->isGET($request)) {
    return $view;
  }
  $validator = $this->validateData($request);
  if (!is_null($validator) && $validator->fails()) {
    return $view->withErrors($validator)->with('errorMessage', trans('messages.checkRedFields'));
  }
  $data = $validator->getData();
  if ($data['min'] > $data['max']) {

  } else {

  }




  $access = Access::create($request->all());
  return $this->doRedirect($request, sprintf(self::EDIT_PATH, $access->id))->with('successMessage', trans('access.created', [
    'name' => $access->name,
    'code' => $access->id
  ]));
}


  /**
   * Listado
   */
  public function index(Request $request) {
    $this->checkAuthorization();
    $this->setCurrentPage($request->query('page'));
    $page = PriceGroup::language()->paginate($this->pageSize);
    if($page->lastPage() < $page->currentPage()) {
      $this->setCurrentPage($page->lastPage());
      $page = PriceGroup::language()->paginate($this->pageSize);
    }
    $query = [];
    if($request->query('search')) {
      $query['search'] = $request->query('search');
    }
    $page->appends($query);
    return view(self::LIST_VIEW, [
      'data' => $page
    ])->with('successMessage', $request->query('search') ? "Realizar el filtrado de la data : {$query['search']}": null);
  }

  /**
   *
   */
  private function validateData(Request $request, $priceGroup = null) {
    $validator = Validator::make($this->clear($request->all()), [
      'spanish' => 'required|string|min:3|max:100|unique:price_group,spanish'.($priceGroup == null ? '' : ('')),
      'english' => 'required|string|min:3|max:100|unique:price_group,english'.($priceGroup == null ? '' : ('')),
      'min'     => 'required|numeric|min:0',
      'max'     => 'required|numeric|min:0',
    ]);
    return $validator;
  }

}
