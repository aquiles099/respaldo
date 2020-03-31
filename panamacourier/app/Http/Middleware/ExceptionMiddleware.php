<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use League\OAuth2\Server\Exception\OAuthException;
use Psy\Exception\ErrorException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Request;

/**
 *
 */
class ExceptionMiddleware {

  /**
   * Handle an incoming request.
   *
   * @param \Illuminate\Http\Request  $request
   * @param \Closure $next
   *
   * @return mixed
   */
  public function handle($request, Closure $next) {
    $response = $next( $request );
    if ( isset ( $response->exception ) ) {
      if ( $response->exception instanceof NotFoundHttpException ) {
        return redirect('/notFound');
      } else {
        return redirect( Request::url() )
        ->with('errorMessage', trans('messages.notSuccess'));
      }
    }
    return $response;
  }
}
