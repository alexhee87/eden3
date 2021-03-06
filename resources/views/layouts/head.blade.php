<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{!! config('config.application_name') ? : config('constants.default_title') !!}</title>

    {!! Html::style('assets/custom/css/bootstrap.min.css') !!}
    {!! Html::style('assets/custom/font-awesome/css/font-awesome.min.css') !!}
    {!! Html::style('assets/custom/css/plugins/iCheck/custom.css') !!}
    {!! Html::style('assets/custom/css/animate.css') !!}
    {!! Html::style('assets/custom/css/style.css') !!}
    {!! Html::style('assets/custom/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') !!}
    {!! Html::style('assets/custom/css/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') !!}
    {!! Html::style('assets/custom/css/plugins/dataTables/datatables.min.css') !!}
    {!! Html::style('assets/custom/css/plugins/toastr/toastr.min.css') !!}
    {!! Html::style('assets/custom/css/plugins/select2/select2.min.css') !!}
    {!! Html::style('assets/custom/css/plugins/datapicker/datepicker3.css') !!}
    {!! Html::style('assets/custom/css/plugins/summernote/summernote-bs3.css') !!}
    {!! Html::style('assets/custom/css/plugins/iCheck/custom.css') !!}
    {!! Html::style('assets/custom/css/plugins/summernote/summernote.css') !!}
    {!! Html::style('assets/custom/css/plugins/chosen/bootstrap-chosen.css') !!}
    <!-- Sweet Alert -->
    {!! Html::style('assets/custom/css/plugins/sweetalert/sweetalert.css') !!}

    {!! Html::style('assets/custom/css/plugins/fullcalendar/fullcalendar.css') !!}
</head>
