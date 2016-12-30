<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use App\Role;
use Entrust;

Class RoleController extends Controller{
    use BasicController;

	public function index(){
		$table_data['role-table'] = array(
            'source' => 'role',
            'title' => 'Role List',
            'id' => 'role_table',
			'data' => array(
                trans('messages.option'),
                trans('messages.name'),
                trans('messages.description')
        		)
			);

		return view('role.index',compact('table_data'));
	}

	public function show(){
	}

	public function create(){
		return view('role.create');
	}

	public function lists(){
		$roles = Role::whereIsHidden(0)->get();
        $rows = array();

        foreach($roles as $role){
            $rows[] = array(
                '<div class="btn-group btn-group-xs center-block">'.
                '<a href="#" data-href="'.url('/role/'.$role->id).'/edit" class="btn btn-xs btn-default" data-toggle="modal" data-target="#myModal"> <i class="fa fa-edit" data-toggle="tooltip" title="'.trans('messages.edit').'"></i></a>'.
				'<a href="#" data-href="'.url('/role/'.$role->id).'/delete" class="btn btn-xs btn-danger btn-default" onclick="popDeleteMessage(this)"> <i class="fa fa-trash-o" data-toggle="tooltip" title="'.trans('role.destroy').'"></i></a>'.
                '<span style="display: none">'.delete_form(['role.destroy',$role->id]).'</span>'.
                '</div>',
                ucfirst($role->name).(($role->default_user_role) ? (' <span class="label label-danger">'.trans('messages.default_user_role').'</span>') : ''),
                $role->description
                );
        }
        $list['aaData'] = $rows;
        return json_encode($list);
	}

	public function edit(Role $role){
		if($role->is_hidden)
            return view('common.error',['message' => trans('messages.permission_denied')]);

		return view('role.edit',compact('role'));
	}

	public function store(RoleRequest $request,Role $role){	

		$db_role = Role::whereName(createSlug($request->input('name')))->count();
		if($db_role){
			$name = $request->input('name').' '.trans('messages.role');
        	if($request->has('ajax_submit')){
        		$response = ['message' => trans('validation.unique',['attribute' => $name]), 'status' => 'error']; 
	        	return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
        	}
            return redirect()->back()->withErrors(trans('validation.unique',['attribute' => $name]));
		}

		$role->fill($request->all());

		if($request->input('default_user_role')){
			Role::whereIsHidden(0)->update(['default_user_role' => 0]);
			$role->default_user_role = 1;
		}

		$role->save();

		$this->logActivity(['module' => 'role','unique_id' => $role->id,'activity' => 'activity_added']);

        if($request->has('ajax_submit')){
            $response = ['message' => trans('messages.role').' '.trans('messages.added'), 'status' => 'success'];
            return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
        }
		return redirect()->back()->withSuccess(trans('messages.role').' '.trans('messages.added'));		
	}

	public function update(RoleRequest $request, Role $role){

		$db_role = Role::whereName(createSlug($request->input('name')))->where('id','!=',$role->id)->count();
		if($db_role){
			$name = $request->input('name').' '.trans('messages.role');
        	if($request->has('ajax_submit')){
        		$response = ['message' => trans('validation.unique',['attribute' => $name]), 'status' => 'error']; 
	        	return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
        	}
            return redirect()->back()->withErrors(trans('validation.unique',['attribute' => $name]));
		}

		$role->fill($request->all());
		if($request->input('default_user_role')){
			Role::whereIsHidden(0)->update(['default_user_role' => 0]);
			$role->default_user_role = 1;
		}
		$role->save();

		$this->logActivity(['module' => 'role','unique_id' => $role->id,'activity' => 'activity_updated']);

        if($request->has('ajax_submit')){
	        $response = ['message' => trans('messages.role').' '.trans('messages.updated'), 'status' => 'success']; 
	        return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
	    }
		return redirect()->back()->withSuccess(trans('messages.role').' '.trans('messages.updated'));
	}

	public function destroy(Role $role,Request $request){

		if($role->is_hidden || $role->default_user_role){
        	if($request->has('ajax_submit')){
        		$response = ['message' => trans('messages.permission_denied'), 'status' => 'error']; 
	        	return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
        	}
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
		}

		$this->logActivity(['module' => 'role','unique_id' => $role->id,'activity' => 'activity_deleted']);

        $role->delete();

        if($request->has('ajax_submit')){
	        $response = ['message' => trans('messages.role').' '.trans('messages.deleted'), 'status' => 'success']; 
	        return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
	    }
        return redirect()->back()->withSuccess(trans('messages.role').' '.trans('messages.deleted'));
	}
}
?>