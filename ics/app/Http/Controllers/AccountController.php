<?php

namespace App\Http\Controllers;

use App\Models\Admin\Log;
use App\Models\Admin\Package;
use App\Models\Admin\User;
use App\Models\Admin\File;
use App\Models\Admin\Store;
use App\Models\Admin\Courier;
use App\Models\Admin\Transport;
use App\Models\Admin\Detailspackage;
use Illuminate\Http\Request;
use \Session;
use \App\Helpers\HUserType;
use \App\Helpers\HConstants;
use Validator;
use Input;
use Mail;
use Crypt;
use DB;
use App\Models\Admin\Event;
use App\Models\Admin\Configuration;
use App\Models\Admin\UserNotifications;
use App\Models\Admin\Prealert;
/**
 *
 */
class AccountController extends Controller {

  /**
   *
   */
   public function index(Request $request) {
     $session = $request->session()->get('key-sesion');
     /**
     *
     */
     if($session == null) {
       return redirect('login');
     }
     /**
     *
     */
     switch ($session['type']) {
       case HUserType::NATURAL_PERSON :
       case HUserType::RESELLER :
         $session  = $request->session()->put('with',''); /** edita session ***/
         $user     = Session::get('key-sesion')['data']->id;
         $packages = Package::byUser($user)->get();
         /**
         *
         */
         if ($this->isGET($request)) {
           return view('pages.user.tracking', [
             'packages' => $packages,
             'user'     => $user,
             'status' => Event::query()->where('active','=','1')->get(),
             'events_number' => Event::query()->where('active','=','1')->count()
           ]);
         }
         /**
         *
         */
         $validator = $this->validateDataFilter($request);
         if (!is_null($validator)) {
           if ($validator->fails()) {
             return view('pages.user.tracking',[
               'packages' => $packages,
               'user'     => $user,
               'error'    => true
               ])->withErrors($validator)->with('errorMessage', trans('messages.checkRedFields'));
           }
         }
         /**
         * se filtran paquetes entre fechas
         */
         $since_date = $request->all()['since_date'];
         $until_date = $request->all()['until_date'];
         $packages   = Package::query()->where('to_user', '=', $user)->whereBetween('start_at', [$since_date, $until_date])->get();
         $packages_user =  Package::byLastEventAndUser($user);
         /**
         *
         */
         return view('pages.user.tracking', [
           'packages'      => $packages,
           'user'          => $user,
           'filter'        => true,
           'packages_user' => $packages_user
         ])->with('successMessage', trans('messages.noFilterPackages', [
           'since_date'    => $since_date,
           'until_date'    => $until_date,
           'count'         => $packages->count()
         ]));
         /**
         *
         */
       default : return redirect('/');
     }
   }

  /**
   * @param Request $request
   * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
   */
  public function details(Request $request, $id) {
    $session = $request->session()->get('key-sesion');
    /**
    *
    */
    if ($session == null) {
      return response()->json([
        "alert"   => "null"
      ]);
    }
    $user    = $session['data']->id;
    /**
    *
    */
    if(is_null($user)) {
      return $this->doRedirect($request, '/admin')
        ->with('errorMessage', trans('user.notFound'));
    }
    /**
    *
    */
    $package = Package::query()->where('id', '=', $id)->where('to_user', '=', $user)->first();
    $packages = Package::byLastEventAndUser($user)->get();
    $detailspackage  = Detailspackage::query()->where('package','=',$id)->get();
    $resultpacklarge = DB::table('detailspackage')->where('package','=',$id)->sum('large');
    $resultpackwidth = DB::table('detailspackage')->where('package','=',$id)->sum('width');
    $resultpackheight = DB::table('detailspackage')->where('package','=',$id)->sum('height');
    $resultpackvol    = DB::table('detailspackage')->where('package','=',$id)->sum($package->type == HConstants::TRANSPORT_MARITHIME ? 'volumetricweightm' : $package->type == HConstants::TRANSPORT_AERIAL ? 'volumetricweighta' : 'volumetricweightm');
    $event = Event::query()->where('active','=','1')->get();
    $events_number = Event::query()->where('active','=','1')->count();
    /**
    *
    */
    $vars = [
      'package' => $package,
      'logs'    => Log::query()->where('package', '=', $id)->get(),
      'user'    => $user,
      'packages'=> $packages,
      'details' => $detailspackage,
      'resultpacklarge'  => $resultpacklarge,
      'resultpackwidth'  => $resultpackwidth,
      'resultpackheight' => $resultpackheight,
      'resultpackvol'    => $resultpackvol,
      'events_number' => $events_number,
      'status' => $event
    ];
    /**
    *
    */
    if(is_null($package)) {
      return $this->doRedirect($request, '/account')->with('errorMessage', trans('package.notFound'));
    }
    /**
    *
    */
    return view('pages.user.tracking_details', $vars);
  }

  /**
   * user details
   */
   public function account(Request $request) {
    $session = $request->session()->get('key-sesion');
    /**
    *
    */
    if ($session == null) {
      return redirect('login');
    }
    /**
    *
    */
    $user     = User::find($session['data']->id);
    $country  = $this->countrys();
    $sex_user  = $this->sex_user();
    $packages = Package::byUser($user)->get();
    /**
    *
    */
    if (is_null($user)) {
      return $this->doRedirect($request, '/account')
        ->with('errorMessage', trans('user.notFound'));
    }
    /**
    *
    */
    $vars = [
      'user'     => $user,
      'path'     => '/account/user',
      'sex_user' => $sex_user,
      'country'  => $country,
      'packages' => $packages
    ];
    /**
    *
    */
    if($this->isGET($request)) {
      return view('pages.user.user_details',$vars);
    }
    /**
    * Edit
    */
    $validator =  Validator::make($request->all(), [
          'name'       => 'required|string|min:5|max:100',
          'last_name'  => 'required|string|min:5|max:100',
          'dni'        => 'required|numeric',
          'sex'        => 'required|not_in:0',
          'celular'    => 'required|string|min:5|max:25',
          'email'      => 'required|string|min:5|max:50|email',
          'alt_email'  => 'required|string|min:5|max:50|email',
          'country'    => 'required|not_in:0',
          'city'       => 'required|string|min:5',
          'region'     => 'required|string|min:5',
          'local_phone'=> 'string|min:5|max:25',
          'postal_code'=> 'required|string|min:4',
          'address'    => 'required|string|min:5',
    ]);
    /**
    *
    */
    if (!is_null($validator)) {
      if ($validator->fails()) {
        return view('pages.user.user_details', $vars)->withErrors($validator)
          ->with('errorMessage', trans('messages.checkRedFields'));
      }
    }
    /**
    *
    */
    $user->update($validator->getData());
    $user->save();
    return view('pages.user.user_details', $vars)
    ->with('successMessage', trans('user.updated', [
      'name'      => $user->name,
      'last_name' => $user->last_name
    ]));
  }

  /**
  * changepass
  */
  public function changepass(Request $request) {
   $session         = $request->session()->get('key-sesion');
   $user            = User::find($session['data']->id);
   $currentPassword = Input::get('old');
   $change          = true;
   $packages        = Package::byUser($user)->get();
   /**
   *
   */
   if ($session == null) {
     return redirect('login');
   }
   /**
   *
   */
   $vars = [
     'user' => $user,
     'path' => "/account/user/pass",
      'packages'=> $packages
   ];
   /**
   *
   */
   if($this->isGET($request)) {
     return view('pages.user.changepass',$vars);
   }
   /**
   *
   */
   $validator =  Validator::make($request->all(), [
     'old'        => 'required',
     'password'   => 'required|string|min:5|max:9|confirmed',
   ]);
   /**
   *
   */
   if (!is_null($validator)) {
     if ($validator->fails()) {
        return view('pages.user.changepass', $vars)->withErrors($validator)
        ->with('errorMessage', trans('messages.checkRedFields'));
     }
     if (!$user->checkPassword($currentPassword)) {
        return view('pages.user.changepass', $vars)
        ->with('errorMessage', trans('user.notmatch', [
            'password' => $currentPassword
          ]));
     }
   }
   /**
   * Se actualizan los datos
   */
   $user->update($validator->getData());
   $user->save();
     /**
     * Se envia una notificacion al correo con la nueva contraseña
     */
     Mail::send('emails.check_email', [
       'change'   => $change,
       'user' => $user,
       'configuration' => Configuration::find(1),
       'password' => Crypt::decrypt($user->password)
     ],
     function($mail) use ($user) {
       $mail->from($this->from);
       $mail->to($user->email , "$user->name $user->lastname")
         ->subject(trans('messages.changepassSuccess'));
     });
     /**
     *
     */
     return view('pages.user.changepass', $vars)
     ->with('successMessage', trans('user.passwordupdated', [
       'name' => $user->name
     ]));
  }
   /**
   *
   */
   public function avatar(Request $request) {
    $session = $request->session()->get('key-sesion');
    /**
    *
    */
     if ($session == null) {
       return response()->json([
         "alert"   => "null"
       ]);
     }
    /**
    *
    */
    $user = User::find($session['data']->id);
    /**
    *
    */
    $vars = [
      'user' => $user
    ];
    /**
    *
    */
    if($this->isGET($request)) {
      return view('pages.user.avatar', $vars);
    }
   }
   /**
   *
   */
   public function avatarUpdate(Request $request) {
     $session = $request->session()->get('key-sesion');
     /**
     *
     */
      if ($session == null) {
        return response()->json([
          "alert"   => "null"
        ]);
      }
     /**
     *
     */
     $user = User::find($session['data']->id);
     /**
     *
     */
     $vars = [
       'user' => $user
     ];
     /**
     *
     */
     return view('sections.attachment', $vars);
   }
   /**
   * Metodo para cargar foto de perfil de cliente
   * NOTA: postpuesto por los momentos
   */
   public function loadFile(Request $request) {
     $attachment = $request->file('file');
     $fileName = str_random().'_'.$attachment->getClientOriginalName();
     $attachment->move('uploads/clientprofilephoto', $fileName);
   }
   /**
   *
   */

   public function upload(Request $request, $id) {
       $session  = $request->session()->get('key-sesion');
       /**
       *
       */
       if ($session == null) {
         return redirect('login');
       }
       /**
       *
       */
       $package = Package::find($id);
       /**
       *
       */
       if (is_null($package)) {
         return redirect('/');
       }
       /**
       *
       */
       $user     = $session['data']->id;
       $packages = Package::byUser($user)->get();
       $couriers = Courier::byStatus()->get();
       $stores   = Store::all();
       /**
        *
        */
        $vars = [
           'user'       => $user,
           'couriers'   => $couriers,
           'packages'   => $packages,
           'stores'     => $stores,
           'package'    => $package
        ];
        /**
        *
        */
        if($this->isGET($request)) {
          return view('pages.user.upload', $vars);
        }
       /**
       * Validacion de datos
       */
       $validator =  Validator::make($request->all(), [
         'contentPackage' => 'required|string|min:5|max:100',
         'pricePackage'   => 'required|numeric|min:1',
         'id_package'     => 'required|unique:file,id_package'
       ]);
       /**
       *
       */
       if (!is_null($validator)) {
         if ($validator->fails()) {
           return view('pages.user.upload', $vars)
             ->withErrors($validator)
             ->with('errorMessage', trans('messages.checkRedFields'));
         }
       }
       /**
       *
       */
       $file           = Input::file('file');
       $aleatorio      = str_random();
       $nombre         = $aleatorio.'_'.$file->getClientOriginalName();
       $carrier        = Input::get('carrier');
       $contentPackage = Input::get('contentPackage');
       $pricePackage   = Input::get('pricePackage');
        /**
        * Configuracion de datos a enviar
        */
       $data = [
         "name"           => $nombre,
         "path"           => asset('/uploads')."/".$nombre,
         "id_package"     => $id,
         "carrier"        => $carrier,
         "contentPackage" => $contentPackage,
         "pricePackage"   => $pricePackage
       ];
       /**
       * Actualizar el paquete a 'con factura'
       */
       $package->invoice = true;
       $package->save();
       /**
       * Se almacenan los datos del archivo subido
       */
       $file->move('uploads', $nombre);
       $session = $request->session()->put('with','successMessage'); /** Edita Session **/
       $save = File::create($data);
         return view('pages.user.tracking', [
           'packages' => $packages
         ])->with('successMessage', trans('package.prealert', [
           'tracking' => $package->tracking
         ]
         ));
     }
   /**
   *Administrar Notificaciones
   */
   public function settingsNotification(Request $request) {
     $session  = $request->session()->get('key-sesion');
     /**
      *
      */
      if ($session == null) {
        return redirect('login');
      }
      /**
      *
      */
      $user                = $session['data']->id;
      $packages            = Package::byUser($user)->get();
      $events              = Event::query()->where('active','=','1')->get();
      $user_notifications  = UserNotifications::byUser($user)->get();
      /**
      *
      */
      $vars = [
         'user'               => $user,
         'packages'           => $packages,
         'events'             => $events,
         'user_notifications' => $user_notifications
      ];
      /**
      *
      */
      if($this->isGET($request)) {
        return view('pages.user.notifications_settings', $vars);
      }
      /**
      *
      */
      $user_notifications = DB::table('user_notifications')->where('user','=', $user)->delete();
      /**
      *
      */
       foreach ($events as $key => $event) {
         isset($request->all()['icsnu'.$event->id]) ? $this->insertUserNotifications($user, $event->id) : '' ;
       }
       /**
       *
       */
       return redirect("/account/notifications/settings")->with('successMessage', trans('messages.updatedsettings'));
   }
 /**
   *Modulo de prealertas
   */
   public function prealertList(Request $request) {
    $session  = $request->session()->get('key-sesion');
    /**
     *
     */
     if ($session == null) {
       return redirect('login');
     }
     /**
      *
      */
     $user      = $session['data']->id;
     $prealerts = Prealert::byUser($user)->orderBy('created_at', 'DESC')->get();
     $packages  = Package::byUser($user)->get();
     /**
     *
     */
     if($this->isGET($request)) {
       return view('pages.user.prealert.list', [
         'user'      => $user,
         'prealerts' => $prealerts,
         'packages'  => $packages
       ]);
     }
     /**
     *
     */
     $validator = $this->validateDataFilter($request);
     if (!is_null($validator)) {
       if ($validator->fails()) {
         return view('pages.user.prealert.list', [
           'user'      => $user,
           'prealerts' => $prealerts,
           'packages'  => $packages,
           'error'     => true
         ])->withErrors($validator)->with('errorMessage', trans('messages.checkRedFields'));
       }
     }
     /**
     * se filtran prealertas entre fechas
     */
     $since_date = $request->all()['since_date'];
     $until_date = $request->all()['until_date'];
     $prealerts   = Prealert::query()->where('user', '=', $user)->whereBetween('date_arrived', [$since_date, $until_date])->get();
    /**
     *
     */
     return view('pages.user.prealert.list', [
       'user'      => $user,
       'prealerts' => $prealerts,
       'packages'  => $packages,
       'filter'    => true,
       'count'     => $prealerts->count()
     ])->with('successMessage', trans('messages.noFilterPackages', [
       'since_date'=> $since_date,
       'until_date'=> $until_date,
       'count'     => $prealerts->count()
     ]));
   }
   /**
   *
   */
   public function prealertCreate(Request $request) {
     $session  = $request->session()->get('key-sesion');
     /**
      *
      */
      if ($session == null) {
        return redirect('login');
      }
      /**
      *
      */
      $user     = $session['data']->id;
      $packages = Package::byUser($user)->get();
      $couriers = Courier::byStatus(1)->get();
      $types    = Transport::all();
      /**
      *
      */
      $vars = [
         'user'     => $user,
         'packages' => $packages,
         'types'    => $types,
         'couriers' => $couriers
      ];
      /**
      *
      */
      if($this->isGET($request)) {
        return view('pages.user.prealert.create', $vars);
      }
      /**
      *
      */
      $validator = $this->validateDataPrealert($request, false);
      if (!is_null($validator)) {
        if ($validator->fails()) {
          return view('pages.user.prealert.create',$vars)->withErrors($validator)
            ->with('errorMessage', trans('messages.checkRedFields'));
        }
      }
      /**
      *
      */
      if (Input::file('file') != null) {
        $attachment     = Input::file('file');
        $aleatorio      = str_random();
        $nombre         = $aleatorio.'_'.$attachment->getClientOriginalName();
       /**
       *
       */
       $file_data = [
         "name"           => $attachment->getClientOriginalName(),
         "path"           => asset('/uploads/prealert').'/'.$nombre
       ];
       /**
       * se crea los datos del adchivo que se ha cargado
       */
        $file = File::create($file_data);
      }
       $data = [
         'user'          => $user,
         'order_service' => $request->all()['order_service'],
         'courier'       => $request->all()['courier'],
         'provider'      => $request->all()['provider'],
         'date_arrived'  => $request->all()['date_arrived'],
         'value'         => $request->all()['value'],
         'content'       => $request->all()['content'],
         'large'         => isset($request->all()['large']) ? $request->all()['large'] : null,
         'height'       => isset($request->all()['height1']) ? $request->all()['height1'] : null,
         'width'        => isset($request->all()['width']) ? $request->all()['width'] : null,
         'weight'        => isset($request->all()['weight1']) ? $request->all()['weight1'] : null,
         'volumetricweightm1' => isset($request->all()['volumetricweightm1']) ? $request->all()['volumetricweightm1'] : null,
         'volumetricweighta1' => isset($request->all()['volumetricweighta1']) ? $request->all()['volumetricweighta1'] : null,
         'type'         => isset($request->all()['content']) ? $request->all()['type'] : 0,
         !is_null(Input::file('file')) ? $file->id : null
       ];
       /**
       *
       */
       $prealert = Prealert::create($data);
       if (Input::file('file') != null) {
         $attachment->move('uploads/prealert', $nombre);
       }
       return redirect("/account/prealert")->with('successMessage', trans('prealert.created', [
         'order_service' => $prealert->order_service,
         'code'          => $prealert->code
       ]));
   }
   /**
   *
   */
   public function prealertDetails(Request $request, $id) {
     $session  = $request->session()->get('key-sesion');
     /**
      *
      */
      if ($session == null) {
        return redirect('login');
      }
      /**
      *
      */
      $prealert = Prealert::find($id);
      /**
      *
      */
      if (is_null($prealert) || ($session['type'] != HUserType::OPERATOR) && ($session['data']->id != $prealert->user)) {
       return $this->doRedirect($request,  $session['type'] == HUserType::OPERATOR ? "admin/package/prealert" : "/account/prealert")
         ->with('errorMessage', trans('prealert.notFound'));
      }
      /**
      *
      */
      $user     = $session['type'] == HUserType::OPERATOR ? $prealert->user : $session['data']->id ;
      $packages = Package::byLastEventAndUser($user)->get();
      $couriers = Courier::byStatus(1)->get();
      /**
      *
      */
      $vars = [
         'user'     => $user,
         'packages' => $packages,
         'couriers' => $couriers,
         'prealert' => $prealert,
         'types'    => Transport::all(),
         'removable'=> $session['type'] == HUserType::OPERATOR ? true : false
      ];
      /**
      *
      */
      if($this->isGET($request)) {
        return view('pages.user.prealert.edit', $vars);
      }
      /**
      *
      */
      $validator = $this->validateDataPrealert($request, true);
      if (!is_null($validator)) {
        if ($validator->fails()) {
          return view('pages.user.prealert.edit',$vars)->withErrors($validator)
            ->with('errorMessage', trans('messages.checkRedFields'));
        }
      }
      /**
      *
      */
      if (Input::file('file') != null) {
        $attachment     = Input::file('file');
        $aleatorio      = str_random();
        $nombre         = $aleatorio.'_'.$attachment->getClientOriginalName();
       /**
       *
       */
       $file_data = [
         "name"           => $attachment->getClientOriginalName(),
         "path"           => asset('/uploads/prealert').'/'.$nombre
       ];
       /**
       * 1) se obtiene el archivo Asociado
       * 2) se valida si se creo la prealerta con un archivo
       */
       $file = File::find($prealert->file);
       /**
       *
       */
       if (is_null($file)) {
           $file = File::create($file_data);
       } else {
         $file->update($file_data);
         $file->save();
       }
      }
      /**
      *
      */
      $data = [
        'order_service' => $request->all()['order_service'],
        'courier'       => $request->all()['courier'],
        'provider'      => $request->all()['provider'],
        'date_arrived'  => $request->all()['date_arrived'],
        'value'         => $request->all()['value'],
        'content'       => $request->all()['content'],
        'large'         => isset($request->all()['large']) ? (($request->all()['large'] == "") ? null: $request->all()['large']) : null,
        'height'       => isset($request->all()['height1']) ? (($request->all()['height1'] == "") ? null: $request->all()['height1']) : null,
        'width'        => isset($request->all()['width']) ? (($request->all()['width'] == "") ? null: $request->all()['width']) : null,
        'weight'        => isset($request->all()['weight1']) ? (($request->all()['weight1'] == "") ? null: $request->all()['weight1'])  : null,
        'volumetricweightm1' => isset($request->all()['volumetricweightm1']) ? (($request->all()['volumetricweightm1'] == "") ? null: $request->all()['volumetricweightm1']) : null,
        'volumetricweighta1' => isset($request->all()['volumetricweighta1']) ? (($request->all()['volumetricweighta1'] == "") ? null: $request->all()['volumetricweighta1']) : null,
        'type'         => isset($request->all()['content']) ? $request->all()['type'] : 0,
        'file'          => !is_null(Input::file('file')) ? $file->id : $prealert->file
      ];
       /**
       *
       */
       $prealert->update($data);
       $prealert->save();
       /**
       *
       */
       if (Input::file('file') != null) {
         $attachment->move('uploads/prealert', $nombre);
       }
       /**
       *
       */
       return redirect( $session['type'] == HUserType::OPERATOR ? "admin/prealert" : "/account/prealert")->with('successMessage', trans('prealert.updated', [
        'order_service' => $prealert->order_service,
        'code'          => $prealert->code
      ]));
   }
   /**
   *
   */
   public function prealertView(Request $request, $id) {
     $session = $request->session()->get('key-sesion');
     /**
     *
     */
     if ($session == null) {
       return response()->json([
         "alert"   => "null"
       ]);
     }
     /**
     *
     */
     $prealert = Prealert::find($id);
     /**
     *
     */
     $vars = [
       'prealert' => $prealert
     ];
      /**
      *
      */
      if($this->isGET($request)) {
        return view('pages.user.prealert.view', $vars);
      }

   }
   /**
   *
   */
   private function validateDataPrealert(Request $request, $update = false) {
    return Validator::make($this->clear($request->all()), [
      'order_service' => 'required|string|min:5|max:100|'.($update ? '' : 'unique:prealert,order_service'),
      'date_arrived'  => 'required|date|date_format:Y-m-d|',
      'value'         => 'required|numeric|min:1',
      'content'       => 'required|string|min:1',
      'file'          => 'file'
    ]);
   }
   /**
   *
   */
   private function validateDatafilter(Request $request) {
    return Validator::make($this->clear($request->all()), [
      'since_date'  => 'required|date|date_format:Y-m-d|',
      'until_date'  => 'required|date|date_format:Y-m-d|after:since_date',
    ]);
   }

}
