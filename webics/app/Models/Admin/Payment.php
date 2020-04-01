<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\HPayment;


class Payment extends Model {
  /**
  *
  */
  use SoftDeletes;
  /**
  *
  */
  protected $with = [
    'getSolicitude'
  ];
  /**
  *
  */
  const TABLE = 'payment';
  /**
  *
  */
  protected $table = self::TABLE;
  /**
  *
  */
  protected $fillable = [
    'type',
    'solicitude',
    'years',
    'amount',
    'bank',
    'transaction',
    'observation',
    'attachment',
    'status',
    'description',
    'concept',
    'billing'
  ];
  /**
  *
  */
  public function getSolicitude () {
    return $this->hasOne('App\Models\Admin\Solicitude', 'id', 'solicitude');
  }
  /**
   *
   */
  public function scopeByBilling ($query, $value) {
    return $query->where('billing', '=', $value);
  }
  /**
  *
  */
  protected static function boot() {
  parent::boot();
    /**
    * Before Create
    */
    Payment::creating(function (Payment $payment) {
      if($payment->id == null || $payment->id == '' || $payment->id == -1) {
        $payment->id = DB::select('select seq_payment_func() as id')[0]->id;
      }
      /**
      * se crea el codigo del pago
      */
      if($payment->code == null || $payment->code == '') {
        $payment->code   = "PAY-".toBase36($payment->id);
        $payment->type   = trans('messages.bank');
        $payment->status = HPayment::HOLD;
      }
      /**
      * se procesa el archivo [alamacenamiento y establecimento de path]
      */
      if(isset($payment->attachment) && $payment->attachment != NULL) {
        $name_img = str_random()."_".$payment->attachment->getClientOriginalName();
        $name_img = str_replace(" ", "", $name_img);
        $payment->attachment->move('uploads/images/payment/attachment', $name_img);
        $payment->attachment = asset('uploads/images/payment/attachment/'.$name_img);
      }
    });
  }
}
