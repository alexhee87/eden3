	<?php $__env->startSection('breadcrumb'); ?>
		<div class="row">
			<ul class="breadcrumb">
			    <li><a href="<?php echo e(url('home')); ?>"><?php echo trans('messages.home'); ?></a></li>
			    <li class="active">Message</li>
			</ul>
		</div>
	<?php $__env->stopSection(); ?>
	
	<?php $__env->startSection('content'); ?>
		<div class="row">
			<div class="col-sm-2">
			    <ul class="nav nav-tabs tabs-left">
				  <li><a href="#compose-tab" data-toggle="tab"><i class="fa fa-pencil-square"></i> Compose</a></li>
			      <li class="active"><a href="#inbox-tab" data-toggle="tab"><i class="fa fa-inbox"></i> Inbox (<?php echo e($count_inbox); ?>)</a></li>
				  <li><a href="#sent-tab" data-toggle="tab"><i class="fa fa-share"></i> Sent</a></li>
				  <li><a href="#starred-tab" data-toggle="tab"><i class="fa fa-star"></i> Starred</a></li>
				  <li><a href="#trash-tab" data-toggle="tab"><i class="fa fa-trash"></i> Trash</a></li>
			    </ul>
			</div>
			<div class="col-sm-10">
			    <div class="tab-content">
			      	<div class="tab-pane active" id="inbox-tab">
						<div class="panel panel-default">
							<div class="panel-heading">
                    			<strong>Inbox</strong>
                    		</div>
                    		<div class="panel-body full">
                    			<div class="row">
                    				<div class="col-md-12">
										<?php echo $__env->make('common.datatable',['table' => $table_data['inbox-table']], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
									</div>
								</div>
                    		</div>
                    	</div>
                    </div>
			      	<div class="tab-pane" id="sent-tab">
						<div class="panel panel-default">
							<div class="panel-heading">
                    			<strong>Sent</strong>
                    		</div>
                    		<div class="panel-body full">
                    			<div class="row">
                    				<div class="col-md-12">
										<?php echo $__env->make('common.datatable',['table' => $table_data['sent-table']], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
									</div>
								</div>
                    		</div>
                    	</div>
                    </div>
			      	<div class="tab-pane" id="starred-tab">
						<div class="panel panel-default">
							<div class="panel-heading">
                    			<strong>Starred</strong>
                    		</div>
                    		<div class="panel-body full">
                    			<div class="row">
                    				<div class="col-md-12">
										<?php echo $__env->make('common.datatable',['table' => $table_data['starred-table']], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
									</div>
								</div>
                    		</div>
                    	</div>
                    </div>
			      	<div class="tab-pane" id="trash-tab">
						<div class="panel panel-default">
							<div class="panel-heading">
                    			<strong>Trash</strong>
                    		</div>
                    		<div class="panel-body full">
                    			<div class="row">
                    				<div class="col-md-12">
										<?php echo $__env->make('common.datatable',['table' => $table_data['trash-table']], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
									</div>
								</div>
                    		</div>
                    	</div>
                    </div>
			      	<div class="tab-pane" id="compose-tab">
						<div class="panel panel-default">
							<div class="panel-heading">
                    			<strong>Compose</strong>
                    		</div>
                    		<div class="panel-body">
                    			<?php echo Form::open(['files'=>'true','route' => 'message.store','role' => 'form', 'class'=>'compose-form','id' => 'compose-form','data-submit' => 'noAjax']); ?>

									<div class="form-group">
										<?php echo Form::select('to_user_id', $users, '',['class'=>'form-control input-xlarge tagsinput','placeholder'=>trans('messages.select_one'),'style' => 'width:100%;']); ?>

									</div>
									<div class="form-group">
										<?php echo Form::input('text','subject','',['class'=>'form-control','placeholder'=>trans('messages.subject')]); ?>

									</div>
									<div class="form-group">
										<?php echo Form::textarea('body','',['class' => 'form-control summernote', 'placeholder' => trans('messages.body')]); ?>

									</div>
									<div class="form-group">
										<input type="file" name="file" id="file" class="fileinput" title="<?php echo trans('messages.select').' '.trans('messages.attachment'); ?>">
									</div>
									<div class="form-group">
										<div class="pull-right">
											<button type="submit" name="submit" class="btn btn-success btn-sm"><i class="fa fa-paper-plane"></i> <?php echo trans('messages.send'); ?></button>
										</div>
									</div>	
								<?php echo Form::close(); ?>

                    		</div>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>