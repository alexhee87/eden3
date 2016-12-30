<?php

namespace App\Http\Controllers;

use App\Company;
use App\Country;
use Illuminate\Http\Request;
use App\Classes\Helper;
use Entrust;
use Lang;
use Validator;
use Session;
use App;

class CompanyController extends Controller
{
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
                trans('message.country'),
        		trans('messages.active')
        		)
			);

		return view('company.index',compact('table_data'));
    }

    public function lists(Request $request){
        $companies = Company::all();

		foreach($companies as $company){
			$rows[] = array(
				delete_form(['company.destroy',$company->id],array('company')),
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
    public function create()
    {
        //
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
