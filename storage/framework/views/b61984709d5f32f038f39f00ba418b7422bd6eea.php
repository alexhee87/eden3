

	<?php $__env->startSection('breadcrumb'); ?>
        <div class="row">
            <ul class="breadcrumb">
			    <li><a href="<?php echo e(url('home')); ?>"><?php echo trans('messages.home'); ?></a></li>
                <li><a href="<?php echo e(url('user')); ?>"><?php echo trans('messages.user'); ?></a></li>
			    <li class="active"><?php echo $user->full_name; ?></li>
			</ul>
        </div>
		
	<?php $__env->stopSection(); ?>
	
	<?php $__env->startSection('content'); ?>
		<div class="row">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong><?php echo trans('messages.user').'</strong> '.trans('messages.profile'); ?>

                    </div>
                    <div class="panel-body full">
                        <div class="row">
                            <div class="col-md-4  col-md-offset-3" style="margin-top:20px;margin-bottom:20px;"><?php echo getAvatar($user->id,150); ?></div>
                        </div>
                        <div class="responsive">
                            <table class="table table-stripped table-hover show-table">
                                <tbody>
                                    <tr>
                                        <th><?php echo e(trans('messages.name')); ?></th>
                                        <td><?php echo e($user->full_name); ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php echo e(trans('messages.status')); ?></th>
                                        <td><?php echo e(toWord($user->status)); ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php echo e(trans('messages.role')); ?></th>
                                        <td>
                                            <?php $__currentLoopData = $user->Roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                                <?php echo e(ucfirst($role->name)); ?><br />
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><?php echo e(trans('messages.email')); ?></th>
                                        <td><?php echo e($user->email); ?></td>
                                    </tr>
                                    <?php if(!config('config.login')): ?>
                                    <tr>
                                        <th><?php echo e(trans('messages.username')); ?></th>
                                        <td><?php echo e($user->username); ?></td>
                                    </tr>
                                    <?php endif; ?>
                                    <tr>
                                        <th><?php echo e(trans('messages.signup').' '.trans('messages.date')); ?></th>
                                        <td><?php echo e(showDate($user->created_at)); ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php echo e(trans('messages.last').' '.trans('messages.login')); ?></th>
                                        <td><?php echo e(showDateTime($user->last_login)); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="row" style="padding:10px;">
                                <div class="col-md-6">
                                    <a href="#" data-href="<?php echo e(url('change-password')); ?>" class="btn btn-block btn-primary"><?php echo e(trans('messages.change').' '.trans('messages.password')); ?></a>
                                </div>
                                <div class="col-md-6">
                                    <a href="#" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();" class="btn btn-block btn-danger"><?php echo e(trans('messages.logout')); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
    			<div class="panel-body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#general-tab" data-toggle="tab"><?php echo e(trans('messages.general')); ?></a>
                        </li>
                        <li><a href="#avatar-tab" data-toggle="tab"><?php echo e(trans('messages.avatar')); ?></a>
                        </li>
                        <li><a href="#social-tab" data-toggle="tab"><?php echo e(trans('messages.social').' '.trans('messages.networking')); ?></a>
                        </li>
                        <li><a href="#custom-field-tab" data-toggle="tab"><?php echo e(trans('messages.custom').' '.trans('messages.field')); ?></a>
                        </li>
                        <?php if($user->id != Auth::user()->id): ?>
                            <li><a href="#password-tab" data-toggle="tab"><?php echo e(trans('messages.reset').' '.trans('messages.password')); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if(config('config.enable_email_template')): ?>
                            <li><a href="#email-tab" data-toggle="tab"><?php echo e(trans('messages.email')); ?></a>
                            </li>
                        <?php endif; ?>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="general-tab">
                            <div class="panel panel-default m-t-10">
                                <div class="panel-heading">
                                    <?php echo e(trans('messages.general')); ?>

                                </div>
                                <div class="panel-body">
                                    <?php echo Form::model($user,['method' => 'POST','route' => ['user.profile-update',$user->id] ,'class' => 'user-profile-form','id' => 'user-profile-form','data-no-form-clear' => 1]); ?>

                                    <div class="row">
                                        <div class="col-md-6">
                                        <?php if(!$user->hasRole(DEFAULT_ROLE)): ?>
                                            <div class="form-group">
                                                <?php echo Form::label('role',trans('messages.role'),[]); ?>

                                                <?php echo Form::select('role_id[]',$roles,$user_roles,['class'=>'chosen-select','style' => 'width:100%;','multiple' => 'multiple']); ?>

                                            </div>
                                        <?php endif; ?>
                                          <div class="form-group">
                                            <?php echo Form::label('name',trans('messages.name'),[]); ?>

                                            <div class="row">
                                                <div class="col-md-6">
                                                <?php echo Form::input('text','first_name',$user->Profile->first_name,['class'=>'form-control','placeholder'=>trans('messages.first').' '.trans('messages.name')]); ?>

                                                </div>
                                                <div class="col-md-6">
                                                <?php echo Form::input('text','last_name',$user->Profile->last_name,['class'=>'form-control','placeholder'=>trans('messages.last').' '.trans('messages.name')]); ?>

                                                </div>
                                            </div>
                                          </div>
                                            <div class="form-group">
                                            <?php echo Form::label('work_phone',trans('messages.phone')); ?>

                                            <div class="row">
                                                <div class="col-xs-8">
                                                <?php echo Form::input('text','work_phone',$user->Profile->work_phone,['class'=>'form-control','placeholder'=>trans('messages.work')]); ?>

                                                </div>
                                                <div class="col-xs-4">
                                                <?php echo Form::input('text','work_phone_extension',$user->Profile->work_phone_extension,['class'=>'form-control','placeholder'=>trans('messages.ext')]); ?>

                                                </div>
                                            </div>
                                            <br />
                                            <?php echo Form::input('text','mobile',$user->Profile->mobile,['class'=>'form-control','placeholder'=>trans('messages.mobile')]); ?>

                                            <div class="help-block">This will be used to send two factor auth code.</div>
                                            <br />
                                            <?php echo Form::input('text','home',$user->Profile->home,['class'=>'form-control','placeholder'=>trans('messages.home')]); ?>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <?php echo Form::label('date_of_birth',trans('messages.date_of_birth'),[]); ?>

                                            <?php echo Form::input('text','date_of_birth',$user->Profile->date_of_birth,['class'=>'form-control datepicker','placeholder'=>trans('messages.date_of_birth')]); ?>

                                          </div>
                                            <div class="form-group">
                                                <?php echo Form::label('address',trans('messages.address'),[]); ?>

                                                <?php echo Form::input('text','address_1',$user->Profile->address_line_1,['class'=>'form-control','placeholder'=>trans('messages.address_line_1')]); ?>

                                                <br />
                                                <?php echo Form::input('text','address_2',$user->Profile->address_line_2,['class'=>'form-control','placeholder'=>trans('messages.address_line_2')]); ?>

                                                <br />
                                                <div class="row">
                                                    <div class="col-xs-5">
                                                    <?php echo Form::input('text','city',$user->Profile->city,['class'=>'form-control','placeholder'=>trans('messages.city')]); ?>

                                                    </div>
                                                    <div class="col-xs-4">
                                                    <?php echo Form::input('text','state',$user->Profile->state,['class'=>'form-control','placeholder'=>trans('messages.state')]); ?>

                                                    </div>
                                                    <div class="col-xs-3">
                                                    <?php echo Form::input('text','zipcode',$user->Profile->zipcode,['class'=>'form-control','placeholder'=>trans('messages.zipcode')]); ?>

                                                    </div>
                                                </div>
                                                <br />
                                                <?php echo Form::select('country_id', config('country'),$user->Profile->country_id,['class'=>'form-control chosen-select','placeholder'=>trans('messages.country'),'style' => 'width:100%;']); ?>

                                            </div>
                                            <?php echo Form::submit(trans('messages.save'),['class' => 'btn btn-primary pull-right']); ?>

                                        </div>
                                    </div>                                        
                                    <?php echo Form::close(); ?>

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade in" id="avatar-tab">
                            <div class="panel panel-default m-t-10">
                                <div class="panel-heading">
                                    <?php echo e(trans('messages.avatar')); ?>

                                </div>
                                <div class="panel-body">
                                    <?php echo Form::model($user,['files' => true, 'method' => 'POST','route' => ['user.avatar',$user->id] ,'class' => 'user-avatar-form','id' => 'user-avatar-form','data-submit' => 'noAjax']); ?>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="file" name="avatar" id="avatar" title="<?php echo trans('messages.select').' '.trans('messages.avatar'); ?>" class="fileinput" data-buttonText="<?php echo trans('messages.select').' '.trans('messages.avatar'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <?php if($user->Profile->avatar && File::exists(config('constant.upload_path.avatar').$user->Profile->avatar)): ?>
                                    <div class="form-group">
                                        <img src="<?php echo URL::to(config('constant.upload_path.avatar').$user->Profile->avatar); ?>" width="150px" style="margin-left:20px;">
                                        <div class="checkbox">
                                            <label>
                                              <input name="remove_avatar" type="checkbox" class="switch-input" data-size="mini" data-on-text="Yes" data-off-text="No" value="1" data-off-value="0"> <?php echo trans('messages.remove').' '.trans('messages.avatar'); ?>

                                            </label>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <?php echo Form::submit(trans('messages.save'),['class' => 'btn btn-primary']); ?>

                                    <?php echo Form::close(); ?>

                                </div>
                            </div>
                        </div>
                        <?php if($user->id != Auth::user()->id): ?>
                        <div class="tab-pane fade in" id="password-tab">
                            <div class="panel panel-default m-t-10">
                                <div class="panel-heading">
                                    <?php echo e(trans('messages.reset').' '.trans('messages.password')); ?>

                                </div>
                                <div class="panel-body">
                                    <?php echo Form::model($user,['method' => 'POST','route' => ['user.force-change-password',$user->id] ,'class' => 'user-force-change-password-form','id' => 'user-force-change-password-form']); ?>

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
                        <?php endif; ?>
                        <div class="tab-pane fade in" id="social-tab">
                            <div class="panel panel-default m-t-10">
                                <div class="panel-heading">
                                    <?php echo e(trans('messages.social').' '.trans('messages.networking')); ?>

                                </div>
                                <div class="panel-body">
                                    
                                    <?php echo Form::model($user,['method' => 'POST','route' => ['user.social-update',$user->id] ,'class' => 'user-social-form','id' => 'user-social-form','data-no-form-clear' => 1]); ?>

                                      <div class="form-group">
                                        <?php echo Form::label('facebook','Facebook',[]); ?>

                                        <?php echo Form::input('text','facebook',$user->Profile->facebook,['class'=>'form-control','placeholder'=>'Facebook']); ?>

                                      </div>
                                      <div class="form-group">
                                        <?php echo Form::label('twitter','Twitter',[]); ?>

                                        <?php echo Form::input('text','twitter',$user->Profile->twitter,['class'=>'form-control','placeholder'=>'Twitter']); ?>

                                      </div>
                                      <div class="form-group">
                                        <?php echo Form::label('google_plus','Google Plus',[]); ?>

                                        <?php echo Form::input('text','google_plus',$user->Profile->google_plus,['class'=>'form-control','placeholder'=>'Google Plus']); ?>

                                      </div>
                                    <?php echo e(getCustomFields('user-social-form',$custom_social_field_values)); ?>

                                    <?php echo Form::submit(trans('messages.save'),['class' => 'btn btn-primary pull-right']); ?>

                                    <?php echo Form::close(); ?>

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade in" id="custom-field-tab">
                            <div class="panel panel-default m-t-10">
                                <div class="panel-heading">
                                    <?php echo e(trans('messages.custom').' '.trans('messages.field')); ?>

                                </div>
                                <div class="panel-body">
                                    
                                    <?php echo Form::model($user,['method' => 'POST','route' => ['user.custom-field-update',$user->id] ,'class' => 'user-custom-field-form','id' => 'user-custom-field-form','data-no-form-clear' => 1]); ?>

                                    <?php echo e(getCustomFields('user-registration-form',$custom_register_field_values)); ?>

                                    <?php echo Form::submit(trans('messages.save'),['class' => 'btn btn-primary pull-right']); ?>

                                    <?php echo Form::close(); ?>

                                </div>
                            </div>
                        </div>
                        <?php if(config('config.enable_email_template')): ?>
                        <div class="tab-pane fade in" id="email-tab">
                            <div class="panel panel-default m-t-10">
                                <div class="panel-heading">
                                    <?php echo e(trans('messages.email').' '.trans('messages.user')); ?>

                                </div>
                                <div class="panel-body">
                                    <?php echo Form::model($user,['method' => 'POST','route' => ['user.email',$user->id] ,'class' => 'user-email-form','id' => 'user-email-form','data-extra' => $user->id]); ?>

                                    <div class="form-group">
                                        <?php echo Form::select('template_id', [null=>trans('messages.select_one')] + $templates,'',['class'=>'form-control input-xlarge chosen-select','id'=>'template_id','style' => 'width:100%;']); ?>

                                    </div>
                                    <div class="form-group">
                                        <?php echo Form::input('text','subject','',['class'=>'form-control','placeholder'=>trans('messages.subject'),'id' => 'mail_subject']); ?>

                                    </div>
                                    <div class="form-group">
                                        <?php echo Form::textarea('body','',['size' => '30x3', 'class' => 'form-control summernote', 'id' => 'mail_body', 'placeholder' => trans('messages.body')]); ?>

                                    </div>
                                    <?php echo Form::submit(trans('messages.send'),['class' => 'btn btn-primary pull-right']); ?>

                                    <?php echo Form::close(); ?>

                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>