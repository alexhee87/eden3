<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;

class FeatureAvailable
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$feature)
    {
        if(config('config.'.$feature))
            return $next($request);
        else
            return redirect('/home')->withErrors(trans('messages.feature_not_available'));
    }
}
