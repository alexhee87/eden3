<?php
namespace App\Http\Middleware;
use Closure;
use Auth;
use Entrust;

class ForgotPassword
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
        if(!config('config.enable_forgot_password'))
            return redirect('/')->withErrors(trans('messages.feature_not_available'));

        return $next($request);
    }
}
