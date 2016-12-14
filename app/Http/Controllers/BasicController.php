<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Entrust;

trait BasicController {

    public function logActivity($data) {
    	$data['user_id'] = isset($data['user_id']) ? $data['user_id'] : ((\Auth::check()) ? \Auth::user()->id : null);
    	$data['ip'] = \Request::getClientIp();
        $data['secondary_id'] = isset($data['secondary_id']) ? $data['secondary_id'] : null;
        $data['user_agent'] = \Request::header('User-Agent');
        if(config('config.enable_activity_log'))
    	$activity = \App\Activity::create($data);
    }
    
    public function logEmail($data){
        $data['to_address'] = $data['to'];
        unset($data['to']);
        $data['from_address'] = config('mail.from.address');
        \App\Email::create($data);
    }
}