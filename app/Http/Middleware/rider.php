<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;

class rider
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
        if(Cookie::get('user_type') == 17 ||Cookie::get('user_type') == 18 ||Cookie::get('user_type') == 19 ||Cookie::get('user_type') == 20||Cookie::get('user_type') == 20||Cookie::get('user_type') == 32){
            return $next($request);
        }
        return redirect()->to('homepage');
    }
}
