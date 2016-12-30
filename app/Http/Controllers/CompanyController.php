<?php

namespace App\Http\Controllers;

use App\Company;
use App\Country;
use Illuminate\Http\Request;
use App\Http\Requests\CompanyRequest;
use App\Permission;
use App\Classes\Helper;
use Entrust;
use Lang;
use Validator;
use Session;
use App;

class CompanyController extends Controller
{
    use BasicController;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $table_data['company-table'] = array(
			'source' => 'company',
			'title' => 'Company List',
			'id' => 'company_table',
			'data' => array(
        		trans('messages.option'),
        		trans('messages.name'),
        		trans('messages.description'),
                trans('messages.country'),
        		trans('messages.active')
        		)
			);

        $countries = Country::where('active', 1)->select('id', 'name')->get();
        $countriesList = array();
        foreach($countries as $country){
            $countriesList[$country->id] = $country->name;
        }

		return view('company.index',compact('table_data', 'countriesList'));
    }

    public function lists(Request $request){
        $companies = Company::all();

		foreach($companies as $company){
			$rows[] = array(
                '<div class="btn-group btn-group-xs center-block">'
                .'<a href="#" data-href="'.url('/company/'.$company->id).'/edit" class="btn btn-xs btn-default" data-toggle="modal" data-target="#myModal"> <i class="fa fa-edit" data-toggle="tooltip" title="'.trans('messages.edit').'"></i></a>'
                .'<a href="#" data-href="'.url('/company/'.$company->id).'/delete" class="btn btn-xs btn-danger btn-default" onclick="popDeleteMessage(this)"> <i class="fa fa-trash-o" data-toggle="tooltip" title="'.trans('permission.destroy').'"></i></a>'
                .'<span style="display: none">'.delete_form(['company.destroy',$company->id]).'</span>'
                .'</div>'
                ,
				$company->name,
				ucfirst($company->description),
                $company->getCountryName(),
                $company->active
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
    public function create(CompanyRequest $request, Company $company)
    {
        $data = $request->all();
        $company->fill($data);

        $company->name = $request->input('name');
		$company->description = $request->input('description');
		$company->save();

		$this->logActivity(['module' => 'company','unique_id' => $company->id,'activity' => 'activity_added']);

        return $this->returnResponse($request, trans('messages.company'), trans('messages.added'));
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
    public function edit(Company $company){

        $countries = Country::where('active', 1)->select('id', 'name')->get();
        $countriesList = array();
        foreach($countries as $country){
            $countriesList[$country->id] = $country->name;
        }


		return view('company.edit',compact('company', 'countriesList'));
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyRequest $request, Company $company){
        $this->ajaxOnlyResponse($request);
        $company->fill($request->all());
		$company->save();

		$this->logActivity(['module' => 'company', 'unique_id' => $company->id, 'activity' => 'activity_updated']);

        return $this->returnResponse($request, trans('messages.company'), trans('messages.updated'));
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompanyRequest $request, Company $company)
    {
        $this->logActivity(['module' => 'company','unique_id' => $company->id,'activity' => 'activity_deleted']);

        $company->delete();

        return $this->returnResponse($request, trans('messages.company'), trans('messages.deleted'));
    }
}
