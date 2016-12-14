<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Entrust;
use App\Classes\Helper;
use App\Email;

Class EmailController extends Controller{
    use BasicController;

	public function index(){

		$table_data['email-table'] = array(
			'source' => 'email',
			'title' => 'Email Log',
			'id' => 'email_table',
			'data' => array(
        		trans('messages.option'),
        		trans('messages.from'),
        		trans('messages.to'),
        		trans('messages.subject')
        		)
			);

		return view('email_log.index',compact('table_data'));
	}

	public function lists(Request $request){
		$emails = Email::all();
        $rows = array();

        foreach($emails as $email){

			$rows[] = array(
				'<div class="btn-group btn-group-xs">'.
				'<a href="#" data-href="/email/'.$email->id.'" class="btn btn-xs btn-default" data-toggle="modal" data-target="#myModal"> <i class="fa fa-arrow-circle-right" data-toggle="tooltip" title="'.trans('messages.view').'"></i></a></div>',
				$email->from_address,
				$email->to_address,
				$email->subject
				);
        }
        $list['aaData'] = $rows;
        return json_encode($list);
	}

	public function show(Email $email){
		return view('email_log.show',compact('email'));
	}
}
?>