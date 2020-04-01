<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Contact;
use App\Helpers\HUserType;
use App\Helpers\HAccess;
use DB;
use Validator;
use \Mail;
use App\Models\Admin\Email;

class ContactController extends Controller {
    /**
    *
    */
    public function __construct (Request $request) {
      $this->middleware('requireAccess:' . HAccess::WEBCONTACTS);
    }
    /**
    *
    */
    public function index (Request $request) {
      /**
      *
      */
      if(is_null($request->session()->get('key-sesion'))) {
        return redirect('login');
      }
      /**
      *
      */
      $user    = $request->session()->get('key-sesion')['data'];
      /**
      *
      */
      if ($request->session()->get('key-sesion')['type'] == HUserType::WRITTER ) {
        return redirect('/');
      }
      /**
      *
      */
      $contacts = Contact::all();
      /**
      *
      */
      \Log::info('Listado de contacto web visualizado por: '.$user->email);
      /**
      *
      */
      return view('pages.admin.contact.list', compact('contacts'));
    }
    /**
    *
    */
    public function delete (Request $request, $id) {
      /**
      *
      */
      if(is_null($request->session()->get('key-sesion'))) {
        return redirect('login');
      }
      /**
      *
      */
      $user = $request->session()->get('key-sesion')['data'];
      /**
      *
      */
      if ($request->session()->get('key-sesion')['type'] == HUserType::WRITTER ) {
        return redirect('/');
      }
      /**
      *
      */
      $contact = Contact::find($id);
      /**
      *
      */
      if(is_null($contact)) {
        return $this->doRedirect($request, '/admin/contacts')->with('errorMessage', trans('contact.notFound'));
      }
      /**
      *
      */
      $contact->delete();
      /**
      *
      */
      \Log::info('Contacto web Borrado por: '.$user->email);
      /**
      *
      */
      return $this->doRedirect($request, '/admin/contacts')->with('successMessage', trans('contact.deleted', [
        'code' => $contact->code
      ]));
    }
    /**
    *
    */
    public function edit (Request $request, $id) {
      /**
      *
      */
      if(is_null($request->session()->get('key-sesion'))) {
        return redirect('login');
      }
      /**
      *
      */
      $user = $request->session()->get('key-sesion')['data'];
      /**
      *
      */
      if ($request->session()->get('key-sesion')['type'] == HUserType::WRITTER ) {
        return redirect('/');
      }
      /**
      *
      */
      $contact = Contact::find($id);
      $email   = Email::byContact($contact->id)->first();
      /**
      *
      */
      if(is_null($contact)) {
        return $this->doRedirect($request, '/admin/contacts')->with('errorMessage', trans('contact.notFound'));
      }
      /**
      *
      */
      if($this->isGet($request)) {
        if($request->ajax()) {
            return view('pages.admin.contact.view', compact('contact', 'email'));
        }
        /**
        *
        */
        \Log::info('Contacto web visualizado por: '.$user->email);
        /**
        *
        */
        return $this->doRedirect($request, '/admin/contacts');
      }
    }
    /**
    *
    */
    public function create (Request $request) {}
    /**
    *
    */
    public function mail (Request $request, $id) {
      /**
      *
      */
      if(is_null($request->session()->get('key-sesion'))) {
        return redirect('login');
      }
      /**
      *
      */
      $user = $request->session()->get('key-sesion')['data'];
      /**
      *
      */
      if ($request->session()->get('key-sesion')['type'] == HUserType::WRITTER ) {
        return redirect('/');
      }
      /**
      *
      */
      $contact = Contact::find($id);
      $vars = [
        'contact' => $contact,
        'path'    => "admin/contacts/{$contact->id}/mail"
      ];
      /**
      *
      */
      if(is_null($contact)) {
        return $this->doRedirect($request, '/admin/contacts')->with('errorMessage', trans('contact.notFound'));
      } else if ($contact->answered == TRUE) {
        return $this->doRedirect($request, '/admin/contacts')->with('errorMessage', trans('contact.answered',[
          'name'   => $contact->name,
          'update' => $contact->updated_at
        ]));
      }
      /**
      *
      */
      if($this->isGet($request)) {
          return view('pages.admin.mail', $vars);
      }
      /**
      *
      */
      $validator = $this->validateMailData($request);
      if (!is_null($validator)) {
        if ($validator->fails()) {
          return view('pages.admin.mail', compact('contact'))
            ->withErrors($validator);
        }
      }
      /**
      *
      */
      $response = $request->all();
      /**
      *
      */
      try {
        Mail::send('emails.message-contact', compact('contact', 'response') , function($mail) use ($contact, $request) {
          $mail->from(env('ICS_MAIL_ADDRESS'));
          $mail->to($contact->email , $contact->name)
               ->bcc(env('ICS_MAIL_ADDRESS'), $contact->name)
               ->subject(strtoupper($request->all()['subject']));
        });
        /**
        * Se almacena la respuesta
        */
        $email = Email::create($request->all());
        DB::table('mail')->where('id', '=', $email->id)->update(['contact' => $contact->id]);
        /**
        * Se modifica el status del contacto
        */
        $contact->answered = TRUE;
        $contact->save();
        /**
        *
        */
        \Log::info('Contacto web respondido por: '.$user->email);
        /**
        *
        */
        return $this->doRedirect($request, '/admin/contacts')->with('successMessage', trans('contact.sendmail',[
          'name' => $contact->name
        ]));
      } catch(\Exception $ex) {
        return $this->doRedirect($request, '/admin/contacts')->with('errorMessage', trans('contact.errormail',[
          'error' => $ex->getMessage()
        ]));
      }
    }
    /**
    *
    */
    private function validateMailData (Request $request) {
        return Validator::make($request->all(), [
          'name'        => 'required|string|min:5|max:100',
          'email'       => 'required|email|min:5|max:100',
          'subject'     => 'required|string|min:5|max:50',
          'message'     => 'required|string|min:5'
        ]);
    }
}
