<?php
namespace App\Http\Controllers;
use Entrust;
use Auth;
use File;
use Mail;
use Illuminate\Http\Request;
use Validator;
use App\Template;

Class TemplateController extends Controller{
    use BasicController;

	public function __construct()
	{
		$this->middleware('feature_available:enable_email_template');
	}

	public function index(Template $template){

		$table_data['template-table'] = array(
			'source' => 'template',
			'title' => 'Template List',
			'id' => 'template_table',
			'data' => array(
        		trans('messages.option'),
        		trans('messages.name'),
        		trans('messages.category'),
        		trans('messages.subject')
        		)
			);

		$category = array();

		$templates = Template::all();
		$insert = array();
		foreach(config('template') as $key => $value){
			$find_template = $templates->where('category',$key)->count();
			if($find_template == 0){
				$insert[] = array('is_default' => 1,'name' => toWord($key),'category' => $key);
			}
		}

		if(count($insert))
			Template::insert($insert);

		foreach(config('template-field') as $key => $value)
			if($key != 'forgot_password' && $key != 'welcome_email')
			$category[$key] = ucwords($key);

		$assets = ['rte'];
		return view('template.index',compact('table_data','assets','category'));
	}

	public function lists(Request $request){

		$templates = Template::all();
        $rows = array();

        foreach($templates as $template){

			$rows[] = array(
				'<div class="btn-group btn-group-xs center-block">'.
				'<a href="#" data-href="/template/'.$template->id.'/edit" class="btn btn-xs btn-default" data-toggle="modal" data-target="#myModal"> <i class="fa fa-edit" data-toggle="tooltip" title="'.trans('messages.edit').'"></i></a> '.
				(!$template->is_default ? delete_form(['template.destroy',$template->id],'template',1) : '').
				'</div>',
				$template->name,
				toWord($template->category),
				$template->subject
				);
        }
        $list['aaData'] = $rows;
        return json_encode($list);
	}

	public function create(){
		
	}

	public function edit(Template $template){
		return view('template.edit',compact('template'));
	}

	public function store(Request $request, Template $template){

        $validation = Validator::make($request->all(),[
            'category' => 'required',
            'name' => 'required|unique:templates,name'
        ]);

        if($validation->fails()){
            if($request->has('ajax_submit')){
                $response = ['message' => $validation->messages()->first(), 'status' => 'error']; 
                return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
            }
            return redirect()->back()->withInput()->withErrors($validation->messages());
        }

		$data = $request->all();
		$template->fill($data)->save();
		$this->logActivity(['module' => 'template','activity' => 'activity_added']);

        if($request->has('ajax_submit')){
            $response = ['message' => trans('messages.template').' '.trans('messages.added'), 'status' => 'success']; 
            return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
        }
		return redirect()->back()->withSuccess(trans('messages.template').' '.trans('messages.saved'));
	}
	
	public function content(Request $request){
		$template = Template::find($request->input('template_id'));
		$user = \App\User::find($request->input('user_id'));

		if(!$template || !$user){
	        $response = ['status' => 'error']; 
	        return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
		}

		if($template->category == 'user'){
			$body = $template->body;
            $body = str_replace('[NAME]',$user->full_name,$body);
            $body = str_replace('[USERNAME]',$user->username,$body);
            $body = str_replace('[EMAIL]',$user->email,$body);
            $body = str_replace('[DATE_OF_BIRTH]',showDate($user->Profile->date_of_birth),$body);
            $body = str_replace('[CURRENT_DATE_TIME]',showDateTime(date('Y-m-d H:i:s')),$body);
            $body = str_replace('[CURRENT_DATE]',showDate(date('Y-m-d')),$body);
		}

        $response = ['body' => $body, 'subject' => $template->subject,'status' => 'success']; 
        return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
	}

	public function update(Request $request,Template $template){

        $validation = Validator::make($request->all(),[
            'subject' => 'required',
            'body' => 'required'
        ]);

        if($validation->fails()){
            if($request->has('ajax_submit')){
                $response = ['message' => $validation->messages()->first(), 'status' => 'error']; 
                return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
            }
            return redirect()->back()->withInput()->withErrors($validation->messages());
        }

        $template->subject = $request->input('subject');
        $template->body = clean($request->input('body'));
        $template->save();

		$this->logActivity(['module' => 'template','activity' => 'activity_updated']);

	    if($request->has('ajax_submit')){
	        $response = ['message' => trans('messages.template').' '.trans('messages.saved'), 'status' => 'success']; 
	        return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
	    }
		return redirect('/template')->withSuccess(trans('messages.template').' '.trans('messages.saved'));
	}

	public function destroy(Template $template,Request $request){

		if($template->is_default){
	        if($request->has('ajax_submit')){
	            $response = ['message' => trans('messages.template_cannot_delete'), 'status' => 'error']; 
	            return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
	        }
			return redirect()->back()->withErrors(trans('messages.template_cannot_delete'));
		}

        $template->delete();
		$this->logActivity(['module' => 'template','activity' => 'activity_deleted']);

	    if($request->has('ajax_submit')){
	        $response = ['message' => trans('messages.template').' '.trans('messages.deleted'), 'status' => 'success']; 
	        return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
	    }
    	return redirect()->back()->withSuccess(trans('messages.template').' '.trans('messages.deleted'));
	}
}
?>