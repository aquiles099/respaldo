<?php namespace App\Http\Controllers\Development;

use \Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Models\Admin\Security\Role;

/**
 * Description of RoutesController
 *
 * @author jrodriguez
 */
class RoleController extends Controller {

  /**
   *
   */
  public function generateFile(){
     $search = [' ', '\''];
     $replace = ['',''];
     $file = "<?php\n  namespace App\Helpers;\n\n";
     $file .= "  class HRole {\n";
     foreach(Role::get() as $role){
         $file .= "    static public $";
         $file .= preg_replace('/\W/', '', str_replace($search, $replace, strtoupper($role->name)));
         $file .= " = ";
         $file .= $role->id. ";\n";
     }
     $file .= "  }\n";
     return $file;
  }

}
