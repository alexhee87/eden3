

	<?php $__env->startSection('breadcrumb'); ?>
        <div class="row">
            <ul class="breadcrumb">
			    <li><a href="/home"><?php echo trans('messages.home'); ?></a></li>
			    <li class="active">IP <?php echo trans('messages.filter'); ?></li>
			</ul>
        </div>
	<?php $__env->stopSection(); ?>
	
	<?php $__env->startSection('content'); ?>
		<div class="row">
			<div class="col-lg-4">
				<div class="panel panel-default">
                    <div class="panel-heading">
                        <strong><?php echo trans('messages.add_new').'</strong> IP '.trans('messages.filter'); ?>

                    </div>
                    <div class="panel-body">
                    <?php echo Form::open(['route' => 'ip-filter.store','role' => 'form', 'class'=>'ip-filter-form','id' => 'ip-filter-form']); ?>

						<?php echo $__env->make('ip_filter._form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
					<?php echo Form::close(); ?>

                    </div>
                </div>
			</div>
			<div class="col-lg-8">
				<div class="panel panel-default">
                    <div class="panel-heading">
                        <strong><?php echo trans('messages.list_all').'</strong> IP '.trans('messages.filter'); ?>

                    </div>
                    <div class="panel-body full">
						<?php echo $__env->make('common.datatable',['table' => $table_data['ip-filter-table']], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>
                </div>
			</div>
		</div>
	<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>