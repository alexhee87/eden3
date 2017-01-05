<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Location;
use App\Department;
use App\Http\Requests\DepartmentRequest;
use App\Classes\Helper;
use Entrust;
use Lang;
use Validator;
use Session;
use App;

class DepartmentController extends Controller
{
      use BasicController;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $table_data['department-table'] = array(
			'source' => 'department',
			'title' => 'Department List',
			'id' => 'department_table',
			'data' => array(
        		trans('messages.option'),
        		trans('messages.name'),
        		trans('messages.description'),
                trans('messages.location'),
        		trans('messages.active')
        		)
			);

        $locations = Location::where('active', 1)->select('id', 'name')->get();
        $locationsList = array();
        foreach($locations as $location){
            $locationsList[$location->id] = $location->name;
        }

		return view('department.index',compact('table_data', 'locationsList'));
    }

    public function lists(Request $request){
        $departments = Department::all();

		foreach($departments as $department){
			$rows[] = array(
                '<div class="btn-group btn-group-xs center-block">'
                .'<a href="#" data-href="'.url('/department/'.$department->id).'/edit" class="btn btn-xs btn-default" data-toggle="modal" data-target="#myModal"> <i class="fa fa-edit" data-toggle="tooltip" title="'.trans('messages.edit').'"></i></a>'
                .'<a href="#" data-href="'.url('/department/'.$department->id).'/delete" class="btn btn-xs btn-danger btn-default" onclick="popDeleteMessage(this)"> <i class="fa fa-trash-o" data-toggle="tooltip" title="'.trans('permission.destroy').'"></i></a>'
                .'<span style="display: none">'.delete_form(['department.destroy',$department->id]).'</span>'
                .'</div>'
                ,
				$department->name,
				ucfirst($department->description),
                $department->getLocationName(),
                $department->active
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
    public function create(DepartmentRequest $request, Department $department)
    {
        $data = $request->all();
        $department->fill($data);

        $department->name = $request->input('name');
		$department->description = $request->input('description');
		$department->save();

		$this->logActivity(['module' => 'department','unique_id' => $department->id,'activity' => 'activity_added']);

        return $this->returnResponse($request, trans('messages.department'), trans('messages.added'));
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
    public function edit(Department $department){

        $locations = Location::where('active', 1)->select('id', 'name')->get();
        $locationsList = array();
        foreach($locations as $location){
            $locationsList[$location->id] = $location->name;
        }

		return view('department.edit',compact('department', 'locationsList'));
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DepartmentRequest $request, Department $department){
        $this->ajaxOnlyResponse($request);
        $department->fill($request->all());
		$department->save();

		$this->logActivity(['module' => 'department', 'unique_id' => $department->id, 'activity' => 'activity_updated']);

        return $this->returnResponse($request, trans('messages.department'), trans('messages.updated'));
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DepartmentRequest $request, Department $department)
    {
        $this->logActivity(['module' => 'department','unique_id' => $department->id,'activity' => 'activity_deleted']);

        $department->delete();

        return $this->returnResponse($request, trans('messages.department'), trans('messages.deleted'));
    }
}
