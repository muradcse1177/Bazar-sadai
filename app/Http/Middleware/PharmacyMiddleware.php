<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;

class PharmacyMiddleware
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
        if(Cookie::get('user_type') == 15){
            return $next($request);
        }
        else{
            return redirect()->to('login')->with('errorMessage', 'আপনার অনুমতি নেই।');
        }
    }
}
