<?php

namespace App\Models\Admin;

use Hash;
use DB;
use App\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Admin\Company;

/**
 * User: jrodriguez
 */
class Client extends Model {
  use SoftDeletes;

  /**
   *
   */
  protected $with = [
    'getCompany'
  ];

  /**
   *
   */
  public $incrementing = false;

  /**
   *
   */
  const TABLE = 'client';

  /**
   * @var string
   */
  protected $table = self::TABLE;

  /**
   * @var bool
   */
  public $timestamps = true;

  /**
   *
   */
  protected $fillable = [
    'code',
    'name',
    'direction',
    'phone',
    'email',
    'identifier',
    'company'
  ];

  /**
   * @var array
   */
  protected $hidden = [

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
   * @param $name
   */
  public function setIdentifierAttribute($identifier) {
    if (!empty($identifier)) {
      $this->attributes['identifier'] = strtolower($identifier);
    }
  }

  /**
   *
   */
  public function toOption() {
    return ['id'=>$this->id, 'text'=>"$this->code $this->name $this->email"];
  }

  /**
   * @param $direction
   */
  public function setDirectionAttribute($direction) {
    if (!empty($direction)) {
      $this->attributes['direction'] = strtolower($direction);
    }
  }


  /**
   * @param $email
   */
  public function setEmailAttribute($email) {
    if (!empty($email)) {
      $this->attributes['email'] = strtolower($email);
    }
  }

  /**
   *
   */
  protected static function boot() {
    parent::boot();
    Client::creating(function(Client $client) {
      if($client->id == null || $client->id == '' || $client->id == -1) {
        $client->id = DB::select('select seq_client_func() as id')[0]->id;
      }
      //
      if($client->code == null || $client->code == '') {
        $client->code = toBase36($client->id);
      }
    });
  }

  /**
   *
   */
  public function getCompany() {
      return $this->hasOne('App\Models\Admin\Company', 'id', 'company');
  }

  /**
   *
   */
  public function scopeByCompany($query, $value) {
      if($value instanceof Company) {
        return $query->where('company', '=', $value->id);
      } else if(is_integer($value)) {
        return $query->where('company', '=', $value);
      } else if(is_string($value) && is_numeric($value)) {
        return $query->where('company', '=', intval($value));
      }
      return $query;
  }

}
