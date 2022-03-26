<?php

namespace App\Http\Middleware;

use Closure;

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->user()->usertype !== 'admin'){
            if($request->wantsJson()) {
                return response()->json([], 403);
            }

            return redirect('/');
        }

        return $next($request);
    }
}
