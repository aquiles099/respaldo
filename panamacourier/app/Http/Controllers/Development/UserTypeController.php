<?php namespace App\Http\Controllers\Development;

use \Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Models\Admin\Security\UserType;

/**
 * Description of RoutesController
 *
 * @author jrodriguez
 */
class UserTypeController extends Controller {

  /**
   *
   */
  public function generateFile(){
     $search = ['\''];
     $replace = [''];
     $file = "<?php\n  namespace App\\Helpers;\n\n";
     $file .= "  class HUserType {\n";
     foreach(UserType::get() as $userType){
         $file .= "    const ";
         $file .= preg_replace('/[^a-zA-Z_]/', '', preg_replace('/\s/', '_', str_replace($search, $replace, strtoupper($userType->english))));
         $file .= " = ";
         $file .= $userType->id. ";\n";
     }
     $file .= "  }\n";
     return $file;
  }

}
