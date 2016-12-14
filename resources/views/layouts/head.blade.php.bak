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

    {!! Html::style('assets/vendor/bootstrap/css/bootstrap.min.css') !!}
    {!! Html::style('assets/vendor/metisMenu/metisMenu.min.css') !!}
    @if($direction == 'ltr')
        {!! Html::style('assets/css/style.min.css') !!}
    @else
        {!! Html::style('assets/css/style-rtl.min.css') !!}
        {!! Html::style('assets/css/bootstrap-rtl.css') !!}
        {!! Html::style('assets/css/bootstrap-flipped.css') !!}
    @endif
    {!! Html::style('assets/css/bootstrap.vertical-tabs.min.css') !!}
    {!! Html::style('assets/vendor/font-awesome/css/font-awesome.min.css') !!}
    {!! Html::style('assets/vendor/switch/bootstrap-switch.min.css') !!}
    {!! Html::style('assets/vendor/datepicker/css/datepicker.css') !!}
    {!! Html::style('assets/vendor/toastr/toastr.min.css') !!}
    {!! Html::style('assets/vendor/select2/select2.min.css') !!}
    {!! Html::style('assets/vendor/select2/select2-bootstrap.min.css') !!}
    {!! Html::style('assets/vendor/datatables/datatables.min.css') !!}
    {!! Html::style('assets/vendor/summernote/summernote.css') !!}
    @if(in_array('calendar',$assets))
        {!! Html::style('assets/vendor/calendar/fullcalendar.min.css') !!}
    @endif
    {!! Html::style('assets/vendor/icheck/skins/flat/blue.css') !!}
    {!! Html::style('assets/vendor/tags/tags.css') !!}
    {!! Html::style('assets/css/custom.css') !!}
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
