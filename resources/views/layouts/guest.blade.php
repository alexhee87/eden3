<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{!! config('config.application_name') ? : config('constants.default_title') !!}</title>
    {!! Html::style('assets/vendor/bootstrap/css/bootstrap.min.css') !!}
    {!! Html::style('assets/vendor/metisMenu/metisMenu.min.css') !!}
    {!! Html::style('assets/css/style.min.css') !!}
    {!! Html::style('assets/vendor/font-awesome/css/font-awesome.min.css') !!}
    {!! Html::style('assets/vendor/switch/bootstrap-switch.min.css') !!}
    {!! Html::style('assets/vendor/toastr/toastr.min.css') !!}
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>

    <div class="container">
        @yield('content')
    </div>

    {!! Html::script('assets/vendor/jquery/jquery.min.js') !!}
    {!! Html::script('assets/vendor/bootstrap/js/bootstrap.min.js') !!}
    {!! Html::script('assets/vendor/toastr/toastr.min.js') !!}
    @include('common.toastr_notification')
    {!! Html::script('assets/vendor/metisMenu/metisMenu.min.js') !!}
    {!! Html::script('assets/vendor/switch/bootstrap-switch.min.js') !!}
    {!! Html::script('assets/js/style.min.js') !!}
    <script>
    $(document).ready(function(){
        $('.switch-input').bootstrapSwitch();
    });
    </script>
</body>
</html>
