<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Psy\Exception\ErrorException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Http\Request;

class ExceptionMiddleware {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $response = $next($request);
        /**
        * Ruta no encontrada
        */
        if (isset($response->exception)) {
          if($response->exception instanceof NotFoundHttpException) {
            return redirect('/');
          }
        }
        /**
        * Metodo no encontrado
        */
        if (isset($response->exception)) {
          if($response->exception instanceof MethodNotAllowedHttpException) {
            return redirect('/error/method-not-found');
          }
        }
        /**
        *
        */
        return $response;
    }
}
