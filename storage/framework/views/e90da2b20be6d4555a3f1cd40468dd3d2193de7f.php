

	<?php $__env->startSection('breadcrumb'); ?>
        <div class="row">
            <ul class="breadcrumb">
			    <li><a href="/home"><?php echo trans('messages.home'); ?></a></li>
			    <li class="active"><?php echo trans('messages.user'); ?></li>
			</ul>
        </div>

	<?php $__env->stopSection(); ?>

	<?php $__env->startSection('content'); ?>
		<div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong><?php echo e(trans('messages.list_all')); ?></strong> <?php echo e(trans('messages.user')); ?>

                        <?php if(Entrust::can('create-user')): ?>
                    	<div class="additional-btn">
                    		<a href="/user/create" class="btn btn-sm btn-primary"><?php echo e(trans('messages.add_new')); ?></a>
                    	</div>
                        <?php endif; ?>
                    </div>
                    <div class="panel-body full">
                        <?php echo $__env->make('common.datatable',['table' => $table_data['user-table']], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>
                </div>
            </div>
		</div>
	<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>