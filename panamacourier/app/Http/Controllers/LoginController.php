<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use Validator;
use Redirect;
use App\Models\Admin\Operator;
use App\Models\Admin\Configuration;
use App\Models\Admin\User;
use App\Models\Admin\Event;
use App\Helpers\HUserType;
use App\Models\Model\Security\Access;
use App\Models\Model\Security\Profile;
use App\Models\Model\Security\Role;
use \Mail;
use Crypt;
use DB;
use App;
use App\Helpers\HConstants;
use Cookie;
/**
 *
 */
class LoginController extends Controller {

  /**
   *
   */
  public function index(Request $request) {

    //App::setLocale('en');
    $session = $request->session()->get('key-sesion');
    /**
    * set cookie data
    */
    if (isset($request->cookie)) {
      if (is_null(Cookie::get('storage_data'))) {
        $pickup_time_cookie = 60;
        $pickup_data = [
            'type_package' => $request->type_package,
            'weight'       => $request->weight,
            'width'        => $request->width,
            'heigh'        => $request->heigh,
            'country'      => $request->country,
            'long'         => $request->long,
            'price'        => $request->price
        ];
        Cookie::queue('storage_data', $pickup_data, $pickup_time_cookie);
      }
    }
    /**
    *
    */
    if($session == null) {
      return view('pages.login');
    }
    /**
    *
    */
    return redirect('/');
  }
  /**
   *
   */

  public function logout(Request $request) {
    $request->session()->set('key-sesion', null);
    if (Cookie::get('storage_data')) {
      Cookie::queue(Cookie::forget('storage_data'));
    }
    return redirect('/');
  }
  /**
   * Verificar datos de logueo
   */
  public function login(Request $request) {

    //App::setLocale('en');
    /**
    * Se valida el formato de los datos ingresados
    */
    $configuration  = Configuration::find(HConstants::FIRST_CONFIGURATION); /** Siempre deberia ser una sola configuracion **/
    if ($configuration->time_zone == null) {
      $configuration->time_zone = 'America/Caracas (UTC-04:30)';
      $Configuration->save();
    }
    /**
    *
    */
    $redirect = $this->doRedirect($request, '/login');
    $validator = Validator::make($request->all(), [
     'username'  => 'required|string|min:5|max:40',
     'password'  => 'required|string|min:5|max:20'
    ]);
    /**
    *
    */
    if (!is_null($validator)) {
      if ($validator->fails()) {
          return view('pages.login')
            ->withErrors($validator);
      }
    }
    //se configura para que muestre los datos de todos los tiempos
    $dashboardDate = Configuration::all()->last();
    if (isset($dashboardDate->date_dashboard)) {
      $dashboardDate->date_dashboard = null;
      $dashboardDate->save();
    }
    /**
    * Obtener parametros
    */
    $username = $request->get('username');
    $password = $request->get('password');
    /**
    * Chequear si es un operador
    */
    $operatorsUser = Operator::query()->where('email','=', strtolower($username))->where('active', '!=', 0)->get();
    //dd($operatorsUser);

    if (!is_null($operatorsUser) && $operatorsUser->count() == 1) {
      $operator = $operatorsUser->get(0);
      if ($operator->checkPassword($password)) {
        $request->session()->set('key-sesion', [
          'type' => HUserType::OPERATOR,
          'data' => $operator
        ]);
        $date = getdate();

      $accesosresult=array();
      $idrole    = DB::table('profile_role')->where('profile','=',$operator->profile)->get();
      $array = json_decode(json_encode($idrole), True);
      foreach($array as $result) {
       $accesos = DB::table('role_access')->where('role','=',$result['role'])->get();
         $array = json_decode(json_encode($accesos), True);
          foreach($array as $result) {
             array_push($accesosresult,$result['access']);
          }
      }

      $configuration = Configuration::find(1);
      if ($operator->terms == false) {
        $operator->terms = true;
        $operator->save();
        $configuration->date_terms = $date['year'].'-'.$date['mon'].'-'.$date['mday'].' '.($date['hours']-4).':'.$date['minutes'].':'.$date['seconds'];
        $configuration->save();
        return redirect('/admin/configuration');
      }


      if($accesosresult[0]=="1"){
        return redirect('/');
      }elseif($accesosresult[0]=="2"){
        return redirect('/admin/package');
      }elseif($accesosresult[0]=="3"){
        return redirect('/admin/consolidated');
      }elseif($accesosresult[0]=="4"){
        return redirect('/admin/receipt/read');
      }elseif($accesosresult[0]=="5"){
        return redirect('/');
      }elseif($accesosresult[0]=="6"){
        return redirect('/admin/company');
      }elseif($accesosresult[0]=="7"){
        return redirect('/admin/operators');
      }elseif($accesosresult[0]=="8"){
        return redirect('/admin/clientAttention');
      }else{
        return redirect('/');
      }
        //return redirect('/');
      }
    }
    /**
    * Chequear si es un cliente
    */

    $users = User::query()->where("email", '=', strtolower($username))->where('active', '=', true)->get();
    if (!is_null($users) && $users->count() == 1) {
      $user = $users->get(0);
      if ($user->checkPassword($password)) {
        /**
        * Chequear si es 'persona natural'
        */
        if($user->user_type == 1) {
          $request->session()->set('key-sesion', [
            'type' => HUserType::NATURAL_PERSON,
            'data' => $user
          ]);
          return redirect('/');
        }
        /**
        * Chequear si es 'compañia'
        */
        if($user->user_type == 2) {
          $request->session()->set('key-sesion', [
            'type' => HUserType::COMPANY,
            'data' => $user
          ]);
          return redirect('/');
        }
        /**
        * Chequear si es 'empresa revendedora'
        */
        if($user->user_type == 3) {
          $request->session()->set('key-sesion', [
            'type' => HUserType::RESELLER,
            'data' => $user
          ]);
          return redirect('/');
        }
      }
    }
    /**
    * Se retorna la misma vista si no se encuentran registros
    */
    return view('pages.login')->with('errorMessage', trans('messages.notFound'));
  }

  /**
   *
   */
   public function register(Request $request) {
       $session = $request->session()->get('key-sesion');
       $countrys = $this->countrys();
       $sex_user = $this->sex_user();
       /**
       *
       */
       $vars=[
         'countrys' => $countrys,
         'sex_user' => $sex_user
       ];
       /**
       *
       */
       if($session == null) {
         return view('pages.register',$vars);
       }
       /**
       *
       */
       return redirect('/');
     }

  /**
   *
   */
   public function doRegister(Request $request) {
     $data           = $request->all();
     $data['accept'] = isset($data['accept']);
     $countrys       = $this->countrys();
     $sex_user       = $this->sex_user();
     $events         = Event::all();
     $configuration  = Configuration::find(HConstants::FIRST_CONFIGURATION);
     /**
     *
     */
     $vars=[
       'countrys' => $countrys,
       'sex_user' => $sex_user
     ];
     /**
     *
     */
     $validator = Validator::make($data, [
       'name'       => 'required|string|min:5|max:100',
       'last_name'  => 'required|string|min:5|max:100',
       'dni'        => 'required|numeric',
       'sex'        => 'required|not_in:0',
       'country'    => 'required|not_in:0',
       'region'     => 'required|string|min:5',
       'address'    => 'required|string|min:5',
       'city'       => 'required|string|min:5',
       'postal_code'=> 'required|string|min:4',
       'local_phone'=> 'required|string|min:5|max:25',
       'celular'    => 'required|string|min:5|max:25',
       'email'      => 'required|string|min:5|max:50|email|unique:user,email',
       'password'   => 'required|string|min:5|max:9|confirmed',
       'accept'     => 'required|boolean'
     ]);
     /**
     *
     */
     if (!is_null($validator) && $validator->fails()) {
       return view('pages.register', $vars)->withErrors($validator)
             ->with('errorMessage', trans('messages.checkRedFields'));
     }
     /**
     *
     */
     $data = $validator->getData();
     $data['company'] = $this->muranoId;
     $data['user_type'] = HUserType::NATURAL_PERSON;
     $data['active'] = false;
     $user = User::create($data);
     /**
     *
     */
     foreach($events as $key => $event) {
       $this->insertUserNotifications($user->id, $event->id);
     }
     /**
     * Envio de correo al usuario
     */
     Mail::send('emails.check_email', [
       'host'          => $this->host,
       'link'          => "check/account?code={$user->remember_token}",
       'user'          => $user,
       'configuration' => $configuration,
       'password'      => Crypt::decrypt($user->password)
     ],
     function($mail) use ($user, $configuration) {
       $mail->from($this->from);
       $mail->to($user->email , "$user->name $user->lastname")
         ->subject(trans('messages.activate'));
     });
     return view('pages.check_email', [
       'user'          => $user,
       'configuration' => $configuration
     ]);
   }

  /**
   *
   */
   public function recoverPassword(Request $request) {
    $session = $request->session()->get('key-sesion');
    $email   = Input::get('email');
    $configuration  = Configuration::find(HConstants::FIRST_CONFIGURATION);
    /**
    *
    */
    if($session == null) {
      if($this->isGET($request)) {
        return view('pages.recover-password');
      }
      /**
      *
      */
      $validator = Validator::make($request->all(), [
       'email'   => 'required|email|min:5|max:40|exists:user'
      ]);
      /**
      *
      */
      if (!is_null($validator)) {
        if ($validator->fails()) {
          return view('pages.recover-password')->withErrors($validator)
          ->with('errorMessage', trans('messages.checkRedFields'));
        }
      }
      /**
      *
      */
      $user = User::query()->where('email','=', $email)->first();
      /**
      * Envio del correo
      */
      Mail::send('emails.check_email', [
        'user'          => $user,
        'password'      => Crypt::decrypt($user->password),
        'configuration' => $configuration,
        'recovery'      => HConstants::RESPONSE_TRUE
      ],
      function($mail) use ($user, $configuration) {
        $mail->from($this->from);
        $mail->to($user->email , "$user->name $user->lastname")
          ->subject(trans('messages.recoveryPasswordSuccess'));
      });
      return view('pages.check_email', [
        'user'          => $user,
        'configuration' => $configuration
      ]);
    }
    return redirect('/');
  }

  /**
   *
   */
  public function terms(Request $request)
  {
    $configuration = Configuration::find(1);
    $session       = $request->session()->get('session');
    /**
    * Se valida la sesion
    */
    if($session == null)
    {
      /**
      * Variables
      */
      $vars = [
        'session' => $session,
        'terms'   => $configuration->terms_ics
      ];
      /**
      *
      */
      return view('pages.terms', $vars);
    }

  }

  /**
   *
   */
  public function help(Request $request)
  {

    return view('pages.help', ['session' => $request->session()->get('session')]);
  }

  /**
  * Check UserToken
  */
  public function check(Request $request)
  {
    $request->session()->put('key-sesion', null);
    $response = redirect('/login');
    $code = $request->query('code');

    if(is_null($code))
    {
      $response->with('errorMessage', trans('messages.invalid_code'));
    }
    else
    {
      $user = User::query()->where('remember_token','=',$code)->first();
      if(is_null($user))
      {
        $response->with('errorMessage', trans('messages.invalid_code'));
      }
      else
      {
        $response->with('successMessage', trans('messages.account_checked'));
        $user->active = true;
        $user->save();
      }
    }
    return $response;
  }

  /**
  * Check OperatorToken
  */
  public function checkOp(Request $request)
  {
    $request->session()->set('key-sesion', null);
    $response = redirect('/login');
    $code = $request->query('code');
    if(is_null($code))
    {
      $response->with('errorMessage', trans('messages.invalid_code'));
    }
    else
    {
      $operator = Operator::query()->where('remember_token','=',$code)->first();
      if(is_null($operator))
      {
        $response->with('errorMessage', trans('messages.invalid_code'));
      }
      else
      {
        $response->with('successMessage', trans('messages.account_checked'));
        $operator->active = true;
        $operator->save();
      }
    }
    return $response;
  }
  public function loadData(Request $request) {
     $session = $request->session()->get('key-sesion');
     $op = $session['data'];
     $operator = isset($op->id) ? Operator::find($op->id) : null;
     if ($operator == null) {
       $operator = isset($request->all()['username']) ? Operator::query()->where('email','=',$request->all()['username'])->first() : null;
       if (isset($operator) && ($operator->active == 2)) {
         return response()->json([
           "message" => "false"
         ]);
       }
       return response()->json([
         "message" => "true"
       ]);
     }
     if (isset($operator) && ($operator->active == 2)) {
       return response()->json([
         "message" => "false"
       ]);
     }
     return response()->json([
       "message" => "true"
     ]);

  }
  public function loadTest(Request $request) {
     $session = $request->session()->get('key-sesion');
     $op = $session['data'];
     $operator = isset($op->id) ? Operator::find($op->id) : null;
     //
     if ($operator == null) {
       $operator = isset($request->all()['username']) ? Operator::query()->where('email','=',$request->all()['username'])->first() : null;
       //dd($operator);
       if ($operator !=null) {
         return response()->json([
             "message" => "true",
           "operator" => $operator
         ]);
       }

     }

     return response()->json([
         "message" => "false",
         "operator" => $operator
     ]);
  }

  public function verifyTerms(Request $request) {
     $session = $request->session()->get('key-sesion');
     $operator = $session['data'];
     if ($operator == null) {
       $operator = Operator::query()->where('email','=',$request->all()['username'])->first();
       if (isset($operator) && ($operator->terms == 0)) {
         return response()->json([
           "message" => "false"
         ]);
       }
       return response()->json([
         "message" => "true"
       ]);
     }
     if (isset($operator) && ($operator->terms == 0)) {
       return response()->json([
         "message" => "false"
       ]);
     }
     return response()->json([
       "message" => "true"
     ]);

  }


}
