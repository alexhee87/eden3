<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;
use Nexmo;
use Exception;
use App\Notifications\TwoFactorAuth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $all_birthdays = \App\Profile::whereBetween( DB::raw('dayofyear(date_of_birth) - dayofyear(curdate())'), [0,config('config.celebration_days')])
            ->orWhereBetween( DB::raw('dayofyear(curdate()) - dayofyear(date_of_birth)'), [0,config('config.celebration_days')])
            ->orderBy('date_of_birth','asc')
            ->get();

        $celebrations = array();
        foreach($all_birthdays as $all_birthday){
            $number = date('Y') - date('Y',strtotime($all_birthday->date_of_birth));
            $celebrations[strtotime(date('d M',strtotime($all_birthday->date_of_birth)))] = array(
                'icon' => 'birthday-cake',
                'title' => getDateDiff($all_birthday->date_of_birth) ? : date('d M',strtotime($all_birthday->date_of_birth)),
                'date' => $all_birthday->date_of_birth,
                'number' => $number.'<sup>'.daySuffix($number).'</sup>'.' '.trans('messages.birthday'),
                'id' => $all_birthday->User->id,
                'name' => $all_birthday->User->full_name
            );
        }

        ksort($celebrations);

        $birthdays = \App\Profile::whereNotNull('date_of_birth')->orderBy('date_of_birth','asc')->get();

        $todos = \App\Todo::where('user_id','=',Auth::user()->id)
            ->orWhere(function ($query)  {
                $query->where('user_id','!=',Auth::user()->id)
                    ->where('visibility','=','public');
            })->get();

        $events = array();
        foreach($birthdays as $birthday){
            $start = date('Y').'-'.date('m-d',strtotime($birthday->date_of_birth));
            $title = trans('messages.birthday').' : '.$birthday->User->full_name;
            $color = '#133edb';
            $events[] = array('title' => $title, 'start' => $start, 'color' => $color);
        }
        foreach($todos as $todo){
            $start = $todo->date;
            $title = trans('messages.to_do').' : '.$todo->title.' '.$todo->description;
            $color = '#ff0000';
            $url = '/todo/'.$todo->id.'/edit';
            $events[] = array('title' => $title, 'start' => $start, 'color' => $color, 'url' => $url);
        }
        $assets = ['calendar'];
        return view('home',compact('assets','events','birthdays','celebrations'));
    }

    public function tnc(){
        if(!config('config.enable_tnc'))
            return redirect('/');

        return view('tnc');
    }

    public function maintenance(){
        if(!config('config.maintenance_mode'))
            return redirect('/');

        return view('maintenance');
    }

    public function lock(){
        if(session('locked'))
            return view('auth.lock');
        else
            return redirect('/home');
    }

    public function unlock(Request $request){
        if(!Auth::check())
            return redirect('/');

        $password = $request->input('password');

        if(\Hash::check($password,Auth::user()->password)){
            session()->forget('locked');
            return redirect('/home');
        }

        return redirect('/lock')->trans('messages.failed');
    }

    public function activityLog(){
        $table_data['activity-log-table'] = array(
            'source' => 'activity-log',
            'title' => 'Activity Log List',
            'id' => 'activity_log_table',
            'disable-sorting' => 1,
            'data' => array(
                'S No',
                trans('messages.user'),
                trans('messages.activity'),
                'IP',
                trans('messages.date'),
                'User Agent',
                )
            );

        return view('activity_log.index',compact('table_data'));
    }

    public function activityLogList(Request $request){
        $activities = \App\Activity::orderBy('created_at','desc')->get();

        $rows = array();
        $i = 0;
        foreach($activities as $activity){
            $i++;

            $activity_detail = ($activity->activity == 'activity_added') ? trans('messages.new').' '.trans('messages.'.$activity->module).' '.trans('messages.'.$activity->activity) : trans('messages.'.$activity->module).' '.trans('messages.'.$activity->activity);
            $row = array(
                $i,
                $activity->User->full_name,
                $activity_detail,
                $activity->ip,
                showDateTime($activity->created_at),
                $activity->user_agent
                );

            $rows[] = $row;
        }

        $list['aaData'] = $rows;
        return json_encode($list);
    }
}
