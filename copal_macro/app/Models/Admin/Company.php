<?php

namespace App\Models\Admin;

use App\Models\Model;
use Hash;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

/**
 * User: jrodriguez
 */
class Company extends Model {
  use SoftDeletes;

  /**
   *
   */
  public $incrementing = false;

  /**
   *
   */
  const TABLE = 'company';

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
    'id',
    'name',
    'ruc',
    'direction',
    'phone_01',
    'phone_02',
    'email_01',
    'email_02',
    'code'
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
   * @param $direction
   */
  public function setDirectionAttribute($direction) {
    if (!empty($direction)) {
      $this->attributes['direction'] = strtolower($direction);
    }
  }

  /**
   * @param $username
   */
  public function setRucAttribute($ruc) {
    if (!empty($ruc)) {
      $this->attributes['ruc'] = strtolower($ruc);
    }
  }

  /**
   * @param $email
   */
  public function setEmail01Attribute($email) {
    if (!empty($email)) {
      $this->attributes['email_01'] = strtolower($email);
    }
  }

  /**
   * @param $email
   */
  public function setEmail02Attribute($email) {
    if (!empty($email)) {
      $this->attributes['email_02'] = strtolower($email);
    }
  }

  /**
   *
   */
  public function toOption() {
    return ['id'=>$this->id, 'text'=> "$this->name"];
  }

  /**
   * Se genera el codigo
   */
  protected static function boot()
  {
    parent::boot();
    Company::creating(function(Company $company) {
      if($company->id == null || $company->id == '' || $company->id == -1) {
        $company->id = DB::select('select seq_company_func() as id')[0]->id;
      }
      // conversion a hexadecimal
      if($company->code == null || $company->code == '') {
        $company->code = "CMP-".toBase36($company->id);
      }
    });
  }

}
