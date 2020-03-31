<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;


class BillOfLading extends Model
{
    protected $hidden = [];
    /**
     *
     */
    public $incrementing = true;
    /**
     *
     */
    const TABLE = 'billoflading';
    /**
    *
    */
    protected $table = self::TABLE;
    /**
    *
    */
    public $timestamps = true;
    /**
    *
    */
    protected $fillable =
    [
        'code',
        'exporter',
        'consignedto',
        'document',
        'notify',
        'blnumber',
        'exportreference',
        'exporting',
        'forwarding',
        'foreing',
        'point',
        'place',
        'placedeli',
        'port',
        'precarri',
        'purchaseorder',
        'loadingpier',
        'typemovie',
        'containerized',
        'package',
        'pickup',
        'create_at'

    ];




}
