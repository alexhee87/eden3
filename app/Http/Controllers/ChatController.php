<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Requests\ChatRequest;
use App\Chat;
use Entrust;

Class ChatController extends Controller{

    public function store(ChatRequest $request,Chat $chat){
    	$chat->message = $request->input('message');
    	$chat->user_id = \Auth::user()->id;
    	$chat->save();

		$content = view('chat.single_list',compact('chat'))->render();

		//upon saving broadcast the message

		$pusher = App::make('pusher');

		$pusher->trigger('eden-chat',
			'message-sent-event',
			array('message' => $content));

    	
    	$response = ['message' => trans('messages.message').' '.trans('messages.posted'), 'status' => 'success'];
        return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
    }

    public function index(){
    	$chats = Chat::orderBy('id','desc')->get()->take(50);
    	$chats = $chats->sortBy('id');

    	return view('chat.fetch',compact('chats'))->render();
    }
}