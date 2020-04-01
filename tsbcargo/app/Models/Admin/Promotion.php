<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Model;
use DB;
use App\Models\Admin\Client;


class Promotion extends Model
{
  //
  use SoftDeletes;

  /**
   *
   */
  protected $with = [
    'getUserType',
    'getTransport'
  ];

  /**
   *
   */
  public $incrementing = true;

  /**
   *
   */
  const TABLE = 'promotion';

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
      'name',
      'type_value',
      'value',
      'user_type',
      'transport',
      'start_date',
      'end_date',
      'status'
    ];
    /**
     * @param $name
     */
    public function setNameAttribute($name) {
      if (!empty($name)) {
         $this->attributes['name'] = strtolower($name);
    	}
    }
    /**
     *
     */
    public function toOption() {
      return ['id' => $this->id, 'text' => "$this->name $this->start_date $this->end_date",   'reduction' => "$this->value"];
    }
    /**
     *
     */
    public function getUserType() {
      return $this->hasOne('App\Models\Admin\User','id','user_type');
    }
    /**
    *
    */
    public function getTransport() {
      return $this->hasOne('App\Models\Admin\Transport','id','transport');
    }
    /**
     *
     */
    public function scopeByUserType($query, $value)
    {
        if($value instanceof User) {
          return $query->where('user_type', '=', $value->id);
        } else if(is_integer($value)) {
          return $query->where('user_type', '=', $value);
        } else if(is_string($value) && is_numeric($value)) {
          return $query->where('user_type', '=', intval($value));
        }
        return $query;
    }
    /**
     * Se genera el codigo
     */
    protected static function boot()
    {
      parent::boot();
      Promotion::creating(function(Promotion $promotion)
      {
        if($promotion->id == null || $promotion->id == '' || $promotion->id == -1)
        {
          $promotion->id = DB::select('select seq_promotion_func() as id')[0]->id;
        }
        // conversion a hexadecimal
        if($promotion->code == null || $promotion->code == '')
        {
          $promotion->code = "PRO-".str_pad($promotion->id,5,'0',STR_PAD_LEFT);
        }
      });
    }
}
