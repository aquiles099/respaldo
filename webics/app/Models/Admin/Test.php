<?php

namespace App\Models\Admin;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Session;
use App\Helpers\HStatus;

class Test extends Model {
  /**
  *
  */
  use SoftDeletes;
  /**
*
*/
  const TABLE = 'test';
  /**
   *
   */
  protected $table = self::TABLE;
  /**
   *
   */
  protected $fillable = [
    'client',
    'admin',
    'solicitude',
    'accept_terms',
    'date_accept_terms',
    'cutoff_date',
    'status',
    'operators',
    'clients'
  ];
  /**
   *
   */
  protected $with = [
    'getStatus'
  ];
  /**
   *
   */
  protected $hidden = [

  ];
  /**
  *
  */
  public function getClient () {
    return $this->hasOne('App\Models\Admin\Client', 'id', 'client');
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
  public function getSolicitude () {
    return $this->hasOne('App\Models\Admin\Solicitude', 'id', 'solicitude');
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
  public function scopeByClient ($query, $value) {
    return $query->where('client', '=', $value);
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
  public function verifyContract ($id) {
    return DB::table('contract')->where('test', '=', $id)->count();
  }
  /**
  *
  */
  public function verifyIncidence ($id) {
    return DB::table('incidence')->where([['type', '=', '1'],['status','=', null],['test', '=', $id]])->count();
  }
  /**
  *
  */
  public function verifyBug ($id) {
    return DB::table('incidence')->where([['type', '=', '0'],['status','=', null],['test', '=', $id]])->count();
  }
  /**
   * Se genera el codigo
   */
  protected static function boot() {
    parent::boot();
    Test::creating(function(Test $test) {
      $date = Carbon::now();
      $date->toDateString();
      /**
      *
      */
      if($test->id == null || $test->id == '' || $test->id == -1) {
        $test->id = DB::select('select seq_test_func() as id')[0]->id;
      }
      /**
      *
      */
      if($test->code == null || $test->code == '') {
        $test->code  = "PRB-".toBase36($test->id);
        $test->admin = Session::get('key-sesion')['data']->id;
        $test->cutoff_date = $date->addMonth();
        $test->status = HStatus::ACTIVE;
      }
      /**
      *
      */
    });
  }
}
