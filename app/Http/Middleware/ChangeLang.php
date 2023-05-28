<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class ChangeLang
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
        // dd(session()->all());
        // if(session()->has('frontLange')) {
        //     dd('now');
        //     dd(session()->get('frontLange'));
        //     App::setLocale(session()->get('frontLange'));
        // }
        // dd('sdf');
        return $next($request);
    }
}
