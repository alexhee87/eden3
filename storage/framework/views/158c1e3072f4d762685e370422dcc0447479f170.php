<?php echo $__env->make('guest_layouts.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<body>
    
    <?php echo $__env->make('guest_layouts.header_install', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    
    <?php echo $__env->yieldContent('content'); ?>

<?php echo $__env->make('guest_layouts.foot', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>