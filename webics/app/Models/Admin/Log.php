<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Log extends Model {
  /**
  *
  */
  use SoftDeletes;
	/**
	*
	*/
	const TABLE = 'log';
	/**
	*
	*/
	protected $table = self::TABLE;
	/**
	* The attributes that are mass assignable.
	*/
protected $fillable = [
  'admin',
  'client',
  'notice',
  'solicitude',
  'contract',
  'test',
  'contact',
  'status',
  'payment',
  'billing',
  'description'
	];
  /**
  *
  */
  public function getUser () {
    return $this->hasOne('App\Models\Admin\User', 'id', 'admin');
  }
  /**
  *
  */
  public function getClient () {
    return $this->hasOne('App\Models\Admin\Client', 'id', 'client');
  }
  /**
  *
  */
  public function getNotice () {
    return $this->hasOne('App\Models\Admin\Notice', 'id', 'notice');
  }
  /**
  *
  */
  public function getSolicitude () {
    return $this->hasOne('App\Models\Admin\Solicitude', 'id', 'solicitude');
  }
  /**
  *
  */
  public function getContract () {
    return $this->hasOne('App\Models\Admin\Contract', 'id', 'contract');
  }
  /**
  *
  */
  public function scopeBySolicitude ($query, $value) {
    return $query->where('solicitude', '=', $value);
  }
  /**
  *
  */
  public function scopeByTest ($query, $value) {
    return $query->where('test', '=', $value);
  }
  /**
  *
  */
  public function scopeByUser ($query, $value) {
    return $query->where('admin', '=', $value);
  }
  /**
  *
  */
  public function getStatus () {
    return $this->hasOne('App\Models\Admin\Status', 'id', 'status');
  }
  /**
  *
  */
  public function scopeByPayment ($query, $value) {
    return $query->where('payment', '=', $value);
  }
}
