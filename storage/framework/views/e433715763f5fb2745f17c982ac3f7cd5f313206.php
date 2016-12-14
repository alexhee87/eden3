<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    <title><?php echo config('config.application_name') ? : config('constants.default_title'); ?></title>

    <?php echo Html::style('assets/custom/css/bootstrap.min.css'); ?>

    <?php echo Html::style('assets/custom/font-awesome/css/font-awesome.min.css'); ?>

    <?php echo Html::style('assets/custom/css/plugins/iCheck/custom.css'); ?>

    <?php echo Html::style('assets/custom/css/animate.css'); ?>

    <?php echo Html::style('assets/custom/css/style.css'); ?>

    <?php echo Html::style('assets/custom/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css'); ?>

    <?php echo Html::style('assets/custom/css/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css'); ?>

    <?php echo Html::style('assets/custom/css/plugins/dataTables/datatables.min.css'); ?>

    <?php echo Html::style('assets/custom/css/plugins/toastr/toastr.min.css'); ?>

    <?php echo Html::style('assets/custom/css/plugins/select2/select2.min.css'); ?>

    <?php echo Html::style('assets/custom/css/plugins/datapicker/datepicker3.css'); ?>

    <?php echo Html::style('assets/custom/css/plugins/summernote/summernote-bs3.css'); ?>

    <?php echo Html::style('assets/custom/css/plugins/summernote/summernote.css'); ?>

    <?php echo Html::style('assets/custom/css/plugins/chosen/bootstrap-chosen.css'); ?>

    <!-- Sweet Alert -->
    <?php echo Html::style('assets/custom/css/plugins/sweetalert/sweetalert.css'); ?>

</head>
