			<div class="form-group">
			    <?php echo Form::label('name',trans('messages.role').' '.trans('messages.name'),[]); ?>

				<?php echo Form::input('text','name',isset($role->name) ? toWord($role->name) : '',['class'=>'form-control','placeholder'=>trans('messages.role').' '.trans('messages.name')]); ?>

			</div>
			<div class="form-group">
			    <?php echo Form::label('description',trans('messages.description'),[]); ?>

			    <?php echo Form::textarea('description',isset($role->description) ? $role->description : '',['size' => '30x3', 'class' => 'form-control', 'placeholder' => trans('messages.description'),"data-show-counter" => 1,'data-autoresize' => 1]); ?>

			    <span class="countdown"></span>
			</div>
			<?php if(!isset($role) || (isset($role) && !$role->default_user_role)): ?>
			<div class="form-group">
				<?php echo trans('messages.default_user_role'); ?>

            	<div class="switch">
					<div class="onoffswitch">
						<input name="default_user_role" type="checkbox" value="1" <?php echo e((isset($role) && $role->default_user_role) ? 'checked' : ''); ?> class="onoffswitch-checkbox" id="default_user_role">
						<label class="onoffswitch-label" for="default_user_role">
							<span class="onoffswitch-inner"></span>
							<span class="onoffswitch-switch"></span>
						</label>
					</div>
				</div>
			</div>
            <?php endif; ?>
			<?php echo Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary pull-right']); ?>