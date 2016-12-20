

<?php $__env->startSection('breadcrumb'); ?>
	<div class="row">
		<ul class="breadcrumb">
			<li><a href="<?php echo e(url('home')); ?>"><?php echo trans('messages.home'); ?></a></li>
			<li class="active"><?php echo trans('messages.custom').' '.trans('messages.field'); ?></li>
		</ul>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<div class="row">
		<div class="col-lg-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<strong><?php echo trans('messages.add_new'); ?></strong> <?php echo trans('messages.custom').' '.trans('messages.field'); ?>

				</div>
				<div class="panel-body">
					<?php echo Form::open(['route' => 'custom-field.store','role' => 'form', 'class'=>'custom-field-form','id' => 'custom-field-form','data-disable-enter-submission' => '1']); ?>

					<div class="form-group">
						<?php echo Form::label('form',trans('messages.form'),[]); ?>

						<?php echo Form::select('form', config('custom_field'),'',['class'=>'form-control input-xlarge tagsinput','placeholder'=>trans('messages.select_one')]); ?>

					</div>
					<div class="form-group">
						<?php echo Form::label('title',trans('messages.title'),[]); ?>

						<?php echo Form::input('text','title','',['class'=>'form-control','placeholder'=>trans('messages.title')]); ?>

					</div>
					<div class="form-group">
						Required
						<div class="switch">
							<div class="onoffswitch">
								<input name="is_required" type="checkbox" checked class="onoffswitch-checkbox" id="is_required">
								<label class="onoffswitch-label" for="is_required">
									<span class="onoffswitch-inner"></span>
									<span class="onoffswitch-switch"></span>
								</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<?php echo Form::label('type',trans('messages.type'),[]); ?>

						<?php echo Form::select('type', [
                        'text' => 'Text Box',
                        'number' => 'Number',
                        'email' => 'Email',
                        'url' => 'URL',
                        'date' => 'Date',
                        'select' => 'Select Box',
                        'radio' => 'Radio Button',
                        'checkbox' => 'Check Box',
                        'textarea' => 'Textarea'
                        ],'',['id' => 'type', 'class'=>'form-control input-xlarge tagsinput','placeholder'=>trans('messages.select_one')]); ?>

					</div>
					<div class="custom-field-option">
						<?php echo Form::label('options',trans('messages.option'),[]); ?>

						<?php echo Form::input('text','options','',['class'=>'tagsinput form-control','placeholder'=>'','size'=>'1','data-role' => 'tagsinput']); ?>


					</div>
					<?php echo Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary pull-right']); ?>


					<?php echo Form::close(); ?>

				</div>
			</div>
		</div>
		<div class="col-lg-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					<strong><?php echo trans('messages.list_all'); ?></strong> <?php echo trans('messages.custom').' '.trans('messages.field'); ?>

				</div>
				<div class="panel-body full">
					<?php echo $__env->make('common.datatable',['table' => $table_data['custom-field-table']], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
				</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>