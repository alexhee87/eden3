<?php if(!getMode()): ?>
	<?php echo $__env->make('common.notification',['message' => 'You are free to perform all actions. The demo gets reset in every 30 minutes.' ,'type' => 'danger'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php endif; ?>