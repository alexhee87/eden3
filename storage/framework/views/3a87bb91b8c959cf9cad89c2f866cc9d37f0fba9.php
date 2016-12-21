

	<?php $__env->startSection('breadcrumb_title'); ?>
		<?php echo trans('messages.activity').' '.trans('messages.log'); ?>

	<?php $__env->stopSection(); ?>

	<?php $__env->startSection('breadcrumb'); ?>
        <div class="row">
            <ul class="breadcrumb">
			    <li><a href="/home"><?php echo trans('messages.home'); ?></a></li>
			    <li class="active"><?php echo trans('messages.activity').' '.trans('messages.log'); ?></li>
			</ul>
        </div>
	<?php $__env->stopSection(); ?>
	
	<?php $__env->startSection('content'); ?>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
                    <div class="panel-heading">
                        <strong><?php echo trans('messages.list_all').'</strong> '.trans('messages.activity').' '.trans('messages.log'); ?>

                    </div>
                    <div class="panel-body full">
						<?php echo $__env->make('common.datatable',['table' => $table_data['activity-log-table']], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>
                </div>
			</div>
		</div>
	<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>