<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\HUserType;

class RequiredMasterMiddleware {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $user = $request->session()->get('key-sesion');
          if ($user['type'] != HUserType::MASTER) {
              return redirect('/')->with('errorMessage', trans('messages.unauthorized'));
          }
        return $next($request);
    }
}
