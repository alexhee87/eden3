<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;

class AccountValid
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
        $profile = Auth::user()->Profile;

        if(!isset($profile) && $profile == '' && $profile == null){
            $profile = new \App\Profile;
            $profile->user()->associate(Auth::user());
            $profile->save();
        }

        if(Auth::user()->status == 'pending_approval'){
            Auth::logout();
            return redirect('/login')->withErrors(trans('messages.account_not_approved'));
        } elseif(Auth::user()->status == 'pending_activation'){
            Auth::logout();
            return redirect('/login')->withErrors(trans('messages.account_not_activated'));
        } elseif(Auth::user()->status == 'banned'){
            Auth::logout();
            return redirect('/login')->withErrors(trans('messages.account_banned'));
        }

        return $next($request);
    }
}
