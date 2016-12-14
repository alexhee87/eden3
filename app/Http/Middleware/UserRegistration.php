<?php
namespace App\Http\Middleware;
use Closure;
use Auth;
use Entrust;

class UserRegistration
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
        if(!config('config.enable_user_registration'))
            return redirect('/')->withErrors(trans('messages.feature_not_available'));

        return $next($request);
    }
}
