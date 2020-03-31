<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Admin\Package;
use App\Models\Admin\User;
use App\Models\Admin\Promotion;
use App\Models\Admin\Tax;
use App\Models\Admin\Transport;
use App\Models\Admin\Category;
use App\Models\Admin\Company;

class ClientAttentionController extends Controller
{
  public function index (Request $request)
  {
    $session  = $request->session()->get('key-sesion');
    /**
    * se valida session
    */
    if ($session == null)
    {
      return redirect('/');
    }
    /**
    * Show view
    */
    return view('pages.admin.clientAttention.dashboard');
  }
  /**
  * Buscar Usuarios
  */
  public function searchUsers(Request $request)
  {
    $session  = $request->session()->get('key-sesion');
    $users = User::byUserType(1)->get();
    /**
    * se valida session
    */
    if ($session == null)
    {
      return redirect('/');
    }
    /**
    * Vars on the view
    */
    $vars =
    [
      'users' => $users
    ];
    /**
    * Show view
    */
    return view('pages.admin.clientAttention.users', $vars);
  }
  /**
  * Buscar Paquetes
  */
  public function searchPackages(Request $request)
  {
    $session  = $request->session()->get('key-sesion');
    $packages = Package::all();
    /**
    * se valida session
    */
    if ($session == null)
    {
      return redirect('/');
    }
    /**
    * Vars on the view
    */
    $vars =
    [
      'packages' => $packages
    ];
    /**
    * Show view
    */
    return view('pages.admin.clientAttention.packages', $vars);
  }
  /**
  * Buscar Promociones
  */
  public function searchPromotions(Request $request)
  {
    $session  = $request->session()->get('key-sesion');
    $promotions = Promotion::all();
    /**
    * se valida session
    */
    if ($session == null)
    {
      return redirect('/');
    }
    /**
    * Vars on the view
    */
    $vars =
    [
      'promotions' => $promotions
    ];
    /**
    * Show view
    */
    return view('pages.admin.clientAttention.promotions', $vars);
  }
  /**
  * Buscar Impuestos
  */
  public function searchTaxes(Request $request)
  {
    $session  = $request->session()->get('key-sesion');
    $taxes = Tax::all();
    /**
    * se valida session
    */
    if ($session == null)
    {
      return redirect('/');
    }
    /**
    * Vars on the view
    */
    $vars =
    [
      'taxes' => $taxes
    ];
    /**
    * Show view
    */
    return view('pages.admin.clientAttention.taxes', $vars);
  }
  /**
  * Buscar Servicios
  */
  public function searchServices(Request $request)
  {
    $session  = $request->session()->get('key-sesion');
    $services = Transport::all();
    /**
    * se valida session
    */
    if ($session == null)
    {
      return redirect('/');
    }
    /**
    * Vars on the view
    */
    $vars =
    [
      'services' => $services
    ];
    /**
    * Show view
    */
    return view('pages.admin.clientAttention.services', $vars);
  }
  /**
  * Buscar categories
  */
  public function searchCategories(Request $request)
  {
    $session  = $request->session()->get('key-sesion');
    $categories = Category::all();
    /**
    * se valida session
    */
    if ($session == null)
    {
      return redirect('/');
    }
    /**
    * Vars on the view
    */
    $vars =
    [
      'categories' => $categories
    ];
    /**
    * Show view
    */
    return view('pages.admin.clientAttention.categories', $vars);
  }
  /**
  * Buscar companies
  */
  public function searchCompanies(Request $request)
  {
    $session  = $request->session()->get('key-sesion');
    $companies = Company::all();
    /**
    * se valida session
    */
    if ($session == null)
    {
      return redirect('/');
    }
    /**
    * Vars on the view
    */
    $vars =
    [
      'companies' => $companies
    ];
    /**
    * Show view
    */
    return view('pages.admin.clientAttention.companies', $vars);
  }
}
