<?php
namespace App\Http\Controllers;
use App\CustomField;
use Auth;
use Entrust;
use Illuminate\Http\Request;
use App\Http\Requests\CustomFieldRequest;

Class CustomFieldController extends Controller{
    use BasicController;

	public function __construct()
	{
		$this->middleware('feature_available:enable_custom_field');
	}

	public function index(CustomField $custom_field){

		$table_data['custom-field-table'] = array(
			'source' => 'custom-field',
			'title' => 'Custom Field List',
			'id' => 'custom_field_table',
			'data' => array(
        		trans('messages.option'),
        		trans('messages.form'),
        		trans('messages.title'),
        		trans('messages.type'),
        		trans('messages.option'),
        		trans('messages.required')
        		)
			);

		return view('custom_field.index',compact('table_data'));
	}

	public function lists(Request $request){
		$custom_fields = CustomField::all();


		foreach($custom_fields as $custom_field){
			$rows[] = array(
				delete_form(['custom-field.destroy',$custom_field->id],array('custom_field')),
				toWord($custom_field->form),
				$custom_field->title,
				ucfirst($custom_field->type),
				implode('<br />',explode(',',$custom_field->options)),
				($custom_field->is_required) ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>'
				);
		}
        $list['aaData'] = (isset($rows) && count($rows)) ? $rows : array();
        return json_encode($list);
	}

	public function store(CustomFieldRequest $request, CustomField $custom_field){

		$data = $request->all();
        $custom_field->fill($data);

		$options = explode(',',$request->input('options'));
		$options = array_unique($options);
		$custom_field->options = implode(',',$options);
		$custom_field->name = createSlug($request->input('title'));
		$custom_field->save();

		$this->logActivity(['module' => 'custom_field','unique_id' => $custom_field->id,'activity' => 'activity_added']);

	    if($request->has('ajax_submit')){
	        $response = ['message' => trans('messages.custom').' '.trans('messages.field').' '.trans('messages.added'), 'status' => 'success']; 
	        return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
	    }
		return redirect()->back()->withSuccess(trans('messages.custom').' '.trans('messages.field').' '.trans('messages.added'));		
	}

	public function destroy(CustomField $custom_field,Request $request){

		$this->logActivity(['module' => 'custom_field','unique_id' => $custom_field->id,'activity' => 'activity_deleted']);

        $custom_field->delete();

        if($request->has('ajax_submit')){
            $response = ['message' => trans('messages.custom').' '.trans('messages.field').' '.trans('messages.deleted'), 'status' => 'success']; 
            return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
        }
        return redirect('/custom-field')->withSuccess(trans('messages.custom').' '.trans('messages.field').' '.trans('messages.deleted'));
	}
}
?>