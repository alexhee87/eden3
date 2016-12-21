<div class="col-sm-6">
    <div class="form-group">
        {!! Form::label('application_name',trans('messages.application').' '.trans('messages.name'),[])!!}
        {!! Form::input('text','application_name',(config('config.application_name')) ? : '',['class'=>'form-control','placeholder'=>trans('messages.application').' '.trans('messages.name')])!!}
    </div>
    <div class="form-group">
        {!! Form::label('timezone_id',trans('messages.timezone'),[])!!}
        {!! Form::select('timezone_id', [null=>trans('messages.select_one')] + config('timezone'),(config('config.timezone_id')) ? : '',['class'=>'form-control tagsinput','placeholder'=>trans('messages.select_one'),'style' => 'width:100%;'])!!}
    </div>
    <div class="form-group">
        {!! Form::label('default_language',trans('messages.default').' '.trans('messages.language'),[])!!}
        {!! Form::select('default_language', $languages,(config('config.default_language')) ? : '',['class'=>'form-control tagsinput','placeholder'=>trans('messages.select_one'),'style' => 'width:100%;'])!!}
    </div>
    <div class="form-group">
        {!! Form::label('direction',trans('messages.direction'),[])!!}
        {!! Form::select('direction', [
        'ltr' => trans('messages.ltr'),
        'rtl' => trans('messages.rtl'),
        ],(config('config.direction')) ? : 'ltr',['class'=>'form-control tagsinput','placeholder'=>trans('messages.select_one'),'style' => 'width:100%;'])!!}
    </div>
    <div class="form-group">
        {!! Form::label('date_format','Date Format',[])!!}
        {!! Form::select('date_format', [
        'd-m-Y' => date('d-m-Y'),
        'm-d-Y' => date('m-d-Y'),
        'M-d-Y' => date('M-d-Y'),
        'd-M-Y' => date('d-M-Y'),
        ],(config('config.date_format')) ? : 'd-m-Y',['class'=>'form-control tagsinput','placeholder'=>trans('messages.select_one'),'style' => 'width:100%;'])!!}
    </div>
    <div class="form-group">
        {!! Form::label('time_format','Time Format',['class' => 'control-label '])!!}
        <div class="checkbox">
            <input name="time_format" type="checkbox" class="switch-input" data-size="mini" data-on-text="12 Hours" data-off-text="24 Hours" value="1" {{ (config('config.time_format') == 1) ? 'checked' : '' }} data-off-value="0">
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('allowed_upload_file',trans('messages.allowed_upload_file_type'),[])!!}
        {!! Form::input('text','allowed_upload_file',(config('config.allowed_upload_file')) ? : '',['class'=>'form-control','placeholder'=>trans('messages.allowed_upload_file_type'),'data-role' => 'tagsinput'])!!}
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        {!! Form::label('notification_position',trans('messages.notification_position'),[])!!}
        {!! Form::select('notification_position', [
        'toast-top-right'=>trans('messages.top_right'),
        'toast-top-left' => trans('messages.top_left'),
        'toast-bottom-right' => trans('messages.bottom_right'),
        'toast-bottom-left' => trans('messages.bottom_left')
        ],(config('config.notification_position')) ? : '',['class'=>'form-control tagsinput','placeholder'=>trans('messages.select_one'),'style' => 'width:100%;'])!!}
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('error_display',trans('messages.error').' '.trans('messages.display'),['class' => 'control-label '])!!}
                <div class="switch">
					<div class="onoffswitch">
						<input name="error_display" id="error_display" {{ (config('config.error_display') == '1') ? 'checked' : '' }} type="checkbox" class="onoffswitch-checkbox" value="1" data-off-value="0">
						<label class="onoffswitch-label" for="error_display">
							<span class="onoffswitch-inner"></span>
							<span class="onoffswitch-switch"></span>
						</label>
					</div>
				</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('multilingual',trans('messages.multilingual'),['class' => 'control-label '])!!}
                <div class="switch">
					<div class="onoffswitch">
						<input name="multilingual" id="multilingual" {{ (config('config.multilingual') == '1') ? 'checked' : '' }} type="checkbox" class="onoffswitch-checkbox" value="1" data-off-value="0">
						<label class="onoffswitch-label" for="multilingual">
							<span class="onoffswitch-inner"></span>
							<span class="onoffswitch-switch"></span>
						</label>
					</div>
				</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('enable_ip_filter',trans('messages.enable').' IP '.trans('messages.filter'),['class' => 'control-label '])!!}
                <div class="switch">
					<div class="onoffswitch">
						<input name="enable_ip_filter" id="enable_ip_filter" {{ (config('config.enable_ip_filter') == '1') ? 'checked' : '' }} type="checkbox" class="onoffswitch-checkbox" value="1" data-off-value="0">
						<label class="onoffswitch-label" for="enable_ip_filter">
							<span class="onoffswitch-inner"></span>
							<span class="onoffswitch-switch"></span>
						</label>
					</div>
				</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('enable_activity_log',trans('messages.enable').' '.trans('messages.activity').' ' .trans('messages.log'),['class' => 'control-label '])!!}
                <div class="switch">
					<div class="onoffswitch">
						<input name="enable_activity_log" id="enable_activity_log" {{ (config('config.enable_activity_log') == '1') ? 'checked' : '' }} type="checkbox" class="onoffswitch-checkbox" value="1" data-off-value="0">
						<label class="onoffswitch-label" for="enable_activity_log">
							<span class="onoffswitch-inner"></span>
							<span class="onoffswitch-switch"></span>
						</label>
					</div>
				</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('enable_email_template',trans('messages.enable').' '.trans('messages.email').' ' .trans('messages.template'),['class' => 'control-label '])!!}
                <div class="switch">
					<div class="onoffswitch">
						<input name="enable_email_template" id="enable_email_template" {{ (config('config.enable_email_template') == '1') ? 'checked' : '' }} type="checkbox" class="onoffswitch-checkbox" value="1" data-off-value="0">
						<label class="onoffswitch-label" for="enable_email_template">
							<span class="onoffswitch-inner"></span>
							<span class="onoffswitch-switch"></span>
						</label>
					</div>
				</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('enable_to_do',trans('messages.enable').' '.trans('messages.to_do'),['class' => 'control-label '])!!}
                <div class="switch">
					<div class="onoffswitch">
						<input name="enable_to_do" id="enable_to_do" {{ (config('config.enable_to_do') == '1') ? 'checked' : '' }} type="checkbox" class="onoffswitch-checkbox" value="1" data-off-value="0">
						<label class="onoffswitch-label" for="enable_user_registration">
							<span class="onoffswitch-inner"></span>
							<span class="onoffswitch-switch"></span>
						</label>
					</div>
				</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('enable_message',trans('messages.enable').' '.trans('messages.message'),['class' => 'control-label '])!!}
                <div class="switch">
					<div class="onoffswitch">
						<input name="enable_message" id="enable_message" {{ (config('config.enable_message') == '1') ? 'checked' : '' }} type="checkbox" class="onoffswitch-checkbox" value="1" data-off-value="0">
						<label class="onoffswitch-label" for="enable_message">
							<span class="onoffswitch-inner"></span>
							<span class="onoffswitch-switch"></span>
						</label>
					</div>
				</div>
            </div>
        </div>
        <div class="col-md-6">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('enable_backup',trans('messages.enable').' '.trans('messages.backup'),['class' => 'control-label '])!!}
                <div class="switch">
					<div class="onoffswitch">
						<input name="enable_backup" id="enable_backup" {{ (config('config.enable_backup') == '1') ? 'checked' : '' }} type="checkbox" class="onoffswitch-checkbox" value="1" data-off-value="0">
						<label class="onoffswitch-label" for="enable_backup">
							<span class="onoffswitch-inner"></span>
							<span class="onoffswitch-switch"></span>
						</label>
					</div>
				</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('enable_custom_field',trans('messages.enable').' '.trans('messages.custom').' '.trans('messages.field'),['class' => 'control-label '])!!}
                <div class="switch">
					<div class="onoffswitch">
						<input name="enable_custom_field" id="enable_custom_field" {{ (config('config.enable_custom_field') == '1') ? 'checked' : '' }} type="checkbox" class="onoffswitch-checkbox" value="1" data-off-value="0">
						<label class="onoffswitch-label" for="enable_custom_field">
							<span class="onoffswitch-inner"></span>
							<span class="onoffswitch-switch"></span>
						</label>
					</div>
				</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('enable_group_chat',trans('messages.enable').' '.trans('messages.group').' '.trans('messages.chat'),['class' => 'control-label '])!!}
                <div class="switch">
					<div class="onoffswitch">
						<input name="enable_group_chat" id="enable_group_chat" {{ (config('config.enable_group_chat') == '1') ? 'checked' : '' }} type="checkbox" class="onoffswitch-checkbox" value="1" data-off-value="0">
						<label class="onoffswitch-label" for="enable_group_chat">
							<span class="onoffswitch-inner"></span>
							<span class="onoffswitch-switch"></span>
						</label>
					</div>
				</div>
            </div>
            <div id="enable_group_chat_field">
                <div class="form-group">
                    {!! Form::label('enable_chat_refresh',trans('messages.enable').' '.trans('messages.chat').' Refresh',['class' => 'control-label '])!!}
                    <div class="switch">
                        <div class="onoffswitch">
                            <input name="enable_chat_refresh" id="enable_chat_refresh" {{ (config('config.enable_chat_refresh') == '1') ? 'checked' : '' }} type="checkbox" class="onoffswitch-checkbox" value="1" data-off-value="0">
                            <label class="onoffswitch-label" for="enable_chat_refresh">
                                <span class="onoffswitch-inner"></span>
                                <span class="onoffswitch-switch"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div id="enable_chat_refresh_field">
                <div class="form-group">
                    {!! Form::label('chat_refresh_duration',trans('messages.chat').' Refresh Duration (In Second)',[])!!}
                    {!! Form::input('text','chat_refresh_duration',(config('config.chat_refresh_duration')) ? : '',['class'=>'form-control','placeholder'=>trans('messages.chat').' Refresh Duration (In Second)'])!!}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('maintenance_mode',trans('messages.maintenance').' '.trans('messages.mode'),['class' => 'control-label '])!!}
                <div class="switch">
					<div class="onoffswitch">
						<input name="maintenance_mode" id="maintenance_mode" {{ (config('config.maintenance_mode') == '1') ? 'checked' : '' }} type="checkbox" class="onoffswitch-checkbox" value="1" data-off-value="0">
						<label class="onoffswitch-label" for="maintenance_mode">
							<span class="onoffswitch-inner"></span>
							<span class="onoffswitch-switch"></span>
						</label>
					</div>
				</div>
            </div>
            <div id="maintenance_mode_field">
                <div class="form-group">
                    {!! Form::label('under_maintenance_message',trans('messages.under_maintenance_message'),[])!!}
                    {!! Form::textarea('under_maintenance_message',config('config.under_maintenance_message'),['size' => '30x3', 'class' => 'form-control', 'placeholder' => trans('messages.under_maintenance_message'),"data-show-counter" => 1,'data-autoresize' => 1])!!}
                    <span class="countdown"></span>
                </div>
            </div>
        </div>
    </div>
    {!! Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary pull-right']) !!}
</div>
<div class="clear"></div>