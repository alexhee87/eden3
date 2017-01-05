<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Department;
use App\Team;
use App\Http\Requests\TeamRequest;
use App\Classes\Helper;
use Entrust;
use Lang;
use Validator;
use Session;
use App;

class TeamController extends Controller
{
      use BasicController;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $table_data['team-table'] = array(
			'source' => 'team',
			'title' => 'Team List',
			'id' => 'team_table',
			'data' => array(
        		trans('messages.option'),
        		trans('messages.name'),
        		trans('messages.description'),
                trans('messages.department'),
        		trans('messages.active')
        		)
			);

        $departments = Department::where('active', 1)->select('id', 'name')->get();
        $departmentsList = array();
        foreach($departments as $department){
            $departmentsList[$department->id] = $department->name;
        }

		return view('team.index',compact('table_data', 'departmentsList'));
    }

    public function lists(Request $request){
        $teams = Team::all();

		foreach($teams as $team){
			$rows[] = array(
                '<div class="btn-group btn-group-xs center-block">'
                .'<a href="#" data-href="'.url('/team/'.$team->id).'/edit" class="btn btn-xs btn-default" data-toggle="modal" data-target="#myModal"> <i class="fa fa-edit" data-toggle="tooltip" title="'.trans('messages.edit').'"></i></a>'
                .'<a href="#" data-href="'.url('/team/'.$team->id).'/delete" class="btn btn-xs btn-danger btn-default" onclick="popDeleteMessage(this)"> <i class="fa fa-trash-o" data-toggle="tooltip" title="'.trans('permission.destroy').'"></i></a>'
                .'<span style="display: none">'.delete_form(['team.destroy',$team->id]).'</span>'
                .'</div>'
                ,
				$team->name,
				ucfirst($team->description),
                $team->getDepartmentName(),
                $team->active
				);
		}
        $list['aaData'] = (isset($rows) && count($rows)) ? $rows : array();
        return json_encode($list);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(TeamRequest $request, Team $team)
    {
        $data = $request->all();
        $team->fill($data);

        $team->name = $request->input('name');
		$team->description = $request->input('description');
		$team->save();

		$this->logActivity(['module' => 'team','unique_id' => $team->id,'activity' => 'activity_added']);

        return $this->returnResponse($request, trans('messages.team'), trans('messages.added'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $team){

        $departments = Department::where('active', 1)->select('id', 'name')->get();
        $departmentsList = array();
        foreach($departments as $department){
            $departmentsList[$department->id] = $department->name;
        }

		return view('team.edit',compact('team', 'departmentsList'));
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TeamRequest $request, Team $team){
        $this->ajaxOnlyResponse($request);
        $team->fill($request->all());
		$team->save();

		$this->logActivity(['module' => 'team', 'unique_id' => $team->id, 'activity' => 'activity_updated']);

        return $this->returnResponse($request, trans('messages.team'), trans('messages.updated'));
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TeamRequest $request, Team $team)
    {
        $this->logActivity(['module' => 'team','unique_id' => $team->id,'activity' => 'activity_deleted']);

        $team->delete();

        return $this->returnResponse($request, trans('messages.team'), trans('messages.deleted'));
    }
}
