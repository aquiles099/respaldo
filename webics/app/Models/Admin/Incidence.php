<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Incidence extends Model {
  /**
  *
  */
  use SoftDeletes;
	/**
	*
	*/
	const TABLE = 'incidence';
	/**
	*
	*/
	protected $table = self::TABLE;
	/**
	* The attributes that are mass assignable.
	*/
  protected $fillable = [
    'type',
    'test',
    'contract',
    'subject',
    'description',
    'img',
    'profile',
    'admin'
	];
  /**
  * Devuelve Administrador
  */
  public function getAdmin () {
	   return $this->hasOne('App\Models\Admin\User', 'id', 'admin');
  }
  /**
  * Retorna registros buscados por estado
  */
  public function scopeByStatus ($query, $value) {
    return $query->where('status', '=', $value);
  }
  /**
  * Retorna registros buscados por prueba
  */
  public function scopeByTest ($query, $value) {
    return $query->where('test', '=', $value);
  }
  /**
  * Retorna registros buscados por contrato
  */
  public function scopeByContract ($query, $value) {
    return $query->where('contract', '=', $value);
  }
  /**
  * Retorna registros buscados por perfil
  */
  public function scopeByProfile ($query, $value) {
    return $query->where('profile', '=', $value);
  }
  /**
  * Retorna registros buscados por tipo[incidencia|Error] de una prueba
  */
  public function scopeByTypeTest ($query, $value, $test) {
    return $query->where([['type', '=', $value],['test', '=', $test] ]);
  }
  /**
  * Retorna registros buscados por tipo[incidencia|Error] de una contracto
  */
  public function scopeByTypeContract ($query, $value, $contract) {
    return $query->where([['type', '=', $value],['contract', '=', $contract]]);
  }
  /**
  * Retorna registros buscados tipo 'incidenca' con status 'no resuelto' de una prueba
  */
  public function scopeByTestNotResolveIncidence ($query, $value) {
    return $query->where([['type', '=', '1'],['status','=', null],['test', '=', $value]]);
  }
  /**
  * Retorna registros buscados tipo 'error' con status 'no resuelto' de una prueba[Recbe Una Prueba]
  */
  public function scopeByTestNotResolveBugs ($query, $value) {
    return $query->where([['type', '=', '0'],['status','=', null],['test', '=', $value]]);
  }
  /**
  * Retorna registros buscados tipo 'incidenca' con status 'no resuelto' de una contrato
  */
  public function scopeByContractNotResolveIncidence ($query, $value) {
    return $query->where([['type', '=', '1'],['status','=', null],['contract', '=', $value]]);
  }
  /**
  * Retorna registros buscados tipo 'error' con status 'no resuelto' de una prueba[Recbe un Contrato]
  */
  public function scopeByContractNotResolveBugs ($query, $value) {
    return $query->where([['type', '=', '0'],['status','=', null],['contract', '=', $value]]);
  }
}
