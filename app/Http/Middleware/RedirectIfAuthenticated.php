<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            return redirect('/home');
        }

        return $next($request);

        if($request->is('login') && strtolower($request->method()) == 'post' && getMode()){
            if(is_connected()){
                $data = verifyPurchase();
                if($data['status'] == 'error'){
                    $config = config('code');
                    $config['purchase_code'] = null;
                    //write2Config($config,'code');
                    //return redirect('/verify-purchase')->withErrors($data['message']);
                }
            }
        }


    }
}
