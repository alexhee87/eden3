<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Auth;
use App\Notifications\TwoFactorAuth;

class AuthEventListener
{
    use \App\Http\Controllers\BasicController;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SomeEvent  $event
     * @return void
     */
    public function login($event)
    {
        \Auth::user()->last_login = \Auth::user()->last_login_now;
        \Auth::user()->last_login_ip = \Auth::user()->last_login_ip_now;
        \Auth::user()->last_login_now = new \DateTime;
        \Auth::user()->last_login_ip_now = \Request::getClientIp();
        \Auth::user()->save();
        if(config('config.enable_two_factor_auth')){
            $code = rand('100000','999999');
            session(['two_factor_auth' => $code]);
            if(!getMode())
            \Auth::user()->notify(new TwoFactorAuth($code));
        }
        $this->logActivity(['module' => 'login','activity' => 'activity_logged_in']);
    }

    public function logout($event)
    {
        session()->forget('two_factor_auth');
        $this->logActivity(['module' => 'logout','activity' => 'activity_logged_out']);
    }
}
