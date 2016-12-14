    <?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <div class="text-center">
                <h1>404 <i class="fa fa-meh-o"></i> </h1>
                <p><?php echo trans('messages.page_not_found'); ?></p>
                <p><?php echo trans('messages.back_to'); ?> <a href="/"><?php echo trans('messages.home'); ?></a></p>
            </div>
        </div>
    </div>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('guest_layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>