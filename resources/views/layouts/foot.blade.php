    <div id="js-var" style="visibility:none;" 
        data-toastr-position="{{config('config.notification_position')}}"
        data-something-error-message="{{trans('messages.something_error_message')}}"
        data-character-remaining="{{trans('messages.character_remaining')}}"
        data-textarea-limit="{{config('config.textarea_limit')}}"
        data-calendar-language="{!! $calendar_language !!}" 
        data-datatable-language="//cdn.datatables.net/plug-ins/1.10.9/i18n/{!! config('lang.'.$default_language.'.datatable') !!}.json" 
    ></div>

    <!-- Main scripts -->
    {!! Html::script('assets/custom/js/jquery-2.1.1.js') !!}
    {!! Html::script('assets/custom/js/bootstrap.min.js') !!}
    {!! Html::script('assets/custom/js/plugins/metisMenu/jquery.metisMenu.js') !!}
    {!! Html::script('assets/custom/js/plugins/slimscroll/jquery.slimscroll.min.js') !!}

    <!-- Datatables -->
    {!! Html::script('assets/vendor/datatables/datatables.min.js') !!}

    <!-- bootstrap switch -->
    {!! Html::script('assets/vendor/switch/bootstrap-switch.min.js') !!}

    {!! Html::script('assets/vendor/password/password.js') !!}
    {!! Html::script('assets/vendor/select2/select2.min.js') !!}
    {!! Html::script('assets/js/textAvatar.js') !!}

    <!-- Custom and plugin javascript -->
    {!! Html::script('assets/custom/js/inspinia.js') !!}
    {!! Html::script('assets/custom/js/plugins/pace/pace.min.js') !!}

    <!-- iCheck -->
    {!! Html::script('assets/custom/js/plugins/iCheck/icheck.min.js') !!}

     <!-- Tags Input -->
    {!! Html::script('assets/custom/js/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') !!}

    <!-- sweet alert -->
    {!! Html::script('assets/custom/js/plugins/sweetalert/sweetalert.min.js') !!}

    <!-- toastr -->
    {!! Html::script('assets/custom/js/plugins/toastr/toastr.min.js') !!}

    <!-- summer note -->
    {!! Html::script('assets/custom/js/plugins/summernote/summernote.min.js') !!}

    <!-- data picker -->
    {!! Html::script('assets/custom/js/plugins/datapicker/bootstrap-datepicker.js') !!}

    <!-- file fileinput-->
    {!! Html::script('assets/vendor/fileinput/fileinput.min.js') !!}

    <!-- Chosen -->
    {!! Html::script('assets/custom/js/plugins/chosen/chosen.jquery.js') !!}

    {!! Html::script('assets/js/bootbox.js') !!}


    <script>
        $(document).ready(function () {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script>
    @include('common.toastr_notification')

    @if(in_array('calendar',$assets))
        {!! Html::script('assets/vendor/calendar/moment.min.js') !!}
        {!! Html::script('assets/custom/js/plugins/fullcalendar/fullcalendar.min.js') !!}
    @endif
    @if(in_array('recaptcha',$assets))
        <script src='https://www.google.com/recaptcha/api.js'></script>
    @endif
    <script>
    $.ajaxSetup({
       headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
    });

        var calendar_events = {!! (isset($events)) ? json_encode($events) : '""' !!};

        var appPath = "{{env('SUBFOLDER_PATH','')}}";
        var currentUserId = "{{Auth::user()->id}}";
        var pusherID = "{{env('PUSHER_KEY')}}";
    </script>
    <script src="https://js.pusher.com/3.2/pusher.min.js"></script>
    {!! Html::script('assets/js/wmlab.js') !!}
    @yield('javascript')



</body>
</html>