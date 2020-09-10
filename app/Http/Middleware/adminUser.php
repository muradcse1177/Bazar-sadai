<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;

class adminUser
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
        if(Cookie::get('user_type') == 1 || Cookie::get('user_type') == 2 ||
            Cookie::get('user_type') == 8 || Cookie::get('user_type') == 11 || Cookie::get('user_type') == 12 ){
            return $next($request);
        }
        return redirect()->to('homepage');
    }
}
