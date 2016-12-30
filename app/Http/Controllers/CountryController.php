<?php

namespace App\Http\Controllers;

use App\Http\Requests\CountryRequest;
use Illuminate\Http\Request;
use App\Country;
use Auth;
use Entrust;

class CountryController extends Controller
{
    use BasicController;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            $table_data['country-table'] = array(
			'source' => 'country',
			'title' => 'Country List',
			'id' => 'country_table',
			'data' => array(
                'ID',
        		trans('messages.name'),
        		trans('messages.country_iso')
            )
			);

		return view('country.index',compact('table_data'));
    }

    public function lists(Request $request){
        $countries = Country::all();

		foreach($countries as $country){
			$rows[] = array(
                $country->id,
				$country->name,
				$country->iso_name
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
    public function create(CountryRequest $request, Country $country)
    {
        $data = $request->all();
        $country->fill($data);

        $country->name = $request->input('name');
		$country->iso_name = $request->input('iso_name');
		$country->save();

		$this->logActivity(['module' => 'country','unique_id' => $country->id,'activity' => 'activity_added']);

	    if($request->has('ajax_submit')){
	        $response = ['message' => trans('messages.custom').' '.trans('messages.field').' '.trans('messages.added'), 'status' => 'success'];
	        return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
	    }
		return redirect()->back()->withSuccess(trans('messages.custom').' '.trans('messages.field').' '.trans('messages.added'));
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
