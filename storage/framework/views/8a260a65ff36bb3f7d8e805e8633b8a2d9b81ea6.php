
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
		<h4 class="modal-title"><?php echo trans('messages.edit').' '.trans('messages.role'); ?></h4>
	</div>
	<div class="modal-body">
		<?php echo Form::model($role,['method' => 'PATCH','route' => ['role.update',$role->id] ,'class' => 'role-form','id' => 'role-form-edit']); ?>

			<?php echo $__env->make('role._form', ['buttonText' => trans('messages.update')], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<?php echo Form::close(); ?>

		<div class="clearfix"></div>
	</div>