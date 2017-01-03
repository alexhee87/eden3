<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Location;
use App\Country;
use App\Http\Requests\LocationRequest;
use App\Classes\Helper;
use Entrust;
use Lang;
use Validator;
use Session;
use App;

class LocationController extends Controller
{
      use BasicController;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $table_data['location-table'] = array(
			'source' => 'location',
			'title' => 'Location List',
			'id' => 'location_table',
			'data' => array(
        		trans('messages.option'),
        		trans('messages.name'),
        		trans('messages.description'),
                trans('messages.company'),
        		trans('messages.active')
        		)
			);

        $companies = Company::where('active', 1)->select('id', 'name')->get();
        $companiesList = array();
        foreach($companies as $company){
            $companiesList[$company->id] = $company->name;
        }

		return view('location.index',compact('table_data', 'companiesList'));
    }

    public function lists(Request $request){
        $locations = Location::all();

		foreach($locations as $location){
			$rows[] = array(
                '<div class="btn-group btn-group-xs center-block">'
                .'<a href="#" data-href="'.url('/location/'.$location->id).'/edit" class="btn btn-xs btn-default" data-toggle="modal" data-target="#myModal"> <i class="fa fa-edit" data-toggle="tooltip" title="'.trans('messages.edit').'"></i></a>'
                .'<a href="#" data-href="'.url('/location/'.$location->id).'/delete" class="btn btn-xs btn-danger btn-default" onclick="popDeleteMessage(this)"> <i class="fa fa-trash-o" data-toggle="tooltip" title="'.trans('permission.destroy').'"></i></a>'
                .'<span style="display: none">'.delete_form(['location.destroy',$location->id]).'</span>'
                .'</div>'
                ,
				$location->name,
				ucfirst($location->description),
                $location->getCompanyName(),
                $location->active
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
    public function create(LocationRequest $request, Location $location)
    {
        $data = $request->all();
        $location->fill($data);

        $location->name = $request->input('name');
		$location->description = $request->input('description');
		$location->save();

		$this->logActivity(['module' => 'location','unique_id' => $location->id,'activity' => 'activity_added']);

        return $this->returnResponse($request, trans('messages.location'), trans('messages.added'));
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
    public function edit(Location $location){

        $countries = Country::where('active', 1)->select('id', 'name')->get();
        $countriesList = array();
        foreach($countries as $country){
            $countriesList[$country->id] = $country->name;
        }


		return view('location.edit',compact('location', 'countriesList'));
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LocationRequest $request, Location $location){
        $this->ajaxOnlyResponse($request);
        $location->fill($request->all());
		$location->save();

		$this->logActivity(['module' => 'location', 'unique_id' => $location->id, 'activity' => 'activity_updated']);

        return $this->returnResponse($request, trans('messages.location'), trans('messages.updated'));
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(LocationRequest $request, Location $location)
    {
        $this->logActivity(['module' => 'location','unique_id' => $location->id,'activity' => 'activity_deleted']);

        $location->delete();

        return $this->returnResponse($request, trans('messages.location'), trans('messages.deleted'));
    }
}
