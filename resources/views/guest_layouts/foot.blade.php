    <div id="js-var" style="visibility:none;" 
        data-toastr-position="{{config('config.notification_position')}}"
        data-something-error-message="{{trans('messages.something_error_message')}}"
        data-character-remaining="{{trans('messages.character_remaining')}}"
        data-textarea-limit="{{config('config.textarea_limit')}}"
        data-calendar-language="{!! config('lang.'.session('lang').'.calendar') !!}"
    ></div>

    {!! Html::script('assets/vendor/jquery/jquery.min.js') !!}
    {!! Html::script('assets/vendor/bootstrap/js/bootstrap.min.js') !!}
    {!! Html::script('assets/vendor/switch/bootstrap-switch.min.js') !!}
    {!! Html::script('assets/vendor/toastr/toastr.min.js') !!}
    @include('common.toastr_notification')
    {!! Html::script('assets/vendor/select2/select2.min.js') !!}
    {!! Html::script('assets/vendor/datepicker/js/bootstrap-datepicker.js') !!}
    @if(isset($assets) && in_array('form-wizard',$assets))
        {!! Html::script('assets/vendor/form-wizard/form-wizard.js') !!}
    @endif
    {!! Html::script('assets/vendor/icheck/icheck.min.js') !!}
    {!! Html::script('assets/vendor/password/password.js') !!}
    {!! Html::script('assets/js/textAvatar.js') !!}
    <script src='https://www.google.com/recaptcha/api.js'></script>
    {!! Html::script('assets/js/wmlab.js') !!}
</body>
</html>
