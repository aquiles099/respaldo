<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Hash;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Transporters extends Model
{
   use SoftDeletes;
    /**
   *
   */
  const TABLE = 'transporters';

   /**
   *
   */
  public $incrementing = true;

  /**
   * @var string
   */
  protected $table = self::TABLE;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'id',
    'name',
    'identification',
    'phone',
    'fax',
    'email',
    'account_number',
    'web',
    'name_contac',
    'lastname_contac',
    'exportation',
    'divition',
    'address_street',
    'address_city',
    'address_country',
    'address_state',
    'address_code',
    'address_port',
    'billing_address_street',
    'billing_address_city',
    'billing_address_country',
    'billing_address_state',
    'billing_address_code',
    'billing_address_port',
    'payments_term_terms',
    'payments_term_pays',
    'payments_term_coin',
    'payments_term_creditlimit',
    'payments_term_bill',
    'attachments',
    'transport',
    'numberfmc',
    'numberscac',
    'numberiata',
    'codeair',
    'numbercodeair',
    'guidenumber',
    'operator'
  ];
  /**
  *
  */
  public function scopeByTransport($query, $value) {
     return $query->where('transport', '=', $value);
  }
  /**
  *
  */
  protected static function boot()
    {
      parent::boot();
      Transporters::creating(function(Transporters $transporters)
      {
        if($transporters->id == null || $transporters->id == '' || $transporters->id == -1)
        {
          $transporters->id = DB::select('select seq_transporters_func() as id')[0]->id;
        }
        // conversion a hexadecimal
        if($transporters->code == null || $transporters->code == '')
        {
          $transporters->code = "TRTA-".str_pad($transporters->id,5,'0',STR_PAD_LEFT);
        }
      });
    }
}
