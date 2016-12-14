    <div id="js-var" style="visibility:none;" 
        data-toastr-position="<?php echo e(config('config.notification_position')); ?>"
        data-something-error-message="<?php echo e(trans('messages.something_error_message')); ?>"
        data-character-remaining="<?php echo e(trans('messages.character_remaining')); ?>"
        data-textarea-limit="<?php echo e(config('config.textarea_limit')); ?>"
        data-calendar-language="<?php echo config('lang.'.session('lang').'.calendar'); ?>"
    ></div>

    <?php echo Html::script('assets/vendor/jquery/jquery.min.js'); ?>

    <?php echo Html::script('assets/vendor/bootstrap/js/bootstrap.min.js'); ?>

    <?php echo Html::script('assets/vendor/switch/bootstrap-switch.min.js'); ?>

    <?php echo Html::script('assets/vendor/toastr/toastr.min.js'); ?>

    <?php echo $__env->make('common.toastr_notification', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo Html::script('assets/vendor/select2/select2.min.js'); ?>

    <?php echo Html::script('assets/vendor/datepicker/js/bootstrap-datepicker.js'); ?>

    <?php if(isset($assets) && in_array('form-wizard',$assets)): ?>
        <?php echo Html::script('assets/vendor/form-wizard/form-wizard.js'); ?>

    <?php endif; ?>
    <?php echo Html::script('assets/vendor/icheck/icheck.min.js'); ?>

    <?php echo Html::script('assets/vendor/password/password.js'); ?>

    <?php echo Html::script('assets/js/textAvatar.js'); ?>

    <script src='https://www.google.com/recaptcha/api.js'></script>
    <?php echo Html::script('assets/js/wmlab.js'); ?>

</body>
</html>
