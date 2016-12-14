<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use File;
use Image;
use Swift_SmtpTransport;
use Swift_TransportException;

class ConfigurationController extends Controller
{
    use BasicController;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $languages = array();
        return view('configuration.index',compact('languages'));
    }

    public function store(Request $request){

        $validation = Validator::make($request->all(),[
            'company_name' => 'sometimes|required',
            'contact_person' => 'sometimes|required',
            'email' => 'sometimes|email|required',
            'country_id' => 'sometimes|required',
            'timezone_id' => 'sometimes|required',
            'application_name' => 'sometimes|required',
        ]);

        if($validation->fails()){
            if($request->has('ajax_submit')){
                $response = ['message' => $validation->messages()->first(), 'status' => 'error']; 
                return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
            }

            return redirect()->back()->withErrors($validation->messages()->first());
        }

        $input = $request->all();
        foreach($input as $key => $value){
            if(!in_array($key, config('constant.ignore_var'))){
                $config = \App\Config::firstOrNew(['name' => $key]);
                if($value != config('config.hidden_value'))
                $config->value = isset($value) ? $value : null;
                $config->save();
            }
        }

        $this->logActivity(['module' => 'configuration','activity' => 'activity_updated']);

        if($request->has('ajax_submit')){
            $response = ['message' => trans('messages.configuration').' '.trans('messages.updated'), 'status' => 'success']; 
            return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
        }
        return redirect('/configuration')->withSuccess(trans('messages.configuration').' '.trans('messages.updated'));  
    }

    public function mail(Request $request){

        $validation = Validator::make($request->all(),[
                'from_address' => 'required|email',
                'from_name' => 'required',
                'host' => 'required_if:driver,smtp',
                'port' => 'required_if:driver,smtp|numeric',
                'username' => 'required_if:driver,smtp',
                'password' => 'required_if:driver,smtp',
                'encryption' => 'in:ssl,tls|required_if:driver,smtp',
                'mailgun_host' => 'required_if:driver,mailgun',
                'mailgun_port' => 'required_if:driver,mailgun|numeric',
                'mailgun_username' => 'required_if:driver,mailgun',
                'mailgun_password' => 'required_if:driver,mailgun',
                'mailgun_domain' => 'required_if:driver,mailgun',
                'mailgun_secret' => 'required_if:driver,mailgun',
                'mandrill_secret' => 'required_if:driver,mandrill',
                ]);

        if($validation->fails()){
            if($request->has('ajax_submit')){
                $response = ['message' => $validation->messages()->first(), 'status' => 'error']; 
                return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
            }
            return redirect()->back()->withInput()->withErrors($validation->messages());
        }

        if($request->input('driver') == 'smtp'){
            $stmp = 0;
            try{
                    $transport = Swift_SmtpTransport::newInstance($request->input('host'), $request->input('port'), $request->input('encryption'));
                    $transport->setUsername($request->input('username'));
                    $transport->setPassword($request->input('password'));
                    $mailer = \Swift_Mailer::newInstance($transport);
                    $mailer->getTransport()->start();
                    $stmp =  1;
                } catch (Swift_TransportException $e) {
                    $stmp =  $e->getMessage();
                } 

            if($stmp != 1){
                if($request->has('ajax_submit')){
                    $response = ['message' => $stmp, 'status' => 'error']; 
                    return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
                }
                return redirect()->back()->withInput()->withErrors($stmp);
            }
        }
        $input = $request->all();
        foreach($input as $key => $value){
            if(!in_array($key, config('constant.ignore_var'))){
                $config = \App\Config::firstOrNew(['name' => $key]);
                if($value != config('config.hidden_value'))
                $config->value = $value;
                $config->save();
            }
        }
        $this->logActivity(['module' => 'mail_configuration','activity' => 'activity_updated']);

        if($request->has('ajax_submit')){
            $response = ['message' => trans('messages.mail').' '.trans('messages.configuration').' '.trans('messages.updated'), 'status' => 'success']; 
            return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
        }
        return redirect('/configuration#'.$config_type)->withSuccess(trans('messages.mail').' '.trans('messages.configuration').' '.trans('messages.updated'));         
    }

    public function sms(Request $request){

        $validation = Validator::make($request->all(),[
                'nextmo_api_key' => 'required',
                'nextmo_api_secret' => 'required',
                'nextmo_from_number' => 'required',
                ]);

        if($validation->fails()){
            if($request->has('ajax_submit')){
                $response = ['message' => $validation->messages()->first(), 'status' => 'error']; 
                return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
            }
            return redirect()->back()->withInput()->withErrors($validation->messages());
        }

        $input = $request->all();
        foreach($input as $key => $value){
            if(!in_array($key, config('constant.ignore_var'))){
                $config = \App\Config::firstOrNew(['name' => $key]);
                if($value != config('config.hidden_value'))
                $config->value = $value;
                $config->save();
            }
        }
        $this->logActivity(['module' => 'sms_configuration','activity' => 'activity_updated']);

        if($request->has('ajax_submit')){
            $response = ['message' => trans('messages.sms').' '.trans('messages.configuration').' '.trans('messages.updated'), 'status' => 'success']; 
            return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
        }
        return redirect('/configuration#'.$config_type)->withSuccess(trans('messages.sms').' '.trans('messages.configuration').' '.trans('messages.updated'));         
    }

    public function logo(Request $request){

        $validation = Validator::make($request->all(),[
            'logo' => 'image'
        ]);

        if($validation->fails()){
            if($request->has('ajax_submit')){
                $response = ['message' => $validation->messages()->first(), 'status' => 'error']; 
                return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
            }

            return redirect()->back()->withErrors($validation->messages()->first());
        }

        $filename = uniqid();
        $config = \App\Config::firstOrNew(['name' => 'logo']);

        if ($request->hasFile('logo') && $request->input('remove_logo') != 1){
            if(File::exists(config('constant.upload_path.logo').config('config.logo')))
                File::delete(config('constant.upload_path.logo').config('config.logo'));
            $extension = $request->file('logo')->getClientOriginalExtension();
            $file = $request->file('logo')->move(config('constant.upload_path.logo'), $filename.".".$extension);
            $img = Image::make(config('constant.upload_path.logo').$filename.".".$extension);
            $img->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save(config('constant.upload_path.logo').$filename.".".$extension);
            $config->value = $filename.".".$extension;
        } elseif($request->input('remove_logo') == 1){
            if(File::exists(config('constant.upload_path.logo').config('config.logo')))
                File::delete(config('constant.upload_path.logo').config('config.logo'));
            $config->value = null;
        }

        $config->save();

        $this->logActivity(['module' => 'logo','activity' => 'activity_updated']);

        if($request->has('ajax_submit')){
            $response = ['message' => trans('messages.configuration').' '.trans('messages.updated'), 'status' => 'success']; 
            return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
        }

        return redirect('/configuration')->withSuccess(trans('messages.configuration').' '.trans('messages.updated'));
    }
}
