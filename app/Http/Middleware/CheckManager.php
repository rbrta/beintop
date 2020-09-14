<?php

namespace App\Http\Middleware;

use Closure;

class CheckManager
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
        if($request->user()->usertype !== 'manager'){
            if($request->wantsJson()) {
                return response()->json([], 403);
            }

            return redirect('/');
        }

        return $next($request);
    }
}
