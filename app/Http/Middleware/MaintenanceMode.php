<?php
namespace App\Http\Middleware;
use Auth;

class MaintenanceMode
{
    /**
     * The following method loops through all request input and strips out all tags from
     * the request. This to ensure that users are unable to set ANY HTML within the form
     * submissions, but also cleans up input.
     *
     * @param Request $request
     * @param callable $next
     * @return mixed
     */

    public function handle($request, \Closure $next)
    {
        if(config('config.maintenance_mode') && !defaultRole() && Auth::check() && !$request->is('under-maintenance')){
            Auth::logout();
            return redirect('/login')->withErrors(config('config.under_maintenance_message'));
        }

        if(getMode() && config('config.enable_ip_filter') && \App\IpFilter::count() && !validateIp() && Auth::check() && defaultRole()){
            Auth::logout();
            return redirect('/login')->withErrors(trans('messages.ip_not_allowed'));
        }

        return $next($request);
    }
}