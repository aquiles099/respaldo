<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Pagination\Paginator;
use Illuminate\Http\Request;
use App\Models\Admin\Log;

class Controller extends BaseController {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    /**
    *
    */
    protected function isGET (Request $request) {
      return $request->method() == 'GET';
    }
    /**
    *
    */
    protected function clear ($data) {
      return clear($data);
    }
    /**
    *
    */
    protected function doRedirect(Request $request, $path) {
      $from = $request->input('from');
      return redirect(is_null($from)? $path : $from);
    }
    /**
    *
    */
    protected function registerLog ($data) {
      $register = Log::create($data);
    }
    /**
    * Retorna los perfiles  Macro y Micro para la seleccion del usuario
    */
    protected function profilesICS () {
      $profiles = [
        ['id'  => 1 , 'text'=> trans('messages.basicICS') ],
        ['id'  => 2 , 'text'=> trans('messages.profesionalICS')]
      ];
      return $profiles;
    }
    /**
    * Retorna status activo a nivel general
    */
    protected function generalStatus () {
      $status = [
        [
          'id'  => 1 ,
          'text'=> trans('messages.active')
        ],
        [
          'id'  => 0 ,
          'text'=> trans('messages.inactive')
        ]
      ];
      return $status;
    }
    /**
    *
    */
    protected function paymentType () {
      $type = [
        [
          'id'     => 1,
          'text'   => trans('messages.paypal')
        ],
        [
          'id'     => 2,
          'text'   => trans('messages.bankdeposit')
        ],
        [
          'id'     => 3,
          'text'   => trans('messages.transfer')
        ]
      ];
      return $type;
    }
    /**
    *
    */
    protected function timeContract () {
      $time = [
        [
          'id'   => 1,
          'text' => trans('messages.oneyear'),
          'amount' => '100.00'
        ],
        [
          'id'   => 2,
          'text' => trans('messages.twoyear'),
          'amount' => '180.00'
        ],
        [
          'id'   => 3,
          'text' => trans('messages.threeyear'),
          'amount' => '270.00'
        ]
      ];
      return $time;
    }
    /**
    *
    */
    protected function paymentStatus () {
      $status = [
        [
          'id'   => 1,
          'text' => trans('payment.hold')
        ],
        [
          'id'   => 2,
          'text' => trans('payment.denied')
        ],
        [
          'id'   => 3,
          'text' => trans('payment.aproved')
        ]
      ];
      return $status;
    }

}
