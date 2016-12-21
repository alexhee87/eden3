

	<?php $__env->startSection('breadcrumb'); ?>
        <div class="row">
			<ul class="breadcrumb">
			    <li><a href="/home"><?php echo trans('messages.home'); ?></a></li>
			    <li class="active"><?php echo trans('messages.language'); ?></li>
			</ul>
		</div>
	<?php $__env->stopSection(); ?>
	
	<?php $__env->startSection('content'); ?>
		<div class="row">
			<div class="col-sm-4">
				<div class="panel panel-default">
                    <div class="panel-heading">
					<strong><?php echo trans('messages.add_new'); ?></strong> <?php echo trans('messages.language'); ?>

					</div>
					<div class="panel-body">
						<?php echo Form::open(['route' => 'language.store','role' => 'form', 'class'=>'language-form','id' => 'language-form']); ?>

							<?php echo $__env->make('language._form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
						<?php echo Form::close(); ?>

					</div>
				</div>
			</div>
			<div class="col-sm-8">
				<div class="panel panel-default">
                    <div class="panel-heading">
						<strong><?php echo trans('messages.list_all'); ?></strong> <?php echo trans('messages.language'); ?>

					</div>
					<div class="panel-body full">
						<?php echo $__env->make('common.datatable',['table' => $table_data['language-table']], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
					</div>
				</div>
			</div>
		</div>
	<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>