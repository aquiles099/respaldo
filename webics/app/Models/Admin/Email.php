<?php

namespace App\Models\Admin;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;

class Email extends Model {
  /**
  *
  */
  use SoftDeletes;
  /**
  *
  */
  const TABLE = 'mail';
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
    'name',
    'email',
    'subject',
    'message',
    'admin',
    'contact'
  ];
  /**
  *
  */
  public function getAdmin () {
    return $this->hasOne('App\Models\Admin\User', 'id', 'admin');
  }
  /**
  *
  */
  public function getContact () {
    return $this->hasOne('App\Models\Admin\Contact', 'id', 'contact');
  }
  /**
  *
  */
  public function getUser () {
    return $this->hasOne('App\Models\Admin\User', 'id', 'admin');  
  }
  /**
  *
  */
  public function scopeByContact ($query, $value) {
    return $query->where('contact', '=', $value);
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
  protected static function boot() {
  parent::boot();
    Email::creating(function(Email $email) {
      if (!isset($email->admin) && $email->admin == NULL) {
        $email->admin = Session::get('key-sesion')['data']->id;
      }
    });
  }
}
