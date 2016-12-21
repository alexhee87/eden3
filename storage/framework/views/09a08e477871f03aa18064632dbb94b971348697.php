

	<?php $__env->startSection('content'); ?>
    	<div class="container">
	        <div class="row">
	            <div class="col-md-8 col-md-offset-2">
	                <div class="login-panel panel panel-default">
	                    <div class="panel-heading">
	                        <h3 class="panel-title"><strong>Installation</strong> Wizard</h3>
	                    </div>
	                    <div class="panel-body">
	                    	<?php echo Form::open(['route' => 'install.store','class' => 'install-form','id' => 'myWizard','data-submit' => 'noAjax']); ?>

	                    	<div id="form-wizard">
								<div class="navbar">
								  <div class="navbar-inner">
								    <div class="container">
								<ul>
								  	<li><a href="#pre-requisite-tab" data-toggle="tab">Pre Requisite</a></li>
									<li><a href="#installation-tab" data-toggle="tab">Installation</a></li>
								</ul>
								 </div>
								  </div>
								</div>
								<div class="tab-content">
								    <div class="tab-pane" id="pre-requisite-tab">
								      	<div class="row">
											<div class="col-sm-12">
												<?php $__currentLoopData = $checks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $check): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
													<?php if($check['type'] == 'error'): ?>
														<div class="alert alert-danger" style="padding:5px;"><i class="fa fa-times icon"></i> <?php echo e($check['message']); ?></div>
													<?php else: ?>
														<div class="alert alert-success" style="padding:5px;"><i class="fa fa-check icon"></i> <?php echo e($check['message']); ?></div>
													<?php endif; ?>
												<?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
											</div>
										</div>
								    </div>
								    <div class="tab-pane" id="installation-tab">
								    	<div class="row">
											<?php if($error): ?>
												<div class="col-sm-12">
													<div class="alert alert-danger">Please fix the error.</div>
												</div>
											<?php else: ?>
												<div class="col-sm-6">
												  <div class="form-group">
													<?php echo Form::input('text','hostname','',['class'=>'form-control','placeholder'=>'Enter Hostname']); ?>

												  </div>
												  <div class="form-group">
													<?php echo Form::input('text','mysql_username','',['class'=>'form-control','placeholder'=>'Enter MYSQL Username']); ?>

												  </div>
												  <div class="form-group">
													<?php echo Form::input('password','mysql_password','',['class'=>'form-control','placeholder'=>'Enter MYSQL Password']); ?>

												  </div>
												  <div class="form-group">
													<?php echo Form::input('text','mysql_database','',['class'=>'form-control','placeholder'=>'Enter MYSQL Database']); ?>

												  </div>
												  <div class="form-group">
													<?php echo Form::input('email','email','',['class'=>'form-control','placeholder'=>'Enter Email']); ?>

												  </div>
												</div>
												<div class="col-sm-6">
												  <div class="row">
													  <div class="col-md-6">
														  <div class="form-group">
															<?php echo Form::input('text','first_name','',['class'=>'form-control','placeholder'=>'Enter First Name']); ?>

														  </div>
													  </div>
													  <div class="col-md-6">
														  <div class="form-group">
															<?php echo Form::input('text','last_name','',['class'=>'form-control','placeholder'=>'Enter Last Name']); ?>

														  </div>
													  </div>
												  </div>
												  <div class="form-group">
													<?php echo Form::input('text','username','',['class'=>'form-control','placeholder'=>'Enter Username']); ?>

												  </div>
												  <div class="form-group">
													<?php echo Form::input('password','password','',['class'=>'form-control','placeholder'=>'Enter Password']); ?>

												  </div>
												  <div class="form-group">
													<?php echo Form::input('text','envato_username','',['class'=>'form-control','placeholder'=>'Enter Envato Username']); ?>

												  </div>
												  <div class="form-group">
													<?php echo Form::input('text','purchase_code','',['class'=>'form-control','placeholder'=>'Enter Purchase Code']); ?>

												  </div>
												  <?php echo Form::submit('Install',['class' => 'btn btn-primary pull-right']); ?>

												</div>
											<?php endif; ?>
										</div>
								    </div>
									<ul class="pager wizard">
										<li class="previous first" style="display:none;"><a href="#">First</a></li>
										<li class="previous"><a href="#">Previous</a></li>
										<li class="next last" style="display:none;"><a href="#">Last</a></li>
									  	<li class="next"><a href="#">Next</a></li>
									</ul>
								</div>
							</div>
							<?php echo Form::close(); ?>

	                    </div>
	                </div>
	            </div>
	        </div>
    	</div>
	<?php $__env->stopSection(); ?>
<?php echo $__env->make('guest_layouts.install', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>