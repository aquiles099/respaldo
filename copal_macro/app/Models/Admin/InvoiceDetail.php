<?php

namespace App\Models\Admin;

use App\Models\Model;
use Hash;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use App\Models\Admin\Invoice;

class InvoiceDetail extends Model
{
  use SoftDeletes;

  /**
   *
   */
  protected $with = [
    'getInvoice'
  ];
  /**
   *
   */
  public $incrementing = true;
  /**
   *
   */
  const TABLE = 'invoice_detail';
  /**
   * @var string
   */
  protected $table = self::TABLE;
  /**
   * @var bool
   */
  public $timestamps = true;

  /**
   * @var array
   */
  protected $hidden = [

  ];
  /**
  *
  */
   protected $fillable = [
     'invoice',
     'paidOut',
     'debt',
     'type',
     'observation'
   ];

   /**
   *
   */
   public function getInvoice()
   {
       return $this->hasOne('App\Models\Admin\Invoice', 'id', 'invoice');
   }

   /**
   *
   */
   public function scopeByInvoice($query, $value)
   {
     return $query->where('invoice', '=', $value);
   }
}
