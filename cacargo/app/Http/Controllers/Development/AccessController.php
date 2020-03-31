<?php namespace App\Http\Controllers\Development;

use \Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Models\Admin\Security\Access;

/**
 * Description of RoutesController
 *
 * @author jrodriguez
 */
class AccessController extends Controller {

  /**
   *
   */
  public function generateFile() {
     $file = "<?php\n  namespace App\\Helpers;\n\n";
     $file .= "  class HAccess {\n";
     foreach(Access::get() as $access){
         $file .= "    static public $";
         $file .= $this->clearString($access->name);
         $file .= " = ";
         $file .= $access->id. ";\n";
     }
     $file .= "  }\n";
     return $file;
  }

}
