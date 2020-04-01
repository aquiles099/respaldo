<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Crypt;
use DB;
use \Mail;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\HStatus;
use App\Helpers\HUserType;
use Redirect;

class Solicitude extends Model {
	/**
  *
  */
  use SoftDeletes;
	/**
	*
	*/
	const TABLE = 'solicitude';
	/**
	*
	*/
	protected $table = self::TABLE;
	/**
	* The attributes that are mass assignable.
	*/
	protected $fillable = [
		'code',
		'admin',
		'status',
		'client',
		'subject',
		'profile',
		'description'
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
	public function getAdmin () {
		return $this->hasOne('App\Models\Admin\User', 'id', 'admin');
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
	public function verifyTest ($id) {
		return DB::table('test')->where('solicitude', '=', $id)->count();
	}
	/**
	* Se genera el codigo
	*/
	protected static function boot() {
		parent::boot();
		/**
		*
		*/
		Solicitude::creating(function(Solicitude $solicitude) {
				if($solicitude->id == null || $solicitude->id == '' || $solicitude->id == -1) {
					$solicitude->id = DB::select('select seq_solicitude_func() as id')[0]->id;
				}
				// conversion a hexadecimal
				if($solicitude->code == null || $solicitude->code == '') {
					$solicitude->code   = "SOL-".toBase36($solicitude->id);
					$solicitude->status = HStatus::GENERATED;
				}
			});
		/**
		*
		*/
		Solicitude::created(function(Solicitude $solicitude) {
			$users = User::byType(HUserType::SELLER)->get();
			$emails = array(env('ICS_MAIL_ADDRESS'));
			$notifiable = Notifiable::all();
			/**
			* 1) se verifican usuarios autorizados para recibir correos
			* 2) Se almacenan las direcciones de correo
			*/
			foreach ($users as $key => $value) {
				foreach ($notifiable as $key => $notify) {
					if (($notify->admin == $value->id) && ($notify->status == $solicitude->status)) {
							array_push($emails, $value->email);
					}
				}
			}
			/**
			* Envio de correo
			*/
			$client = Client::find($solicitude->client);
			try {
				Mail::send('emails.generate-solicitude', compact('client' , 'solicitude') , function($mail) use ($solicitude, $client, $emails) {
					$mail->from(env('ICS_MAIL_ADDRESS'));
					$mail->to($client->email, $client->name)
							 ->bcc($emails, $client->name)
							 ->subject(strtoupper($solicitude->subject));
				});
			} catch(\Exception $ex) {
					return Redirect::back()->with('errorMessage', $ex->getMessage());
			}
		});
	}
}
