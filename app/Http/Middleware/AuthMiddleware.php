<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthMiddleware
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
        if(Cookie::get('backRole') != null){
             return $next($request);
        }
        elseif(Cookie::get('frontRole') != null){
            return $next($request);
        }
        else{
            return redirect()->to('login')->with('errorMessage', 'আপনার অনুমতি নেই।');
        }
    }
}
