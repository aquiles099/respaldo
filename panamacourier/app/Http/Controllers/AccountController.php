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
use Carbon\Carbon;
use App\Models\Admin\Tax;
use App\Models\Admin\Country;
use App\Models\Admin\Promotion;
use App\Models\Admin\Consolidated;
use App\Models\Admin\Suppliers;
use App\Models\Admin\Transporters;
use App\Models\Admin\Category;
use App\Models\Admin\Office;
use App\Models\Admin\AddCharge;
use App\Models\Admin\TypePickup;
use App\Models\Admin\NumberParts;
use App\Models\Admin\Pickup;
use App\Models\Admin\Attachment;
use App\Models\Admin\Service;
use App\Models\Admin\DetailsPickup;
use App\Models\Admin\PickupStatus;

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;

use URL;
use Redirect;
use Cookie;

/**
 *
 */
class AccountController extends Controller {
  /**
  * object to authenticate the call.
  * @param object $_apiContext
  */
  private $_api_context;
  /**
  * setup PayPal api context
  */
  public function __construct () {
    $paypal_conf = config('paypal');
    $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
    $this->_api_context->setConfig($paypal_conf['settings']);
  }
  /**
  *
  */
  public function PaymentWithpaypal (Request $request, Pickup $pickup) {

    $user = User::find($pickup->user);
    $items = DetailsPickup::byPickup($pickup->id)->get();
    /**
    *
    */
    if ( $this->isGet($request) ) {
     return view('pages.admin.pickup.payment', compact('pickup', 'user', 'items'));
    }
    /**
    *
    */
    $validator = Validator::make($request->all(), [
      'amount' => 'required|numeric|min:1'
    ]);
    /**
    *
    */
    if ( $validator->fails() ) {
      return redirect('account/prealert')->withErrors($validator)->with('errorMessage', trans('payment.amountError'));
    }
    /**
    * payer
    */
    $payer = new Payer();
    $payer->setPaymentMethod('paypal');
    /**
    * item name
    */
    $item_1 = new Item();
    $item_1->setName($pickup->code)->setCurrency('USD')->setQuantity(1)->setPrice($request->get('amount'));
    /**
    * unit price
    */
    $item_list = new ItemList();
    $item_list->setItems(array($item_1));
    /**
    *
    */
    $amount = new Amount();
    $amount->setCurrency('USD')->setTotal($request->amount);
    /**
    *
    */
    $transaction = new Transaction();
    $transaction->setAmount($amount)->setItemList($item_list)->setDescription("pickup solicitada por $user->name $user->last_name - $user->email");
    /**
    * specify return URL
    */
    $redirect_urls = new RedirectUrls();
    $redirect_urls->setReturnUrl(URL::route('payment.status', [$pickup->id]))->setCancelUrl(URL::route('payment.status', [$pickup->id]));
    /**
    *
    */
    $payment = new Payment();
    $payment->setIntent('Sale')->setPayer($payer)->setRedirectUrls($redirect_urls)->setTransactions(array($transaction));

    /**
    *
    */
    try {
      $payment->create($this->_api_context);
    } catch (\PayPal\Exception\PayPalConnectionException $ex) {
      return redirect('account/prealert')->with('errorMessage', trans('payment.exception', [
        'code'  => $pickup->code,
        'error' => $ex->getMessage()
      ]));
    }
    /**
    *
    */
    foreach ($payment->getLinks() as $link) {
      if ( $link->getRel() == 'approval_url') {
        $redirect_url = $link->getHref();
        break;
      }
    }
    /**
    *
    */
    Session::put('paypal_payment_id', $payment->getId());
    /**
    *
    */
    if ( isset($redirect_url) ) {
     return redirect($redirect_url);
    }
    /**
    *
    */
    return redirect('account/prealert')->with('errorMessage', trans('payment.error'));
  }
  /**
  *
  */
  public function PaymentStatus (Request $request, Pickup $pickup) {

    $user = session()->get('key-sesion')['data'];
    /**
    * Get the payment ID before session clear
    */
    $payment_id = Session::get('paypal_payment_id');
    /**
    * clear the session payment ID
    */
    Session::forget('paypal_payment_id');
    /**
    *
    */
    if ( empty($request->input('PayerID')) || empty($request->input('token')) ) {
      return redirect('account/prealert')->with('errorMessage', trans('payment.unProcesed', [
        'code'  => $pickup->code
      ]));
    }
    /**
    *
    */
    $payment = Payment::get($payment_id, $this->_api_context);
    /**
    * 1) PaymentExecution object includes information necessary.
    * 2) to execute a PayPal account payment.
    * 3) The payer_id is added to the request query parameters.
    * 4) Execute the payment
    */
    $execution = new PaymentExecution();
    $execution->setPayerId($request->input('PayerID'));
    /**
    *
    */
    $result = $payment->execute($execution, $this->_api_context);
    /**
    *
    */
    if ( $result->getState() == 'approved' ) {
      /**
      *
      */
      $mail_vars = [
        'user'          => $user,
        'configuration' => Configuration::find(1),
        'pickup'        => $pickup
      ];
      /**
      *
      */
      try {
        Mail::send('emails.payment.payment-success', $mail_vars, function($mail) use ($user) {
        $mail->from($this->from);
        $mail->to($user->email , "$user->name $user->lastname")
        ->cc(env('ICS_WEBSITE_OWNER'))
        ->subject(trans('payment.approved'));
        });
      } catch (Exception $e) {
        return redirect('account/prealert')->with('successMessage', trans('payment.successnomail', [
          'code'  => $pickup->code,
          'error' => $e->getMessage()
        ]));
      }
      /**
      *
      */
      return redirect('account/prealert')->with('successMessage', trans('payment.success', [
       'code'  => $pickup->code
      ]));
    }
    /**
    *
    */
    return redirect('account/prealert')->with('errorMessage', trans('payment.error'));
  }
  /**
  *
  */
  public function index(Request $request) {
    $session = $request->session()->get('key-sesion');
    /**
    *
    */
    if ( $session == null ) {
     return redirect('login');
    }
    /**
    *
    */
    switch ( $session['type'] ) {
      case HUserType::NATURAL_PERSON :
      /** nothing**/
      case HUserType::RESELLER :
        $session  = $request->session()->put('with',''); /** edita session ***/
        $user     = Session::get('key-sesion')['data']->id;
        $packages = Package::byUser($user)->get();
        /**
        *
        */
        if ( $this->isGET($request) ) {
          return redirect('account/prealert');
        }
        /**
        *
        */
        $validator = $this->validateDataFilter($request);
        if ( !is_null($validator) ) {
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
    if ( $session == null ) {
      return response()->json([
        "alert"   => "null"
      ]);
    }
    $user = $session['data']->id;
    /**
    *
    */
    if ( is_null($user) ) {
      return $this->doRedirect($request, '/admin')->with('errorMessage', trans('user.notFound'));
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
      'package'          => $package,
      'logs'             => Log::query()->where('package', '=', $id)->get(),
      'user'             => $user,
      'packages'         => $packages,
      'details'          => $detailspackage,
      'resultpacklarge'  => $resultpacklarge,
      'resultpackwidth'  => $resultpackwidth,
      'resultpackheight' => $resultpackheight,
      'resultpackvol'    => $resultpackvol,
      'events_number'    => $events_number,
      'status'           => $event
    ];
    /**
    *
    */
    if ( is_null($package) ) {
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
    if ( $session == null ) {
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
    if ( is_null($user) ) {
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
    if ( $this->isGET($request) ) {
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
    if ( !is_null($validator) ) {
      if ( $validator->fails() ) {
        return view('pages.user.user_details', $vars)->withErrors($validator)
        ->with('errorMessage', trans('messages.checkRedFields'));
      }
    }
    /**
    *
    */
    $user->update($validator->getData());
    $user->save();
    return view('pages.user.user_details', $vars)->with('successMessage', trans('user.updated', [
      'name'      => $user->name,
      'last_name' => $user->last_name
    ]));
  }
  /**
  * changepass
  */
  public function changepass ( Request $request ) {

    $session         = $request->session()->get('key-sesion');
    $user            = User::find($session['data']->id);
    $currentPassword = Input::get('old');
    $change          = true;
    $packages        = Package::byUser($user)->get();
    /**
    *
    */
    if ( $session == null ) {
      return redirect('login');
    }
    /**
    *
    */
    $vars = [
      'user'     => $user,
      'path'     => "/account/user/pass",
      'packages' => $packages
    ];
    /**
    *
    */ 
    if ( $this->isGET($request) ) {
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
    * Se actualizan los datos
    */
    $user->update($validator->getData());
    $user->save();
    /**
    *
    */
    $mail_vars = [
      'change'        => $change,
      'user'          => $user,
      'configuration' => Configuration::find(1),
      'password'      => Crypt::decrypt($user->password)
    ];
    /**
    * Se envia una notificacion al correo con la nueva contraseña
    */
    try {
      Mail::send('emails.check_email', $mail_vars, function($mail) use ($user) {
      $mail->from($this->from);
      $mail->to($user->email , "$user->name $user->lastname")
      ->subject(trans('messages.changepassSuccess'));
      });
    } catch (Exception $e) {
      return view('pages.user.changepass', $vars)->with('errorMessage', trans('user.passwordupdatedNoMail', [
        'name'  => $user->name,
        'error' => $e->getMessage()
      ]));
    }
    /**
    *
    */
    return view('pages.user.changepass', $vars)->with('successMessage', trans('user.passwordupdated', [
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
    if ( $session == null ) {
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
    if ( $this->isGET($request) ) {
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
    if ( $session == null ) {
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
  * [loadFile description]
  * @param  Request $request [description]
  * @return [type]           [description]
  */
  public function loadFile ( Request $request ) {
    $attachment = $request->file('file');
    $fileName = str_random().'_'.$attachment->getClientOriginalName();
    $attachment->move('uploads/clientprofilephoto', $fileName);
  }
  /**
  *
  */
  public function upload (Request $request, $id) {
    $session  = $request->session()->get('key-sesion');
    /**
    *
    */
    if ( $session == null ) {
     return redirect('login');
    }
    /**
    *
    */
    $package = Package::find($id);
    /**
    *
    */
    if ( is_null($package) ) {
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
    if ( $this->isGET($request) ) {
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
    if ( !is_null($validator) ) {
      if ( $validator->fails() ) {
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
    ]));
  }
  /**
  * [settingsNotification description]
  * @param  Request $request [description]
  * @return [type]           [description]
  */
  public function settingsNotification(Request $request) {
    $session  = $request->session()->get('key-sesion');
    /**
    *
    */
    if ( $session == null ) {
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
    if ( $this->isGET($request) ) {
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
  * [prealertList description]
  * @param  Request $request [description]
  * @return [type]           [description]
  */
  public function prealertList(Request $request) {

    $session = $request->session()->get('key-sesion');
    $user = $session['data'];
    /**
    *  Se valida que la sesion este activa
    */
    if ($session == null) {
      return redirect('login');
    }
    $pickup = Pickup::byUser($user->id)->get();
    /**
    *
    */
    if ( $this->isGet($request) ) {
      if (Cookie::get('storage_data')) {
        return redirect('account/prealert/new');
      }
      return view('pages.admin.pickup.list', compact('pickup'));
    }
    /**
    *
    */
    $validator = $this->validateDataFilter($request);
    if ( !is_null($validator) ) {
      if ( $validator->fails() ) {
        return view('pages.admin.pickup.list', [
          'pickup' => $pickup,
          'user'   => $user,
          'error'  => true
        ])->withErrors($validator)->with('errorMessage', trans('messages.checkRedFields'));
      }
    }
    /**
    *
    */
    $pickup = Pickup::byPickupDate($user->id, $request->since_date, $request->until_date)->get();
    return view('pages.admin.pickup.list', [
      'pickup' => $pickup,
      'filter' => true
    ]);
  }
  /**
  * [prealertCreate description]
  * @param  Request $request [description]
  * @return [type]           [description]
  */
  public function prealertCreate (Request $request) {
    $session = $request->session()->get('key-sesion');
    $admin =  $request->session()->get('key-sesion')['data'];
    $start_at = Carbon::now()->format('Y-m-d');
    $taxs = Tax::byStatus(1)->get();
    $taxss = array();
    /**
    *  Se valida que la sesion este activa
    */
    if ( $session == null ) {
      return redirect('login');
    }
    /**
    *
    */
    foreach ( $taxs as $key=> $tax ) {
      $valtax = 'tax'.$tax->id;
      if ($valtax == isset($request->all()[$valtax])) {
        array_push($taxss, array(
          'name'        => $valtax,
          'value'       => $request->all()[$valtax],
          'value_oring' => $tax->id)
        );
      }
    }
    /**
    *
    */
    $vars = [
      'countries'   => Country::all(),
      'promotions'  => Promotion::all(),
      'consolidated'=> Consolidated::byStatus(1)->get(),
      'couriers'    => Courier::byStatus()->get(),
      'users'       => array($admin),
      'tax'         => $taxs,
      'transports'  => Transport::all(),
      'suppliers'   => Suppliers::all(),
      'transporters'=> Transporters::all(),
      'category'    => Category::all(),
      'start_at'    => Carbon::now()->format('Y-m-d'),
      'office'      => Office::all(),
      'services'    => '',
      'addcharges'  => AddCharge::all(),
      'typepickup'  => TypePickup::all(),
      'numberparts' => NumberParts::all(),
      'taxxes'      =>(isset($request->all()['tax1']) ? $taxss : ''),
      'cookie'     => Cookie::get('storage_data')
    ];
    /**
    *
    */
    if ($this->isGET($request)) {
      return view('pages.admin.pickup.create', $vars);
    }
    /**
    *
    */
    $validator = $this->validateData($request);
    /**
    *
    */
    if ( $request->all()['exporter'] == '0' ) {
      $userCons = null;
    }
    /**
    *
    */
    if ( $request->all()['consigner'] == '' ) {
      $userDest = null;
    }
    /**
    *
    */
    $destin = (($request->all()['consigner'] == '')||(!isset($request->all()['consigner']))) ? null :$request->all()['consigner'];
    if ( $destin == '0') {
      $type_destin = 0;
      $destin = $admin->id;
    } else {
      $type_destin = $destin;
    }
    /**
    *
    */
    $pickupData = [
      'type_destin'       => $type_destin,
      'from_courier'      => isset($request->all()['courierSelect']) ? $request->all()['courierSelect'] : null,
      'promotion'         => null,
      'observation'       => null,
      'insurance'         => null,
      'volumetricweightm' => null,
      'volumetricweighta' => null,
      'costservice'       => null,
      'costinsurance'     => null,
      'aditionalcost'     => null,
      'subtotal'          => null,
      'total'             => null,
      'tax'               => null,
      'pro'               => null,
      'value'             => null,
      'type'              => null,
      'details_type'      => null,
      'category'          => null,
      'office'            => null,
      'typeservice'       => null,
      'start_at'          => null,
      'destin_phone'      => (($request->all()['cons_phone'] == '')||(!isset($request->all()['cons_phone']))) ? null :$request->all()['cons_phone'],
      'destin_name'       => (($request->all()['destin_name'] == '')||(!isset($request->all()['destin_name']))) ? null :$request->all()['destin_name'],
      'shipper_phone'     => (!isset($request->all()['destin_phone'])||($request->all()['destin_phone']=='')) ? null : $request->all()['destin_phone'],
      'to_user'           => $destin,
      'consigner_user'    => (($request->all()['exporter'] == '0')||(!isset($request->all()['exporter'])))? $userCons:$request->all()['exporter'],
      'addcharge'         => (!isset($request->all()['addcharge']) || $request->all()['addcharge'] == "") ? 0 :$request->all()['addcharge'],
      'invoice'           => ((!isset($request->all()['invoiced1'])||($request->all()['invoiced1'] == '')||($request->all()['invoiced1'] == null)))? '' :$request->all()['invoiced1'],
      'last_event'        => 1,
      'notes'             => (!isset($request->all()['notes'])||($request->all()['notes']=='')) ? null : $request->all()['notes'],
      'country_shipper'   => (!isset($request->all()['cons_country'])||($request->all()['cons_country']=='')) ? null : $request->all()['cons_country'],
      'region_shipper'    => (!isset($request->all()['cons_region'])||($request->all()['cons_region']=='')) ? null : $request->all()['cons_region'],
      'city_shipper'      => (!isset($request->all()['cons_city'])||($request->all()['cons_city']=='')) ? null : $request->all()['cons_city'],
      'address_shipper'   => (!isset($request->all()['cons_direction'])||($request->all()['cons_direction']=='')) ? null : $request->all()['cons_direction'],
      'location_shipper'  => (!isset($request->all()['consigner_dir'])||($request->all()['exporter_dir']=='')) ? '0' : $request->all()['exporter_dir'],
      'country_consig'    => (!isset($request->all()['destin_country'])||($request->all()['destin_country']=='')) ? null : $request->all()['destin_country'],
      'region_consig'     => (!isset($request->all()['destin_region'])||($request->all()['destin_region']=='')) ? null : $request->all()['destin_region'],
      'city_consig'       => (!isset($request->all()['destin_city'])||($request->all()['destin_city']=='')) ? null : $request->all()['destin_city'],
      'address_consig'    => (!isset($request->all()['destin_direction'])||($request->all()['destin_direction']=='')) ? null : $request->all()['destin_direction'],
      'location_consig'   => (!isset($request->all()['exporter_dir'])||($request->all()['exporter_dir']=='')) ? '0' : $request->all()['exporter_dir'],
      'provider'          => (!isset($request->all()['supplier'])||($request->all()['supplier']=='')) ? '0' : $request->all()['supplier'],
      'po_number'         => (!isset($request->all()['purchase_order'])||($request->all()['purchase_order']=='')) ? null : $request->all()['purchase_order'],
      'transporter'       => (!isset($request->all()['transporter'])||($request->all()['transporter']=='')) ? '0' : $request->all()['transporter'],
      'trans_tracking'    => (!isset($request->all()['tracking_transporter'])||($request->all()['tracking_transporter']=='')) ? null : $request->all()['tracking_transporter'],
      'pickup_number'     => (!isset($request->all()['pickup_number'])||($request->all()['pickup_number']=='')) ? null : $request->all()['pickup_number'],
      'pickup_date'       => $request->all()['pickup_date'].' '.$request->all()['pickup_hour'],
      'deliver_date'      => $request->all()['deliver_date'].' '.$request->all()['deliver_hour']
    ];
    /**
    *
    */
    $pickup = Pickup::create($pickupData);
    /**
    * Se envia correo electronico
    */
    $this->notifyUserPickup($pickup->to_user, '', $pickup->id);

    $files = Input::file('upload_file');
    mkdir(asset('/uploads/').$pickup->code);
    /**
    *
    */
    if ( $files[0] != '' ) {
      foreach($files as $file) {
        $aleatorio = str_random();
        $nombre    = $aleatorio.'_'.$file->getClientOriginalName();
        $file->move('uploads/'.$pickup->code."/", $nombre);
        $data = [
          'shipment'      => null,
          'booking'       => null,
          'warehouse'     => null,
          'pickup'        => $pickup->id,
          'cargo_release' => null,
          'transporters'  => null,
          'suppliers'     => null,
          'path'          => asset('/uploads/').'/'.$pickup->code."/".$nombre,
          'name_path'     => $nombre,
          'operator'      => $admin->id
        ];
        $attachment = Attachment::create($data);
      }
    }
    /**
    *
    */
    for ($i = 1; $i <= $request->all()['countpack']; $i++) {
      $pickupdetailsData = [
        'description'       => $request->all()['description'.$i],
        'numberparts'       => isset($request->all()['numberparts'.$i]) ? $request->all()['numberparts'.$i] : null,
        'pieces'            => $request->all()['pieces'.$i],
        'large'             => $request->all()['large'.$i],
        'width'             => $request->all()['width'.$i],
        'height'            => $request->all()['height'.$i],
        'weight'            => $request->all()['weight'.$i],
        'volumetricweightm' => $request->all()['volumetricweightm'.$i],
        'volumetricweighta' => $request->all()['volumetricweighta'.$i],
        'value'             => $request->all()['valued'.$i],
        'invoice'           => ((!isset($request->all()['invoiced'.$i])||($request->all()['invoiced'.$i] == '')||($request->all()['invoiced'.$i] == null)))? '' :$request->all()['invoiced'.$i],
        'tracking'          => isset($request->all()['tracking'.$i]) ? $request->all()['tracking'.$i]: '',
        //'po'                => $request->all()['po'.$i],
        'pickup'            => $pickup->id
      ];
      $pickupdetails = DetailsPickup::create($pickupdetailsData);
    }
    /**
    *
    */
    $session = $request->session()->get('key-sesion');
    $receipt = $this->setreceiptpickup($pickup->id, isset($request->all()['observation']) ? $request->all()['observation'] : null , isset($request->all()['subtotal']) ? $request->all()['subtotal'] : '0' , isset($request->all()['total']) ? $request->all()['total'] : '0' );
    /**
    *
    */
    foreach ( $taxs as $key => $tax) {
      $valtax = 'tax'.$tax->id;
      if ($valtax == isset($request->all()[$valtax])) {
        $receipts = [
          'receipt'         =>  $receipt->id,
          'type_cost'       =>  $tax->type,
          'type_attribute'  =>  'I',
          'id_complemento'  =>  $tax->id,
          'name_oring'      =>  $tax->name,
          'value_oring'     =>  $tax->value,
          'value_package'   =>  $request->all()[$valtax]
        ];
        DetailsReceipt::create($receipts);
      }
    }
    /**
    *
    */
    if ( isset($request->all()['addcharge']) ) {
      if ( $request->all()['addcharge'] ) {
        $addcharge = AddCharge::find($idcharge);
        $addchargeData = [
          'receipt' =>  $receipt->id,
          'type_cost' =>  1,
          'type_attribute' =>  'A',
          'id_complemento' =>  $addcharge->id,
          'name_oring' =>  $addcharge->name,
          'value_oring' =>  $addcharge->value,
          'value_package' =>  $addcharge->value
        ];
        DetailsReceipt::create($addchargeData);
      }
    }
    /**
    * se notifica al usuario
    */
    if ($request->all()['consigner'] != HConstants::RESPONSE_NULL) {
      $this->notifyUserPickup($request->all()['consigner'], HConstants::EVENT_RECEIVED, $pickup->id);
    }
    /**
    *
    */
    $this->insertLogPickup($pickup->id, 1,isset($request->all()['note']) ? $request->all()['note'] : null ,null,$session['data']->id);
    /**
    *
    */
    $vars_mail = [
      'user'          => $admin,
      'pickup'        => $pickup,
      'country'       => Country::find($pickup->country_consig),
      'details'       => DetailsPickup::byPickup($pickup->id),
      'configuration' => Configuration::find(1)
    ];
    Cookie::queue(Cookie::forget('storage_data'));
    /**
    * Se envia una notificacion al correo OWNER
    */
    try {
      Mail::send('emails.pickup.pickup-prealert', $vars_mail, function($mail) use ($admin) {
      $mail->from($this->from);
      $mail->to(env('ICS_WEBSITE_OWNER'), "$admin->name $admin->lastname")
      ->subject(trans('pickup.prealerted'));
      });
    } catch ( Exception $e ) {
      return redirect("/account/prealert")->with('errorMessage', trans('package.createdNoMail', [
        'error' => $e->getMessage(),
        'code'  => $pickup->code
      ]));
    }
    /**
    *
    */
    return redirect("/account/prealert")->with('successMessage', trans('package.created', [
      'code'     => $pickup->code
    ]));
  }
  /**
  *
  */
  public function prealertDetails(Request $request, $id, $readonly = false) {

    $session    = $request->session()->get('key-sesion');
    $admin      = $request->session()->get('key-sesion')['data'];
    $edit       = true;
    /**
    *
    */
    if ( $session == null ) {
      return redirect('login');
    }
    $pickup = Pickup::find($id);
    /**
    *
    */
    if (is_null($pickup) || $pickup->user != $admin->id) {
     return redirect('account/prealert');
    }
    $attachment = Attachment::query()->where('pickup', '=', $pickup->id)->get();
    /**
    *
    */
    $vars = [
      'pickup'      => $pickup,
      'attachments' => $attachment,
      'edit'        => $edit,
      'numberparts' => NumberParts::all(),
      'users'       => array($admin),
      'usercons'    => isset($pickup->consigner_user) ? User::find($pickup->consigner_user)->first():null,
      'userdestin'  => isset($pickup->to_user) ? User::find($pickup->to_user)->first():null,
      'couriers'    => Courier::byStatus()->get(),
      'typepickup'  => TypePickup::all(),
      'transports'  => Transport::all(),
      'office'      => Office::all(),
      'consolidated'=> Consolidated::byStatus(1)->get(),
      'services'    => Service::all(),
      'category'    => Category::all(),
      'start_at'    => Carbon::now()->format('Y-m-d'),
      'addcharges'  => AddCharge::all(),
      'countries'   => Country::all(),
      'promotions'  => Promotion::all(),
      'suppliers'   => Suppliers::all(),
      'transporters'=> Transporters::all(),
      'taxxes'      => (isset($request->all()['tax1']) ? $taxss : ''),
      'readonly'    => $readonly,
      'details'     => DetailsPickup::byPickup($pickup->id)->get(),
      'cookie'      => Cookie::get('storage_data')
    ];
    /**
    * Se obtiene la vista para editar
    */
    if ( $this->isGET($request) ) {
      return view('pages.admin.pickup.edit', $vars);
    }
    /**
    *
    */
    $destin = (($request->all()['consigner'] == '')||(!isset($request->all()['consigner']))) ? null :$request->all()['consigner'];
    if ( $destin == '0' ) {
      $type_destin = 0;
      $destin = $admin->id;
    } else {
      $type_destin = $destin;
    }
    /**
    *
    */
    $pickupData = [
      'from_courier'        => isset($request->all()['courierSelect']) ? $request->all()['courierSelect'] : null,
      'promotion'           => null,
      'observation'         => null,
      'insurance'           => null,
      'volumetricweightm'   => $request->all()['volumetricweightm1'],
      'volumetricweighta'   => $request->all()['volumetricweighta1'],
      'costservice'         => null,
      'costinsurance'       => null,
      'aditionalcost'       => null,
      'subtotal'            => null,
      'total'               => null,
      'tax'                 => null,
      'pro'                 => null,
      'value'               => null,
      'type'                => null,
      'details_type'        => null,
      'category'            => null,
      'office'              => null,
      'typeservice'         => null,
      'start_at'            => null,
      'to_user'             => $destin,
      'consigner_phone'     => (($request->all()['cons_phone'] == '')||(!isset($request->all()['cons_phone']))) ? null :$request->all()['cons_phone'],
      'consigner_phone'     => (($request->all()['destin_name'] == '')||(!isset($request->all()['cons_name']))) ? null :$request->all()['cons_name'],
      'consigner_user'      => (($request->all()['exporter'] == '0')||(!isset($request->all()['exporter'])))? null:$request->all()['exporter'],
      'addcharge'           => (!isset($request->all()['addcharge']) || $request->all()['addcharge'] == "") ? 0 : $request->all()['addcharge'],
      'invoice'           => ((!isset($request->all()['invoiced1'])||($request->all()['invoiced1'] == '')||($request->all()['invoiced1'] == null)))? '' :$request->all()['invoiced1'],
      'last_event'          => 1,
      'notes'               => (!isset($request->all()['notes'])||($request->all()['notes']=='')) ? null : $request->all()['notes'],
      'country_shipper'     => (!isset($request->all()['cons_country'])||($request->all()['cons_country']=='')) ? null : $request->all()['cons_country'],
      'region_shipper'      => (!isset($request->all()['cons_region'])||($request->all()['cons_region']=='')) ? null : $request->all()['cons_region'],
      'city_shipper'        => (!isset($request->all()['cons_city'])||($request->all()['cons_city']=='')) ? null : $request->all()['cons_city'],
      'shipper_phone'       => (!isset($request->all()['destin_phone'])||($request->all()['destin_phone']=='')) ? null : $request->all()['destin_phone'],
      'address_shipper'     => (!isset($request->all()['cons_direction'])||($request->all()['cons_direction']=='')) ? null : $request->all()['cons_direction'],
      'location_shipper'    => (!isset($request->all()['consigner_dir'])||($request->all()['exporter_dir']=='')) ? '0' : $request->all()['exporter_dir'],
      'country_consig'      => (!isset($request->all()['destin_country'])||($request->all()['destin_country']=='')) ? null : $request->all()['destin_country'],
      'region_consig'       => (!isset($request->all()['destin_region'])||($request->all()['destin_region']=='')) ? null : $request->all()['destin_region'],
      'city_consig'         => (!isset($request->all()['destin_city'])||($request->all()['destin_city']=='')) ? null : $request->all()['destin_city'],
      'address_consig'      => (!isset($request->all()['destin_direction'])||($request->all()['destin_direction']=='')) ? null : $request->all()['destin_direction'],
      'location_consig'     => (!isset($request->all()['exporter_dir'])||($request->all()['exporter_dir']=='')) ? '0' : $request->all()['exporter_dir'],
      'provider'            => (!isset($request->all()['supplier'])||($request->all()['supplier']=='')) ? '0' : $request->all()['supplier'],
      'po_number'           => (!isset($request->all()['purchase_order'])||($request->all()['purchase_order']=='')) ? null : $request->all()['purchase_order'],
      'transporter'         => (!isset($request->all()['transporter'])||($request->all()['transporter']=='')) ? '0' : $request->all()['transporter'],
      'trans_tracking'      => (!isset($request->all()['tracking_transporter'])||($request->all()['tracking_transporter']=='')) ? null : $request->all()['tracking_transporter'],
      'pickup_number'       => (!isset($request->all()['pickup_number'])||($request->all()['pickup_number']=='')) ? null : $request->all()['pickup_number'],
      'pickup_date'         => $request->all()['pickup_date'].' '.$request->all()['pickup_hour'],
      'deliver_date'        => $request->all()['deliver_date'].' '.$request->all()['deliver_hour']
    ];
    /**
    *
    */
    $pickup->update($pickupData);
    $pickup->save();
    $files = Input::file('upload_file');
    mkdir(asset('/uploads/').$pickup->code,0777,true);
    if ( $files[0] != '' ) {
      foreach ( $files as $file ) {
        $aleatorio      = str_random();
        $nombre         = $aleatorio.'_'.$file->getClientOriginalName();
        $file->move('uploads/'.$pickup->code."/", $nombre);

        $data = [
          'shipment'      => null,
          'booking'       => null,
          'warehouse'     => null,
          'pickup'        => $pickup->id,
          'cargo_release' => null,
          'transporters'  => null,
          'suppliers'     => null,
          'path'          => asset('/uploads/').'/'.$pickup->code."/".$nombre,
          'name_path'     => $nombre,
          'operator'      => $admin->id
        ];
        $attachment = Attachment::create($data);
      }
    }
    /**
    *
    */
    DB::table('detailspackage')->where('package', '=', $pickup->id)->delete();
    /**
    *
    */
    //$pickupdetails = DetailsPickup::query()->where('pickup','=',$id)->get();
    DB::table('details_pickup_order')->where('pickup', '=', $pickup->id)->delete();
    for ($i = 1; $i <= $request->all()['countpack']; $i++) {
      $pickupdetailsData = [
      'description'  => $request->all()['description'.$i],
      //'typepickup'        => isset($request->all()['typepickup'.$i]) ? $request->all()['typepickup'.$i] : null,
      'numberparts' => isset($request->all()['numberparts'.$i]) ? $request->all()['numberparts'.$i] : "",
      'pieces' => $request->all()['pieces'.$i],
      'large' => $request->all()['large'.$i],
      'width' => $request->all()['width'.$i],
      'height' => $request->all()['height'.$i],
      'weight' => $request->all()['weight'.$i],
      'volumetricweightm' => $request->all()['volumetricweightm'.$i],
      'volumetricweighta' => $request->all()['volumetricweighta'.$i],
      'value' => $request->all()['valued'.$i],
      //'invoice'           => $request->all()['invoiced'.$i],
      'invoice' => ((!isset($request->all()['invoiced'.$i])||($request->all()['invoiced'.$i] == '')||($request->all()['invoiced'.$i] == null)))? '' :$request->all()['invoiced'.$i],
      //  'po'                => $request->all()['po'.$i],
      'pickup' => $pickup->id
      ];
      //dd($pickupdetailsData);
      $pickupdetails=DetailsPickup::create($pickupdetailsData);
    }
    /**
    *
    */
    return redirect("/account/prealert")->with('successMessage', trans('package.updated', [
      'name' => $pickup->name,
      'code' => $pickup->code
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
    if ( $session == null ) {
      return view('sections.restart-session');
    }
    /**
    *
    */
    $session  = $request->session()->get('key-sesion');
    $pickup = Pickup::find($id);
    $packageLog = Log::ByPickup($pickup->id)->get();
    $invoice = File::query()->where("id_package", "=", $id)->get();
    $detailspackage  = DetailsPickup::query()->where('pickup','=',$id)->get();
    $event = PickupStatus::query()->where('active','=','1')->get();
    $events_number = PickupStatus::query()->where('active','=','1')->count();
    $attachment = Attachment::query()->where('pickup','=',$id)->get();
    /**
    *
    */
    $companyclient = "";
    if ( isset($pickup->to_client) ) {
      $client = Client::find($pickup->to_client);
      $companyclient = Company::find($client->company);
    }
    /**
    *
    */
    $vars = [
      'package'      => $pickup,
      'attachments'  => $attachment,
      'detailspack'  => $detailspackage,
      'packageLog'   => $packageLog,
      'event'        => $event,
      'events_num'   => $events_number,
      'invoice'      => $invoice,
      'companyclient'=> $companyclient
    ];
    /**
    * Se obtiene la vista para ver detalles del paquete
    */
    return view('pages.admin.pickup.view', $vars);
  }
  /**
  * retorna los paquetes asociados a un pickup
  */
  public function prealertDetailsPackage (Request $request,  $id) {
    $pickup = Pickup::find($id);
    $details = DetailsPickup::byPickup($pickup->id)->get();
    return response()->json([
      'message' => true,
      'alert'   => $details
    ]);
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
  /**
   * 
   */
  private function validateData(Request $request) {
    return Validator::make($this->clear($request->all()), [
      'name'         => 'required|string|min:3|max:100|unique:typepickup,name',
      'description'  => 'required|string|min:3|max:100|unique:typepickup,description'
    ]);
  }

}
