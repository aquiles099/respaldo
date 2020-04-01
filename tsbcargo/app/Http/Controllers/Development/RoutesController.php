<?php namespace App\Http\Controllers\Development;

use \Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;


/**
 * Description of RoutesController
 *
 * @author jrodriguez
 */
class RoutesController extends Controller {

    /**
     *
     */
    public function index(){
        return view('routes', ['collection' => Route::getRoutes()]);
    }
}
