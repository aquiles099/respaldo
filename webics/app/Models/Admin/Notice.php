<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;
use \Mail;
use Redirect;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;
use Illuminate\Http\Request;
use Jenssegers\Date\Date;

class Notice extends Model {
  /**
  *
  */
  use SoftDeletes;
  /**
   *
   */
  protected $with = [
    'getAdmin'
  ];
  /**
  *
  */
  const TABLE = 'notice';
  /**
  *
  */
  protected $table = self::TABLE;
  /**
  *
  */
  protected $fillable = [
    'title',
    'published',
    'extract',
    'description',
    'admin',
    'img',
    'slug'
  ];
  /**
  *
  */
  public function getCreatedAtAttribute ($date) {
    return new Date($date);
  }
  /**
  *
  */
  public function getAdmin () {
    return $this->hasOne('App\Models\Admin\User', 'id', 'admin');
  }
  /**
  *
  */
  public function scopeByPublished($query, $value) {
    return $query->where('published', '=', $value)->orderBy('created_at', 'desc');
  }
  /**
  *
  */
  public function scopeByUser($query, $value) {
    return $query->where('admin', '=', $value);
  }
  /**
  *
  */
  public function scopeBySlug($query, $value) {
    return $query->where('slug', '=', $value);
  }
  /**
  *
  */
  protected static function boot() {
  parent::boot();
    /**
    * Before Create
    */
    Notice::creating(function(Notice $notice) {
      if($notice->id == null || $notice->id == '' || $notice->id == -1) {
        $notice->id = DB::select('select seq_notice_func() as id')[0]->id;
      }
      /**
      * Defiendo codigo unico de noticia
      */
      if($notice->code == null || $notice->code == '') {
        $notice->code = "NOT-".toBase36($notice->id);
        $notice->admin = Session::get('key-sesion')['data']->id;
        $notice->slug = str_slug($notice->title.' '.$notice->code, "-");
      }
      /**
      * Almacenando archivo al crear noticia
      */
      if(isset($notice->img) && $notice->img != NULL) {
        $name_img = str_random()."_".$notice->img->getClientOriginalName();
        $name_img = str_replace(" ", "", $name_img);
        $notice->img->move('uploads/images/notice', $name_img);
        $notice->img = asset('uploads/images/notice/'.$name_img);
      }
    });
    /**
    * Before Update
    */
    Notice::saving(function (Notice $notice) {
      if (is_null($notice->admin)) {
        $notice->admin = Session::get('key-sesion')['data']->id;
        $notice->slug = str_slug($notice->title.' '.$notice->code, "-");
      }
    });
    /**
    * After create
    */
    Notice::created(function (Notice $notice) {
      $admin = User::find($notice->admin);
      try {
        Mail::send('emails.notice.new-notice', compact('admin', 'notice') , function($mail) use ($admin, $notice) {
          $mail->from(env('ICS_MAIL_ADDRESS'));
          $mail->to($admin->email, $admin->name)
               ->bcc(env('ICS_MAIL_ADDRESS'), $admin->name)
               ->subject(strtoupper(trans('mail.created_notice', ['name' => $admin->name])));
        });
      } catch(\Exception $ex) {
          return Redirect::back()->with('errorMessage', $ex->getMessage());
      }
    });
  }
}
