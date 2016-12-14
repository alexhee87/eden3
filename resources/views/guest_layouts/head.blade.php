<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    {!! Html::style('assets/custom/css/bootstrap.min.css') !!}
    {!! Html::style('assets/custom/css/style.css') !!}
    {!! Html::style('assets/custom/css/animate.css') !!}
    {!! Html::style('assets/custom/css/plugins/iCheck/custom.css') !!}
    {!! Html::style('assets/custom/css/plugins/toastr/toastr.min.css') !!}
    {!! Html::style('assets/custom/font-awesome/css/font-awesome.min.css') !!}
    <link href="" rel="stylesheet">
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>