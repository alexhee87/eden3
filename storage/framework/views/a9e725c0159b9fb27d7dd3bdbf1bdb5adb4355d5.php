

	<?php $__env->startSection('breadcrumb'); ?>
        <div class="row">
            <ul class="breadcrumb">
			    <li><a href="/home"><?php echo trans('messages.home'); ?></a></li>
			    <li><a href="/user"><?php echo trans('messages.user'); ?></a></li>
			    <li class="active"><?php echo trans('messages.add_new').' '.trans('messages.user'); ?></li>
			</ul>
        </div>
		
	<?php $__env->stopSection(); ?>
	
	<?php $__env->startSection('content'); ?>
		<div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong><?php echo e(trans('messages.add_new')); ?></strong> <?php echo e(trans('messages.user')); ?>

                    	<div class="additional-btn">
                    		<a href="#" data-href="/user" class="btn btn-sm btn-primary"><?php echo e(trans('messages.list_all')); ?></a>
                    	</div>
                    </div>
                    <div class="panel-body">
                    	<?php echo Form::open(['route' => 'user.store','role' => 'form', 'class' => 'user-form','id' => "user-form"]); ?>

						<?php echo $__env->make('auth._register_form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
						<div class="form-group">
							<?php echo Form::submit(trans('messages.save'),['class' => 'btn btn-primary pull-right']); ?>

						</div>
						<?php echo Form::close(); ?>

                    </div>
                </div>
            </div>
		</div>
	<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>