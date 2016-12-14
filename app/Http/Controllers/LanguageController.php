<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\LanguageRequest;
use File;
use App\Classes\Helper;
use Entrust;
use Lang;
use Validator;
use Session;
use App;

Class LanguageController extends Controller{
    use BasicController;

	public function __construct()
	{
		$this->middleware('feature_available:multilingual');
	}

	public function index(){

		$table_data['language-table'] = array(
			'source' => 'language',
			'title' => 'Language List',
			'id' => 'language_table',
			'data' => array(
        		trans('messages.option'),
        		trans('messages.locale'),
        		trans('messages.language').' '.trans('messages.name'),
        		trans('messages.percentage').' '.trans('messages.translation')
        		)
			);

		return view('language.index',compact('table_data'));
	}

	public function lists(Request $request){

        $languages = config('lang');
		$translation_count = count(config('language'));
		$rows = array();

        foreach($languages as $locale => $language){

			$trans = File::getRequire(base_path().'/resources/lang/'.$locale.'/messages.php');
    		$percentage = ($translation_count) ? round(((count($trans)*100)/$translation_count),2) : 0;

			$rows[] = array(
				'<div class="btn-group btn-group-xs">'.
				'<a href="/language/'.$locale.'" class="btn btn-default btn-xs md-trigger"> <i class="fa fa-arrow-circle-right" title="'.trans('messages.view').'" data-toggle="tooltip"></i></a> '.
				'<a href="#" data-href="/language/'.$locale.'/edit" class="btn btn-default btn-xs md-trigger" data-toggle="modal" data-target="#myModal"> <i class="fa fa-edit" title="'.trans('messages.edit').'" data-toggle="tooltip"></i></a> '.
				delete_form(['language.destroy',$locale]).'</div>',
				$locale,
				$language['language'],
				$percentage.' % '.trans('messages.translation')
				);	
        }
        $list['aaData'] = $rows;
        return json_encode($list);
	}

	public function plugin(Request $request,$locale){

		$lang = config('lang');
		$lang[$locale] = array(
			'language' => config('lang.'.$locale.'.language'),
			'calendar' => $request->input('calendar'),
			'datatable' => $request->input('datatable'),
			'datetimepicker' => $request->input('datetimepicker'),
			'datepicker' => $request->input('datepicker'),
			'validation' => $request->input('validation'),
			);

		$filename = base_path().config('constant.path.lang');
		File::put($filename,var_export($lang, true));
		File::prepend($filename,'<?php return ');
		File::append($filename, ';');

		$this->logActivity(['module' => 'language_plugin','activity' => 'activity_updated']);

        if($request->has('ajax_submit')){
            $response = ['message' => trans('messages.language').' '.trans('messages.plugin').' '.trans('messages.updated'), 'status' => 'success']; 
            return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
        }
		return redirect()->back()->withSuccess(trans('messages.language').' '.trans('messages.plugin').' '.trans('messages.saved'));
	}

	public function show($locale){

		if(!array_key_exists($locale, config('lang')))
			return redirect()->back()->withErrors(trans('messages.invalid_link'));

		$language = config('lang.'.$locale);

		$words = config('language');
		$modules = array();
		foreach($words as $word)
			$modules[] = $word['module'];

		$word_count = array_count_values($modules);

		$modules = array_unique($modules);
		asort($modules);

		asort($words);

		$translation = File::getRequire(base_path().'/resources/lang/'.$locale.'/messages.php');

		return view('language.show',compact('language','words','translation','locale','modules','word_count'));
	}

	public function create(){
	}

	public function edit($locale){

		if(!array_key_exists($locale, config('lang')))
            return view('common.error',['message' => trans('messages.invalid_link')]);

		return view('language.edit',compact('locale'));
	}

	
	public function update(LanguageRequest $request, $locale){

		$languages = config('lang');
		if(!array_key_exists($locale, $languages)){
	        if($request->has('ajax_submit')){
	            $response = ['message' => trans('messages.invalid_link'), 'status' => 'error']; 
	            return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
	        }
			return redirect()->back()->withErrors(trans('messages.invalid_link'));
		}

		$languages[$locale] = [
							'language' => $request->input('name'),
							'datatable' => $request->input('datatable'),
							'calendar' => $request->input('calendar')
							];
		$filename = base_path().config('constant.path.lang');
		File::put($filename,var_export($languages, true));
		File::prepend($filename,'<?php return ');
		File::append($filename, ';');
		
		$this->logActivity(['module' => 'language','activity' => 'activity_updated']);

        if($request->has('ajax_submit')){
            $response = ['message' => trans('messages.language').' '.trans('messages.updated'), 'status' => 'success']; 
            return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
        }
		return redirect('/language')->withSuccess(trans('messages.language').' '.trans('messages.updated'));
	}

	public function store(LanguageRequest $request){

        $languages = config('lang');

		if(array_key_exists($request->input('locale'), $languages)){
	        if($request->has('ajax_submit')){
	            $response = ['message' => trans('messages.language_already_added'), 'status' => 'error']; 
	            return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
	        }
			return redirect()->back()->withErrors(trans('messages.language_already_added'));
		}

		$languages[$request->input('locale')] = [
			'language' => $request->input('name')
			];
		$filename = base_path().config('constant.path.lang');

		File::put($filename,var_export($languages, true));
		File::prepend($filename,'<?php return ');
		File::append($filename, ';');

		File::copyDirectory(base_path().'/resources/lang/en', base_path().'/resources/lang/'.$request->input('locale'));
		$filename = base_path().'/resources/lang/'.$request->input('locale').'/messages.php';
		File::put($filename,'<?php return array();');

		$this->logActivity(['module' => 'language','activity' => 'activity_added']);

        if($request->has('ajax_submit')){
            $response = ['message' => trans('messages.language').' '.trans('messages.added'), 'status' => 'success']; 
            return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
        }
		return redirect()->back()->withSuccess(trans('messages.language').' '.trans('messages.added'));	
	}

	public function setLanguage($locale,Request $request){

        $languages = config('lang');
		if(!array_key_exists($locale, $languages))
			return redirect()->back()->withErrors(trans('messages.invalid_link'));

		cache()->put('lang', $locale, config('config.cache_lifetime'));
		App::setLocale($locale);

		$this->logActivity(['module' => 'language','activity' => 'activity_switched']);

		return redirect()->back()->withSuccess(trans('messages.language').' '.trans('messages.switched'));
	}

	public function addWords(Request $request){

		if(!getMode())
			return redirect()->back()->withErrors(trans('messages.disable_message'));
		
		$validator = Validator::make($request->all(),[
		    	'key' => 'required',
		    	'text' => 'required',
		    	'module' => 'required']
		);

		if ($validator->fails())
			return redirect()->back()->withErrors($validator->messages()->first());

		$data = $request->all();

		$translation = config('language');
		$word_array = array();
		foreach(config('language') as $word => $value){
			$word_array[] = $word;
		}
		if(in_array($data['key'],$word_array))
			return redirect()->back()->withInput()->withErrors(trans('messages.word_already_added'));

		$translation[$data['key']] = array('value' => $data['text'],'module' => $data['module']);
		$filename = base_path().config('constant.path.language');
		File::put($filename,var_export($translation, true));
		File::prepend($filename,'<?php return ');
		File::append($filename, ';');

		$this->logActivity(['module' => 'translation_word','activity' => 'activity_added']);
		
		return redirect()->back()->withSuccess(trans('messages.word_or_sentence').' '.trans('messages.added'));	
	}

	public function updateTranslation(Request $request, $locale){
		$array_input = $request->all();

		if(!array_key_exists($locale,config('lang'))){
	        if($request->has('ajax_submit')){
	            $response = ['message' => trans('messages.invalid_link'), 'status' => 'error']; 
	            return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
	        }
			return redirect()->back()->withErrors(trans('messages.invalid_link'));
		}

		$translation = File::getRequire(base_path().'/resources/lang/'.$locale.'/messages.php');
		foreach($array_input as $key => $value)
			if($key != '_token' && $key != '_method' && $key != 'module' && $value != '' && $key != 'ajax_submit')
				$translation[$key] = $value;

		$filename = base_path().'/resources/lang/'.$locale.'/messages.php';
		File::put($filename,var_export($translation, true));
		File::prepend($filename,'<?php return ');
		File::append($filename, ';');

		$this->logActivity(['module' => 'language_translation','activity' => 'activity_updated']);

        if($request->has('ajax_submit')){
            $response = ['message' => trans('messages.language').' '.trans('messages.translation').' '.trans('messages.updated'), 'status' => 'success']; 
            return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
        }
		return redirect('/language/'.$locale.'#_'.$request->input('module'))->withSuccess(trans('messages.language').' '.trans('messages.translation').' '.trans('messages.updated'));	
	}

	public function destroy($locale,Request $request){

        $languages = config('lang');
		if(!array_key_exists($locale, $languages)){
	        if($request->has('ajax_submit')){
	            $response = ['message' => trans('messages.invalid_link'), 'status' => 'error']; 
	            return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
	        }
			return redirect()->back()->withErrors(trans('messages.invalid_link'));
		}

		if($locale == 'en'){
	        if($request->has('ajax_submit')){
	            $response = ['message' => trans('messages.cannot_delete_primary_language'), 'status' => 'error']; 
	            return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
	        }
			return redirect('/language')->withErrors(trans('messages.cannot_delete_primary_language'));
		}

		if(Session::get('lang') == $locale){
	        if($request->has('ajax_submit')){
	            $response = ['message' => trans('messages.cannot_delete_default_language'), 'status' => 'error']; 
	            return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
	        }
			return redirect('/language')->withErrors(trans('messages.cannot_delete_default_language'));
		}

		$result = File::deleteDirectory(base_path().'/resources/lang/'.$locale);
		unset($languages[$locale]);
		$filename = base_path().config('constant.path.lang');
		File::put($filename,var_export($languages, true));
		File::prepend($filename,'<?php return ');
		File::append($filename, ';');

		$this->logActivity(['module' => 'language','activity' => 'activity_deleted']);

        if($request->has('ajax_submit')){
            $response = ['message' => trans('messages.language').' '.trans('messages.deleted'), 'status' => 'success']; 
            return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
        }
		return redirect('/language')->withSuccess(trans('messages.language').' '.trans('messages.deleted'));
	}
}
?>