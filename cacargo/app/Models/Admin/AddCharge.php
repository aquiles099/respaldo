<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Hash;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class AddCharge extends Model
{
     use SoftDeletes;
    /**
   *
   */
  const TABLE = 'addcharges';

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
    'description',
    'value'
  ];

  public function toOption() {
      return ['id' => $this->id, 'text' => "$this->name $this->value",'price' => "$this->value"];
  }

  /**
  * Se genera el codigo
  */
  protected static function boot()
    {
      parent::boot();
      AddCharge::creating(function(AddCharge $addcharge)
      {
        if($addcharge->id == null || $addcharge->id == '' || $addcharge->id == -1)
        {
          $addcharge->id = DB::select('select seq_addcharges_func() as id')[0]->id;
        }
        // conversion a hexadecimal
        if($addcharge->code == null || $addcharge->code == '')
        {
          $addcharge->code = "ACH-".str_pad($addcharge->id,5,'0',STR_PAD_LEFT);
        }
      });
    }
}
