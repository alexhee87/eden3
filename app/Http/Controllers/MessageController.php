<?php
namespace App\Http\Controllers;
use Entrust;
use Auth;
use File;
use Mail;
use Illuminate\Http\Request;
use App\Http\Requests\MessageRequest;
use Validator;
use App\Message;

Class MessageController extends Controller{
    use BasicController;

	public function __construct()
	{
		$this->middleware('feature_available:enable_message');
	}

	public function validateLiveMessage($type,$value){
		$message = Message::where($type,'=',$value)->where(function($query) {
			$query->where(function($query1){
				$query1->where('from_user_id','=',Auth::user()->id)
				->where('delete_sender','=','0');
			})->orWhere(function($query2){
				$query2->where('to_user_id','=',Auth::user()->id)
				->where('delete_receiver','=','0');
			});
		})->first();
		return ($message) ? : 0;
	}

	public function validateDeleteMessage($type,$value){
		$message = Message::where($type,'=',$value)->where(function($query) {
			$query->where(function($query1){
				$query1->where('from_user_id','=',Auth::user()->id)
				->where('delete_sender','=','1');
			})->orWhere(function($query2){
				$query2->where('to_user_id','=',Auth::user()->id)
				->where('delete_receiver','=','1');
			});
		})->first();
		return ($message) ? : 0;
	}

	public function index(){

		$table_data['inbox-table'] = array(
			'source' => 'message/inbox',
			'title' => 'Inbox',
			'id' => 'inbox_table',
			'data' => array(
        		trans('messages.option'),
        		'From',
        		trans('messages.subject'),
        		'Date Time',
        		''
        		)
			);

		$table_data['sent-table'] = array(
			'source' => 'message/sent',
			'title' => 'Sent',
			'id' => 'sent_table',
			'data' => array(
        		trans('messages.option'),
        		'To',
        		trans('messages.subject'),
        		'Date Time',
        		''
        		)
			);

		$table_data['starred-table'] = array(
			'source' => 'message/starred',
			'title' => 'Starred',
			'id' => 'starred_table',
			'data' => array(
        		trans('messages.option'),
        		'',
        		trans('messages.subject'),
        		'Date Time',
        		''
        		)
			);

		$table_data['trash-table'] = array(
			'source' => 'message/trash',
			'title' => 'Trash',
			'id' => 'trash_table',
			'data' => array(
        		trans('messages.option'),
        		'',
        		trans('messages.subject'),
        		'Date Time',
        		''
        		)
			);

		$users = \App\User::where('id','!=',Auth::user()->id)->get()->pluck('full_name','id')->all();
		$messages = Message::whereToUserId(Auth::user()->id)
			->whereDeleteReceiver('0')->whereNull('reply_id')
			->get();
        $count_inbox = count($messages);

        $assets = ['rte'];
        $menu = ['message'];

		return view('message.index',compact('users','count_inbox','assets','menu','table_data'));
	}

	public function starred(Request $request){

		$message = $this->validateLiveMessage('token',$request->input('token'));

		if(!$message){
			if($request->has('ajax_submit')){
            $response = ['message' => trans('messages.invalid_link'), 'status' => 'error']; 
	            return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
	        }
			return redirect('/message')->withErrors(trans('messages.invalid_link'));	
		}

		if(Auth::user()->id == $message->from_user_id)
			$message->is_starred_sender = ($message->is_starred_sender) ? 0 : 1;
		else
			$message->is_starred_receiver = ($message->is_starred_receiver) ? 0 : 1;
		$message->save();

		if($request->has('ajax_submit')){
        $response = ['status' => 'success']; 
            return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
        }
		return redirect('/message');	
	}

	public function lists($type,Request $request){

		if($type == 'inbox')
			$inbox_message = Message::whereToUserId(Auth::user()->id)
				->select(\DB::raw('reply_id'))
				->whereDeleteReceiver(0)
				->whereNotNull('reply_id')
				->groupBy('reply_id')
				->get()
				->pluck('reply_id')
				->all();
		elseif($type == 'sent')
			$sent_message = Message::whereFromUserId(Auth::user()->id)
				->select(\DB::raw('reply_id'))
				->whereDeleteSender(0)
				->whereNotNull('reply_id')
				->groupBy('reply_id')
				->get()
				->pluck('reply_id')
				->all();

		if($type == 'sent')
			$messages = Message::where(function($query) use($sent_message){
				$query->where(function($query1) use($sent_message){
					$query1->where('from_user_id','=',Auth::user()->id)
					->where('delete_sender','=','0')
					->whereNull('reply_id');
				})->orWhereIn('id',$sent_message);
			})->orderBy('created_at','desc')->get();
		elseif($type == 'inbox')
			$messages = Message::where(function($query) use($inbox_message){
				$query->where(function($query1) use($inbox_message){
					$query1->where('to_user_id','=',Auth::user()->id)
					->where('delete_receiver','=','0')
					->whereNull('reply_id');
				})->orWhereIn('id',$inbox_message);
			})->orderBy('created_at','desc')->get();
		elseif($type == 'starred')
			$messages = Message::where(function($query){
				$query->where(function($query1){
					$query1->where('from_user_id','=',Auth::user()->id)
					->where('delete_sender','=',0)
					->where('is_starred_sender','=',1);
				})->orWhere(function($query2){
					$query2->where('to_user_id','=',Auth::user()->id)
					->where('delete_receiver','=',0)
					->where('is_starred_receiver','=',1);
				});
			})->orderBy('created_at','desc')->get();
		elseif($type == 'trash')
			$messages = Message::where(function($query){
				$query->where(function($query1){
					$query1->where('from_user_id','=',Auth::user()->id)
					->where('delete_sender','=',1);
				})->orWhere(function($query2){
					$query2->where('to_user_id','=',Auth::user()->id)
					->where('delete_receiver','=',1);
				});
			})->orderBy('created_at','desc')->get();

        $rows=array();
        foreach($messages as $message){

        	$starred = 0;
			if(Auth::user()->id == $message->from_user_id)
				$starred = ($message->is_starred_sender) ? 1 : 0;
			else
				$starred = ($message->is_starred_receiver) ? 1 : 0;

			$option = (($type != 'trash') ? '<div class="btn-group btn-group-xs"><a href="'.url('/message/'.$message->token).'" class="btn btn-default btn-xs" data-toggle="tooltip" title="'.trans('messages.view').'"> <i class="fa fa-arrow-circle-right"></i></a>' : '').
				(($type != 'trash') ? '<a href="#" data-source="'.url('/message/starred').'" data-extra="&token='.$message->token.'" class="btn btn-default btn-xs" data-ajax="1"> <i class="fa fa-'.($starred ? 'star starred' : 'star-o').'"></i></a>' : '').
				(($type == 'trash') ? '<a href="#" data-source="'.url('/message/restore').'" data-extra="&token='.$message->token.'" class="btn btn-default btn-xs" data-ajax="1"> <i class="fa fa-retweet" data-toggle="tooltip" data-title="'.trans('messages.restore').'"></i></a>' : '').
				(($type != 'trash') ? delete_form(['message.trash',$message->id]) : delete_form(['message.destroy',$message->id])).'</div>';

				$source = (Auth::user()->id == $message->from_user_id) ? $message->UserTo->full_name : $message->UserFrom->full_name;

				if($type == 'starred' || $type == 'trash')
					$source .= (Auth::user()->id == $message->from_user_id) ? ' <span class="label label-success">Sent</span>' : ' <span class="label label-info">Inbox</span>';

				$unread = 0;
				if($type == 'inbox' && ((!$message->is_read && $message->to_user_id == Auth::user()->id) || ($message->Replies->where('to_user_id','=',Auth::user()->id)->where('is_read','=',0)->count())))
					$unread = 1;

				if($message->Replies->count() && ($type == 'inbox' || $type == 'sent'))
					$source .= ' ('.(($message->Replies->where('to_user_id','=',Auth::user()->id)->where('delete_receiver','=',0)->count())+($message->Replies->where('from_user_id','=',Auth::user()->id)->where('delete_sender','=',0)->count())+1).')';

				if($type == 'trash' && $message->reply_id != null && (($message->Reply->to_user_id == Auth::user()->id && $message->Reply->delete_receiver == 1) || ($message->Reply->from_user_id == Auth::user()->id && $message->Reply->delete_sender == 1)))
					$show = 0;
				else
					$show = 1;

				if($show)
					$rows[] = array('<div class="btn-group btn-group-xs">'.$option.'</div>', 
						($unread) ? ('<strong>'.$source.'</strong>') : $source,
						($unread) ? ('<strong>'.$message->subject.'</strong>') : $message->subject,
						($unread) ? ('<strong>'.showDateTime($message->created_at).'</strong>') : showDateTime($message->created_at),
						($message->attachments != '') ? '<i class="fa fa-paperclip"></i>' : ''
					);	
        }
        $list['aaData'] = $rows;
        return json_encode($list);
	}

	public function forward($token){

		$message = $this->validateLiveMessage('token',$token);

		if(!$message)
            return view('common.error',['message' => trans('messages.permission_denied')]);

		$users = \App\User::where('id','!=',Auth::user()->id)->get()->pluck('full_name','id')->all();
		return view('message.forward',compact('message','users'));
	}

	public function postForward(Request $request, $token){

		$message = $this->validateLiveMessage('token',$token);

		if(!$message){
			if($request->has('ajax_submit')){
	        	$response = ['message' => trans('messages.invalid_link'), 'status' => 'error']; 
	            return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
	        }
            return redirect('/message')->withErrors(trans('messages.invalid_link'));
		}

        $validation = Validator::make($request->all(),[
            'to_user_id' => 'required',
            'subject' => 'required'
        ]);
        $friendly_name = array('to_user_id' => 'receiver');
        $validation->setAttributeNames($friendly_name); 

        if($validation->fails()){
            if($request->has('ajax_submit')){
                $response = ['message' => $validation->messages()->first(), 'status' => 'error']; 
                return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
            }
            return redirect()->back()->withErrors($validation->messages()->first());
        }

        $new_message = new Message;
        $new_message->subject = $request->input('subject');
        $new_message->body = clean($request->input('body'));
        $new_message->attachments = $message->attachments;
        $new_message->to_user_id = $request->input('to_user_id');
        $new_message->from_user_id = Auth::user()->id;
        $new_message->token = randomString(30);
        $new_message->save();

		if($request->has('ajax_submit')){
        $response = ['message' => trans('messages.message').' '.trans('messages.sent'), 'status' => 'success']; 
            return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
        }
		return redirect('/message')->withSuccess(trans('messages.message').' '.trans('messages.sent'));	
	}

	public function load(Request $request){

		$message = $this->validateLiveMessage('token',$request->input('token'));

		if($message){
			$replies = Message::where('reply_id','=',$message->id)->where(function($query){
				$query->where(function($query1){
					$query1->where('to_user_id','=',Auth::user()->id)->where('delete_receiver','=','0');
				})->orWhere(function($query2){
					$query2->where('from_user_id','=',Auth::user()->id)->where('delete_sender','=','0');
				});
			})->get();
    		return view('message.load',compact('message','replies'))->render();
		}
	}

	public function reply($id,Request $request){

		$message = $this->validateLiveMessage('id',$id);

		if(!$message){
			if($request->has('ajax_submit')){
            $response = ['message' => trans('messages.invalid_link'), 'status' => 'error']; 
	            return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
	        }
			return redirect('/message')->withErrors(trans('messages.invalid_link'));	
		}

		$data = $request->all();
		$filename = uniqid();
     	if ($request->hasFile('file')) {
	 		$extension = $request->file('file')->getClientOriginalExtension();
	 		$file = $request->file('file')->move(config('constant.upload_path.attachments'), $filename.".".$extension);
	 		$data['attachments'] = $filename.".".$extension;
		 }
		 else
		 	$data['attachments'] = '';

		$reply = new Message;
	    $reply->fill($data);
	    $reply->token = randomString(30);
		$reply->subject = 'Re: '.$message->subject;
		$reply->body = clean($request->input('body'));
		$reply->from_user_id = Auth::user()->id;
	    $reply->reply_id = $message->id;
	    $reply->is_read = 0;
		$reply->to_user_id = ($message->from_user_id == Auth::user()->id) ? $message->to_user_id : $message->from_user_id;
		$reply->save();

		if($request->has('ajax_submit')){
        $response = ['message' => trans('messages.message').' '.trans('messages.sent'), 'status' => 'success']; 
            return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
        }
		return redirect('/message')->withSuccess(trans('messages.message').' '.trans('messages.sent'));	
	}

	public function store(MessageRequest $request){

		$data = $request->all();
		$filename = uniqid();
		
     	if ($request->hasFile('file')) {
	 		$extension = $request->file('file')->getClientOriginalExtension();
	 		$file = $request->file('file')->move(config('constant.upload_path.attachments'), $filename.".".$extension);
	 		$data['attachments'] = $filename.".".$extension;
		 }
		 else
		 	$data['attachments'] = '';

		$message = new Message;
	    $message->fill($data);
	    $message->token = randomString(30);
	    $message->body = clean($request->input('body'));
	    $message->from_user_id = Auth::user()->id;
	    $message->is_read = 0;
		$message->save();

		$this->logActivity(['module' => 'message','unique_id' => $request->input('to_user_id'),'activity' => 'activity_message_sent']);

        if($request->has('ajax_submit')){
            $response = ['message' => trans('messages.message').' '.trans('messages.sent'), 'status' => 'success']; 
            return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
        }
		return redirect('/message')->withSuccess(trans('messages.message').' '.trans('messages.sent'));	
	}

	public function download($token){

		$message = $this->validateLiveMessage('token',$token);

		if(!$message)
			return redirect('/message')->withErrors(trans('messages.invalid_link'));	

		if($message->attachments == null || $message->attachments == '')
			return redirect('/message')->withErrors(trans('messages.invalid_link'));

		$file = config('constant.upload_path.attachments').$message->attachments;
		if(File::exists($file))
			return response()->download($file);
		else
			return redirect()->back()->withErrors(trans('messages.file_not_found'));
	}

	public function view($token){

		$message = $this->validateLiveMessage('token',$token);

		if(!$message)
			return redirect('/message')->withErrors(trans('messages.invalid_link'));	

		if($message->Replies->count())
			Message::where('reply_id','=',$message->id)->where('to_user_id','=',Auth::user()->id)->update(['is_read' => 1]);

		if($message->reply)
			return redirect('/message/'.$message->Reply->token);

		if(Auth::user()->id == $message->to_user_id){
			$message->is_read = 1;
			$message->save();
		}

		return view('message.view',compact('message'));
	}

	public function trash($id,Request $request){

		$message = $this->validateLiveMessage('id',$id);

		if(!$message){
        	if($request->has('ajax_submit')){
        		$response = ['message' => trans('messages.invalid_link'), 'status' => 'error']; 
	        	return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
        	}
            return redirect()->back()->withErrors(trans('messages.invalid_link'));
		}

		$this->logActivity(['module' => 'message','unique_id' => $message->id,'activity' => 'activity_trashed']);

		if($message->to_user_id == Auth::user()->id)
			$message->delete_receiver = 1;
		else
			$message->delete_sender = 1;	
		$message->save();

		if($message->Replies->count()){
			$sender_messages = $message->Replies->where('from_user_id','=',Auth::user()->id)->pluck('id');
			Message::whereIn('id',$sender_messages)->update(['delete_sender' => 1]);
			$receiver_messages = $message->Replies->where('to_user_id','=',Auth::user()->id)->pluck('id');
			Message::whereIn('id',$receiver_messages)->update(['delete_receiver' => 1]);
		}

        if($request->has('ajax_submit')){
	        $response = ['message' => trans('messages.message').' '.trans('messages.trashed'), 'status' => 'success']; 
	        return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
	    }
        return redirect('/message')->withSuccess(trans('messages.message').' '.trans('messages.trashed'));
	}

	public function restore(Request $request){

		$message = $this->validateDeleteMessage('token',$request->input('token'));

		if(!$message){
        	if($request->has('ajax_submit')){
        		$response = ['message' => trans('messages.invalid_link'), 'status' => 'error']; 
	        	return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
        	}
            return redirect()->back()->withErrors(trans('messages.invalid_link'));
		}

		if($message->reply_id != null && (($message->Reply->to_user_id == Auth::user()->id && $message->Reply->delete_receiver > 0) || ($message->Reply->from_user_id == Auth::user()->id && $message->Reply->delete_sender > 0))){
        	if($request->has('ajax_submit')){
        		$response = ['message' => trans('messages.invalid_link'), 'status' => 'error']; 
	        	return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
        	}
            return redirect()->back()->withErrors(trans('messages.invalid_link'));
		}

		$this->logActivity(['module' => 'message','unique_id' => $message->id,'activity' => 'activity_restored']);

		if($message->to_user_id == Auth::user()->id)
			$message->delete_receiver = 0;
		else
			$message->delete_sender = 0;	
		$message->save();

		if($message->Replies->count()){
			$sender_messages = $message->Replies->where('from_user_id','=',Auth::user()->id)->pluck('id');
			Message::whereIn('id',$sender_messages)->update(['delete_sender' => 0]);
			$receiver_messages = $message->Replies->where('to_user_id','=',Auth::user()->id)->pluck('id');
			Message::whereIn('id',$receiver_messages)->update(['delete_receiver' => 0]);
		}

        if($request->has('ajax_submit')){
	        $response = ['message' => trans('messages.message').' '.trans('messages.restored'), 'status' => 'success']; 
	        return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
	    }
        return redirect('/message')->withSuccess(trans('messages.message').' '.trans('messages.restored'));
	}

	public function destroy($id,Request $request){

		$message = $this->validateDeleteMessage('id',$id);

		if(!$message){
        	if($request->has('ajax_submit')){
        		$response = ['message' => trans('messages.invalid_link'), 'status' => 'error']; 
	        	return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
        	}
            return redirect()->back()->withErrors(trans('messages.invalid_link'));
		}

		$this->logActivity(['module' => 'message','unique_id' => $message->id,'activity' => 'activity_deleted']);

		if($message->to_user_id == Auth::user()->id)
			$message->delete_receiver = 2;
		else
			$message->delete_sender = 2;	
		$message->save();

		if($message->Replies->count()){
			$sender_messages = $message->Replies->where('from_user_id','=',Auth::user()->id)->pluck('id');
			Message::whereIn('id',$sender_messages)->update(['delete_sender' => 2]);
			$receiver_messages = $message->Replies->where('to_user_id','=',Auth::user()->id)->pluck('id');
			Message::whereIn('id',$receiver_messages)->update(['delete_receiver' => 2]);
		}

        if($request->has('ajax_submit')){
	        $response = ['message' => trans('messages.message').' '.trans('messages.deleted'), 'status' => 'success']; 
	        return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
	    }
        return redirect('/message')->withSuccess(trans('messages.message').' '.trans('messages.deleted'));
	}
}