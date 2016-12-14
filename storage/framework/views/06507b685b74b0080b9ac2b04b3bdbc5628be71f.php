

	<?php $__env->startSection('breadcrumb'); ?>
        <div class="row">
            <ul class="breadcrumb">
			    <li><a href="/home"><?php echo trans('messages.home'); ?></a></li>
			    <li class="active"><?php echo trans('messages.permission'); ?></li>
			</ul>
        </div>
	<?php $__env->stopSection(); ?>
	
	<?php $__env->startSection('content'); ?>
		<div class="row">
			<div class="col-lg-4">
				<div class="panel panel-default">
                    <div class="panel-heading">
                        <strong><?php echo trans('messages.add_new').'</strong> '.trans('messages.permission'); ?>

                    </div>
                    <div class="panel-body">
                    <?php echo Form::open(['route' => 'permission.store','role' => 'form', 'class'=>'permission-form','id' => 'permission-form','data-submit' => 'noAjax']); ?>

						<?php echo $__env->make('permission._form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
					<?php echo Form::close(); ?>

                    </div>
                </div>
			</div>
			<div class="col-lg-8">
				<div class="panel panel-default">
                    <div class="panel-heading">
                        <strong><?php echo trans('messages.list_all').'</strong> '.trans('messages.permission'); ?></strong>
                        <div class="additional-btn">
                        	<a href="/save-permission" class="btn btn-primary btn-sm"><?php echo e(trans('messages.permission_edit_roles')); ?></a>
                        </div>
                    </div>
                    <div class="panel-body full">
                        <?php echo $__env->make('common.datatable',['table' => $table_data['permission-table']], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>
                </div>
			</div>
		</div>
	<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>