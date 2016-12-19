<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
use File;

class WMLab
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
        defaultDB();
        $assets = array();
        view()->share(compact('assets'));
        setEncryptionKey();

        if(!checkDBConnection() && !$request->is('install') && !$request->is('update'))
            return redirect('/install');

        foreach(config('constant.path') as $key => $path)
            if (!File::exists(base_path().$path) && $key != 'verifier')
                abort(399,$path.' '.trans('messages.file_not_found'));

        foreach(config('constant.system_default') as $key => $value)
            config(['config.'.$key => config('constant.system_default.'.$key)]);

        config([
            'mail.driver' => config('constant.mail_default.driver'),
            'mail.from.name' => config('constant.mail_default.from_name'),
            'mail.from.address' => config('constant.mail_default.from_address'),
            ]);

        if(checkDBConnection()){

            $config_vars = \App\Config::all();
            setConfig($config_vars);

            $default_permission = array();
            foreach(config('permission') as $key => $value)
                $default_permission[] = $key;

            $db_permissions = array();
            $db_permissions = \App\Permission::all()->pluck('name')->all();
            $permissions = array_diff($default_permission,$db_permissions);
            $permission_insert = array();
            foreach($permissions as $key => $value)
                $permission_insert[] = array('category' => config('permission.'.$value),'name' => $value,'is_default' => 1);

            if(count($permission_insert))
                \App\Permission::insert($permission_insert);

            $default_role = \App\Role::whereIsHidden(1)->first();
            define("DEFAULT_ROLE",($default_role) ? $default_role->name : '');

            $all_permissions = \App\Permission::all()->pluck('id')->all();
            $permission_role = \DB::table('permission_role')->where('role_id','=',$default_role->id)->pluck('permission_id')->all();
            $permission_role_array = array_diff($all_permissions,$permission_role);
            $permission_role_insert = array();
            foreach($permission_role_array as $value)
                $permission_role_insert[] = array('permission_id' => $value,'role_id' => $default_role->id);
            \DB::table('permission_role')->insert($permission_role_insert);
        }

        foreach(config('constant.social_login_provider') as $value){
            config([
                'services.'.$value.'.client_id' => config('config.'.$value.'_client_id'),
                'services.'.$value.'.client_secret' => config('config.'.$value.'_client_secret'),
                'services.'.$value.'.redirect' => config('config.'.$value.'_redirect'),
                ]);
        }

        config([
            'nexmo.api_key' => config('config.nexmo_api_key'),
            'nexmo.api_secret' => config('config.nexmo_api_secret')
            ]);

        config([
            'services.nexmo.key' => config('config.nexmo_api_key'),
            'services.nexmo.secret' => config('config.nexmo_api_secret'),
            'services.nexmo.sms_from' => config('config.nexmo_from_number')
            ]);

        config([
            'session.lifetime' => (config('config.session_lifetime')) ? : '120',
            'session.expire_on_close' => (config('config.session_expire_browser_close')) ? true : false,
            'auth.passwords.user.expire' => (config('config.reset_token_lifetime')) ? : '120',
            ]);

        config(['app.name' => config('config.application_name')]);
        $default_timezone = config('config.timezone_id') ? config('timezone.'.config('config.timezone_id')) : 'Asia/Kuching';
        date_default_timezone_set($default_timezone);

        $default_language = (cache()->has('lang')) ? cache('lang') : ((config('config.default_language')) ? : 'en' );
        cache()->put('lang', $default_language, config('config.cache_lifetime'));
        \App::setLocale($default_language);

        $datatable_language = (config('lang.'.$default_language.'.datatable')) ? : 'English';
        $calendar_language = (config('lang.'.$default_language.'.calendar')) ? : 'en';
        $direction = (config('config.direction')) ? : 'ltr';
        view()->share(compact('direction','default_language','datatable_language','calendar_language'));

        return $next($request);
    }
}
