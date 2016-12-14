    

    <?php $__env->startSection('content'); ?>
    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>
                <?php if(config('config.logo') && File::exists(config('constant.upload_path.logo').config('config.logo'))): ?>
                    <div class="logo text-center">
                        <img src="/<?php echo config('constant.upload_path.logo').config('config.logo'); ?>" class="logo-image" alt="Logo">
                    </div>
                <?php endif; ?>
            </div>
            <h3>Welcome to Eden+</h3>
            <p>
                Perfectly designed for the internal usage across departments
                <!--Continually expanded and constantly improved Inspinia Admin Them (IN+)-->
            </p>
            <p>Login in. To see it in action.</p>
            <form class="m-t" role="form" action="<?php echo URL::to('/login'); ?>" method="post" class="login-form" id="login-form" data-submit="noAjax">
                <?php echo csrf_field(); ?>

                <?php if(config('config.login')): ?>
                <div class="form-group">
                    <input name="email" type="email" class="form-control" placeholder="Username" required="true">
                </div>
                <?php else: ?>
                <div class="form-group">
                    <input name="username" type="username" class="form-control" placeholder="Username" required="true">
                </div>
                <?php endif; ?>
                <div class="form-group">
                    <input name="password" type="password" class="form-control" placeholder="Password" required="">
                    <?php if(config('config.enable_remember_me')): ?>
                    <div class="i-checks"><label> <input type="checkbox" name="remember" value="1"><i></i> <?php echo trans('messages.remember_me'); ?> </label></div>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary block full-width m-b"><?php echo trans('messages.login'); ?></button>
                <?php if(config('config.enable_forgot_password')): ?>
                    <a href="/password/reset"><small><?php echo trans('messages.forgot').' '.trans('messages.password'); ?>?</small></a>
                <?php endif; ?>
                <?php if(config('config.enable_user_registration')): ?>
                <p class="text-muted text-center"><small>Do not have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="/register"><?php echo trans('messages.create').' '.trans('messages.account'); ?></a>
                <?php endif; ?>
            </form>
            <p class="m-t"> <small>Brought to you by GIT Team © 2016</small> </p>
        </div>
    </div>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('guest_layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>