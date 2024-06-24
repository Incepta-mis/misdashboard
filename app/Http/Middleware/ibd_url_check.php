<?php

namespace App\Http\Middleware;

use Closure;

class ibd_url_check
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
        if(strrpos($request->getHttpHost(),'web.inceptapharma.com:5031') === false){
            return redirect('/');
        }

        return $next($request);
    }
}
