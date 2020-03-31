<?php

namespace App\Models\Admin;

use App\Models\Model;
use Hash;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use App\Models\Admin\Receipt;

class Invoice extends Model
{
  use SoftDeletes;

  /**
   *
   */
  protected $with = [

  ];
  /**
   *
   */
  public $incrementing = true;
  /**
   *
   */
  const TABLE = 'invoice';
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
     'status',
     'value',
     'receipt'
   ];
   /**
   *
   */
   public function toOption() {
      return ['id' => $this->id, 'text' => "$this->id $this->value"];
   }
   /**
   *
   */
   public function scopeByStatus($query, $value) {
     return $query->where('status', '=', $value);
   }
   /**
   *
   */
   public function scopeByReceipt($query, $value) {
     return $query->where('receipt', '=', $value);
   }
   /**
    * Se genera el codigo
    */
   protected static function boot() {
     parent::boot();
     Invoice::creating(function(Invoice $invoice){
       if($invoice->id == null || $invoice->id == '' || $invoice->id == -1){
         $invoice->id = DB::select('select seq_invoice_func() as id')[0]->id;
       }
        /**
        *
        */
       if($invoice->code == null || $invoice->code == '') {
         $invoice->code = "INV-".toBase36($invoice->id);
       }
     });
   }
}
