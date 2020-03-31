<?php

namespace App\Http\Middleware;
use App\Models\Admin\Operator;
use Session;
use Closure;

class BlockUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   $user     = Session::get('key-sesion')['data']->id;
        $operator = Operator::find($user);
        if ($operator->active == 2) {
          return redirect()->guest('/');
        }
        return $next($request);
    }
}
