<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Hash;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Suppliers extends Model
{
     use SoftDeletes;
    /**
   *
   */
  const TABLE = 'suppliers';

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
    'note',
    'operator'
  ];

  public function toOption() {
      return ['id' => $this->id, 'text' => "$this->name $this->value",'price' => "$this->value"];

  }

  protected static function boot()
    {
      parent::boot();
      Suppliers::creating(function(Suppliers $suppliers)
      {
        if($suppliers->id == null || $suppliers->id == '' || $suppliers->id == -1)
        {
          $suppliers->id = DB::select('select seq_suppliers_func() as id')[0]->id;
        }
        // conversion a hexadecimal
        if($suppliers->code == null || $suppliers->code == '')
        {
          $suppliers->code = "PROV-".str_pad($suppliers->id,5,'0',STR_PAD_LEFT);
        }
      });
    }
}
