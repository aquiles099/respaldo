<?php

namespace App\Models\Admin;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mail;
use \Redirect;
use App\Helpers\HUserType;
use \Session;

class Contact extends Model {
  /**
  *
  */
  use SoftDeletes;
  /**
  *
  */
  const TABLE = 'contact';
  /**
   *
   */
  protected $table = self::TABLE;
  /**
   *
   */
  protected $fillable = [
    'name',
    'email',
    'subject',
    'message',
    'answered'
  ];
  /**
   *
   */
  protected $with = [

  ];
  /**
   *
   */
  protected $hidden = [

  ];
  /**
   * Se genera el codigo
   */
  protected static function boot() {
    parent::boot();
    /**
    *
    */
    Contact::creating(function(Contact $contact) {
      if($contact->id == null || $contact->id == '' || $contact->id == -1) {
        $contact->id = DB::select('select seq_contact_func() as id')[0]->id;
      }
      /**
      *
      */
      if($contact->code == null || $contact->code == '') {
        $contact->code = "CNT-".toBase36($contact->id);
      }
    });
    /**
    *
    */
    Contact::created(function(Contact $contact) {
      $users = User::byType(HUserType::SELLER)->get();
      $emails = array(env('ICS_MAIL_ADDRESS'));
      /**
      * Se almacenan las direcciones de correos
      */
      foreach ($users as $key => $value) {
        array_push($emails, $value->email);
      }
      /**
      * Envio de correo
      */
      try {
        Mail::send('emails.generate-contact', compact('contact') , function($mail) use ($contact, $emails) {
          $mail->from(env('ICS_MAIL_ADDRESS'));
          $mail->to($contact->email , $contact->name)
               ->bcc($emails, $contact->name)
               ->subject(strtoupper($contact->subject));
        });
      } catch(\Exception $ex) {
          return Redirect::back()->with('errorMessage', $ex->getMessage());
      }
    });
  }
}
