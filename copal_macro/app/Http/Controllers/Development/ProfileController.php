<?php namespace App\Http\Controllers\Development;

use \Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Models\Admin\Security\Profile;

/**
 * Description of RoutesController
 *
 * @author jrodriguez
 */
class ProfileController extends Controller {

  /**
   *
   */
  public function generateFile(){
     $search = [' ', '\''];
     $replace = ['',''];
     $file = "<?php\n  namespace App\Helpers;\n\n";
     $file .= "  class HProfile {\n";
     foreach(Profile::get() as $profile){
         $file .= "    static public $";
         $file .= preg_replace('/\W/', '', str_replace($search, $replace, strtoupper($profile->name)));
         $file .= " = ";
         $file .= $profile->id. ";\n";
     }
     $file .= "  }\n";
     return $file;
  }

}
