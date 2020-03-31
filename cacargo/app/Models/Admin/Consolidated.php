<?php

namespace App\Models\Admin;


use App\Models\Model;
use Hash;
use DB;

class Consolidated  extends Model {

  /**
   *
   */
  const TABLE = 'consolidated';
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
    'description',
    'observation',
    'status',
    'last_event'
  ];
  /**
   *
   */
  protected $with = [];
  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [];
  /**
   *
   */
  public function toOption() {
    return ['id'=>$this->id, 'text'=>"$this->code $this->description"];
  }
  /**
   * @param $name
   */
  public function setDescriptionAttribute($description) {
    if (!empty($description)) {
      $this->attributes['description'] = strtolower($description);
    }
  }
  /**
   * @param $email
   */
  public function setObservationAttribute($observation) {
    if (!empty($observation)) {
      $this->attributes['observation'] = strtolower($observation);
    }
  }
  /**
  *
  */
  public function getLastEvent() {
    return $this->hasOne('App\Models\Admin\Event', 'id', 'last_event');
  }
  /**
  *
  */
   public function getPackagesCount($value) {
      return DB::table('package')->where('consolidated', '=', $value)->count();
   }
  /**
   *
   */
  public function scopeById($query, $value) {
      return $query->where('id', '=', $value);
  }
  /**
  *
  */
    public function scopeBystatus($query, $value) {
      return $query->where('status', '=', $value);
  }
  /**
   * Se genera el codigo
   */
  protected static function boot() {
    parent::boot();
    Consolidated::creating(function(Consolidated $consolidated) {
      if($consolidated->id == null || $consolidated->id == '' || $consolidated->id == -1) {
        $consolidated->id = DB::select('select seq_consolidated_func() as id')[0]->id;
      }
      // conversion a hexadecimal
      if($consolidated->code == null || $consolidated->code == '') {
        $consolidated->code = "CNS-".str_pad($consolidated->id,5,'0',STR_PAD_LEFT);
      }
    });
  }
}
