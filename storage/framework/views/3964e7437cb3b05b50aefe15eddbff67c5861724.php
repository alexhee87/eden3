

	<?php $__env->startSection('breadcrumb'); ?>
        <div class="row">
            <ul class="breadcrumb">
			    <li><a href="/home"><?php echo trans('messages.home'); ?></a></li>
			    <li class="active"><?php echo trans('messages.configuration'); ?></li>
			</ul>
        </div>
		
	<?php $__env->stopSection(); ?>
	
	<?php $__env->startSection('content'); ?>
		<div class="row">
			<div class="panel-body">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#general-tab" data-toggle="tab"><?php echo e(trans('messages.general')); ?></a>
                    </li>
                    <li><a href="#logo-tab" data-toggle="tab"><?php echo e(trans('messages.logo')); ?></a>
                    </li>
                    <li><a href="#system-tab" data-toggle="tab"><?php echo e(trans('messages.system')); ?></a>
                    </li>
                    <li><a href="#mail-tab" data-toggle="tab"><?php echo e(trans('messages.mail')); ?></a>
                    </li>
                    <li><a href="#sms-tab" data-toggle="tab">SMS</a>
                    </li>
                    <li><a href="#auth-tab" data-toggle="tab"><?php echo e(trans('messages.authentication')); ?></a>
                    </li>
                    <li><a href="#social-login-tab" data-toggle="tab"><?php echo e(trans('messages.social').' '.trans('messages.login')); ?></a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="general-tab">
                        <div class="panel panel-default m-t-10">
                            <div class="panel-heading">
                                <?php echo e(trans('messages.general').' '.trans('messages.configuration')); ?>

                            </div>
                            <div class="panel-body">
                                <?php echo Form::open(['route' => 'configuration.store','role' => 'form', 'class'=>'config-general-form','id' => 'config-general-form','data-no-form-clear' => 1]); ?>

                                    <?php echo $__env->make('configuration._general_form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                <?php echo Form::close(); ?>

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade in" id="logo-tab">
                        <div class="panel panel-default m-t-10">
                            <div class="panel-heading">
                                <?php echo e(trans('messages.logo')); ?>

                            </div>
                            <div class="panel-body">
                                <?php echo Form::open(['files' => true, 'route' => 'configuration.logo','role' => 'form', 'class'=>'config-logo-form','id' => 'config-logo-form','data-submit' => 'noAjax']); ?>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="file" class="fileinput" name="logo" id="logo" data-buttonText="<?php echo trans('messages.select').' '.trans('messages.logo'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <?php if(config('config.logo') && File::exists(config('constant.upload_path.logo').config('config.logo'))): ?>
                                    <div class="form-group">
                                        <img src="<?php echo e(URL::to(config('constant.upload_path.logo').config('config.logo'))); ?>" width="150px" style="margin-left:20px;">
                                        <div class="checkbox">
                                            <label>
                                              <input name="remove_logo" type="checkbox" class="switch-input" data-size="mini" data-on-text="Yes" data-off-text="No" value="1" data-off-value="0"> <?php echo trans('messages.remove').' '.trans('messages.logo'); ?>

                                            </label>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                <?php echo Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary']); ?>

                                <?php echo Form::close(); ?>

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade in" id="system-tab">
                        <div class="panel panel-default m-t-10">
                            <div class="panel-heading">
                                <?php echo e(trans('messages.system').' '.trans('messages.configuration')); ?>

                            </div>
                            <div class="panel-body">
                                <?php echo Form::open(['route' => 'configuration.store','role' => 'form', 'class'=>'config-system-form','id' => 'config-system-form','data-disable-enter-submission' => '1','data-no-form-clear' => 1]); ?>

                                    <?php echo $__env->make('configuration._system_form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                <?php echo Form::close(); ?>

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade in" id="mail-tab">
                        <div class="panel panel-default m-t-10">
                            <div class="panel-heading">
                                <?php echo e(trans('messages.mail').' '.trans('messages.configuration')); ?>

                            </div>
                            <div class="panel-body">
                                <?php echo Form::open(['route' => 'configuration.mail','role' => 'form', 'class'=>'config-mail-form','id' => 'config-mail-form','data-no-form-clear' => 1]); ?>

                                    <?php echo $__env->make('configuration._mail_form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                <?php echo Form::close(); ?>

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade in" id="sms-tab">
                        <div class="panel panel-default m-t-10">
                            <div class="panel-heading">
                                <?php echo e('SMS '.trans('messages.configuration')); ?>

                            </div>
                            <div class="panel-body">
                                <?php echo Form::open(['route' => 'configuration.sms','role' => 'form', 'class'=>'config-sms-form','id' => 'config-sms-form','data-no-form-clear' => 1]); ?>

                                    <?php echo $__env->make('configuration._sms_form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                <?php echo Form::close(); ?>

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade in" id="auth-tab">
                        <div class="panel panel-default m-t-10">
                            <div class="panel-heading">
                                <?php echo e(trans('messages.authentication').' '.trans('messages.configuration')); ?>

                            </div>
                            <div class="panel-body">
                                <?php echo Form::open(['route' => 'configuration.store','role' => 'form', 'class'=>'config-auth-form','id' => 'config-auth-form','data-no-form-clear' => 1]); ?>

                                    <?php echo $__env->make('configuration._auth_form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                <?php echo Form::close(); ?>

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade in" id="social-login-tab">
                        <div class="panel panel-default m-t-10">
                            <div class="panel-heading">
                                <?php echo e(trans('messages.social').' '.trans('messages.login').'  '.trans('messages.configuration')); ?>

                            </div>
                            <div class="panel-body">
                                <?php echo Form::open(['route' => 'configuration.store','role' => 'form', 'class'=>'config-social-login-form','id' => 'config-social-login-form','data-no-form-clear' => 1]); ?>

                                    <?php echo $__env->make('configuration._social_login_form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                <?php echo Form::close(); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>