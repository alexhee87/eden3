<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Entrust;
use App\Classes\Helper;
use App\Backup;
use File;

Class BackupController extends Controller{
    use BasicController;

	public function __construct()
	{
		$this->middleware('feature_available:enable_backup');
	}

	public function index(){

		$table_data['backup-table'] = array(
			'source' => 'backup',
			'title' => 'Backup Log',
			'id' => 'backup_table',
			'data' => array(
        		trans('messages.option'),
        		trans('messages.file'),
        		trans('messages.date')
        		)
			);

		return view('backup_log.index',compact('table_data'));
	}

	public function lists(Request $request){
		$backups = Backup::all();
        $rows = array();

        foreach($backups as $backup){

			$rows[] = array(
				'<div class="btn-group btn-group-xs center-block">'.
				'<a href="/backup/'.$backup->id.'" class="btn btn-xs btn-default" > <i class="fa fa-download" data-toggle="tooltip" title="'.trans('messages.download').'"></i></a>'.
				delete_form(['backup.destroy',$backup->id]).
				'</div>',
				$backup->file,
				showDateTime($backup->created_at)
				);
        }
        $list['aaData'] = $rows;
        return json_encode($list);
	}

	public function store(Request $request){
		if($request->has('delete_old_backup')){
			Backup::truncate();
			File::cleanDirectory(config('constant.upload_path.backup'));
		}

        include('../app/Classes/Dumper.php');
        $data = backupDatabase();

        if($data['status'] == 'error')
            return response()->json(['status' => 'error','message' => $data],200,array('Access-Controll-Allow-Origin' => '*'));

        $filename = $data['filename'];
        if(!File::exists(config('constant.upload_path.backup')))
        File::makeDirectory(config('constant.upload_path.backup'));

        File::move($filename, config('constant.upload_path.backup').$filename);
        $backup = \App\Backup::create(['file' => $filename]);

		$this->logActivity(['module' => 'backup','unique_id' => $backup->id,'activity' => 'activity_generated']);
        $response = ['message' => trans('messages.backup').' '.trans('messages.generated'), 'status' => 'success']; 
        return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
	}

	public function show(Backup $backup){
		$file = config('constant.upload_path.backup').$backup->file;

        if(!config('code.mode'))
			return redirect()->back()->withErrors(trans('messages.disable_message'));

		if(File::exists($file))
			return response()->download($file);
		else
			return redirect()->back()->withErrors(trans('messages.file_not_found'));
	}


	public function destroy(Backup $backup,Request $request){

		$this->logActivity(['module' => 'backup','unique_id' => $backup->id,'activity' => 'activity_deleted']);

		if(File::exists(config('constant.upload_path.backup').$backup->file))
			File::delete(config('constant.upload_path.backup').$backup->file);
        $backup->delete();
        
        if($request->has('ajax_submit')){
            $response = ['message' => trans('messages.backup').' '.trans('messages.deleted'), 'status' => 'success']; 
            return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
        }

        return redirect('/backup')->withSuccess(trans('messages.backup').' '.trans('messages.deleted'));
	}
}
?>