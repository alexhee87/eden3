
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h4 class="modal-title"><?php echo trans('messages.change').' '.trans('messages.password'); ?></h4>
	</div>
	<div class="modal-body">
		<div class="row">
			<div class="col-md-12">
				<?php echo Form::open(['route' => 'change-password','role' => 'form', 'class' => 'change-password-form','id' => "change-password-form"]); ?>

				<div class="form-group">
				    <?php echo Form::label('old_password',trans('messages.current').' '.trans('messages.password'),[]); ?>

					<?php echo Form::input('password','old_password','',['class'=>'form-control','placeholder'=>trans('messages.current').' '.trans('messages.password')]); ?>

				</div>
				<div class="form-group">
				    <?php echo Form::label('new_password',trans('messages.new').' '.trans('messages.password'),[]); ?>

					<?php echo Form::input('password','new_password','',['class'=>'form-control '.(config('config.enable_password_strength_meter') ? 'password-strength' : ''),'placeholder'=>trans('messages.new').' '.trans('messages.password')]); ?>

				</div>
				<div class="form-group">
				    <?php echo Form::label('new_password_confirmation',trans('messages.confirm').' '.trans('messages.password'),[]); ?>

					<?php echo Form::input('password','new_password_confirmation','',['class'=>'form-control','placeholder'=>trans('messages.confirm').' '.trans('messages.password')]); ?>

				</div>
				<div class="form-group">
					<?php echo Form::submit(isset($buttonText) ? $buttonText : trans('messages.update'),['class' => 'btn btn-primary pull-right']); ?>

				</div>
				<?php echo Form::close(); ?>

			</div>
		</div>
	</div>
	<div class="modal-footer">
	</div>