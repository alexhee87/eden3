<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;

class TwoFactorAuth
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
        if(config('config.enable_two_factor_auth') && Auth::check() && session()->has('two_factor_auth') && !$request->is('verify-security'))
            return redirect('/verify-security');

        return $next($request);
    }
}
