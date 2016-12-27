    <?php $__env->startSection('breadcrumb'); ?>
        <div class="row">
            <div class="col-lg-12">
                <h4 class="page-header">Dashboard</h4>
            </div>
        </div>
    <?php $__env->stopSection(); ?>

    <?php $__env->startSection('content'); ?>
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-users fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo e(\App\User::whereStatus('active')->count()); ?></div>
                                <div><?php echo e(trans('messages.active').' '.trans('messages.user')); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-user-times fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo e(\App\User::whereStatus('banned')->count()); ?></div>
                                <div><?php echo e(trans('messages.banned').' '.trans('messages.user')); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-user fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo e(\App\User::whereStatus('pending_activation')->count()); ?></div>
                                <div><?php echo e(trans('messages.pending').' '.trans('messages.activation')); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-user-plus fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo e(\App\User::whereStatus('pending_approval')->count()); ?></div>
                                <div><?php echo e(trans('messages.pending').' '.trans('messages.approval')); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">

            </div>
            <div class="col-md-4">
                <?php if(config('config.enable_group_chat')): ?>
                <div class="panel panel-primary chat-panel">
                    <div class="panel-heading">
                        <strong><?php echo e(trans('messages.group')); ?></strong> <?php echo e(trans('messages.chat')); ?>

                    </div>
                    <div class="panel-body" id="chat-box">
                        <div id="chat-messages" data-chat-refresh="<?php echo e(config('config.enable_chat_refresh')); ?>" data-chat-refresh-duration="<?php echo e(config('config.chat_refresh_duration')); ?>"></div>
                    </div>
                    <div class="panel-footer">
                    <?php echo Form::open(['route' => 'chat.store','role' => 'form', 'class'=>'chat-form','id' => 'chat-form','data-refresh' => 'chat-messages']); ?>

                    <?php echo Form::input('text','message','',['class'=>'form-control','data-autoresize' => 1,'placeholder' => 'Type your message here..']); ?>

                    <?php echo Form::close(); ?>

                    </div>
                </div>
                <?php endif; ?>
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <?php echo e(trans('messages.celebration')); ?>

                    </div>
                    <div class="panel-body" style="max-height:350px;overflow-y:scroll;">
                        <ul class="media-list">
                        <?php $__currentLoopData = $celebrations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $celebration): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                          <li class="media">
                            <a class="pull-left" href="#">
                              <?php echo getAvatar($celebration['id'],55); ?>

                            </a>
                            <div class="media-body">
                              <p class="media-heading"><i class="fa fa-<?php echo e($celebration['icon']); ?> icon" style="margin-right:10px;"></i> <?php echo e($celebration['title']); ?> (<?php echo $celebration['number']; ?>)</p>
                              <p style="margin-bottom:5px;"><strong><?php echo $celebration['name']; ?></strong></p>
                            </div>
                          </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>