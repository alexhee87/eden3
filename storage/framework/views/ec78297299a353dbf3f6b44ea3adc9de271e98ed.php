    <?php $__env->startSection('content'); ?>
    <div class="container">
        <?php if(config('config.logo') && File::exists(config('constant.upload_path.logo').config('config.logo'))): ?>
            <div class="logo text-center">
                <img src="/<?php echo config('constant.upload_path.logo').config('config.logo'); ?>" class="logo-image" alt="Logo">
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong><?php echo trans('messages.forgot'); ?></strong> <?php echo trans('messages.password'); ?></h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="<?php echo URL::to('/password/email'); ?>" method="post" class="forgot-form" id="forgot-form" data-submit="noAjax">
                            <?php echo csrf_field(); ?>

                            <fieldset>
                                <div class="form-group">
                                    <div class="input-group margin-bottom-sm">
                                        <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
                                        <input type="email" name="email" id="email" class="form-control" placeholder="<?php echo trans('messages.email'); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-block btn-success"><?php echo trans('messages.reset').' '.trans('messages.password'); ?></button>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="/login" class="btn btn-block btn-info"><?php echo trans('messages.back_to').' '.trans('messages.login'); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="credit"><?php echo e(config('config.credit')); ?></div>
    </div>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('guest_layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>