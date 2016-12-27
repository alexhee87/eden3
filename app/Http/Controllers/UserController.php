<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\UserRequest;
use Validator;
use File;
use Image;
use Auth;
use Entrust;
use App\Notifications\ActivationToken;
use App\Notifications\UserStatusChange;

class UserController extends Controller
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

        if(!Entrust::can('manage-user'))
            return redirect('/home')->withErrors(trans('messages.permission_denied'));

        $col_heads = array(
                trans('messages.option'),
                trans('messages.email')
                );

        if(!config('config.login'))
            array_push($col_heads, trans('messages.username'));

        array_push($col_heads, trans('messages.name'));
        array_push($col_heads, trans('messages.role'));
        array_push($col_heads, trans('messages.status'));
        array_push($col_heads, trans('messages.signup').' '.trans('messages.date'));
        array_push($col_heads, trans('messages.last').' '.trans('messages.login').' '.trans('messages.date'));

        $table_data['user-table'] = array(
            'source' => 'user',
            'title' => 'User List',
            'id' => 'user_table',
            'data' => $col_heads
            );

        $assets = ['recaptcha'];
        return view('user.index',compact('table_data','assets'));
    }

    public function lists(Request $request){

        if(defaultRole())
            $users = User::all();
        else
            $users = User::whereIsHidden(0)->get();

        $rows = array();

        foreach($users as $user){
            $row = array(
                '<div class="btn-group btn-group-xs">'.
                '<a href="'.url('/user/'.$user->id).'" class="btn btn-xs btn-default"> <i class="fa fa-arrow-circle-o-right" data-toggle="tooltip" title="'.trans('messages.view').'"></i></a>'.
                (($user->status == 'active' && Entrust::can('change-user-status')) ? '<a href="#" class="btn btn-xs btn-default" data-ajax="1" data-extra="&user_id='.$user->id.'&status=ban" data-source="/change-user-status"> <i class="fa fa-ban" data-toggle="tooltip" title="'.trans('messages.ban').' '.trans('messages.user').'"></i></a>' : '').
                (($user->status == 'banned' && Entrust::can('change-user-status')) ? '<a href="#" class="btn btn-xs btn-default" data-ajax="1" data-extra="&user_id='.$user->id.'&status=active" data-source="/change-user-status"> <i class="fa fa-check" data-toggle="tooltip" title="'.trans('messages.active').' '.trans('messages.user').'"></i></a>' : '').
                (($user->status == 'pending_approval' && Entrust::can('change-user-status')) ? '<a href="#" class="btn btn-xs btn-default" data-ajax="1" data-extra="&user_id='.$user->id.'&status=approve" data-source="/change-user-status"> <i class="fa fa-check" data-toggle="tooltip" title="'.trans('messages.approve').' '.trans('messages.user').'"></i></a>' : '').
                (Entrust::can('delete-user') ? delete_form(['user.destroy',$user->id]) : '').
                '</div>',
                $user->email
                );

            $status = '';
            if($user->status == 'active')
                $status = '<span class="label label-success">'.trans('messages.active').'</span>';
            elseif($user->status == 'pending_activation')
                $status = '<span class="label label-warning">'.trans('messages.pending').' '.trans('messages.activation').'</span>';
            elseif($user->status == 'pending_approval')
                $status = '<span class="label label-info">'.trans('messages.pending').' '.trans('messages.approval').'</span>';
            elseif($user->status == 'banned')
                $status = '<span class="label label-danger">'.trans('messages.banned').'</span>';

            if(!config('config.login'))
                array_push($row,$user->username);

            array_push($row, $user->full_name);
            $user_role = '';
            foreach($user->Roles as $role)
                $user_role .= toWord($role->name).' <br />';

            array_push($row, $user_role);
            array_push($row,$status);
            array_push($row,showDate($user->created_at));
            array_push($row,showDateTime($user->last_login));

            $rows[] = $row;
        }
        $list['aaData'] = $rows;
        return json_encode($list);
    }

    public function changeStatus(Request $request){

        $user_id = $request->input('user_id');
        $status = $request->input('status');

        $user = \App\User::find($user_id);
        if(!$user)
            return redirect('/user')->withErrors(trans('messages.invalid_link'));

        if(!Entrust::can('change-user-status') || $user->hasRole(DEFAULT_ROLE)){
            if($request->has('ajax_submit')){
                $response = ['message' => trans('messages.permission_denied'), 'status' => 'error']; 
                return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
            }
            return redirect()->back()->withErrors(trans('messages.permission_denied'));
        }

        if($status == 'ban' && $user->status != 'active')
            return redirect('/user')->withErrors(trans('messages.invalid_link'));
        elseif($status == 'approve' && $user->status != 'pending_approval')
            return redirect('/user')->withErrors(trans('messages.invalid_link'));
        elseif($status == 'active' && $user->status != 'banned')
            return redirect('/user')->withErrors(trans('messages.invalid_link'));

        if($status == 'ban')
            $user->status = 'banned';
        elseif($status == 'approve' || $status == 'active')
            $user->status  = 'active';

        $user->save();
        $user->notify(new UserStatusChange($user));

        if($request->has('ajax_submit')){
            $response = ['message' => trans('messages.status').' '.trans('messages.updated'), 'status' => 'success']; 
            return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
        }
        return redirect()->back()->withSuccess(trans('messages.status').' '.trans('messages.updated'));
    }

    public function show(User $user){

        if(!Entrust::can('manage-user') || (!Entrust::hasRole(DEFAULT_ROLE) && $user->hasRole(DEFAULT_ROLE)) )
            return redirect('/home')->withErrors(trans('messages.permission_denied'));

        $roles = \App\Role::whereIsHidden(0)->get()->pluck('name','id')->all();
        $all_user_roles = $user->Roles;
        $user_roles = array();
        foreach($all_user_roles as $user_role)
            $user_roles[] = $user_role->id;

        $templates = \App\Template::whereIsDefault(0)->pluck('name','id')->all();
        $custom_social_field_values = getCustomFieldValues('user-social-form',$user->id);
        $custom_register_field_values = getCustomFieldValues('user-registration-form-form',$user->id);

        return view('user.show',compact('user','roles','user_roles','templates','custom_social_field_values','custom_register_field_values'));
    }

    public function changePassword(){
        return view('auth.change_password');
    }

    public function doChangePassword(Request $request){
        if(!getMode()){
            if($request->has('ajax_submit')){
                $response = ['message' => trans('messages.disable_message'), 'status' => 'error']; 
                return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
            }
            return redirect()->back()->withErrors(trans('messages.disable_message'));
        }

        $credentials = $request->only(
                'new_password', 'new_password_confirmation'
        );

        $validation = Validator::make($request->all(),[
            'old_password' => 'required|valid_password',
            'new_password' => 'required|confirmed|different:old_password|min:6',
            'new_password_confirmation' => 'required|different:old_password|same:new_password'
        ]);

        if($validation->fails()){
            if($request->has('ajax_submit')){
                $response = ['message' => $validation->messages()->first(), 'status' => 'error']; 
                return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
            }
            return redirect()->back()->withErrors($validation->messages()->first());
        }

        $user = \Auth::user();
        
        $user->password = bcrypt($credentials['new_password']);
        $user->save();
        if($request->has('ajax_submit')){
            $response = ['message' => trans('messages.password_changed'), 'status' => 'success']; 
            return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
        }
        
        return redirect()->back()->withErrors(trans('messages.password_changed'));
    }

    public function forceChangePassword($user_id,Request $request){
        if(!Entrust::can('reset-user-password'))
            return redirect('/home')->withErrors(trans('messages.permission_denied'));

        if($user_id == Auth::user()->id){
            if($request->has('ajax_submit')){
                $response = ['message' => trans('messages.invalid_link'), 'status' => 'error']; 
                return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
            }
            return redirect()->back()->withErrors(trans('messages.invalid_link'));
        }

        if(!getMode()){
            if($request->has('ajax_submit')){
                $response = ['message' => trans('messages.disable_message'), 'status' => 'error']; 
                return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
            }
            return redirect()->back()->withErrors(trans('messages.disable_message'));
        }

        $credentials = $request->only(
                'new_password', 'new_password_confirmation'
        );

        $validation = Validator::make($request->all(),[
            'new_password' => 'required|confirmed|min:6',
            'new_password_confirmation' => 'required|same:new_password'
        ]);

        if($validation->fails()){
            if($request->has('ajax_submit')){
                $response = ['message' => $validation->messages()->first(), 'status' => 'error']; 
                return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
            }
            return redirect()->back()->withErrors($validation->messages()->first());
        }

        $user = User::find($user_id);
        
        $user->password = bcrypt($credentials['new_password']);
        $user->save();
        if($request->has('ajax_submit')){
            $response = ['message' => trans('messages.password_changed'), 'status' => 'success']; 
            return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
        }
        
        return redirect()->back()->withErrors(trans('messages.password_changed'));
    }

    public function profileUpdate(Request $request, $id){

        $user = \App\User::find($id);
        
        if(!Entrust::can('update-user') || (!Entrust::hasRole(DEFAULT_ROLE) && $user->hasRole(DEFAULT_ROLE)) )
            return redirect('/home')->withErrors(trans('messages.permission_denied'));

        if(!$user)
            return redirect('/user')->withErrors(trans('messages.invalid_link'));

        $profile = $user->Profile;

        $profile->fill($request->all());

        $profile->date_of_birth = ($request->input('date_of_birth')) ? : null;
        $profile->save();

        if($request->has('username')){
            $user->username = $request->input('username');
            $user->save();
        }

        if($request->has('role_id') && !$user->hasRole(DEFAULT_ROLE)){
            $user->roles()->sync($request->input('role_id'));
        }

        if($request->has('ajax_submit')){
            $response = ['message' => trans('messages.profile').' '.trans('messages.updated'), 'status' => 'success']; 
            return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
        }
        return redirect()->back()->withSuccess(trans('messages.profile').' '.trans('messages.updated'));
    }

    public function socialUpdate(Request $request, $id){
        
        if(!Entrust::can('update-user') || (!Entrust::hasRole(DEFAULT_ROLE) && $user->hasRole(DEFAULT_ROLE)) )
            return redirect('/home')->withErrors(trans('messages.permission_denied'));

        $validation = validateCustomField('user-social-form',$request);

        if($validation->fails()){
            if($request->has('ajax_submit')){
                $response = ['message' => $validation->messages()->first(), 'status' => 'error']; 
                return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
            }
            return redirect()->back()->withInput()->withErrors($validation->messages());
        }

        $user = \App\User::find($id);

        if(!$user)
            return redirect('/user')->withErrors(trans('messages.invalid_link'));

        $profile = $user->Profile;

        $data = $request->all();
        $profile->fill($data);
        $profile->save();
        storeCustomField('user-social-form',$user->id, $data);

        if($request->has('ajax_submit')){
            $response = ['message' => trans('messages.profile').' '.trans('messages.updated'), 'status' => 'success']; 
            return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
        }
        return redirect()->back()->withSuccess(trans('messages.profile').' '.trans('messages.updated'));
    }

    public function customFieldUpdate(Request $request,$id){

        if(!Entrust::can('update-user') || (!Entrust::hasRole(DEFAULT_ROLE) && $user->hasRole(DEFAULT_ROLE)) )
            return redirect('/home')->withErrors(trans('messages.permission_denied'));

        $validation = validateCustomField('user-registration-form',$request);

        if($validation->fails()){
            if($request->has('ajax_submit')){
                $response = ['message' => $validation->messages()->first(), 'status' => 'error']; 
                return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
            }
            return redirect()->back()->withInput()->withErrors($validation->messages());
        }

        $user = \App\User::find($id);

        if(!$user)
            return redirect('/user')->withErrors(trans('messages.invalid_link'));

        $data = $request->all();
        storeCustomField('user-registration-form',$user->id, $data);

        if($request->has('ajax_submit')){
            $response = ['message' => trans('messages.custom').' '.trans('messages.field').' '.trans('messages.updated'), 'status' => 'success']; 
            return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
        }
        return redirect()->back()->withSuccess(trans('messages.custom').' '.trans('messages.field').' '.trans('messages.updated'));
    }

    public function avatar(Request $request, $id){

        if(!Entrust::can('update-user') || (!Entrust::hasRole(DEFAULT_ROLE) && $user->hasRole(DEFAULT_ROLE)) )
            return redirect('/home')->withErrors(trans('messages.permission_denied'));

        $user = \App\User::find($id);

        if(!$user)
            return redirect('/user')->withErrors(trans('messages.invalid_link'));

        $profile = $user->Profile;

        $validation = Validator::make($request->all(),[
            'avatar' => 'image'
        ]);

        if($validation->fails()){
            if($request->has('ajax_submit')){
                $response = ['message' => $validation->messages()->first(), 'status' => 'error']; 
                return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
            }

            return redirect()->back()->withErrors($validation->messages()->first());
        }

        $filename = uniqid();

        if ($request->hasFile('avatar') && $request->input('remove_avatar') != 1){
            if(File::exists(config('constant.upload_path.avatar').config('config.avatar')))
                File::delete(config('constant.upload_path.avatar').config('config.avatar'));
            $extension = $request->file('avatar')->getClientOriginalExtension();
            $file = $request->file('avatar')->move(config('constant.upload_path.avatar'), $filename.".".$extension);
            $img = Image::make(config('constant.upload_path.avatar').$filename.".".$extension);
            $img->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save(config('constant.upload_path.avatar').$filename.".".$extension);
            $profile->avatar = $filename.".".$extension;
        } elseif($request->input('remove_avatar') == 1){
            if(File::exists(config('constant.upload_path.avatar').config('config.avatar')))
                File::delete(config('constant.upload_path.avatar').config('config.avatar'));
            $profile->avatar = null;
        }

        $profile->save();

        $this->logActivity(['module' => 'profile','activity' => 'activity_updated']);

        if($request->has('ajax_submit')){
            $response = ['message' => trans('messages.profile').' '.trans('messages.updated'), 'status' => 'success']; 
            return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
        }
        return redirect()->back()->withSuccess(trans('messages.profile').' '.trans('messages.updated'));
    }

    public function create(){
        if(!Entrust::can('create-user'))
            return redirect('/home')->withErrors(trans('messages.permission_denied'));
            
        return view('user.create');
    }

    public function store(UserRequest $request, User $user){

        if(Auth::check() && !Entrust::can('create-user'))
            return redirect('/home')->withErrors(trans('messages.permission_denied'));

        if($request->has('g-recaptcha-response')){
            $url = "https://www.google.com/recaptcha/api/siteverify";
            $postData = array(
                'secret' => config('config.recaptcha_secret'),
                'response' => $request->input('g-recaptcha-response'),
                'remoteip' => $request->getClientIp()
            );
            $gresponse = postCurl($url,$postData);

            if(!$gresponse['success']){
                if($request->has('ajax_submit')){
                    $response = ['message' => 'Please verify the captcha again!', 'status' => 'error']; 
                    return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
                }
                return redirect()->back()->withInput()->withErrors('Please verify the captcha again!');
            }
        }

        $validation = validateCustomField('user-registration-form',$request);

        if($validation->fails()){
            if($request->has('ajax_submit')){
                $response = ['message' => $validation->messages()->first(), 'status' => 'error']; 
                return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
            }
            return redirect()->back()->withInput()->withErrors($validation->messages());
        }

        $user->email = $request->input('email');
        $user->username = (config('config.login')) ? null : $request->input('username');
        $user->password = bcrypt($request->input('password'));
        
        if(Auth::check())
            $user->status = 'active';
        elseif(config('config.enable_email_verification')){
            $user->status = 'pending_activation';
            $user->activation_token = randomString('30','token');
            $user->notify(new ActivationToken($user));
        } elseif(config('config.enable_admin_approval'))
            $user->status = 'pending_approval';
        else
            $user->status = 'active';

        $user->save();

        $role = \App\Role::whereDefaultUserRole(1)->first();
        $user->roles()->sync(($request->input('role')) ? : (isset($role) ? [$role->id] : []));

        $profile = new \App\Profile;
        $profile->user()->associate($user);
        $profile->first_name = $request->input('first_name');
        $profile->last_name = $request->input('last_name');
        $profile->save();
        
        if($request->has('send_welcome_email')){
            $template = \App\Template::whereCategory('welcome_email')->first();
            $body = isset($template->body) ? $template->body : 'Hello [NAME], Welcome to '.config('config.application_name');
            $body = str_replace('[NAME]',$user->full_name,$body); 
            $body = str_replace('[PASSWORD]',$request->input('password'),$body);
            if(!config('config.login'))
            $body = str_replace('[USERNAME]',$user->username,$body);
            $body = str_replace('[EMAIL]',$user->email,$body);

            $mail['email'] = $user->email;
            $mail['subject'] = $template->subject;

            \Mail::send('emails.email', compact('body'), function($message) use ($mail){
                $message->to($mail['email'])->subject($mail['subject']);
            });
            $this->logEmail(array('to' => $mail['email'],'subject' => $mail['subject'],'body' => $body));
        }

        $data = $request->all();
        storeCustomField('user-registration-form',$user->id, $data);

        if($request->has('ajax_submit')){
            $response = ['message' => trans('messages.user').' '.trans('messages.added'), 'status' => 'success']; 
            return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
        }
        return redirect()->back()->withSuccess(trans('messages.user').' '.trans('messages.added'));    
    }

    public function resendActivation(Request $request)
    {
        if(!config('config.enable_email_verification'))
            return redirect('/');

        return view('auth.resend_activation');
    }

    public function postResendActivation(Request $request){
        if(!config('config.enable_email_verification'))
            return redirect('/');
        
        $user = \App\User::whereEmail($request->input('email'))->first();

        if(!$user){
            if($request->has('ajax_submit')){
                $response = ['message' => trans('messages.no_user_with_email'), 'status' => 'error']; 
                return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
            }
            return redirect()->back()->withErrors(trans('messages.no_user_with_email'));
        } elseif($user->status != 'pending_activation'){
            if($request->has('ajax_submit')){
                $response = ['message' => trans('messages.invalid_link'), 'status' => 'error']; 
                return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
            }
            return redirect()->back()->withErrors(trans('messages.invalid_link'));
        }

        $user->notify(new ActivationToken($user));

        if($request->has('ajax_submit')){
            $response = ['message' => trans('messages.activation_email_sent'), 'status' => 'success']; 
            return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
        }
        return redirect('/')->withSuccess(trans('messages.activation_email_sent'));
    }

    public function activateAccount($token = null){

        if(!config('config.enable_email_verification'))
            return redirect('/');
        
        if($token == null)
            return redirect('/');

        $user = \App\User::whereActivationToken($token)->first();

        if(!$user)
            return redirect('/')->withErrors(trans('messages.invalid_link'));

        if($user->status != 'pending_activation')
            return redirect('/')->withErrors(trans('messages.invalid_link'));

        $user->status = (config('config.enable_admin_approval')) ? 'pending_approval' : 'active';
        $user->save();
        return redirect('/')->withSuccess(trans('messages.account_activated'));
    }

    public function email(Request $request, $id){

        if(!Entrust::can('email-user') || (!Entrust::hasRole(DEFAULT_ROLE) && $user->hasRole(DEFAULT_ROLE)) )
            return redirect('/home')->withErrors(trans('messages.permission_denied'));

        $validation = Validator::make($request->all(),[
            'subject' => 'required',
            'body' => 'required'
        ]);

        if($validation->fails()){
            if($request->has('ajax_submit')){
                $response = ['message' => $validation->messages()->first(), 'status' => 'error']; 
                return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
            }
            return redirect()->back()->withErrors($validation->messages()->first());
        }

        $user = User::find($id);
        $mail['email'] = $user->email;
        $mail['subject'] = $request->input('subject');
        $body = $request->input('body');

        \Mail::send('emails.email', compact('body'), function($message) use ($mail){
            $message->to($mail['email'])->subject($mail['subject']);
        });
        $this->logEmail(array('to' => $mail['email'],'subject' => $mail['subject'],'body' => $body));

        $this->logActivity(['module' => 'employee','unique_id' => $user->id,'activity' => 'activity_mail_sent']);
        if($request->has('ajax_submit')){
            $response = ['message' => trans('messages.mail').' '.trans('messages.sent'), 'status' => 'success']; 
            return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
        }
        return redirect()->back()->withSuccess(trans('messages.mail').' '.trans('messages.sent'));
    }

    public function destroy(User $user, Request $request){

        if(!Entrust::can('delete-user') || (!Entrust::hasRole(DEFAULT_ROLE) && $user->hasRole(DEFAULT_ROLE)) )
            return redirect('/home')->withErrors(trans('messages.permission_denied'));

        if($user->is_hidden){
            if($request->has('ajax_submit')){
                $response = ['message' => trans('messages.permission_denied'), 'status' => 'error']; 
                return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
            }
          return redirect('/home')->withErrors(trans('messages.permission_denied'));
        }

        if($user->id == \Auth::user()->id){
            if($request->has('ajax_submit')){
                $response = ['message' => trans('messages.permission_denied'), 'status' => 'error']; 
                return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
            }
            return redirect('/user')->withErrors(trans('message.unable_to_delete_yourself'));
        }

        deleteCustomField('user-registration-form', $user->id);
        $this->logActivity(['module' => 'user','unique_id' => $user->id,'activity' => 'activity_deleted']);

        $user->delete();
        if($request->has('ajax_submit')){
            $response = ['message' => trans('messages.user').' '.trans('messages.deleted'), 'status' => 'success']; 
            return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
        }
        return redirect('/user')->withSuccess(trans('messages.user').' '.trans('messages.deleted'));
    }

    public function verifySecurity(){
        if(config('config.enable_two_factor_auth') && session('two_factor_auth'))
            return view('auth.verify_security');
        else
            return redirect('/home');
    }

    public function postVerifySecurity(Request $request){

        if(!config('config.enable_two_factor_auth') || !session('two_factor_auth') || !Auth::check())
            return redirect('/home');

        $two_factor_auth = $request->input('two_factor_auth');

        if($two_factor_auth == '' || $two_factor_auth != session('two_factor_auth'))
            return redirect('/verify-security')->withErrors(trans('messages.invalid_two_factor_auth_code'));

        if($two_factor_auth == session('two_factor_auth')){
            session()->forget('two_factor_auth');
            return redirect('/home');
        }
    }
}
