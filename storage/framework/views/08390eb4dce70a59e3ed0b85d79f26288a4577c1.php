

	<?php $__env->startSection('breadcrumb'); ?>
        <div class="row">
			<ul class="breadcrumb">
			    <li><a href="/home"><?php echo trans('messages.home'); ?></a></li>
			    <li class="active"><?php echo trans('messages.template'); ?></li>
			</ul>
		</div>
	<?php $__env->stopSection(); ?>
	
	<?php $__env->startSection('content'); ?>
		<div class="row">
			<div class="col-sm-12 collapse" id="box-detail">
				<div class="panel panel-default">
                    <div class="panel-heading">
                    	<strong><?php echo trans('messages.add_new'); ?></strong> <?php echo trans('messages.template'); ?>

                    	<div class="additional-btn">
							<button class="btn btn-sm btn-primary" data-toggle="collapse" data-target="#box-detail"><i class="fa fa-minus icon"></i> <?php echo trans('messages.hide'); ?></button>
						</div>
                    </div>
                    <div class="panel-body">
                    	<?php echo Form::open(['route' => 'template.store','role' => 'form', 'class'=>'email-template-form','id' => 'email-template-form','data-form-table' => 'template_table']); ?>

							<?php echo $__env->make('template._form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
						<?php echo Form::close(); ?>

                    </div>
                </div>
            </div>
			<div class="col-sm-12">
				<div class="panel panel-default">
                    <div class="panel-heading">
                    	<strong><?php echo trans('messages.list_all'); ?></strong> <?php echo trans('messages.template'); ?>

                    	<div class="additional-btn">
                    		<a href="/email" class="btn btn-sm btn-primary"><?php echo e(trans('messages.email').' '.trans('messages.log')); ?></a>
							<a href="#" data-toggle="collapse" data-target="#box-detail"><button class="btn btn-sm btn-primary"><i class="fa fa-plus icon"></i> <?php echo trans('messages.add_new'); ?></button></a>
						</div>
                    </div>
                    <div class="panel-body full">
						<?php echo $__env->make('common.datatable',['table' => $table_data['template-table']], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>
                </div>
            </div>
		</div>
	<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>