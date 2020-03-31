<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Hash;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Receipt extends Model
{
 //
   protected $with = [
    'getPackage',
    'getInvoice'
  ];

  /**
   *
   */
  public $incrementing = true;

  /**
   *
   */
  const TABLE = 'receipt';

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
      'id',
      'code',
      'package',
      'pickup',
      'observation',
      'subtotal',
      'total',
      'invoice'
   ];

   public function setNameAttribute($name)
   {
      if (!empty($name))
      {
         $this->attributes['observation'] = strtolower($name);
      }
    }
  /**
  *
  */
  public function getPackage()
  {
      return $this->hasOne('App\Models\Admin\Package', 'id', 'package');
  }
  /**
  *
  */
   public function getPickup()
   {
        return $this->hasOne('App\Models\Admin\Pickup', 'id', 'pickup');
   }
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
   public function toOption()
   {
      return ['id' => $this->id, 'text' => "$this->observation $this->subtotal"];
   }
  /**
  *
  */
   public function scopeByPackage($query, $value)
   {
      return $query->where('package', '=', $value);
   }
  /**
  *
  */
  public function scopeByInvoice($query, $value)
  {
     return $query->where('invoice', '=', $value);
  }
  /**
   * Se genera el codigo
   */
  protected static function boot()
  {
    parent::boot();
    Receipt::creating(function(Receipt $receipt)
    {
      if($receipt->id == null || $receipt->id == '' || $receipt->id == -1)
      {
        $receipt->id = DB::select('select seq_receipt_func() as id')[0]->id;
      }
      // conversion a hexadecimal
      if($receipt->code == null || $receipt->code == '')
      {
        $receipt->code = "RCP-".toBase36($receipt->id);
      }
    });
  }
}
