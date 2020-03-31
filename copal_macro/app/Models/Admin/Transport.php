<?php

namespace App\Models\Admin;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Model;
use DB;
use Hash;

class Transport extends Model
{
  //
  use SoftDeletes;

  /**
   *
   */
  protected $with = [

  ];

  /**
   *
   */
  public $incrementing = true;

  /**
   *
   */
  const TABLE = 'transport';

  /**
   * @var string
   */
  protected $table = self::TABLE;

  /**
   * @var bool
   */
  public $timestamps = true;

  /**
   * @var array
   */
  protected $hidden = [

  ];

   /**
   *
   */
    protected $fillable = [
      'code',
      'spanish',
      'price'
    ];

    /**
     * @param $spanish
     */
    public function setNameAttribute($spanish)
    {
      if (!empty($spanish))
      {
        $this->attributes['spanish'] = strtolower($spanish);
      }
    }

    /**
     *
     */
    public function toOption() {
      return ['id' => $this->id,'price' => "$this->price",'text' => "$this->spanish"];
    }
    /**
     * Se genera el codigo
     */
    protected static function boot()
    {
      parent::boot();
      Transport::creating(function(Transport $transport)
      {
        if($transport->id == null || $transport->id == '' || $transport->id == -1)
        {
          $transport->id = DB::select('select seq_transport_func() as id')[0]->id;
        }
        // conversion a hexadecimal
        if($transport->code == null || $transport->code == '')
        {
          $transport->code = "TRN-".toBase36($transport->id);
        }
      });
    }
}
