<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin\Notice;
use App\Models\Admin\User;
use App\Helpers\HUserType;
use Validator;
use \Mail;
use Session;
use DB;
use App\Helpers\HAccess;

class NoticeController extends Controller {
  /**
  *
  */
  public function __construct (Request $request) {
    $this->middleware('requireAccess:' . HAccess::NEWS);
  }
  /**
  * Listado de Noticias
  */
  public function index(Request $request) {
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
    /*if ($request->session()->get('key-sesion')['type'] == HUserType::SELLER ) {
      return redirect('/');
    }*/
    /**
    *
    */
    $notices = Notice::all();
    if ($request->session()->get('key-sesion')['type'] == HUserType::WRITTER ) {
      $notices = Notice::byUser($user->id)->get();
    }
    /**
    *
    */
    $vars = [
      'user'    => $user,
      'notices' => $notices
    ];
    \Log::info('listado de noticias visto por: '.$user->email);
    /**
    *
    */
    return view('pages.admin.notice.list', $vars);
  }
  /**
  * Borrar Noticia
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
    /*if ($request->session()->get('key-sesion')['type'] == HUserType::SELLER ) {
      return redirect('/');
    }*/
    $user = $request->session()->get('key-sesion')['data'];
    /**
    *
    */
    $notice = Notice::find($id);
    /**
    *
    */
    if(is_null($notice)) {
      $this->doRedirect($request, '/admin/notices')->with('errorMessage', trans('notice.notFound'));
    }
    /**
    *
    */
    $notice->delete();
    \Log::info('noticia borrada por: '.$user->email);
    return $this->doRedirect($request, '/admin/notices')->with('successMessage', trans('notice.deleted', [
      'code' => $notice->code
    ]));
  }
  /**
  * Actualizar Noticia
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
    /*if ($request->session()->get('key-sesion')['type'] == HUserType::SELLER ) {
      return redirect('/');
    }*/
    /**
    *
    */
    $notice = Notice::find($id);
    /**
    *
    */
    if(is_null($notice)) {
      $this->doRedirect($request, '/admin/notices')->with('errorMessage', trans('notice.notFound'));
    }
    /**
    *
    */
    $statuses = $this->generalStatus();
    /**
    *
    */
    if ($this->isGet($request)) {
      return view('pages.admin.notice.edit', compact('notice', 'statuses'));
    }
    /**
    *
    */
    $validator = $this->validateData($request, true);
    if (!is_null($validator)) {
      if ($validator->fails()) {
        return view('pages.admin.notice.edit', compact('notice', 'statuses'))
          ->withErrors($validator);
      }
   }
   /**
   * Se define la estructura de la noticia que se va a actualizar
   */
   if ($request->hasFile('img')) {
     $name_img            = str_random()."_".$request->file('img')->getClientOriginalName();
     $name_img            = str_replace(" ", "", $name_img);
     $notice->title       = $request->all()['title'];
     $notice->extract     = $request->all()['extract'];
     $notice->published   = $request->all()['published'];
     $notice->description = $request->all()['description'];
     $notice->img         = asset('uploads/images/notice/'.$name_img);
     $notice->admin       = $user->id;
     $request->file('img')->move('uploads/images/notice', $name_img);
   } else {
     $notice->update($request->all());
   }
   /**
   *
   */
   $notice->save();
   $notice->published == true ? $this->notify($request, $notice) : '';
   /**
   *
   */
   \Log::info('noticia editada por: '.$user->email);
   return $this->doRedirect($request, '/admin/notices')->with('successMessage', trans('notice.updated', [
     'code' => $notice->code
   ]));
  }
  /**
  * Crear Noticia
  */
  public function create (Request $request ) {
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
    /*if ($request->session()->get('key-sesion')['type'] == HUserType::SELLER ) {
      return redirect('/');
    }*/
    /**
    *
    */
    $statuses = $this->generalStatus();
    /**
    *
    */
    if ($this->isGet($request)) {
      return view('pages.admin.notice.create', compact('statuses'));
    }
    /**
    *
    */
    $validator = $this->validateData($request);
    if (!is_null($validator)) {
      if ($validator->fails()) {
        return view('pages.admin.notice.create', compact('statuses'))
          ->withErrors($validator);
      }
   }
   /**
   *
   */
   if(Session::get('errorMessage') || isset($errorMessage)) {
     return $this->doRedirect($request, '/admin/notices')->with('errorMessage', trans('contact.errormail',[
       'error' => Session::get('errorMessage')
     ]));
   }
   /**
   *
   */
   $notice = Notice::create($request->all());
    \Log::info('noticia creada por: '.$user->email);
   return $this->doRedirect($request, '/admin/notices')->with('successMessage', trans('notice.created', [
     'code' => $notice->code
   ]));
  }
  /**
  * Ver en modal
  */
  public function view (Request $request, $id) {
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
    /*if ($request->session()->get('key-sesion')['type'] == HUserType::SELLER ) {
      return redirect('/');
    }*/
    $notice = Notice::find($id);
    /**
    *
    */
    if(is_null($notice)) {
      $this->doRedirect($request, '/admin/notices')->with('errorMessage', trans('notice.notFound'));
    }
    /**
    *
    */
    if ($this->isGet($request)) {
      if ($request->ajax()) {
       \Log::info('noticia visualizada por: '.$user->email);
        return view('pages.admin.notice.view', compact('notice'));
      }
      return redirect('admin/notices');
    }
  }
  /**
  * Vista previa de la noticia
  */
  public function check (Request $request, $id) {
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
    /*if ($request->session()->get('key-sesion')['type'] == HUserType::SELLER ) {
      return redirect('/');
    }*/
    $notice = Notice::find($id);
    /**
    *
    */
    if(is_null($notice)) {
      return  $this->doRedirect($request, '/admin/notices')->with('errorMessage', trans('notice.notFound'));
    } else {
      if ($user->user_type != HUserType::MASTER && $notice->admin != $user->id) {
        return  $this->doRedirect($request, '/admin/notices')->with('errorMessage', trans('messages.notFound'));
      }
    }
    /**
    *
    */
    $vars = [
      'only'   => true,
      'notice' => $notice
    ];
    /**
    *
    */
    if ($this->isGet($request)) {
      \Log::info('noticia visualizada por: '.$user->email);
      return view('pages.admin.notice.show', $vars);
    }
  }
  /**
  * Publicar Noticia
  */
  public function aproved (Request $request, $id) {
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
    /*if ($request->session()->get('key-sesion')['type'] == HUserType::SELLER ) {
      return redirect('/');
    }*/
    $notice = Notice::find($id);
    /**
    *
    */
    if(is_null($notice)) {
      return  $this->doRedirect($request, '/admin/notices')->with('errorMessage', trans('notice.notFound'));
    } else {
      if ($user->user_type != HUserType::MASTER && $notice->admin != $user->id) {
        return  $this->doRedirect($request, '/admin/notices')->with('errorMessage', trans('messages.notFound'));
      }
    }
    /**
    *
    */
    DB::table('notice')->where('id', '=', $notice->id)->update(['published' => true, 'admin' => $user->id]);
    $this->notify($request, $notice);
    /**
    *
    */
    \Log::info('noticia publicada por: '.$user->email);
    return $this->doRedirect($request, '/admin/notices')->with('successMessage', trans('notice.publish', [
      'code' => $notice->code
    ]));
  }
  /**
  *
  */
  public function reload (Request $request, $id) {
    $notice = Notice::find($id);
    if($request->ajax()) {
      return response()->json([
        'message' => true,
        'notice'  => $notice
      ]);
     }
     return redirect('news');
  }
  /**
  *
  */
  public function notify (Request $request, $notice) {
    $admin = User::find($notice->admin);
    /**
    * se valida el admin
    */
    if(is_null($admin)) {
      return  $this->doRedirect($request, '/admin/notices')->with('errorMessage', trans('user.notFound'));
    }
    /**
    * se envia la notificacion
    */
    try {
      Mail::send('emails.notice.aproved-notice', compact('admin', 'notice') , function($mail) use ($admin, $notice) {
        $mail->from(env('ICS_MAIL_ADDRESS'));
        $mail->to($admin->email, $admin->name)
             ->bcc(env('ICS_MAIL_ADDRESS'), $admin->name)
             ->subject(strtoupper(trans('mail.published_notice', ['name' => $admin->name])));
      });
    } catch(\Exception $ex) {
      return $this->doRedirect($request, '/admin/notices')->with('errorMessage', trans('contact.errormail',[
        'error' => $ex->getMessage()
      ]));
    }
  }
  /**
  *
  */
  private function validateData (Request $request, $update=false) {
      return Validator::make($request->all(), [
        'title'        => 'required|string|min:5|max:70',
        'extract'      => 'required|string|min:5|max:150',
        'published'    => 'required|not_in:-1',
        'description'  => 'required|string|min:5',
        'img'          => (!isset($update) ? 'required|' : '').'file'
      ]);
  }
}
