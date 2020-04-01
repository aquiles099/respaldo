<?php

namespace App\Models\Admin;
use Hash;
use Crypt;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\HStatus;
use Carbon\Carbon;
use Jenssegers\Date\Date;

class Contract extends Model {
  /**
  *
  */
  use SoftDeletes;
  /**
  *
  */
  const TABLE = 'contract';
  /**
  *
  */
  protected $table = self::TABLE;
  /**
  *
  */
  protected $with = [
    'getStatus'
  ];
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'code',
    'solicitude',
    'test',
    'status',
    'register_date',
    'cut_off_date',
    'version'
  ];
  /**
  * Mutador para fechas
  */
  public function getRegisterDateAttribute ($date) {
    return new Date($date);
  }
  /**
  * Mutador para fechas
  */
  public function getCutOffDateAttribute ($date) {
    return new Date($date);
  }
  /**
  * obtener status de un contrato
  */
  public function getStatus () {
    return $this->hasOne('App\Models\Admin\Status', 'id', 'status');
  }
  /**
  * buscar por solicitud
  */
  public function scopeBySolicitude ($query, $value) {
    return $query->where('solicitude', '=', $value);
  }
  /**
  * Buscar por prueba
  */
  public function scopeByTest ($query, $value) {
    return $query->where('test', '=', $value);
  }
  /**
  * Obtener la solicitud asociada a un contrato
  */
  public function getSolicitude () {
    return $this->hasOne('App\Models\Admin\Solicitude', 'id', 'solicitude');
  }
  /**
  * Verifica sin un contrato tiene incidencias nuevas
  */
  public function verifyIncidence ($id) {
    return DB::table('incidence')->where([['type', '=', '1'],['status','=', null],['contract', '=', $id]])->count();
  }
  /**
  * Verifica sin un contrato tiene errores nuevos
  */
  public function verifyBug ($id) {
    return DB::table('incidence')->where([['type', '=', '0'],['status','=', null],['contract', '=', $id]])->count();
  }
  /**
  *
  */
  protected static function boot() {
	parent::boot();
		Contract::creating(function(Contract $contract) {
      $date = Carbon::now();
      $date->toDateString();
			if($contract->id == null || $contract->id == '' || $contract->id == -1) {
				$contract->id = DB::select('select seq_contract_func() as id')[0]->id;
			}
      /**
      * se edita el codigo del contrato
      */
			if($contract->code == null || $contract->code == '') {
				$contract->code   = "CON-".toBase36($contract->id);
				$contract->status = HStatus::ACTIVE;
			}
      /**
      * se modifican las fechas de inicio y corte si no se han definido por el sistema.
      */
      if (is_null($contract->register_date) || is_null($contract->cut_off_date)) {
        $contract->register_date = Carbon::now();
        $contract->cut_off_date = $date->addYear();
      }
		});
	}
}
