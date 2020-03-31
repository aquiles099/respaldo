<?php

namespace App\Models\Admin;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Package;
use App\Models\Admin\Courier;
use DB;
use Hash;

class File extends Model
{
  use SoftDeletes;

  /**
   *
   */
  protected $with = [
    'getIdPackage',
    'getIdCarrier'
  ];
  /**
   *
   */
  public $incrementing = true;
  /**
   *
   */
  const TABLE = 'file';
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
     'name',
     'path',
     'id_package',
     'carrier',
     'contentPackage',
     'pricePackage'
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
   public function getIdPackage() {
     return $this->hasOne('App\Models\Admin\Package','id','id_package');
   }
   /**
    *
    */
   public function getIdCarrier() {
     return $this->hasOne('App\Models\Admin\Courier','id','carrier');
   }
   /**
    *
    */
   public function toOption() {
     return ['id' => $this->id, 'text' => "$this->name"];
   }
   /**
    *
    */
   public function scopeByIdPackage($query, $value)
   {
       if($value instanceof User) {
         return $query->where('id_package', '=', $value->id);
       } else if(is_integer($value)) {
         return $query->where('id_package', '=', $value);
       } else if(is_string($value) && is_numeric($value)) {
         return $query->where('id_package', '=', intval($value));
       }
       return $query;
   }

   /**
    *
    */
   public function scopeBygetIdCarrier($query, $value)
   {
       if($value instanceof User) {
         return $query->where('carrier', '=', $value->id);
       } else if(is_integer($value)) {
         return $query->where('carrier', '=', $value);
       } else if(is_string($value) && is_numeric($value)) {
         return $query->where('carrier', '=', intval($value));
       }
       return $query;
   }

}
