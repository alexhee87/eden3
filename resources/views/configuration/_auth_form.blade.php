	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('session_lifetime',trans('messages.session').' '.trans('messages.lifetime').' (In Min)',[])!!}
				{!! Form::input('text','session_lifetime',(config('config.session_lifetime')) ? : '',['class'=>'form-control','placeholder'=>trans('messages.session').' '.trans('messages.lifetime')])!!}
			</div>
			<div class="form-group">
				{!! Form::label('reset_token_lifetime',trans('messages.reset').' '.trans('messages.token').' '.trans('messages.lifetime').' (In Min)',[])!!}
				{!! Form::input('text','reset_token_lifetime',(config('config.reset_token_lifetime')) ? : '',['class'=>'form-control','placeholder'=>trans('messages.reset').' '.trans('messages.token').' '.trans('messages.lifetime')])!!}
			</div>
			<div class="form-group">
				{!! Form::label('enable_two_factor_auth',trans('messages.enable').' Two factor Auth',['class' => 'control-label '])!!}
				<div class="switch">
					<div class="onoffswitch">
						<input name="enable_two_factor_auth" id="enable_two_factor_auth" {{ (config('config.enable_two_factor_auth') == '1') ? 'checked' : '' }} type="checkbox" class="onoffswitch-checkbox" value="1" data-off-value="0">
						<label class="onoffswitch-label" for="enable_two_factor_auth">
							<span class="onoffswitch-inner"></span>
							<span class="onoffswitch-switch"></span>
						</label>
					</div>
				</div>
			</div>
			<div id="enable_two_factor_auth_field">
				<div class="form-group">
					{!! Form::label('two_factor_auth_type','Two factor Auth Type',['class' => 'control-label '])!!}
				</div>
                <div class="col-sm-10">
                    <div class="i-checks"><label> <input type="radio" {{ (config('config.two_factor_auth_type') != '1') ? 'checked' : '' }} value="0" name="two_factor_auth_type"><i></i> SMS </label></div>
                    <div class="i-checks"><label> <input type="radio" {{ (config('config.two_factor_auth_type') == '1') ? 'checked' : '' }} value="1" name="two_factor_auth_type"> <i></i> Email</label></div>
                </div>
			</div>
			<div class="form-group">
				{!! Form::label('enable_lock_screen',trans('messages.enable').' '.trans('messages.lock_screen'),['class' => 'control-label '])!!}
				<div class="switch">
					<div class="onoffswitch">
						<input name="enable_lock_screen" id="enable_lock_screen" {{ (config('config.enable_lock_screen') == '1') ? 'checked' : '' }} type="checkbox" class="onoffswitch-checkbox" value="1" data-off-value="0">
						<label class="onoffswitch-label" for="enable_lock_screen">
							<span class="onoffswitch-inner"></span>
							<span class="onoffswitch-switch"></span>
						</label>
					</div>
				</div>
			</div>
			<div id="enable_lock_screen_field">
				<div class="form-group">
					{!! Form::label('lock_screen_timeout',trans('messages.lock_screen').' '.trans('messages.timeout').' (In Min)',[])!!}
					{!! Form::input('text','lock_screen_timeout',(config('config.lock_screen_timeout')) ? : '',['class'=>'form-control','placeholder'=>trans('messages.lock_screen').' '.trans('messages.timeout')])!!}
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('enable_throttle',trans('messages.enable').' Throttle',['class' => 'control-label '])!!}
				<div class="switch">
					<div class="onoffswitch">
						<input name="enable_throttle" id="enable_throttle" {{ (config('config.enable_throttle') == '1') ? 'checked' : '' }} type="checkbox" class="onoffswitch-checkbox" value="1" data-off-value="0">
						<label class="onoffswitch-label" for="enable_throttle">
							<span class="onoffswitch-inner"></span>
							<span class="onoffswitch-switch"></span>
						</label>
					</div>
				</div>
			</div>
			<div id="enable_throttle_field">
				<div class="form-group">
					{!! Form::label('throttle_attempt','Throttle Attempt',[])!!}
					{!! Form::input('text','throttle_attempt',(config('config.throttle_attempt')) ? : '',['class'=>'form-control','placeholder'=>'Throttle Attempt'])!!}
				</div>
				<div class="form-group">
					{!! Form::label('throttle_lockout_period','Throttle Lockout Period (In Min)',[])!!}
					{!! Form::input('text','throttle_lockout_period',(config('config.throttle_lockout_period')) ? : '',['class'=>'form-control','placeholder'=>'Throttle Lockout Period'])!!}
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('login',trans('messages.login').' '.trans('messages.with'),['class' => 'control-label '])!!}
                <div class="col-sm-10">
                    <div class="i-checks"><label> <input type="radio" {{ (config('config.login') != '1') ? 'checked' : '' }} value="0" name="login"><i></i> Username </label></div>
                    <div class="i-checks"><label> <input type="radio" {{ (config('config.login') == '1') ? 'checked' : '' }} value="1" name="login"> <i></i> Email</label></div>
                </div>
			</div>
			<div class="form-group">
				{!! Form::label('enable_user_registration',trans('messages.enable').' '.trans('messages.user').' '.trans('messages.registration'),['class' => 'control-label '])!!}
				<div class="switch">
					<div class="onoffswitch">
						<input name="enable_user_registration" id="enable_user_registration" {{ (config('config.enable_user_registration') == '1') ? 'checked' : '' }} type="checkbox" class="onoffswitch-checkbox" value="1" data-off-value="0">
						<label class="onoffswitch-label" for="enable_user_registration">
							<span class="onoffswitch-inner"></span>
							<span class="onoffswitch-switch"></span>
						</label>
					</div>
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('enable_password_strength_meter',trans('messages.enable').' '.trans('messages.password_strength_meter'),['class' => 'control-label '])!!}
				<div class="switch">
					<div class="onoffswitch">
						<input name="enable_password_strength_meter" id="enable_password_strength_meter" {{ (config('config.enable_password_strength_meter') == '1') ? 'checked' : '' }} type="checkbox" class="onoffswitch-checkbox" value="1" data-off-value="0">
						<label class="onoffswitch-label" for="enable_password_strength_meter">
							<span class="onoffswitch-inner"></span>
							<span class="onoffswitch-switch"></span>
						</label>
					</div>
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('enable_email_verification',trans('messages.enable').' '.trans('messages.email').' '.trans('messages.verification'),['class' => 'control-label '])!!}
				<div class="switch">
					<div class="onoffswitch">
						<input name="enable_email_verification" id="enable_email_verification" {{ (config('config.enable_email_verification') == '1') ? 'checked' : '' }} type="checkbox" class="onoffswitch-checkbox" value="1" data-off-value="0">
						<label class="onoffswitch-label" for="enable_email_verification">
							<span class="onoffswitch-inner"></span>
							<span class="onoffswitch-switch"></span>
						</label>
					</div>
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('enable_admin_approval',trans('messages.enable').' '.trans('messages.admin').' '.trans('messages.approval'),['class' => 'control-label '])!!}
				<div class="switch">
					<div class="onoffswitch">
						<input name="enable_admin_approval" id="enable_admin_approval" {{ (config('config.enable_admin_approval') == '1') ? 'checked' : '' }} type="checkbox" class="onoffswitch-checkbox" value="1" data-off-value="0">
						<label class="onoffswitch-label" for="enable_admin_approval">
							<span class="onoffswitch-inner"></span>
							<span class="onoffswitch-switch"></span>
						</label>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('enable_tnc',trans('messages.enable').' '.trans('messages.tnc'),['class' => 'control-label '])!!}
				<div class="switch">
					<div class="onoffswitch">
						<input name="enable_tnc" id="enable_tnc" {{ (config('config.enable_tnc') == '1') ? 'checked' : '' }} type="checkbox" class="onoffswitch-checkbox" value="1" data-off-value="0">
						<label class="onoffswitch-label" for="enable_tnc">
							<span class="onoffswitch-inner"></span>
							<span class="onoffswitch-switch"></span>
						</label>
					</div>
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('enable_remember_me',trans('messages.enable').' '.trans('messages.remember_me'),['class' => 'control-label '])!!}
				<div class="switch">
					<div class="onoffswitch">
						<input name="enable_remember_me" id="enable_remember_me" {{ (config('config.enable_remember_me') == '1') ? 'checked' : '' }} type="checkbox" class="onoffswitch-checkbox" value="1" data-off-value="0">
						<label class="onoffswitch-label" for="enable_remember_me">
							<span class="onoffswitch-inner"></span>
							<span class="onoffswitch-switch"></span>
						</label>
					</div>
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('enable_forgot_password',trans('messages.enable').' '.trans('messages.forgot').' '.trans('messages.password'),['class' => 'control-label '])!!}
				<div class="switch">
					<div class="onoffswitch">
						<input name="enable_forgot_password" id="enable_forgot_password" {{ (config('config.enable_forgot_password') == '1') ? 'checked' : '' }} type="checkbox" class="onoffswitch-checkbox" value="1" data-off-value="0">
						<label class="onoffswitch-label" for="enable_forgot_password">
							<span class="onoffswitch-inner"></span>
							<span class="onoffswitch-switch"></span>
						</label>
					</div>
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('session_expire_browser_close','Session Expire on Browser Close',['class' => 'control-label '])!!}
				<div class="switch">
					<div class="onoffswitch">
						<input name="session_expire_browser_close" id="session_expire_browser_close" {{ (config('config.session_expire_browser_close') == '1') ? 'checked' : '' }} type="checkbox" class="onoffswitch-checkbox" value="1" data-off-value="0">
						<label class="onoffswitch-label" for="session_expire_browser_close">
							<span class="onoffswitch-inner"></span>
							<span class="onoffswitch-switch"></span>
						</label>
					</div>
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('enable_recaptcha',trans('messages.enable').' Recaptcha',['class' => 'control-label '])!!}
				<div class="switch">
					<div class="onoffswitch">
						<input name="enable_recaptcha" id="enable_recaptcha" {{ (config('config.enable_recaptcha') == '1') ? 'checked' : '' }} type="checkbox" class="onoffswitch-checkbox" value="1" data-off-value="0">
						<label class="onoffswitch-label" for="enable_recaptcha">
							<span class="onoffswitch-inner"></span>
							<span class="onoffswitch-switch"></span>
						</label>
					</div>
				</div>
			</div>
			<div id="enable_recaptcha_field">
				<div class="form-group">
					{!! Form::label('recaptcha_key','Recaptcha Key',[])!!}
					{!! Form::input('text','recaptcha_key',(config('config.recaptcha_key')) ? config('config.hidden_value') : '',['class'=>'form-control','placeholder'=>'Recaptcha Key'])!!}
				</div>
				<div class="form-group">
					{!! Form::label('recaptcha_secret','Recaptcha Secret',[])!!}
					{!! Form::input('text','recaptcha_secret',(config('config.recaptcha_secret')) ? config('config.hidden_value') : '',['class'=>'form-control','placeholder'=>'Recaptcha Secret'])!!}
				</div>
			</div>
		</div>
	</div>
	<div class="form-group">
		{!! Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary pull-right']) !!}
	</div>