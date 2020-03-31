<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Admin\User;
use App\Models\Admin\Transport;
use App\Models\Admin\Transporters;
use App\Models\Admin\Country;
use App\Models\Admin\Package;
use App\Models\Admin\Detailspackage;
use App\Models\Admin\Container;
use App\Models\Admin\Booking;
use App\Models\Admin\BookingStatus;
use App\Models\Admin\Operator;
use App\Models\Admin\BookingDetail;
use App\Models\Admin\Event;
use App\Models\Admin\Log;
use App\Models\Admin\Attachment;
use Validator;
use Input;
use DB;
use App\Models\Admin\Configuration;
use \Mail;
use App\Helpers\HConstants;
use Crypt;


class BookingController extends Controller
{
    /**
    * Initial process
    */
    public function index(Request $request) {
      $session = $request->session()->get('key-sesion');
      $bookingCourse = $this->bookingCourse();
      $booking = Booking::orderBy('created_at', 'desc')->get();
      /**
      *
      */
      if($session == null) {
        return redirect('login');
      }
      /**
      *
      */
      $vars = [
        'bookingCourse' => $bookingCourse,
        'booking'       => $booking
      ];
      /**
      *
      */
      return view('pages.admin.booking.list',$vars);
    }
    /**
    * Editar booking
    */
    public function details(Request $request, $id, $readonly = false) {
      $session        = $request->session()->get('key-sesion');
      $booking        = Booking::find($id);
      $bookingCourse  = $this->bookingCourse();
      $countrys       = Country::all();
      $transport      = Transport::all();
      $container      = Container::all();
      $users          = User::all();
      $transporters      = Transporters::all();
      $operators          = Operator::all();

      /**
      * se valida la existencia de la reserva, si falla se redirige al listado
      */
      if(is_null($booking)) {
        return $this->doRedirect($request, '/admin/bookings')
          ->with('errorMessage', trans('booking.notFound'));
      }
      /**
      *
      */
      if($session == null) {
        return redirect('login');
      }
      /**
      *
      */
      $vars = [
        'readonly'      => $readonly,
        'booking'       => $booking,
        'container'     => $container,
        'countrys'      => $countrys,
        'transports'    => $transport,
        'users'         => $users,
        'bookingCourse' => $bookingCourse,
        'transporters'  => $transporters,
        'operators'     => $operators
      ];
      /**
      *
      */
      if($this->isGET($request)) {
        return view('pages.admin.booking.edit', $vars);
      }
      /**
      * se configura la data para la tabla booking
      */
      $data = [
        'transport'             => $request->all()['transport'],
        'course'                => $request->all()['course'],
        'from_country'          => (isset($request->all()['from_country'])&&($request->all()['from_country'] != '')) ? $request->all()['from_country'] : null,
        'to_country'            => (isset($request->all()['to_country'])&&($request->all()['to_country'] != '')) ? $request->all()['to_country'] : null,
        'since_departure_date'  => $request->all()['since_departure_date'],
        'until_departure_date'  => $request->all()['until_departure_date'],
        'since_arrived_date'    => $request->all()['since_arrived_date'],
        'until_arrived_date'    => $request->all()['until_arrived_date'],
        'declarate_goods'       => $request->all()['declarate_goods'],
        'shipper'               => $request->all()['shipperName'] == 0 ? null : $request->all()['shipperName'],
        'agent'                 => $request->all()['agentName'] == 0 ? null : $request->all()['agentName'] ,
        'consigneer'            => $request->all()['consName'] == 0 ? null : $request->all()['consName'],
        'transporter'           => $request->all()['transporter'] == 0 ? null : $request->all()['transporter'],
        'vessel'                => $request->all()['vessel'],
        'reference'             => $request->all()['references'],
        'cotiza'                => $request->all()['cotiza'],
        'employee'              => $request->all()['employee'] == 0 ? null : $request->all()['employee'],
        'dangerous'             => $request->all()['dangerous'] == 0 ? null : $request->all()['dangerous'],
        'way'                  => $request->all()['way'],
        'guide'                => $request->all()['guide'],
        'aditional_information' => $request->all()['aditional_information']
      ];
      /**
      *
      */
      $booking->update($data);
      $booking->save();
      $bookingDetail = DB::table('booking_detail')->where('booking','=',$id)->delete();
      /**
      * se crea la carga relacionada con esta reserva
      */
      for ($i = 1; $i <= $request->all()['countbooking']; $i++) {
        $bookingData = [
          'booking'         => $booking->id,
          'description'     => $request->all()['description'.$i],
          'container'       => isset($request->all()['type'.$i]) ? $request->all()['type'.$i] : null,
          'pieces'          => $request->all()['pieces'.$i],
          'large'           => $request->all()['large'.$i],
          'width'           => $request->all()['width'.$i],
          'height'          => $request->all()['height'.$i],
          'maritime_volume' => $request->all()['volumetricweightm'.$i],
          'aerial_volume'   => $request->all()['volumetricweighta'.$i],
          'weight'          => $request->all()['weight'.$i]
        ];
        /**
        *
        */
        $bookingDetail = BookingDetail::create($bookingData);
      }
      /**
      *
      */
      $attachment = Attachment::create($data);
      /**
      *
      */
      return redirect("/admin/bookings")->with('successMessage', trans('booking.updated', [
        'code' => $booking->code
      ]));
    }
    /**
    * ver modo lectura (Inhabilitado para bookings)
    */
    public function readDetails(Request $request, $id) {
      $session = $request->session()->get('key-sesion');
      /**
      *  Se valida que la sesion este activa
      */
      if ($session == null) {
        return redirect('login');
      }
      /**
      *
      */
      return $this->details($request, $id, true);
    }
    /**
    * Crear bookings
    */
    public function create(Request $request) {
      $session        = $request->session()->get('key-sesion');
      $bookingCourse  = $this->bookingCourse();
      $countrys       = Country::all();
      $users          = User::all();
      $transports     = Transport::all();
      $package        = Package::all();
      $detailsPackage = Detailspackage::all();
      $container      = Container::all();
      $admin          = $request->session()->get('key-sesion')['data'];
      $configuration = Configuration::find(HConstants::FIRST_CONFIGURATION);
      $timezone = explode(" ", $configuration->time_zone);
      date_default_timezone_set($timezone[0]);
      $transporters      = Transporters::all();
      $operators          = Operator::all();

      /**
      *
      */
      if($session == null) {
        return redirect('login');
      }
      /**
      *
      */
      $vars = [
        'bookingCourse'  => $bookingCourse,
        'users'          => $users,
        'transports'     => $transports,
        'countrys'       => $countrys,
        'package'        => $package,
        'detailsPackage' => $detailsPackage,
        'transporters'  => $transporters,
        'operators'     => $operators,
        'container'      => $container
      ];
      /**
      *
      */
      if($this->isGET($request)) {
        return view('pages.admin.booking.create',$vars);
      }
     // dd($request->all());
      if($request->all()['shipperName'] == 'adduc') ///no se selecciona cliente destino
    {
        $userCons = User::create([
          'name'           => $request->all()['cons_name'],
          'last_name'      => $request->all()['cons_lastname'],
          'dni'            => $request->all()['cons_dni'],
          'local_phone'    => $request->all()['cons_phone'],
          'celular'        => $request->all()['cons_cell'],
          'email'          => $request->all()['cons_email'],
          'postal_code'    => $request->all()['cons_zipcode'],
          'address'        => $request->all()['cons_direction'],
          'region'         => $request->all()['cons_region'],
          'country'        => $request->all()['cons_country'],
          'city'           => $request->all()['cons_city'],
          'password'       => '12345678',
          'user_type'      => 1

        ]);
        /**
        *
        */
        Mail::send('emails.check_email', [
          'host'          => $this->host,
          'link'          => "check/account/op?code={$userCons->remember_token}",
          'user'          => $userCons,
          'configuration' => $configuration,
          'password'      => Crypt::decrypt($userCons->password)
        ],
        function($mail) use ($userCons) {
          $mail->from($this->from);
          $mail->to($userCons->email , "$userCons->user $userCons->name")->subject(trans('messages.activate'));
        });
        /**
        *
        */
      //  $this->notifyUserStatus($userCons, HConstants::EVENT_RECEIVED, $userCons->id);
    }
    /**
    * esta opcion se ejecuta cuando se agreag un nuevo usuario de destino
    */
    if($request->all()['consName'] == 'addud')  {
        $userDest = User::create([
          'name'           => $request->all()['destin_name'],
          'last_name'      => $request->all()['destin_lastname'],
          'dni'            => $request->all()['destin_dni'],
          'local_phone'    => $request->all()['destin_phone'],
          'celular'        => $request->all()['destin_cell'],
          'email'          => $request->all()['destin_email'],
          'postal_code'    => $request->all()['destin_zipcode'],
          'country'        => $request->all()['destin_country'],
          'region'         => $request->all()['destin_region'],
          'city'           => $request->all()['destin_city'],
          'address'        => $request->all()['destin_direction'],
          'password'       => '12345678',
          'user_type'      => 1

        ]);
        /**
        * Se envia correo electronico
        */
         Mail::send('emails.check_email', [
          'host'          => $this->host,
          'link'          => "check/account/op?code={$userDest->remember_token}",
          'user'          => $userDest,
          'configuration' => $configuration,
          'password' => Crypt::decrypt($userDest->password)
        ],
        function($mail) use ($userDest)
        {
          $mail->from($this->from);
          $mail->to($userDest->email , "$userDest->user $userDest->name")->subject(trans('messages.activate'));
        });
        /**
        *
        */
        //$this->notifyUserStatus($userDest, HConstants::EVENT_RECEIVED, $userDest->id);
    }

    /**
    * Se realizan las validaciones del paquete, En esta condicion se valida si el paquete viene de una persona natural
    */
    if($request->all()['consName'] == "") {
       $userdestino = null;
    } elseif ($request->all()['consName'] == 'addud') {
       $userdestino = $userDest->id;
    } else {
       $userdestino = $request->all()['consName'];
    }

    if($request->all()['shipperName']==""){
      $userconsig=null;
    }elseif ($request->all()['shipperName'] == 'adduc') {
      $userconsig= $userCons->id;
    }else{
      $userconsig=$request->all()['shipperName'];
    }



      /**
      * se configura la data para la tabla booking
      */
      $data = [
        'transport'             => $request->all()['transport'],
        'course'                => $request->all()['course'],
        'from_country'          => (isset($request->all()['from_country'])&&($request->all()['from_country'] != '')) ? $request->all()['from_country'] : null,
        'to_country'            => (isset($request->all()['to_country'])&&($request->all()['to_country'] != '')) ? $request->all()['to_country'] : null,
        'since_departure_date'  => $request->all()['since_departure_date'],
        'until_departure_date'  => $request->all()['until_departure_date'],
        'since_arrived_date'    => $request->all()['since_arrived_date'],
        'until_arrived_date'    => $request->all()['until_arrived_date'],
        'declarate_goods'       => $request->all()['declarate_goods'],
        'shipper'               => $userconsig,
        'consigneer'            => $userdestino,
        'agent'                 => $request->all()['agentName'] == 0 ? null : $request->all()['agentName'] ,
        'transporter'           => $request->all()['transporter'] == 0 ? null : $request->all()['transporter'],
        'vessel'                => $request->all()['vessel'],
        'reference'             => $request->all()['references'],
        'cotiza'                => $request->all()['cotiza'],
        'employee'              => $request->all()['employee'] == 0 ? null : $request->all()['employee'],
        'dangerous'             => $request->all()['dangerous'] == 0 ? null : $request->all()['dangerous'],
        'way'                  => $request->all()['way'],
        'guide'                => $request->all()['guide'],
        'aditional_information' => $request->all()['aditional_information']
      ];
      /**
      *
      */
      $booking = Booking::create($data);

      $files = Input::file('upload_file');
        mkdir(asset('/uploads/').$booking->code);
        //$files = Request::file('upload_file');
        if ($files[0] != '') {
          foreach($files as $file) {

              $aleatorio      = str_random();
              $nombre         = $aleatorio.'_'.$file->getClientOriginalName();
              $file->move('uploads/'.$booking->code."/", $nombre);

              $data = [
              'shipment'      => null,
              'booking'       => $booking->id,
              'warehouse'     => null,
              'pickup'        => null,
              'cargo_release' => null,
              'transporters'  => null,
              'suppliers'     => null,
              'path'          => asset('/uploads/').$booking->code."/".$nombre,
              'name_path'     => $nombre,
              'operator'      => $admin->id
            ];
            $attachment = Attachment::create($data);
         }
      }
      /**
      *
      */
      for ($i = 1; $i <= $request->all()['countbooking']; $i++) {
        $bookingData = [
          'booking'           => $booking->id,
          'description'       => $request->all()['description'.$i],
          'container'         => isset($request->all()['type'.$i]) ? $request->all()['type'.$i] : null,
          'pieces'            => $request->all()['pieces'.$i],
          'large'             => $request->all()['large'.$i],
          'width'             => $request->all()['width'.$i],
          'height'            => $request->all()['height'.$i],
          'maritime_volume'   => $request->all()['volumetricweightm'.$i],
          'aerial_volume'     => $request->all()['volumetricweighta'.$i],
          'weight'            => $request->all()['weight'.$i]
        ];
        /**
        *
        */
        $bookingDetail = BookingDetail::create($bookingData);
      }
      /**
      * Se escribe en la base de datos los datos de los adjuntos relacionados con esta reserva
      * 1) se lee el xml y se agrega el pie del archivo
      * 2) se inserta en la base de datos
      * 3) se borra el archivo
      */
      $xml = 'uploads/tmp/attachment_BK.xml';
      if(file_exists($xml)) {
        /**
        *
        */
        $file = fopen($xml, "a");
        fwrite($file, "</attachment>".PHP_EOL);
        fclose($file);
  	    $xml_data = simplexml_load_file($xml);
        /**
        *
        */
        foreach ($xml_data as $key => $value) {
          $data = [
            'shipment'      => null,
            'booking'       => $booking->id,
            'warehouse'     => null,
            'pickup'        => null,
            'cargo_release' => null,
            'path'          => $value->path,
            'name_path'     => $value->name,
            'operator'      => $admin->id
          ];
          $attachment = Attachment::create($data);
        }
        /**
        *
        */
        unlink($xml);
      }
      /**
      *
      */
      $this->insertLogBooking($booking->id, '1' , ' ', null, $session['data']->id);
        return redirect("/admin/bookings")->with('successMessage', trans('booking.created', [
          'code' => $booking->code
        ]));
    }
    /**
    * retorna tipo de contendores modo json
    */
    public function type(Request $request) {
      $container = Container::all();
      /**
      *
      */
      return response()->json([
        "message" => $container
      ]);
    }
    /**
    * vista en modal
    */
    public function view(Request $request, $id) {
      $session       = $request->session()->get('key-sesion');
      $bookingDetail = BookingDetail::byBooking($id)->get();
      $booking       = Booking::find($id);
      $event         = BookingStatus::query()->where('active','=','1')->get();
      $events_number = BookingStatus::query()->where('active','=','1')->count();
      $event_list    = Log::byBooking($booking->id)->get();
      $user          = $booking->consigneer;
      /**
      *
      */
      $vars = [
        'bookingDetail' => $bookingDetail,
        'booking'       => $booking,
        'event'         => $event,
        'events_num'    => $events_number,
        'event_list'    => $event_list
      ];
      /**
      *
      */
      if($this->isGET($request)) {
        return view('pages.admin.booking.view', $vars);
      }
      /**
      *
      */
      $booking->update(['last_event' => $request->all()['status']]);
      $booking->save();
      /**
      *
      */
      $this->insertLogBooking($booking->id, $request->all()['status'] , $request->all()['observation'],$booking->getLastEvent['id'], $session['data']->id);
      /**
      * insertar en el log antes de enviar el response
    */
        //$this->notifyUserBooking($user, $request->all()['status'], $booking->id);

      return response()->json([
        'message' => true
      ]);
    }

    /**
    * Elimina booking
    */
    public function delete(Request $request, $id) {
      $redirect = $this->doRedirect($request, '/admin/bookings');
      $booking  = Booking::find($id);
      $booking_detail =BookingDetail::query()->where('booking','=',$id)->get();

      /**
      *
      */
      if(is_null($booking))
      {
        $redirect->with('errorMessage', trans('category.notFound'));
      }
      else
      {
        foreach ($booking_detail as $key => $value) {
          $value->delete();
        }
        //dd($booking);
        $booking->delete();
        $redirect->with('successMessage', trans('booking.deleted', [
          'code' => $booking->code
        ]));
      }
      /**
      *
      */
      return $redirect;
    }
    /**
    *
    */
    public function items(Request $request, $id) {
      $bookingDetail      = BookingDetail::byBooking($id)->get();
      $bookingDetailCount = BookingDetail::byBooking($id)->count();
      /**
      *
      */
      if($bookingDetail){
        return response()->json([
          "message" => 'true',
          "alert"   => $bookingDetail
        ]);
      }
      else{
        return response()->json([
          "message" => 'false'
        ]);
      }
    }
    /**
    *
    */
    public function uploadFile(Request $request) {
      $attachment = $request->file('file');
      $fileName   = str_random().'_'.$attachment->getClientOriginalName();
      $attachment->move('uploads/attachments', $fileName);
     /**
      * creamos un archivo xml para guardar los datos de los adjuntos
      */
      $xml_name = 'uploads/tmp/attachment_BK.xml';
      if(!file_exists($xml_name)) {
        $xml =
        '<?xml version="1.0" encoding="utf-8"?>
        <attachment>
          <attach>
            <name>'.$fileName.'</name>
            <path>'.asset('/uploads/tmp').'/'.$fileName.'</path>
          </attach>';
      } else {
        $xml=
        '<attach>
            <name>'.$fileName.'</name>
            <path>'.asset('/uploads/tmp').'/'.$fileName.'</path>
          </attach>';
      }
      $file = fopen($xml_name, "a");
      fwrite($file, $xml.PHP_EOL);
      fclose($file);
    }
}
