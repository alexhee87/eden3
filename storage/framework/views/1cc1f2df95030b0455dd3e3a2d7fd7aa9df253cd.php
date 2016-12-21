<?php echo $__env->make('layouts.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<body>
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation" style="margin-bottom: 0">
            <!-- sidebar -->
            <?php echo $__env->make('layouts.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </nav>
        <div id="page-wrapper" class="gray-bg">

            <!-- header navigation-->
            <div class="row L">
            <?php echo $__env->make('layouts.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>

            <div class="row wrapper border-bottom white-bg page-heading">
                <h2><?php echo $__env->yieldContent('breadcrumb_title'); ?></h2>
                <div class="col-lg-10">
                    <?php echo $__env->yieldContent('breadcrumb'); ?>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
            <?php echo $__env->make('common.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <div class="wrapper wrapper-content animated fadeInRight">
            <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div>
    </div>
    <div id="overlay"></div>
    <div class="modal fade" id="myModal" role="basic" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            </div>
        </div>
    </div>
<?php echo $__env->make('layouts.foot', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
