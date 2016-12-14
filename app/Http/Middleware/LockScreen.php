<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
use Session;
 
class LockScreen {
 
    /**
     * Check session data, if role is not valid logout the request
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        if($request->is('lock') || $request->is('logout') || !Auth::check() || !config('config.enable_lock_screen'))
            return $next($request);

        if(session('locked'))
            return redirect('/lock');

        $bag = Session::getMetadataBag();
        $max = config('config.lock_screen_timeout') * 60;
        if (($bag && $max < (time() - $bag->getLastUsed()))) {
            session(['locked' => 1]);
            return redirect('/lock');
        }
        return $next($request);
    }
 
}