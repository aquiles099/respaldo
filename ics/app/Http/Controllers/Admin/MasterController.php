<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Admin\Package;
use App\Models\Admin\Pickup;
use App\Models\Admin\User;

class MasterController extends Controller
{
  public function create(Request $request)
  {
  	$session = $request->session()->get('key-sesion');
    $users   = User::all();
    $large   = true;
    $cargo   = null;
    /**
    * Verificacion de ruta de manera provisional
    */
  /*  if ($id > 0 && $id < 3)
    {
      if ($id == 1)
      {
        $cargo = Package::all();
      }
      if ($id == 2)
      {
        $cargo = Pickup::all();
      }
    }
    else
    {
      return redirect('notFound');
    }
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
      'users' => $users,
      'cargo' => $cargo,
      'large' => $large,
      'type'  =>2
      
    ];
    /**
    *
    */
    
    if ($this->isGET($request))
    {
      return view('pages.admin.masterBill.create', $vars);
    }

  }

  public function getdata(Request $request,$id)
  {
  	$session = $request->session()->get('key-sesion');
    	if ($id > 0 && $id < 3)
	    {
	      if ($id == 1)
	      {
	        $cargo = Package::all();
	      }
	      if ($id == 2)
	      {
	        $cargo = Pickup::all();
	      }
	    }
	    else
	    {
	      return redirect('notFound');
	    }
	    /**
	    *  Se valida que la sesion este activa
	    */
	    if ($session == null)
	    {
	      return redirect('login');
	    }

	    $vars = [
		  'cargo' => $cargo
		      
		];

		return $vars;

  }
}
