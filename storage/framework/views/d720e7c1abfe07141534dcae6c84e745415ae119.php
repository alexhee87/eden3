    <div id="js-var" style="visibility:none;" 
        data-toastr-position="<?php echo e(config('config.notification_position')); ?>"
        data-something-error-message="<?php echo e(trans('messages.something_error_message')); ?>"
        data-character-remaining="<?php echo e(trans('messages.character_remaining')); ?>"
        data-textarea-limit="<?php echo e(config('config.textarea_limit')); ?>"
        data-calendar-language="<?php echo $calendar_language; ?>" 
        data-datatable-language="//cdn.datatables.net/plug-ins/1.10.9/i18n/<?php echo config('lang.'.$default_language.'.datatable'); ?>.json" 
    ></div>

    <!-- Main scripts -->
    <?php echo Html::script('assets/custom/js/jquery-2.1.1.js'); ?>

    <?php echo Html::script('assets/custom/js/bootstrap.min.js'); ?>

    <?php echo Html::script('assets/custom/js/plugins/metisMenu/jquery.metisMenu.js'); ?>

    <?php echo Html::script('assets/custom/js/plugins/slimscroll/jquery.slimscroll.min.js'); ?>


    <!-- Datatables -->
    <?php echo Html::script('assets/vendor/datatables/datatables.min.js'); ?>


    <!-- bootstrap switch -->
    <?php echo Html::script('assets/vendor/switch/bootstrap-switch.min.js'); ?>


    <?php echo Html::script('assets/vendor/password/password.js'); ?>

    <?php echo Html::script('assets/vendor/select2/select2.min.js'); ?>

    <?php echo Html::script('assets/js/textAvatar.js'); ?>


    <!-- Custom and plugin javascript -->
    <?php echo Html::script('assets/custom/js/inspinia.js'); ?>

    <?php echo Html::script('assets/custom/js/plugins/pace/pace.min.js'); ?>


    <!-- iCheck -->
    <?php echo Html::script('assets/custom/js/plugins/iCheck/icheck.min.js'); ?>


     <!-- Tags Input -->
    <?php echo Html::script('assets/custom/js/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js'); ?>


    <!-- sweet alert -->
    <?php echo Html::script('assets/custom/js/plugins/sweetalert/sweetalert.min.js'); ?>


    <!-- toastr -->
    <?php echo Html::script('assets/custom/js/plugins/toastr/toastr.min.js'); ?>


    <!-- summer note -->
    <?php echo Html::script('assets/custom/js/plugins/summernote/summernote.min.js'); ?>


    <!-- data picker -->
    <?php echo Html::script('assets/custom/js/plugins/datapicker/bootstrap-datepicker.js'); ?>


    <!-- file fileinput-->
    <?php echo Html::script('assets/vendor/fileinput/fileinput.min.js'); ?>


    <!-- Chosen -->
    <?php echo Html::script('assets/custom/js/plugins/chosen/chosen.jquery.js'); ?>



    <script>
        $(document).ready(function () {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script>
    <?php echo $__env->make('common.toastr_notification', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php if(in_array('calendar',$assets)): ?>
        <?php echo Html::script('assets/vendor/calendar/moment.min.js'); ?>

        <?php echo Html::script('assets/vendor/calendar/fullcalendar.min.js'); ?>

    <?php endif; ?>
    <?php if(in_array('recaptcha',$assets)): ?>
        <script src='https://www.google.com/recaptcha/api.js'></script>
    <?php endif; ?>
    <script>
    $.ajaxSetup({
       headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
    });

        var appPath = "<?php echo e(env('SUBFOLDER_PATH','')); ?>";
        var currentUserId = "<?php echo e(Auth::user()->id); ?>";
    </script>
    <script src="https://js.pusher.com/3.2/pusher.min.js"></script>
    <?php echo Html::script('assets/js/wmlab.js'); ?>

    <?php echo $__env->yieldContent('javascript'); ?>



</body>
</html>