<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthenticateUserLoginStatus
{
    /*
     * Created By: Md. Raqib Hasan
     * Emp Code: 1012064
     */
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        check if user is valid to continue using the site
        if(Auth::user() && strtoupper(Auth::user()->valid) != 'YES'){
            Auth::logout();
            return redirect('/');
        }
        return $next($request);
    }
}
