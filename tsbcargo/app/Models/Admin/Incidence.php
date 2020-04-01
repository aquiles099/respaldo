<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Incidence extends Model
{


    /**
     *
     */
    protected $with = [

    /**
    * vARIABLES QUE HACEN REFERENCIA AL PERFIEL DE OPERADOR
    */

    ];
    /**
     *
     */
    const TABLE = 'incidences';

    /**
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'type',
      'subject',
      'description',
      'email',
      'image',
      'perfil'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];
}
