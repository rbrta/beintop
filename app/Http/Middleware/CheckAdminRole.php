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
            return redirect('/');
        }
        
        return $next($request);
    }
}
