<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Price;
use App\Helpers\HUserType;
use App\Helpers\HProfileType;
use App\Helpers\HYears;
use App\Helpers\HAccess;
use Validator;

class PriceController extends Controller {
  /**
  *
  */
  public function __construct (Request $request) {
    $this->middleware('requireAccess:' . HAccess::PRICES);
  }
  /**
  * Ver los precios
  */
  public function index (Request $request) {
    $prices = Price::all();
    /**
    *
    */
    if ($request->session()->get('key-sesion')['type'] != HUserType::MASTER ) {
      return redirect('/');
    }
    /**
    *
    */
    return view('pages.admin.price.index', compact('prices'));
  }
  /**
  * Editar precios
  */
  public function edit (Request $request) {

    $user = $request->session()->get('key-sesion')['data'];
    $prices = Price::all();
    /**
    *
    */
    if ($request->session()->get('key-sesion')['type'] != HUserType::MASTER ) {
      return redirect('/');
    }
    /**
    *
    */
    if ($this->isGet($request)) {
      return view('pages.admin.price.edit', compact('prices'));
    }
    /**
    *
    */
    $validator = $this->validateData($request);
    if (!is_null($validator)) {
      if ($validator->fails()) {
        return view('pages.admin.price.edit', compact('prices'))->withErrors($validator)->with('errorMessage', trans('messages.founderrors'));

      }
    }
    $all = Price::byAll(HProfileType::BASIC, HProfileType::PROFESSIONAL)->delete();
    /**
    *
    */
    $data = [
      ['type' => HProfileType::BASIC       , 'years' => HYears::ONE    , 'monthly' => $request->basic_montly_1_year       , 'annual' => $request->basic_annual_1_year],
      ['type' => HProfileType::BASIC       , 'years' => HYears::TWO    , 'monthly' => $request->basic_montly_2_year       , 'annual' => $request->basic_annual_2_year],
      ['type' => HProfileType::BASIC       , 'years' => HYears::TRHEE  , 'monthly' => $request->basic_montly_3_year       , 'annual' => $request->basic_annual_3_year],
      ['type' => HProfileType::PROFESSIONAL, 'years' => HYears::ONE    , 'monthly' => $request->professional_montly_1_year, 'annual' => $request->professional_annual_1_year],
      ['type' => HProfileType::PROFESSIONAL, 'years' => HYears::TWO    , 'monthly' => $request->professional_montly_2_year, 'annual' => $request->professional_annual_2_year],
      ['type' => HProfileType::PROFESSIONAL, 'years' => HYears::TRHEE  , 'monthly' => $request->professional_montly_3_year, 'annual' => $request->professional_annual_3_year],
    ];
    /**
    *
    */
    foreach ($data as $key => $row) {
      Price::create($row);
    }
    /**
    *
    */
    \Log::info('precios actualizados por: '.$user->email);
    return $this->doRedirect($request, '/admin/prices')->with('successMessage', trans('prices.updated'));
  }
  /**
  * Validate Data
  */
  private function validateData (Request $request, $update = false) {
      return Validator::make($request->all(), [
        'basic_montly_1_year'        => 'required|numeric|min:1',
        'basic_montly_2_year'        => 'required|numeric|min:1',
        'basic_montly_3_year'        => 'required|numeric|min:1',
        'basic_annual_1_year'        => 'required|numeric|min:1',
        'basic_annual_2_year'        => 'required|numeric|min:1',
        'basic_annual_3_year'        => 'required|numeric|min:1',
        'professional_montly_1_year' => 'required|numeric|min:1',
        'professional_montly_2_year' => 'required|numeric|min:1',
        'professional_montly_3_year' => 'required|numeric|min:1',
        'professional_annual_1_year' => 'required|numeric|min:1',
        'professional_annual_2_year' => 'required|numeric|min:1',
        'professional_annual_3_year' => 'required|numeric|min:1'
      ]);
    }
}
