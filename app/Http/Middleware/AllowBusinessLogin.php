<?php

namespace App\Http\Middleware;

use Closure;

class AllowBusinessLogin
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
        if (!config('constants.allow_business_login')) {
            return redirect('/');
        }
        return $next($request);
    }
}
