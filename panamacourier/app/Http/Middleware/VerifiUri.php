<?php

namespace App\Http\Middleware;

use Closure;

class VerifiUri {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $uri) {
      $response = $next($request);
      dd(\Session::get('key-sesion'), $uri);
      return $response;
    }
}
