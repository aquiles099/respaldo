<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App\Models\Admin\UserAccess;

class RequiredAccessMidleware {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle ($request, Closure $next, $access) {

      $accesses = UserAccess::byUser(Session::get('key-sesion')['data']->id)->get();
      $result = [];
      /**
       *
       */
      foreach ($accesses as $key => $value) {
          array_push($result, $value->item);
      }
      /**
       *
       */
      if (!in_array($access, $result)) {
        return redirect('/')->with('errorMessage', trans('messages.unauthorized', [
          'name' => Session::get('key-sesion')['data']->name
        ]));
      }
      return $next($request);
    }
}
