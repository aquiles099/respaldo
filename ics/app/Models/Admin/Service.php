<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Hash;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Service extends Model
{
  use SoftDeletes;
    /**
   *
   */
  const TABLE = 'service';

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
    'code',
    'name',
    'transport',
    'description',
    'value'
  ];
  /**
  *
  */

  public function getTransport() {
     return $this->hasOne('App\Models\Admin\Transport', 'id', 'transport');
  }

  public function scopeByTransport($query, $value) {
    return $query->where('transport', '=', $value);
  }
  public function toOption() {
      return ['id' => $this->id, 'text' => "$this->name $this->value",'price' => "$this->value"];
  }
  /**
   * Se genera el codigo
   */
  protected static function boot() {
    parent::boot();
    Service::creating(function(Service $service){
      if($service->id == null || $service->id == '' || $service->id == -1){
        $service->id = DB::select('select seq_service_func() as id')[0]->id;
      }
       /**
       *
       */
      if($service->code == null || $service->code == '') {
        $service->code = "SRV-".str_pad($service->id,5,'0',STR_PAD_LEFT);
      }
    });
  }
}
