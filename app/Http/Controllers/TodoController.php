<?php
namespace App\Http\Controllers;
use DB;
use Entrust;
use App\Todo;
use App\Classes\Helper;
use Illuminate\Http\Request;
use App\Http\Requests\TodoRequest;
use Auth;

Class TodoController extends Controller{
    use BasicController;

	protected $form = 'todo-form';

	public function __construct()
	{
		$this->middleware('feature_available:enable_to_do');
	}

	public function index(){
		return view('todo.create');
	}

	public function show(Todo $todo){
		return view('todo.edit');
	}

	public function create(){
	}

	public function edit(Todo $todo){
		return view('todo.edit',compact('todo'));
	}

	public function store(TodoRequest $request, Todo $todo){	
		$data = $request->all();
	    $todo->fill($data);
	    $todo->user_id = Auth::user()->id;
		$todo->save();

		$this->logActivity(['module' => 'to_do','unique_id' => $todo->id,'activity' => 'activity_added']);

        if($request->has('ajax_submit')){
            $response = ['message' => trans('messages.to_do').' '.trans('messages.added'), 'status' => 'success'];
            return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
        }
		return redirect()->back()->withSuccess(trans('messages.to_do').' '.trans('messages.added'));	
	}

	public function update(TodoRequest $request, Todo $todo){
		
		$data = $request->all();
		$todo->fill($data)->save();
		$this->logActivity(['module' => 'to_do','unique_id' => $todo->id,'activity' => 'activity_updated']);
		
        if($request->has('ajax_submit')){
            $response = ['message' => trans('messages.to_do').' '.trans('messages.updated'), 'status' => 'success'];
            return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
        }
		return redirect('/dashboard')->withSuccess(trans('messages.to_do').' '.trans('messages.updated'));
	}

	public function destroy(Todo $todo){
        $todo->delete();
		$this->logActivity(['module' => 'to_do','unique_id' => $todo->id,'activity' => 'activity_deleted']);

        if($request->has('ajax_submit')){
            $response = ['message' => trans('messages.to_do').' '.trans('messages.deleted'), 'status' => 'success'];
            return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
        }
        return redirect('/dashboard')->withSuccess(trans('messages.to_do').' '.trans('messages.deleted'));
	}
}
?>